<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include('db_config.php');

// Fetch total pemasukan
$pemasukanQuery = "SELECT SUM(jumlah) AS total_pemasukan FROM pemasukan";
$pemasukanResult = mysqli_query($conn, $pemasukanQuery);
$totalPemasukan = mysqli_fetch_assoc($pemasukanResult)['total_pemasukan'] ?? 0;

// Fetch total pengeluaran
$pengeluaranQuery = "SELECT SUM(jumlah) AS total_pengeluaran FROM pengeluaran";
$pengeluaranResult = mysqli_query($conn, $pengeluaranQuery);
$totalPengeluaran = mysqli_fetch_assoc($pengeluaranResult)['total_pengeluaran'] ?? 0;

// Fetch total donasi
$donasiQuery = "SELECT SUM(jumlah) AS total_donasi FROM donasi";
$donasiResult = mysqli_query($conn, $donasiQuery);
$totalDonasi = mysqli_fetch_assoc($donasiResult)['total_donasi'] ?? 0;

// Calculate total financial balance
$totalBalance = $totalPemasukan - $totalPengeluaran + $totalDonasi;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total Keuangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
            color: #333;
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            background-color: #333;
            color: white;
            padding: 20px;
            width: 250px;
        }
        .sidebar h2 {
            font-size: 20px;
            text-align: center;
            margin-bottom: 20px;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }
        .sidebar ul li {
            margin-bottom: 10px;
        }
        .sidebar ul li a {
            color: white;
            text-decoration: none;
            padding: 10px;
            display: block;
            border-radius: 5px;
        }
        .sidebar ul li a:hover {
            background-color: #575757;
        }
        .content {
            flex: 1;
            padding: 20px;
            max-width: 600px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .total-box {
            display: flex;
            justify-content: space-between;
            padding: 15px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #e9ecef;
        }
        .total-balance {
            background-color: #28a745;
            color: #fff;
            text-align: center;
            padding: 15px;
            margin-top: 20px;
            border-radius: 5px;
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
    <h3>Dompet Keuangan</h3>
    <div class="total-box">
        <h5>Total Pemasukan:</h5>
        <h5>Rp. <?php echo number_format($totalPemasukan, 0, ',', '.'); ?></h5>
    </div>
    <div class="total-box">
        <h5>Total Pengeluaran:</h5>
        <h5>Rp. <?php echo number_format($totalPengeluaran, 0, ',', '.'); ?></h5>
    </div>
    <div class="total-box">
        <h5>Total Donasi:</h5>
        <h5>Rp. <?php echo number_format($totalDonasi, 0, ',', '.'); ?></h5>
    </div>
    <div class="total-balance">
        <h4>Total Keuangan: Rp. <?php echo number_format($totalBalance, 0, ',', '.'); ?></h4>
    </div>
    <br>
    <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
</div>

</body>
</html>
