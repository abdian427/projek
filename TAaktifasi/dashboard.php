<?php
session_start();
include 'db_config.php';

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];

// Ambil data pengguna termasuk foto profil
$sql = "SELECT profile_picture FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($profile_picture);
$stmt->fetch();
$stmt->close();

// Ambil data pemasukan dan pengeluaran
$income_sql = "SELECT SUM(jumlah) FROM pemasukan";
$expense_sql = "SELECT SUM(jumlah) FROM pengeluaran";

$income_stmt = $conn->prepare($income_sql);
$income_stmt->execute();
$income_stmt->bind_result($total_income);
$income_stmt->fetch();
$income_stmt->close();

$expense_stmt = $conn->prepare($expense_sql);
$expense_stmt->execute();
$expense_stmt->bind_result($total_expense);
$expense_stmt->fetch();
$expense_stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Tambahkan Chart.js -->

    <style>
        body {
            background-image: url('masjiddd.jpeg'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
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
            display: flex; 
            flex-direction: column; 
            justify-content: center; 
            align-items: center; 
            text-align: center; 
            padding: 20px;
            color: white; 
        }

        .clock-display {
            position: absolute;
            top: 10px;
            right: 10px;
            padding: 10px 20px;
            background: linear-gradient(135deg, #00c6ff, #0072ff);
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.5);
            font-family: 'Courier New', monospace;
            font-size: 24px;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
            border: 2px solid rgba(255, 255, 255, 0.5);
        }

        .profile-info {
            display: flex;
            align-items: center; 
            margin-bottom: 10px; 
        }

        .profile-image {
            width: 30px;  
            height: 30px;
            border-radius: 50%; 
            object-fit: cover; 
            margin-right: 10px; 
        }

        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px 0;
        }

        .footer p {
            margin: 0;
        }
    </style>
</head>
<body>

    <div class="clock-display">
        <span id="clock"></span>
    </div>

    <div class="container-fluid">
        <!-- Sidebar Menu -->
        <div class="sidebar">
            <h2>Dashboard</h2>
            <ul>
                <li class="profile-info">
                    <?php if ($profile_picture): ?>
                        <img src="<?php echo htmlspecialchars($profile_picture); ?>" alt="Foto Profil" class="profile-image">
                    <?php else: ?>
                        <img src="gambar/default_profile.jpeg" alt="Foto Profil" class="profile-image"> 
                    <?php endif; ?>
                    <a href="#" style="color: white;">Welcome, <?php echo htmlspecialchars($username); ?>!</a>
                </li>
                <li><a href="add_income.php" >Tambah Pemasukan</a></li>
                <li><a href="add_expense.php">Tambah Pengeluaran</a></li>
                <li><a href="settings.php">Pengaturan</a></li>
                <li><a href="developers.php">Developers</a></li>
                <li><a href="view_users.php">users</a></li>
                <li><a href="dompet.php">dompet kita</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div>

        <div class="content">
            <h1>Selamat Datang di Dashboard</h1>
            <p>Kelola pemasukan dan pengeluaran dengan mudah.</p>

            <canvas id="incomeExpenseChart" width="400" height="200"></canvas>
        </div>
    </div>

    <!-- JavaScript untuk memperbarui jam -->
    <script>
        function updateClock() {
            var now = new Date();
            var hours = now.getHours().toString().padStart(2, '0');
            var minutes = now.getMinutes().toString().padStart(2, '0');
            var seconds = now.getSeconds().toString().padStart(2, '0');
            var timeString = hours + ':' + minutes + ':' + seconds;
            document.getElementById('clock').textContent = timeString;
        }
        setInterval(updateClock, 1000); 
        updateClock(); 

        // Diagram Batang Pemasukan dan Pengeluaran
        const ctx = document.getElementById('incomeExpenseChart').getContext('2d');
        const incomeExpenseChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Pemasukan', 'Pengeluaran'],
                datasets: [{
                    label: 'Jumlah',
                    data: [<?php echo $total_income ?: 0; ?>, <?php echo $total_expense ?: 0; ?>],
                    backgroundColor: [
                        'green',
                        'red'
                    ],
                    borderColor: [
                        'black',
                        'black'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
