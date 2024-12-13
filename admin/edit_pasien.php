<?php
$servername = "localhost";
$username = "root"; // Sesuaikan dengan username Anda
$password = ""; // Sesuaikan dengan password Anda
$dbname = "db_poli"; // Sesuaikan dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mendapatkan data pasien berdasarkan ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM pasien WHERE id = $id";
    $result = $conn->query($sql);
    $data = $result->fetch_assoc();
} else {
    echo "ID pasien tidak ditemukan!";
    exit();
}

// Menangani aksi edit data pasien
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $no_ktp = $_POST['no_ktp'];
    $no_hp = $_POST['no_hp'];
    $no_rm = $_POST['no_rm'];

    $sql = "UPDATE pasien SET 
                nama='$nama', 
                alamat='$alamat', 
                no_ktp='$no_ktp', 
                no_hp='$no_hp', 
                no_rm='$no_rm' 
            WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success mt-3'>Data pasien berhasil diperbarui!</div>";
        header("Location: pasien.php"); // Redirect ke halaman utama
        exit();
    } else {
        echo "<div class='alert alert-danger mt-3'>Error: " . $conn->error . "</div>";
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
    <div class="container-fluid mt-5">
    <h3 class="text-center mb-4">Edit Data Pasien</h3>
    <div class="row justify-content-center">
        <div class="col-md-6">
            <form action="pasien.php" method="POST">
                <!-- Hidden input untuk ID -->
                <input type="hidden" name="id" value="<?php echo $data['id']; ?>">

                <!-- Nama -->
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Pasien</label>
                    <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $data['nama']; ?>" required>
                </div>

                <!-- Alamat -->
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?php echo $data['alamat']; ?></textarea>
                </div>

                <!-- Nomor KTP -->
                <div class="mb-3">
                    <label for="no_ktp" class="form-label">Nomor KTP</label>
                    <input type="text" class="form-control" id="no_ktp" name="no_ktp" value="<?php echo $data['no_ktp']; ?>" required>
                </div>

                <!-- Nomor HP -->
                <div class="mb-3">
                    <label for="no_hp" class="form-label">Nomor HP</label>
                    <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?php echo $data['no_hp']; ?>" required>
                </div>

                <!-- Nomor RM -->
                <div class="mb-3">
                    <label for="no_rm" class="form-label">Nomor RM</label>
                    <input type="text" class="form-control" id="no_rm" name="no_rm" value="<?php echo $data['no_rm']; ?>" readonly>
                </div>

                <!-- Tombol Simpan dan Kembali -->
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="pasien.php" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
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
