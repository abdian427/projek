<?php
session_start();
include 'db_config.php';

if (!isset($_GET['id'])) {
    die("ID donasi tidak ditemukan.");
}

$id = $_GET['id'];

// Ambil data donasi yang akan diedit
$query = "SELECT * FROM donasi WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    die("Donasi tidak ditemukan.");
}

$donasi = $result->fetch_assoc();

// Jika form disubmit, lakukan update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $namaDonatur = $_POST['nama_donatur'];
    $jumlah = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];

    $queryUpdate = "UPDATE donasi SET nama_donatur = ?, jumlah = ?, keterangan = ? WHERE id = ?";
    $stmt = $conn->prepare($queryUpdate);
    $stmt->bind_param("sdsi", $namaDonatur, $jumlah, $keterangan, $id);

    if ($stmt->execute()) {
        $pesan = "Donasi berhasil diperbarui!";
    } else {
        $pesan = "Terjadi kesalahan. Silakan coba lagi.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Donasi</title>
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
    <h3 class="text-center">Edit Donasi</h3>
    <?php if (isset($pesan)) echo "<p class='text-center'>$pesan</p>"; ?>
    <form method="POST" action="edit_donasi.php?id=<?php echo $id; ?>">
        <div class="mb-3">
            <label for="nama_donatur" class="form-label">Nama Anda</label>
            <input type="text" class="form-control" id="nama_donatur" name="nama_donatur" value="<?php echo $donasi['nama_donatur']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="jumlah" class="form-label">Jumlah (Rp)</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?php echo $donasi['jumlah']; ?>" required min="1">
        </div>
        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"><?php echo $donasi['keterangan']; ?></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-100">Perbarui Donasi</button>
    </form>
    <div class="mt-4 text-center">
        <a href="add_income.php" class="btn btn-secondary">Kembali</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
