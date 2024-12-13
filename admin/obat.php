<?php
$servername = "localhost"; // Nama host server MySQL
$username = "root"; // Username MySQL
$password = ""; // Password MySQL
$dbname = "db_poli"; // Nama database yang digunakan

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Mengecek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Menangani aksi simpan data
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_obat'])) {
    $nama_obat = $_POST['nama_obat'];
    $kemasan = $_POST['kemasan'] ? $_POST['kemasan'] : NULL;
    $harga = $_POST['harga'];

    // Menyimpan data ke database
    $sql = "INSERT INTO obat (nama_obat, kemasan, harga) VALUES (?, ?, ?)";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssi", $nama_obat, $kemasan, $harga);
        $stmt->execute();
        $stmt->close();
    }
}

// Menangani aksi hapus data
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM obat WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $delete_id);
        $stmt->execute();
        $stmt->close();
    }
}

// Menangani aksi edit data
if (isset($_POST['edit_obat'])) {
    $id = $_POST['id'];
    $nama_obat = $_POST['nama_obat'];
    $kemasan = $_POST['kemasan'] ? $_POST['kemasan'] : NULL;
    $harga = $_POST['harga'];

    $sql = "UPDATE obat SET nama_obat = ?, kemasan = ?, harga = ? WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssii", $nama_obat, $kemasan, $harga, $id);
        $stmt->execute();
        $stmt->close();
    }
}

// Menampilkan data obat
$sql = "SELECT * FROM obat";
$result = $conn->query($sql);
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
    <?php include('../logo/logo_admin.php') ?>

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
              <a href="../admin/pasien.php" class="nav-link">
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
            <a href="../admin/obat.php" class="nav-link active">
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
    <div class="container-fluid">
    <link rel="stylesheet" href="../style/admin_obat.css">
        <h3 class="text-center my-4">Form Input Obat</h3>
        <!-- Form Input Data -->
        <form action="../admin/obat.php" method="POST">
            <div class="form-group">
                <label for="nama_obat">Nama Obat</label>
                <input type="text" class="form-control" id="nama_obat" name="nama_obat" required>
            </div>
            <div class="form-group">
                <label for="kemasan">Kemasan</label>
                <input type="text" class="form-control" id="kemasan" name="kemasan">
            </div>
            <div class="form-group">
                <label for="harga">Harga (Rp)</label>
                <input type="number" class="form-control" id="harga" name="harga" required>
            </div>
            <button type="submit" name="save_obat" class="btn btn-primary btn-block">Simpan</button>
        </form>

        <hr>

        <!-- Tabel Data Obat -->
        <h4>Data Obat</h4>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Obat</th>
                    <th>Kemasan</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0) { 
                    $no = 1;
                    while($row = $result->fetch_assoc()) { ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $row['nama_obat'] ?></td>
                            <td><?= $row['kemasan'] ?></td>
                            <td>Rp <?= number_format($row['harga'], 0, ',', '.') ?></td>
                            <td>
                                <!-- Edit -->
                                <a href="edit_obat.php?edit_id=<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <!-- Delete -->
                                <a href="obat.php?delete_id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                            </td>
                        </tr>
                    <?php } 
                } else { ?>
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data obat</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
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
