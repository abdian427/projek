<?php
require_once('db_config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = $_POST["identifier"]; // Adjusted to match the form input name
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION["username"] = $user['username']; // Fetch username from the query result
            $_SESSION["role"] = $user['role']; // Fetch user role from the query result

            if ($user['role'] === 'admin') {
                header("Location: dashboard.php");
            } else {
                header("Location: admin_dashboard.php");
            }
            exit;   
        } else {
            $error = "Username atau password tidak valid";
        }
    } else {
        $error = "Username atau password tidak valid";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Pengelolaan Uang Masjid</title>
    <style>
        body {
            background-image: url('gambar/masjid.jpeg'); 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, sans-serif;
            margin: 0;
        }

        .login-container {
            background-color: rgba(255, 255, 255, 0.8); 
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #45a049;
            font-size: 14px;
            transition: 1s font-size, 1s background-color;
        }

        .error {
            color: red;
            margin-top: 10px;
        }

        .register-link {
            display: block;
            text-align: center;
            margin-top: 10px;
            color: #007BFF;
            text-decoration: none;
        }

        .register-link:hover {
            text-decoration: underline;
        }

        h2 {
            text-align: center;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Login Pengelolaan Uang Masjid</h2>
        <!-- Login Form -->
        <form action="index.php" method="POST">
            <table>
                <tr>
                    <td><label for="identifier">Username atau Email:</label></td>
                    <td><input type="text" name="identifier" id="identifier" placeholder="Masukkan Username atau Email" required></td>
                </tr>
                <tr>
                    <td><label for="password">Password:</label></td>
                    <td><input type="password" name="password" id="password" placeholder="Masukkan Password" required></td>
                </tr>
                <tr>
                    <td colspan="3"><button type="submit">Login</button></td>
                </tr>
            </table>
        </form>
        <a href="register.php" class="register-link">Belum punya akun? Daftar di sini</a>
        
        <!-- Display Error Message if Exists -->
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
    </div>
</body>
</html>