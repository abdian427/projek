<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];
$message = "";

// Proses perubahan pengaturan
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $currentPassword = $_POST['currentPassword'];
    $newPassword = $_POST['newPassword'];
    $confirmPassword = $_POST['confirmPassword'];

    if ($newPassword === $confirmPassword) {
        // Lakukan validasi dan update kata sandi di sini
        $message = "Pengaturan telah berhasil diperbarui.";
    } else {
        $message = "Kata sandi baru dan konfirmasi tidak cocok.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan</title>
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
    <!-- Sidebar Menu -->
    <div class="sidebar">
        <h2>Pengaturan</h2>
        <ul>
            <li><a href="profile.php">Profil Pengguna</a></li>
            <li><a href="password.php">Ubah Kata Sandi</a></li>
            <li><a href="notifications.php">Pengaturan Notifikasi</a></li>
            <li><a href="dashboard.php">Kembali ke Dashboard</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="content">
        <h2>Halo, <?php echo htmlspecialchars($username); ?>! Ubah Pengaturan Akun Anda</h2>
        
        <?php if ($message): ?>
            <p class="<?php echo ($message === "Pengaturan telah berhasil diperbarui.") ? 'message' : 'error'; ?>">
                <?php echo $message; ?>
            </p>
        <?php endif; ?>

        <!-- Ubah Profil -->
        <div id="profile">
            <h3>Profil Pengguna</h3>
            <p>Pengaturan ini bisa digunakan untuk memperbarui profil pengguna.</p>
            <!-- Tambahkan formulir untuk mengubah profil jika diperlukan -->
        </div>
        
        

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
