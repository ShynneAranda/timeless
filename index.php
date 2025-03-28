
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Timeless Vault</title>
    <link rel="stylesheet" href="/timeless/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">

</head>
<body>
    <div class="container">
        <div class="overlay"></div>
        
        <!-- Header Section -->
        <header>
            <div class="logo">
                <img src="/timeless/images/logobook.png" alt="Logo" class="logo-img"> <!-- Your Logo Image -->
                <span>Timeless Vault</span> <!-- Text beside the logo -->
            </div>
            <a href="login.php" class="login-btn">Login</a>
        </header>

        <!-- Main Content -->
        <div class="main-content">
            <div class="content">
                <h1>Welcome to Timeless Vault</h1>
                <p>A modern Library Management System for efficient book tracking.</p>
                <a href="login.php" class="cta-btn">Get  Started</a>
            </div>
        </div>
    </div>
</body>
</html>
