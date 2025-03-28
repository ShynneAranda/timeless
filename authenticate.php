<?php
session_start();

// Simulated login (bypass authentication)
$_SESSION['user_id'] = 1;  // Sample user ID
$_SESSION['username'] = "admin"; // Sample username

header("Location: home.php"); // Redirect to home page after login
exit();
?>
