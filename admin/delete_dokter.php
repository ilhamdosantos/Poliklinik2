
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_poli"; // ganti dengan nama database Anda
// Cek apakah parameter ID ada
if (isset($_GET['id'])) {
    $id_dokter = $_GET['id'];

    // Koneksi ke database
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Periksa koneksi
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }

    // Query untuk menghapus dokter
    $sql = "DELETE FROM dokter WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_dokter);

    if ($stmt->execute()) {
        // Redirect kembali ke halaman daftar dokter setelah penghapusan berhasil
        echo "<script>alert('Dokter berhasil dihapus'); window.location.href='../admin/dokter.php';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Menutup koneksi
    $stmt->close();
    $conn->close();
} else {
    echo "ID dokter tidak ditemukan.";
}
?>
