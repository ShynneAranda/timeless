<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Timeless Vault</title>
    <link rel="stylesheet" href="/timeless/css/style.css">
</head>
<body>
    <div class="container">
        <div class="overlay"></div>

        <header>
            <div class="logo">
                <img src="/timeless/images/logobook.png" alt="Logo" class="logo-img">
                <span>Timeless Vault</span>
            </div>
            <a href="index.php" class="login-btn">Back</a>
        </header>

        <!-- Login Form -->
        <div class="main-content">
            <div class="content login-box">
                <h2>Login</h2>
                <form action="authenticate.php" method="POST">
                    <input type="text" name="username" placeholder="Username" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit" class="login-submit">Login</button>
                </form>
                <a href="#" class="cta-btn">Forgot password?</a>
            </div>
        </div>
    </div>
</body>
</html>
