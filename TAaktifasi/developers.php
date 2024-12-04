<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Developers</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            display: flex;
            min-height: 100vh;
            background-color: #f4f4f9;
            font-family: Arial, sans-serif;
            color: #333;
        }

        /* Sidebar styling */
        .sidebar {
            width: 250px;
            background-color: #333;
            color: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .sidebar h2 {
            font-size: 20px;
            margin-bottom: 20px;
            text-align: center;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
            width: 100%;
        }

        .sidebar ul li {
            margin: 10px 0;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            padding: 10px;
            display: block;
            border-radius: 5px;
            text-align: center;
        }

        .sidebar ul li a:hover {
            background-color: #575757;
        }

        /* Content styling */
        .content {
            flex: 1;
            padding: 20px;
            max-width: 900px;
            margin: auto;
        }

        .developer-card:hover {
            transform: scale(1.05);
        }

        .developer-img {
            width: 150px; 
            height: 150px;
            object-fit: cover;
            border-radius: 50%; 
            margin: 15px auto; 
        }

        .developer-info {
            padding: 15px;
        }

        .developer-name {
            font-size: 1.5em;
            margin: 10px 0;
        }

        .developer-role {
            color: #777;
            font-size: 1em;
            margin-bottom: 10px;
        }

        .info-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }

        h4 {
            color: #333;
            margin-top: 20px;
        }

        p {
            color: #555;
            line-height: 1.6;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Menu</h2>
    <ul>
    <li><a href="dashboard.php">dashboard</a></li>
                <li><a href="add_income.php" >Tambah Pemasukan</a></li>
                <li><a href="add_expense.php">Tambah Pengeluaran</a></li>
                <li><a href="settings.php">Pengaturan</a></li>
                <li><a href="developers.php">Developers</a></li>
                <li><a href="view_users.php">users</a></li>
                <li><a href="dompet.php">dompet kita</a></li>
                <li><a href="logout.php">Logout</a></li>
    </ul>
</div>

<div class="content">
    <h2 class="text-center">Meet Our Developers</h2>
    <div class="row">
        <!-- Developer 1 -->
        <div class="col-md-4">
            <div class="developer-card text-center">
                <img src="gambar/developers1.jpeg" alt="Developer 1" class="developer-img">
                <div class="developer-info">
                    <div class="developer-name">John Doe</div>
                    <div class="developer-role">Lead Developer</div>
                </div>
            </div>
        </div>

        <!-- Developer 2 -->
        <div class="col-md-4">
            <div class="developer-card text-center">
                <img src="gambar/developers2.jpeg" alt="Developer 2" class="developer-img">
                <div class="developer-info">
                    <div class="developer-name">Jane Smith</div>
                    <div class="developer-role">Front-End Developer</div>
                </div>
            </div>
        </div>

        <!-- Developer 3 -->
        <div class="col-md-4">
            <div class="developer-card text-center">
                <img src="gambar/developers3.jpeg" alt="Developer 3" class="developer-img">
                <div class="developer-info">
                    <div class="developer-name">Grace Hopper</div>
                    <div class="developer-role">Back-End Developer</div>
                </div>
            </div>
        </div>
    </div>

    <div class="info-card">
        <h4>Tentang Aplikasi</h4>
        <p>
            Aplikasi Pengelolaan Uang Masjid ini dikembangkan untuk mempermudah administrasi keuangan masjid, 
            dengan menyediakan fitur pelacakan pemasukan, pengeluaran, serta pembuatan laporan keuangan yang 
            transparan dan akurat. Dengan dukungan teknologi terkini, aplikasi ini bertujuan untuk memberikan solusi 
            yang efisien, mudah diakses, dan user-friendly bagi pengurus masjid dalam mengelola dana yang diamanahkan 
            oleh jamaah.
        </p>
    </div>

    <div class="info-card">
        <h4>Fitur Utama</h4>
        <ul>
            <li><strong>Manajemen Pengguna:</strong> Akses berbasis peran yang membatasi hak akses antara pengguna umum dan administrator.</li>
            <li><strong>Dasbor Ringkas:</strong> Tampilan visual untuk pemasukan, pengeluaran, serta status kas secara keseluruhan.</li>
            <li><strong>Pengaturan Profil:</strong> Fitur pengubahan email dan foto profil pengguna untuk pengalaman yang lebih personal.</li>
            <li><strong>Laporan Keuangan Otomatis:</strong> Grafik dan laporan yang diperbarui secara otomatis setiap kali ada transaksi baru.</li>
        </ul>
    </div>

    <div class="info-card">
        <h4>Tentang Pengembang</h4>
        <p>
            Sebagai pengembang, kami berkomitmen untuk menghadirkan solusi digital yang bisa memberikan manfaat nyata 
            bagi masyarakat. Dengan semangat transparansi dan kemudahan, aplikasi ini dirancang untuk mendukung 
            kepercayaan dan kenyamanan dalam pengelolaan dana masjid. Kami percaya bahwa teknologi dapat membuat 
            perbedaan yang signifikan dalam administrasi keuangan masjid.
        </p>
    </div>

    <a href="dashboard.php" class="btn btn-primary">Kembali ke Dashboard</a>
</div>

<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
