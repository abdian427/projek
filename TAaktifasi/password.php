<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];
$message = "";

// Koneksi ke database
$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "db_masjid";

$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Proses perubahan kata sandi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($newPassword === $confirmPassword) {
        // Ambil data pengguna berdasarkan username
        $sql = "SELECT password FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($hashedPassword);
        $stmt->fetch();

        // Periksa apakah kata sandi lama cocok
        if (password_verify($currentPassword, $hashedPassword)) {
            // Hash kata sandi baru dan update ke database
            $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $updateSql = "UPDATE users SET password = ? WHERE username = ?";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bind_param("ss", $newHashedPassword, $username);

            if ($updateStmt->execute()) {
                $message = "Kata sandi berhasil diperbarui.";
            } else {
                $message = "Gagal memperbarui kata sandi. Silakan coba lagi.";
            }
            $updateStmt->close();
        } else {
            $message = "Kata sandi saat ini salah.";
        }
        $stmt->close();
    } else {
        $message = "Kata sandi baru dan konfirmasi tidak cocok.";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Kata Sandi</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
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
            margin-bottom: 20px;
            text-align: center;
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
        .message {
            color: green;
        }
        .error {
            color: red;
        }
    </style>
</head>
<body>

<div class="container-fluid">
    <div class="sidebar">
        <h2>Pengaturan</h2>
        <ul>
            <li><a href="profile.php">Profil Pengguna</a></li>
            <li><a href="password.php">Ubah Kata Sandi</a></li>
            <li><a href="notifications.php">Pengaturan Notifikasi</a></li>
            <li><a href="dashboard.php">Kembali ke Dashboard</a></li>
        </ul>
    </div>
    <div class="container">
        <h2>Halo, <?php echo htmlspecialchars($username); ?>! Ubah Kata Sandi Anda</h2>
        
        <?php if ($message): ?>
            <p class="<?php echo ($message === "Kata sandi berhasil diperbarui.") ? 'text-success' : 'text-danger'; ?>">
                <?php echo $message; ?>
            </p>
        <?php endif; ?>

        <form method="post" action="password.php">
            <div class="form-group">
                <label for="currentPassword">Kata Sandi Saat Ini:</label>
                <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
            </div>
            <div class="form-group">
                <label for="newPassword">Kata Sandi Baru:</label>
                <input type="password" class="form-control" id="newPassword" name="newPassword" required>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Konfirmasi Kata Sandi Baru:</label>
                <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
            </div>
            <button type="submit" class="btn btn-primary">Perbarui Kata Sandi</button>
        </form>
        
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
