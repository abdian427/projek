<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];

// Query to process adding expense
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tanggal = $_POST['tanggal'];
    $deskripsi = $_POST['deskripsi'];
    $jumlah = $_POST['jumlah'];
    $kategori = $_POST['kategori'];
    
    $target_dir = "gambar/"; // Ensure this folder exists with correct permissions
    $gambar = $_FILES['gambar']['name'];
    $target_file = $target_dir . basename($gambar);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["gambar"]["tmp_name"]);
    if ($check === false) {
        $error = "File yang diunggah bukan gambar.";
    } elseif (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
        $query = "INSERT INTO pengeluaran (tanggal, deskripsi, jumlah, kategori, gambar) VALUES ('$tanggal', '$deskripsi', '$jumlah', '$kategori', '$target_file')";
        if (mysqli_query($conn, $query)) {
            $success = "Data pengeluaran berhasil ditambahkan!";
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    } else {
        $error = "Terjadi kesalahan saat mengunggah gambar.";
    }
}

$totalPengeluaranQuery = "SELECT SUM(jumlah) AS total_pengeluaran FROM pengeluaran";
$totalPengeluaranResult = mysqli_query($conn, $totalPengeluaranQuery);
$totalPengeluaran = mysqli_fetch_assoc($totalPengeluaranResult)['total_pengeluaran'];

$pengeluaranQuery = "SELECT * FROM pengeluaran";
$pengeluaranResult = mysqli_query($conn, $pengeluaranQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Pengeluaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('gambar/kabaha.jpeg');
            background-size: cover;
            margin: 0;
            font-family: Arial, sans-serif;
            height: 100vh;
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
            text-align: center;
            font-size: 20px;
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
            color: black;
             .card-header {
            background-color: #28a745;
            color: black;
        }

        .table-dark thead th {
            background-color: #28a745;
        }

        .btn-primary, .btn-danger {
            margin-right: 5px;
        }
        }
        .table-dark {
            background-color: rgba(0, 0, 0, 0.7);
        }
        img {
            max-width: 50px;
            height: auto;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <!-- Sidebar Menu -->
    <div class="sidebar">
        <h2>Dashboard</h2>
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
        <div class="card">
            <div class="card-header">
                <h3 class="text-center">Tambah Pengeluaran</h3>
            </div>
        <form method="POST" action="add_expense.php" enctype="multipart/form-data" class="mb-4">
            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal:</label>
                <input type="date" id="tanggal" name="tanggal" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi:</label>
                <input type="text" id="deskripsi" name="deskripsi" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah:</label>
                <input type="number" id="jumlah" name="jumlah" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori:</label>
                <select id="kategori" name="kategori" class="form-select" required>
                    <option value="">Pilih Kategori</option>
                    <option value="Kebutuhan Operasional">Kebutuhan Operasional</option>
                    <option value="Pemeliharaan">Pemeliharaan</option>
                    <option value="Donasi">Donasi</option>
                    <option value="Lain-lain">Lain-lain</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="gambar" class="form-label">Gambar:</label>
                <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-success">Tambah Pengeluaran</button>
            <a href="dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
        </form>
        <br>
        <div class="card">
        <div class="card-header">
        <h3 class="text-center">Laporan Pengeluaran</h3>
        <table class="table table-light table-bordered mt-3">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                    <th>Jumlah</th>
                    <th>Kategori</th>
                    <th>Gambar</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php while ($row = mysqli_fetch_assoc($pengeluaranResult)): ?>
                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['tanggal']) ?></td>
                        <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                        <td><?= number_format($row['jumlah'], 0, ',', '.') ?></td>
                        <td><?= htmlspecialchars($row['kategori']) ?></td>
                        <td>
                            <?php if (!empty($row['gambar'])): ?>
                                <img src="<?= htmlspecialchars($row['gambar']) ?>" alt="Gambar Pengeluaran">
                            <?php else: ?>
                                Tidak Ada Gambar
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="edit_expense.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                            <a href="hapus.php?hapus=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?');">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
</div>
</div>

</body>
</html>
