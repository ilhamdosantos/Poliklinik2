<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_poli"; // ganti dengan nama database Anda
// Koneksi ke database
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ambil id dokter dari URL
$id_dokter = $_GET['id'];

// Ambil data dokter berdasarkan id
$sql = "SELECT * FROM dokter WHERE id = $id_dokter";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "Data tidak ditemukan.";
    exit;
}

// Update data dokter setelah form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_dokter = $_POST['nama_dokter'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];
    $id_poli = $_POST['id_poli'];

    $sql_update = "UPDATE dokter SET nama_dokter='$nama_dokter', no_hp='$no_hp', alamat='$alamat', id_poli='$id_poli' WHERE id=$id_dokter";

    if ($conn->query($sql_update) === TRUE) {
        echo "Data berhasil diperbarui.";
        header("Location: ../admin/dokter.php"); // Redirect ke dashboard setelah sukses
    } else {
        echo "Error: " . $sql_update . "<br>" . $conn->error;
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
<link rel="stylesheet" href="../style/edit_admin_dokter.css">
    <h2 class="text-center mb-4">Edit Dokter</h2>
    <form method="POST">
        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="nama_dokter" class="form-label">Nama Dokter:</label>
                <input type="text" class="form-control" id="nama_dokter" name="nama_dokter" value="<?php echo $row['nama_dokter']; ?>" required>
            </div>
            <div class="col-md-6 mb-3">
                <label for="no_hp" class="form-label">No HP:</label>
                <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?php echo $row['no_hp']; ?>" required>
            </div>
        </div>

        <div class="mb-3">
            <label for="alamat" class="form-label">Alamat:</label>
            <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?php echo $row['alamat']; ?></textarea>
        </div>

        <div class="mb-3">
            <label for="id_poli" class="form-label">Pilih Poli:</label>
            <select class="form-select" id="id_poli" name="id_poli" required>
                <option value="">Pilih Poli</option>
                <?php
                // Ambil daftar poli untuk dropdown
                $conn = new mysqli($servername, $username, $password, $dbname);
                $sql_poli = "SELECT * FROM poli";
                $result_poli = $conn->query($sql_poli);
                while ($row_poli = $result_poli->fetch_assoc()) {
                    $selected = ($row['id_poli'] == $row_poli['id']) ? 'selected' : '';
                    echo "<option value='" . $row_poli['id'] . "' $selected>" . $row_poli['nama_poli'] . "</option>";
                }
                ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary w-100">Simpan</button>
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
