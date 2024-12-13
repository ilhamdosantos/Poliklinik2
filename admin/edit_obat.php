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
// Menangani aksi update data (edit)
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_obat'])) {
    $id = $_POST['id'];
    $nama_obat = $_POST['nama_obat'];
    $kemasan = $_POST['kemasan'] ? $_POST['kemasan'] : NULL;
    $harga = $_POST['harga'];

    $sql = "UPDATE obat SET nama_obat = ?, kemasan = ?, harga = ? WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("ssii", $nama_obat, $kemasan, $harga, $id);
        $stmt->execute();
        $stmt->close();
        // Redirect setelah update untuk mencegah pengiriman data ulang
        header("Location: ../admin/obat.php");
        exit();
    }
}

// Menampilkan data untuk diedit
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $sql = "SELECT * FROM obat WHERE id = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("i", $edit_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($row = $result->fetch_assoc()) {
            $nama_obat = $row['nama_obat'];
            $kemasan = $row['kemasan'];
            $harga = $row['harga'];
        }
        $stmt->close();
    }
}

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
    <?php include('../sidebar/sidebar_admin.php') ?>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <?php include('../content_header/content_admin.php') ?>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="container-fluid">
    <link rel="stylesheet" href="edit_admin_obat.css">
        <h3 class="text-center my-4">Edit Obat</h3>

        <!-- Form Edit Data Obat -->
        <form method="POST">
            <div class="form-group">
                <label for="nama_obat">Nama Obat</label>
                <input type="text" class="form-control" id="nama_obat" name="nama_obat" value="<?= isset($nama_obat) ? $nama_obat : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="kemasan">Kemasan</label>
                <input type="text" class="form-control" id="kemasan" name="kemasan" value="<?= isset($kemasan) ? $kemasan : ''; ?>">
            </div>
            <div class="form-group">
                <label for="harga">Harga (Rp)</label>
                <input type="number" class="form-control" id="harga" name="harga" value="<?= isset($harga) ? $harga : ''; ?>" required>
            </div>
            <input type="hidden" name="id" value="<?= isset($edit_id) ? $edit_id : ''; ?>">
            <button type="submit" name="edit_obat" class="btn btn-warning btn-block">Update Data</button>
        </form>
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
