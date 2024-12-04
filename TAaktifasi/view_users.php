<?php
include 'db_config.php';

// Query to get all users
$userQuery = "SELECT * FROM users";
$userResult = mysqli_query($conn, $userQuery);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            background-image: url('moscowa.jpeg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            color: #fff;
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
            text-align: center;
            margin-bottom: 20px;
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
            max-width: 900px;
            margin: auto;
            background-color: rgba(0, 0, 0, 0.5);
            padding: 20px;
            border-radius: 8px;
            color: #fff;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>Menu</h2>
    <ul>
        <li><a href="dashboard.php">Dashboard</a></li>
        <li><a href="add_income.php">Tambah Pemasukan</a></li>
        <li><a href="add_expense.php">Tambah Pengeluaran</a></li>
        <li><a href="settings.php">Pengaturan</a></li>
        <li><a href="developers.php">Developers</a></li>
        <li><a href="view_users.php">Users</a></li>
        <li><a href="dompet.php">Dompet Kita</a></li>
        <li><a href="logout.php">Logout</a></li>
    </ul>
</div>

<div class="content">
    <h3 class="text-white">List of Users</h3>
    <table class="table table-dark table-striped mt-3">
        <thead>
            <tr>
                <th>No</th>
                <th>Username</th>
                <th>Role</th> <!-- Display Role Column -->
            </tr>
        </thead>
        <tbody>
        <?php $no = 1; ?>
        <?php while ($row = mysqli_fetch_assoc($userResult)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?php echo $row['username']; ?></td>
                <td><?php echo $row['role']; ?></td> <!-- Display Role -->
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
