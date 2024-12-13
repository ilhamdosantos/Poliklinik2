<?php
$conn = new mysqli("localhost", "root", "", "db_poli"); // Ganti dengan kredensial database Anda

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Generate No RM
$result = $conn->query("SELECT COUNT(*) as total FROM pasien");
$row = $result->fetch_assoc();
$next_id = isset($row['total']) ? $row['total'] + 1 : 1; // Total data + 1
$no_rm = date("Ym") . '-' . str_pad($next_id, 3, '0', STR_PAD_LEFT);

// Tambah/Edit Pasien
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_ktp = $_POST['no_ktp'];
    $no_hp = $_POST['no_hp'];
    $no_rm = $_POST['no_rm'];

    if (isset($_POST['id']) && !empty($_POST['id'])) {
        // Edit Pasien
        $id = $_POST['id'];
        $sql = "UPDATE pasien SET nama='$nama', alamat='$alamat', no_ktp='$no_ktp', no_hp='$no_hp', no_rm='$no_rm' WHERE id='$id'";
    } else {
        // Tambah Pasien Baru
        $sql = "INSERT INTO pasien (nama, alamat, no_ktp, no_hp, no_rm) VALUES ('$nama', '$alamat', '$no_ktp', '$no_hp', '$no_rm')";
    }

    if ($conn->query($sql)) {
        header("Location: ../admin/pasien.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}

// Hapus Pasien
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM pasien WHERE id = $id";
    if ($conn->query($sql)) {
        echo "<script>alert('Data pasien berhasil dihapus!'); window.location.href='pasien.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "'); window.location.href='pasien.php';</script>";
    }
}

// Ambil Data Pasien
$pasien = $conn->query("SELECT * FROM pasien");
?>


<!DOCTYPE html>
<html lang="en">
<?php
session_start(); 
include('../header/header_admin.php') ?>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <?php include('../preloader/preloader_admin.php')?>

  <!-- Navbar -->
  <?php include('../navbar/navbar_admin.php') ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <?php include('../logo/logo_pasien.php') ?>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../app/dist/img/giselle.jpg" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $_SESSION['nama'];?></a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
          <a href="../admin/dashboard.php" class="nav-link ">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <span class="badge badge-info right">Admin</span>
              </p>
            </a>
              <li class="nav-item">
              <a href="../admin/dokter.php" class="nav-link ">
                  <span class="badge badge-info right">Admin</span>
                  <i class="nav-icon 	fas fa-user-md"></i>
                  <p>Dokter</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="../admin/pasien.php" class="nav-link active">
                <span class="badge badge-info right">Admin</span>
                <i class="nav-icon fas fa-wheelchair"></i>
                
                  <p>Pasien</p>
                </a>
              </li>
              <li class="nav-item">
              <a href="../admin/poli.php" class="nav-link">
                <span class="badge badge-info right">Admin</span>
                <i class="nav-icon fas fa-hospital"></i>
                  <p>Poli</p>
                </a>
              </li>
          </li>
          <li class="nav-item">
            <a href="../admin/obat.php" class="nav-link">
            <i class="nav-icon fas fa-pills"></i>
              <p>
                Obat
                <span class="badge badge-info right">Admin</span>
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php include('../content_header/content_admin.php') ?>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="container-fluid py-4">
        <h1 class="text-center mb-4">Manajemen Pasien</h1>
        
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header bg-primary text-white">Form Tambah/Edit Pasien</div>
                    <div class="card-body">
                        <form method="POST" action="">
                            <input type="hidden" name="id" value="<?php echo isset($_GET['edit']) ? $_GET['edit'] : ''; ?>">
                            <div class="mb-3">
                                <label class="form-label">Nama Pasien:</label>
                                <input type="text" name="nama" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat:</label>
                                <input type="text" name="alamat" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nomor KTP:</label>
                                <input type="text" name="no_ktp" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nomor HP:</label>
                                <input type="text" name="no_hp" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nomor RM:</label>
                                <input type="text" name="no_rm" class="form-control" value="<?php echo $no_rm; ?>" readonly>
                            </div>
                            <button type="submit" class="btn btn-success">Simpan</button>
                            <button type="reset" class="btn btn-secondary">Reset</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-md-12">
                <h2 class="text-center">Daftar Pasien</h2>
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>No. KTP</th>
                            <th>No. HP</th>
                            <th>No. RM</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
    // Variabel untuk nomor urut
    $no = 1; 

    // Memeriksa apakah ada data pasien
    if ($pasien->num_rows > 0): 
        while ($row = $pasien->fetch_assoc()): 
    ?>
        <tr>
            <td><?php echo $no++; // Increment nomor ?></td>
            <td><?php echo $row['nama']; ?></td>
            <td><?php echo $row['alamat']; ?></td>
            <td><?php echo $row['no_ktp']; ?></td>
            <td><?php echo $row['no_hp']; ?></td>
            <td><?php echo $row['no_rm']; ?></td>
            <td>
                <a href="edit_pasien.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="pasien.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
            </td>
            </td>
        </tr>
    <?php 
        endwhile; 
    else: 
    ?>
        <tr>
            <td colspan="7" class="text-center">Tidak ada data pasien.</td>
        </tr>
    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include('../footer/footer_admin.php') ?>
  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
</body>
</html>
