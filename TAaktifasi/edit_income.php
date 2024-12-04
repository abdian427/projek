<?php
// Mulai session
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Include file koneksi
include('db_config.php');

// Cek apakah ID dari income yang ingin diedit sudah diterima
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query untuk mendapatkan data pemasukan berdasarkan ID
    $query = "SELECT * FROM pemasukan WHERE id = $id";
    $result = mysqli_query($conn, $query);

    // Jika data ditemukan
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "Data tidak ditemukan!";
        exit();
    }
}

// Jika form disubmit
if (isset($_POST['update'])) {
    $tanggal = $_POST['tanggal'];
    $deskripsi = $_POST['keterangan'];
    $jumlah = $_POST['jumlah'];
    $kategori = $_POST['kategori']; // Tambahkan kategori

    // Query untuk update data pemasukan
    $updateQuery = "UPDATE pemasukan SET tanggal = '$tanggal', keterangan = '$deskripsi', jumlah = '$jumlah', kategori = '$kategori' WHERE id = $id";

    if (mysqli_query($conn, $updateQuery)) {
        // Redirect kembali ke halaman add_income.php setelah update berhasil
        header("Location: add_income.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pemasukan</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            max-width: 600px;
        }
        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .form-title {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .form-group label {
            font-weight: bold;
        }
        .form-group input,
        .form-group select {
            border-radius: 5px;
            box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
        }
        .btn-primary, .btn-secondary {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
        }
        .btn-secondary {
            background-color: #6c757d;
            color: white;
            border: none;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2 class="form-title">Edit Data Pemasukan</h2>

            <form action="" method="POST">
                <div class="form-group">
                    <label for="tanggal">Tanggal:</label>
                    <input type="date" id="tanggal" name="tanggal" class="form-control" value="<?php echo htmlspecialchars($row['tanggal']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="deskripsi">Deskripsi:</label>
                    <input type="text" id="deskripsi" name="keterangan" class="form-control" value="<?php echo htmlspecialchars($row['keterangan']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="jumlah">Jumlah:</label>
                    <input type="number" id="jumlah" name="jumlah" class="form-control" value="<?php echo htmlspecialchars($row['jumlah']); ?>" required>
                </div>

                <div class="form-group">
    <label for="kategori">Kategori:</label>
    <select id="kategori" name="kategori" class="form-control" required>
        <option value="">Pilih Kategori</option>
        <option value="Donasi" <?php if ($row['kategori'] === 'Donasi') echo 'selected'; ?>>Donasi</option>
        <option value="Sumbangan" <?php if ($row['kategori'] === 'Sumbangan') echo 'selected'; ?>>Sumbangan</option>
        <option value="Zakat" <?php if ($row['kategori'] === 'Zakat') echo 'selected'; ?>>Zakat</option>
        <option value="Infak" <?php if ($row['kategori'] === 'Infak') echo 'selected'; ?>>Infak</option>
        <option value="Lain-lain" <?php if ($row['kategori'] === 'Lain-lain') echo 'selected'; ?>>Lain-lain</option>
    </select>
</div>


                <button type="submit" name="update" class="btn btn-primary">Update</button>
                <a href="add_income.php" class="btn btn-secondary mt-2">Batal</a>

                <?php if (isset($error)) echo "<div class='alert alert-danger mt-3' role='alert'>$error</div>"; ?>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
