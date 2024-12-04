<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: admin_login.php");
    exit();
}

include 'db_config.php';

// Query to get the total number of users
$userCountQuery = "SELECT COUNT(*) AS total_users FROM users";
$userCountResult = mysqli_query($conn, $userCountQuery);
$totalUsers = mysqli_fetch_assoc($userCountResult)['total_users'];

// Query to get the total expenses
$totalExpensesQuery = "SELECT SUM(jumlah) AS total_expenses FROM pengeluaran";
$totalExpensesResult = mysqli_query($conn, $totalExpensesQuery);
$totalExpenses = mysqli_fetch_assoc($totalExpensesResult)['total_expenses'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('moscowa.jpeg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 50vh;
            color: white;
            margin: 0;
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 50px;
            max-width: 900px;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
        }
        .card {
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
        }
        .jdl {
            color: black;
        }
    </style>
</head>
<body>
<div class="container">
    <h3 class="text-center">User Dashboard</h3>
    <div class="card mt-4">
        <div class="card-body text-center">
            <h5 class="jdl">Total Pengeluaran: <span class="text-danger">Rp. <?php echo number_format($totalExpenses, 0, ',', '.'); ?></span></h5>
        </div>
    </div>
    <div class="mt-4 text-center">
        <a href="donate.php" class="btn btn-primary mx-2">donasi</a>
        <a href="view_expense.php" class="btn btn-primary mx-2">View Pengeluaran</a>
        <a href="admin_logout.php" class="btn btn-secondary mx-2">Logout</a>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
