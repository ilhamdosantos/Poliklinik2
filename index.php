<?php
  $title = "Halaman Utama"; // Variabel untuk judul halaman
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="style/styles.css">
</head>
<body>

    <header class="header">
        <div class="logo">
            <h1>Poliklinik</h1> <!-- Ganti dengan logo atau teks sesuai kebutuhan -->
        </div>
    </header>

    <section id="home" class="hero">
        <div class="hero-content">
            <h2>Sistem Temu Janji </h2>
            <h2>Pasien - Dokter </h2>
            <p>Bimbingan Karir 2024</p>
        </div>
    </section>

    <section id="about" class="about" style="display: flex; justify-content: space-between; align-items: center;">
    <div>
        <img src="pasien2.jpg" alt="Product Image" style="width: 90px; height: auto;">
        <h1>Registrasi Sebagai Pasien</h1>
        <p>Apablia anda adalah seorang Pasien, Silahkan Registrasi terlebih dahulu untuk mulai berobat !!!</p>
        <a href="register_pasien.php">
        <button class="btn">REGISTRASI</button></a>
    </div>
    <div style="margin-left: 180px;">
    <img src="dokter4.jpg" alt="Product Image" style="width: 90px; height: auto;">
        <h1>Login Sebagai Dokter</h1>
        <p>Apabila anda adalah seorang Dokter, silahkan Login terlebih dahulu untuk mulai melayani Pasien!</p>
        <a href="login_dokter.php">
        <button class="btn">LOG IN</button> </a>
    </div>
    <div style="margin-left: 180px;">
    <img src="admin3.png" alt="Product Image" style="width: 90px; height: auto;">
        <h1>Login Sebagai Admin</h1>
        <p>Apabila anda adalah seorang Admin, Silahkan login terlebih dahulu untuk mengelola semuanya!!</p>
        <a href="login_admin.php">
        <button class="btn">LOG IN</button> </a>
    </div>
</section>

        

</body>
</html>
