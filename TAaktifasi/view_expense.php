<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

include 'db_config.php';

// Query to fetch expenses
$pengeluaranQuery = "SELECT * FROM pengeluaran ORDER BY id DESC";
$pengeluaranResult = mysqli_query($conn, $pengeluaranQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Expenses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-image: url('moscowa.jpeg');
            background-size: cover;
            background-position: center;
            color: #fff;
        }
        .container {
            margin-top: 50px;
            max-width: 900px;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 8px;
        }
        img {
            max-width: 50px;
            height: auto;
            cursor: pointer;
        }
        table {
            color: white;
        }
    </style>
</head>
<body>
<div class="container">
    <h3 class="text-center">Laporan Pengeluaran</h3>
    
    <table class="table table-dark table-bordered mt-4">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Deskripsi</th>
                <th>Jumlah</th>
                <th>Kategori</th>
                <th>Gambar</th>
            </tr>
        </thead>
        <tbody>
        <?php $no = 1; ?>
            <?php while ($row = mysqli_fetch_assoc($pengeluaranResult)): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row['tanggal'] ?></td>
                    <td><?= htmlspecialchars($row['deskripsi']) ?></td>
                    <td><?= number_format($row['jumlah'], 0, ',', '.') ?></td>
                    <td><?= htmlspecialchars($row['kategori']) ?></td>
                    <td>
                        <?php if (!empty($row['gambar'])): ?>
                            <img src="<?= htmlspecialchars($row['gambar']) ?>" alt="Expense Image" data-bs-toggle="modal" data-bs-target="#imageModal" onclick="showImageModal('<?= htmlspecialchars($row['gambar']) ?>')">
                        <?php else: ?>
                            Tidak Ada Gambar
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
            <a href="admin_dashboard.php" class="btn btn-secondary">Kembali ke Dashboard</a>
        </tbody>
    </table>
</div>

<!-- Modal for Image Zoom -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Gambar Pengeluaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="modalImage" src="" alt="Expense Image" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<script>
    function showImageModal(imageSrc) {
        document.getElementById('modalImage').src = imageSrc;
    }
</script>
</body>
</html>
