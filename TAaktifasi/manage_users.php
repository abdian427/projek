<?php
session_start();
include 'db_config.php';

if ($_SESSION['role'] != 'admin') {
    echo "Anda tidak memiliki akses ke halaman ini!";
    exit();
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengguna</title>
</head>
<body>
    <h2>Manajemen Pengguna</h2>

</body>
</html>
