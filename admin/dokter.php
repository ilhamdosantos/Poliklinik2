<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_poli"; // ganti dengan nama database Anda

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data dokter dari database
$sql = "SELECT dokter.id, dokter.nama_dokter, dokter.alamat, dokter.no_hp, poli.nama_poli 
        FROM dokter
        JOIN poli ON dokter.id_poli = poli.id";
$result = $conn->query($sql);

// Ambil data poli untuk dropdown
$sql_poli = "SELECT * FROM poli";
$result_poli = $conn->query($sql_poli);

// Proses form untuk menambah dokter
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['nama_dokter'], $_POST['alamat'], $_POST['no_hp'], $_POST['id_poli'])) {
        $nama_dokter = $_POST['nama_dokter'];
        $alamat = $_POST['alamat'];
        $no_hp = $_POST['no_hp'];
        $id_poli = $_POST['id_poli'];

        // Query untuk insert data dokter
        $sql_insert = "INSERT INTO dokter (nama_dokter, alamat, no_hp, id_poli) 
                       VALUES ('$nama_dokter', '$alamat', '$no_hp', '$id_poli')";

        if ($conn->query($sql_insert) === TRUE) {
            echo "<div class='alert alert-success mt-3'>Dokter berhasil ditambahkan!</div>";
        } else {
            echo "<div class='alert alert-danger mt-3'>Error: " . $conn->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-warning mt-3'>Semua field harus diisi!</div>";
    }
}

$conn->close();
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
    <?php include('../logo/logo_dokter.php') ?>

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
              <a href="../admin/dokter.php" class="nav-link active">
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
    <div class="container-fluid mt-5">
    <link rel="stylesheet" href="../style/admin_dokter.css">
    <h2 class="text-center mb-4">Tambah/Edit Dokter</h2>
    <!-- Form tambah dokter -->
    <form method="POST">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nama_dokter" class="form-label">Nama Dokter:</label>
                <input type="text" class="form-control" id="nama_dokter" name="nama_dokter" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="no_hp" class="form-label">No HP:</label>
                <input type="text" class="form-control" id="no_hp" name="no_hp" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat:</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
        </div>

        <div class="mb-3">
            <label for="id_poli" class="form-label">Pilih Poli:</label>
            <select class="form-select" id="id_poli" name="id_poli" required>
    <option value="">Pilih Poli</option>
    <?php
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql_poli = "SELECT * FROM poli";
    $result_poli = $conn->query($sql_poli);
    while ($row = $result_poli->fetch_assoc()) {
        echo "<option value='" . $row['id'] . "'>" . $row['nama_poli'] . "</option>";
    }
    ?>
</select>
        </div>

        <button type="submit" class="btn btn-primary w-100">Simpan</button>
    </form>

    <!-- Daftar Dokter -->
    <h3 class="mt-5 mb-3">Daftar Dokter</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No. HP</th>
                <th>Poli</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
// Pastikan $result adalah objek yang valid
    // Memeriksa apakah ada baris yang dikembalikan oleh query
    if ($result->num_rows > 0) {
        $no = 1;
        // Loop untuk menampilkan data dokter
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $no . "</td>";
            echo "<td>" . $row['nama_dokter'] . "</td>";
            echo "<td>" . $row['alamat'] . "</td>";
            echo "<td>" . $row['no_hp'] . "</td>";
            echo "<td>" . $row['nama_poli'] . "</td>";
            echo "<td>
                    <a href='edit_dokter.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                    <a href='delete_dokter.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus dokter ini?\")'>Hapus</a>
                  </td>";
            echo "</tr>";
            $no++;
        }
    } else {
        // Jika tidak ada data dokter
        echo "<tr><td colspan='6' class='text-center'>Tidak ada dokter yang terdaftar</td></tr>";
    }
?>
        </tbody>
    </table>
</div>
    <!-- /.content -->
  </div>
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
