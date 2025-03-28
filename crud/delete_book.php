<?php
require_once(__DIR__ . '/../db/database.php');

if (isset($_GET['isbn'])) {
    $isbn = $_GET['isbn'];

    $sql = $conn->prepare("DELETE FROM books WHERE ISBN = ?");
    $sql->bind_param("s", $isbn);

    if ($sql->execute()) {
        echo "<script>alert('Book deleted successfully!'); window.location.href='../home.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }

    $sql->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Book</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h2>Delete Book</h2>

<form>
    <p>Are you sure you want to delete this book?</p>
    <button onclick="window.location.href='../home.php'">Go Back</button>
</form>

</body>
</html>
