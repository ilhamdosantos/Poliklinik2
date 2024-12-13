<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_poli"; // ganti dengan nama database Anda

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil data poli dari database
$sql = "SELECT * FROM poli";
$result = $conn->query($sql);

// Proses form untuk menambah poli
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_poli = $_POST['nama_poli'];
    $keterangan = $_POST['keterangan'];

    // Query untuk insert data poli
    $sql_insert = "INSERT INTO poli (nama_poli, keterangan) VALUES ('$nama_poli', '$keterangan')";

    if ($conn->query($sql_insert) === TRUE) {
        echo "<div class='alert alert-success mt-3'>Poli berhasil ditambahkan!</div>";
    } else {
        echo "<div class='alert alert-danger mt-3'>Error: " . $conn->error . "</div>";
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
              <a href="../admin/poli.php" class="nav-link active">
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
    <link rel="stylesheet" href="../style/admin_poli.css">
    <h2 class="text-center mb-4">Mengelola Poli</h2>
    
    <!-- Form untuk menambah poli -->
    <form method="POST">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nama_poli" class="form-label">Nama Poli:</label>
                <input type="text" class="form-control" id="nama_poli" name="nama_poli" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="keterangan" class="form-label">Keterangan:</label>
                <input type="text" class="form-control" id="keterangan" name="keterangan" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">Simpan</button>
    </form>

    <!-- Daftar Poli -->
    <h3 class="mt-5 mb-3">Daftar Poli</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Poli</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Mengambil data poli
            $conn = new mysqli($servername, $username, $password, $dbname);
            $sql = "SELECT * FROM poli";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $no = 1;
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $no . "</td>";
                    echo "<td>" . $row['nama_poli'] . "</td>";
                    echo "<td>" . $row['keterangan'] . "</td>";
                    echo "<td>
                           <a href='edit_poli.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                           <a href='delete_poli.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm'>Hapus</a>
                          </td>";
                    echo "</tr>";
                    $no++;
                }
            } else {
                echo "<tr><td colspan='4' class='text-center'>Tidak ada data poli</td></tr>";
            }
            ?>
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
