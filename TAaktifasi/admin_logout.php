<?php
session_start();
session_unset();
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out...</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #343a40; /* Dark background for the loading screen */
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full viewport height */
            flex-direction: column;
        }
        .spinner-border {
            width: 3rem;
            height: 3rem;
        }
        .loading-text {
            margin-top: 20px;
            font-size: 1.2rem;
        }
    </style>
    <script>
        // Redirect to the login page after 2 seconds
        setTimeout(function() {
            window.location.href = 'index.php';
        }, 2000); // Change the duration (in milliseconds) as needed
    </script>
</head>
<body>

    <div>
        <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <div class="loading-text">Logging out, please wait...</div>
    </div>

</body>
</html>
