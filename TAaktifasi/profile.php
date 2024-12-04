<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];
$message = "";
$error = "";

// Ambil data pengguna dari database
$sql = "SELECT email, profile_picture FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($currentEmail, $currentProfilePicture);
$stmt->fetch();
$stmt->close();

// Proses perubahan profil
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newEmail = $_POST['email'];
    $newProfilePicture = $_FILES['profile_picture'];

    // Proses upload gambar jika ada file yang diunggah
    if (!empty($newProfilePicture['name'])) {
        $target_dir = "gambar/";
        $profilePictureName = basename($newProfilePicture['name']);
        $target_file = $target_dir . $profilePictureName;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        
        // Validasi tipe file gambar
        $check = getimagesize($newProfilePicture["tmp_name"]);
        if ($check === false) {
            $error = "File yang diunggah bukan gambar.";
        } elseif (move_uploaded_file($newProfilePicture["tmp_name"], $target_file)) {
            // Jika file berhasil diunggah, update profil dengan gambar baru
            $profilePicturePath = $target_file;
        } else {
            $error = "Terjadi kesalahan saat mengunggah foto profil.";
        }
    } else {
        // Jika tidak ada file yang diunggah, tetap gunakan gambar saat ini
        $profilePicturePath = $currentProfilePicture;
    }

    // Jika tidak ada error, simpan perubahan ke database
    if (empty($error)) {
        $sql = "UPDATE users SET email = ?, profile_picture = ? WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $newEmail, $profilePicturePath, $username);
        
        if ($stmt->execute()) {
            $message = "Profil berhasil diperbarui.";
            $currentEmail = $newEmail;
            $currentProfilePicture = $profilePicturePath;
        } else {
            $error = "Terjadi kesalahan saat memperbarui profil.";
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
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
<div class="container">
    <h2>Halo, <?php echo htmlspecialchars($username); ?>! Ubah Profil Anda</h2>
    
    <?php if ($message): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php elseif ($error): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="post" action="profile.php" enctype="multipart/form-data">
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($currentEmail); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="profile_picture">Foto Profil:</label><br>
            <?php if ($currentProfilePicture): ?>
                <img src="<?php echo $currentProfilePicture; ?>" alt="Foto Profil" style="width:100px; height:auto; border-radius:5px;">
            <?php endif; ?>
            <input type="file" class="form-control" id="profile_picture" name="profile_picture" accept="image/*">
        </div>

        <button type="submit" class="btn btn-primary">Perbarui Profil</button>
    </form>
    
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
