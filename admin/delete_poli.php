<?php
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

    // Query untuk menghapus poli berdasarkan ID
    $delete_sql = "DELETE FROM poli WHERE id = ?";
    $delete_stmt = $conn->prepare($delete_sql);
    $delete_stmt->bind_param("i", $id_poli);

    if ($delete_stmt->execute()) {
        echo "<script>alert('Data poli berhasil dihapus'); window.location.href='../admin/poli.php';</script>";
    } else {
        echo "Error: " . $delete_stmt->error;
    }

    // Menutup koneksi
    $delete_stmt->close();
    $conn->close();
} else {
    echo "ID poli tidak ditemukan.";
    exit();
}
?>
