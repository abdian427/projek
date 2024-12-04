<?php
session_start();
include 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $namaDonatur = $_POST['nama_donatur'];
    $jumlah = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];  // Add the keterangan field

    $queryDonasi = "INSERT INTO donasi (nama_donatur, jumlah, keterangan) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($queryDonasi);
    $stmt->bind_param("sds", $namaDonatur, $jumlah, $keterangan); // Adjusted for 3 parameters

    if ($stmt->execute()) {
        $pesan = "Donasi berhasil! Terima kasih atas kontribusi Anda.";
    } else {
        $pesan = "Donasi gagal! Silakan coba lagi.";
    }
    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('moscowa.jpeg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: white;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
            max-width: 600px;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 30px;
            border-radius: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h3 class="text-center">Buat Donasi</h3>
    <?php if (isset($pesan)) echo "<p class='text-center'>$pesan</p>"; ?>
    <form method="POST" action="donate.php">
        <div class="mb-3">
            <label for="nama_donatur" class="form-label">Nama Anda</label>
            <input type="text" class="form-control" id="nama_donatur" name="nama_donatur" required>
        </div>
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah (Rp)</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" required min="1">
        </div>
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
            <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Tuliskan keterangan jika ada (opsional)"></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-100">Donasi</button>
    </form>
    <div class="mt-4 text-center">
        <a href="admin_dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
