<?php
// Koneksi ke database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_poli"; // ganti dengan nama database Anda

// Cek apakah parameter ID ada
if (isset($_GET['id'])) {
    $id_poli = $_GET['id'];

    // Koneksi ke database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Periksa koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Ambil data poli berdasarkan ID
    $sql = "SELECT * FROM poli WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_poli);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Data poli tidak ditemukan.";
        exit();
    }
} else {
    echo "ID poli tidak ditemukan.";
    exit();
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
    <div class="container-fluid mt-5">
    <link rel="stylesheet" href="edit_admin_poli.css">
    <h2 class="text-center mb-4">Edit Poli</h2>

    <!-- Form untuk edit poli -->
    <form method="POST">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nama_poli" class="form-label">Nama Poli:</label>
                <input type="text" class="form-control" id="nama_poli" name="nama_poli" value="<?php echo $row['nama_poli']; ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="keterangan" class="form-label">Keterangan:</label>
                <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?php echo $row['keterangan']; ?>" required>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
    </form>
</div>

<?php
// Proses form untuk update data poli
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_poli = $_POST['nama_poli'];
    $keterangan = $_POST['keterangan'];

    // Query untuk memperbarui data poli
    $update_sql = "UPDATE poli SET nama_poli = ?, keterangan = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssi", $nama_poli, $keterangan, $id_poli);

    if ($update_stmt->execute()) {
        echo "<script>alert('Data poli berhasil diperbarui'); window.location.href='../admin/poli.php';</script>";
    } else {
        echo "Error: " . $update_stmt->error;
    }

    // Menutup koneksi
    $update_stmt->close();
    $conn->close();
}
?>
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
