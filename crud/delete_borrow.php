<?php
include '../db/database.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$borrow_id = intval($_GET['borrow_id'] ?? 0);
if ($borrow_id === 0) {
    die("<script>alert('Error: No Borrow ID provided!'); window.location.href='../home.php';</script>");
}

$sql = $conn->prepare("DELETE FROM borrowing_log WHERE borrow_id = ?");
$sql->bind_param("i", $borrow_id);

if ($sql->execute()) {
    echo "<script>
        alert('Borrowing record deleted successfully.');
        window.location.href = '../home.php';
    </script>";
} else {
    echo "<script>
        alert('Error deleting record: " . $conn->error . "');
        window.location.href = '../home.php';
    </script>";
}

$sql->close();
$conn->close();
?>
