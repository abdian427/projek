<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];
$message = "";

// Proses perubahan pengaturan notifikasi
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir dan lakukan validasi di sini
    $emailNotifications = isset($_POST['email_notifications']) ? 1 : 0; // Contoh: toggle email notifications

    // Simulasi update berhasil
    $message = "Pengaturan notifikasi berhasil diperbarui.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Notifikasi</title>
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
    <h2>Halo, <?php echo htmlspecialchars($username); ?>! Ubah Pengaturan Notifikasi Anda</h2>
    
    <?php if ($message): ?>
        <p class="text-success"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="post" action="notifications.php">
        <div class="form-group">
            <label>
                <input type="checkbox" name="email_notifications" <?php // Check if notifications are enabled to mark the checkbox? ?>>
                Terima notifikasi melalui email
            </label>
        </div>
        <button type="submit" class="btn btn-primary">Perbarui Pengaturan Notifikasi</button>
    </form>
    
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
