<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include('db_config.php');

// Proses tambah pemasukan
if (isset($_POST['submit'])) {
    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];
    $jumlah = $_POST['jumlah'];
    $kategori = $_POST['kategori'];

    $query = "INSERT INTO pemasukan (tanggal, keterangan, jumlah, kategori) VALUES ('$tanggal', '$keterangan', '$jumlah', '$kategori')";
    
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Data pemasukan berhasil ditambahkan!'); window.location.href = 'add_income.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}

// Proses hapus pemasukan dan donasi
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    // Check if this is a "pemasukan" record
    if (isset($_GET['type']) && $_GET['type'] == 'pemasukan') {
        $deleteQuery = "DELETE FROM pemasukan WHERE id = '$id'";
        if (mysqli_query($conn, $deleteQuery)) {
            echo "<script>alert('Data pemasukan berhasil dihapus!'); window.location.href = 'add_income.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
    // Check if this is a "donasi" record
    elseif (isset($_GET['type']) && $_GET['type'] == 'donasi') {
        $deleteQuery = "DELETE FROM donasi WHERE id = '$id'";
        if (mysqli_query($conn, $deleteQuery)) {
            echo "<script>alert('Data donasi berhasil dihapus!'); window.location.href = 'add_income.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}

// Query untuk mendapatkan data pemasukan dan donasi
$pemasukanQuery = "SELECT * FROM pemasukan";
$donasiQuery = "SELECT * FROM donasi";

$pemasukanResult = mysqli_query($conn, $pemasukanQuery);
$donasiResult = mysqli_query($conn, $donasiQuery);

// Query untuk menghitung total pemasukan
$totalPemasukanQuery = "SELECT SUM(jumlah) AS total_pemasukan FROM pemasukan";
$totalPemasukanResult = mysqli_query($conn, $totalPemasukanQuery);
$totalPemasukanRow = mysqli_fetch_assoc($totalPemasukanResult);
$totalPemasukan = $totalPemasukanRow['total_pemasukan'] ?? 0;

// Query untuk menghitung total donasi
$totalDonasiQuery = "SELECT SUM(jumlah) AS total_donasi FROM donasi";
$totalDonasiResult = mysqli_query($conn, $totalDonasiQuery);
$totalDonasiRow = mysqli_fetch_assoc($totalDonasiResult);
$totalDonasi = $totalDonasiRow['total_donasi'] ?? 0;

// Total keseluruhan (pemasukan + donasi)
$totalKeseluruhan = $totalPemasukan + $totalDonasi;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pemasukan dan Laporan Keuangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('gambar/kabaha.jpeg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            height: 100vh;
            color: white;
        }

        .container-fluid {
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
        }

        .card-header {
            background-color: #28a745;
            color: white;
        }

        .table-light thead th {
            background-color: #28a745;
        }

        label{
            color: black;
        }

        .btn-primary, .btn-danger {
            margin-right: 5px;
        }

        .total {
            font-size: 1.2em;
            font-weight: bold;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <!-- Sidebar Menu -->
    <div class="sidebar">
        <h2>Menu</h2>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="add_income.php" >Tambah Pemasukan</a></li>
            <li><a href="add_expense.php">Tambah Pengeluaran</a></li>
            <li><a href="settings.php">Pengaturan</a></li>
            <li><a href="developers.php">Developers</a></li>
            <li><a href="view_users.php">Users</a></li>
            <li><a href="dompet.php">Dompet Kita</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div class="content">
        <div class="card">
            <div class="card-header">
                <h3 class="text-center" >Tambah Pemasukan</h3>
            </div>
            <div class="card-body">
                <form method="POST" action="add_income.php">
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal:</label>
                        <input type="date" id="tanggal" name="tanggal" class="form-control" placeholder="Masukkan tanggal pemasukan" required>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan:</label>
                        <input type="text" id="keterangan" name="keterangan" class="form-control" placeholder="Masukkan deskripsi pemasukan anda" required>
                    </div>
                    <div class="mb-3">
                        <label for="jumlah" class="form-label">Jumlah:</label>
                        <input type="number" id="jumlah" name="jumlah" class="form-control" placeholder="Masukkan jumlah uang yang diterima" required>
                    </div>
                    <div class="mb-3">
                        <label for="kategori" class="form-label">Kategori:</label>
                        <select id="kategori" name="kategori" class="form-control" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Donasi">Donasi</option>
                            <option value="Sumbangan">Sumbangan</option>
                            <option value="Zakat">Zakat</option>
                            <option value="Infak">Infak</option>
                            <option value="Lain-lain">Lain-lain</option>
                        </select>
                    </div>
                    <button type="submit" name="submit" class="btn btn-success">Tambah Pemasukan</button>
                    <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
                </form>
            </div>
        </div>

        <div class="mt-5">
            <h3 class="text-center">Laporan Pemasukan dan Donasi</h3>
            <table class="table table-light table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Keterangan</th>
                        <th>Jumlah</th>
                        <th>Kategori</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    // Displaying pemasukan records
                    while ($row = mysqli_fetch_assoc($pemasukanResult)): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <?php 
                                $tanggal = $row['tanggal']; 
                                echo date("l, d F Y", strtotime($tanggal));
                                ?>
                            </td>
                            <td><?php echo $row['keterangan']; ?></td>
                            <td><?php echo number_format($row['jumlah'], 2, ',', '.'); ?></td>
                            <td><?php echo $row['kategori']; ?></td>
                            <td>
                                <a href="edit_income.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                <a href="add_income.php?hapus=<?php echo $row['id']; ?>&type=pemasukan" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    <!-- Displaying donasi records -->
                    <?php while ($row = mysqli_fetch_assoc($donasiResult)): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <?php 
                                $tanggal = $row['tanggal_donasi']; 
                                echo date("l, d F Y", strtotime($tanggal)); 
                                ?>
                            </td>
                            <td><?php echo $row['keterangan']; ?></td>
                            <td><?php echo number_format($row['jumlah'], 2, ',', '.'); ?></td>
                            <td>Donasi</td>
                            <td>
                                <a href="edit_donasi.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                <a href="add_income.php?hapus=<?php echo $row['id']; ?>&type=donasi" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <div class="total">
                <h4>Total Pemasukan: <?php echo number_format($totalKeseluruhan, 2, ',', '.'); ?></h4>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
