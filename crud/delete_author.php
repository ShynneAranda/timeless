<?php
require_once(__DIR__ . '/../db/database.php');

if (isset($_GET['author_id'])) {
    $author_id = $_GET['author_id'];

    $sql = $conn->prepare("DELETE FROM authors WHERE author_id = ?");
    $sql->bind_param("i", $author_id);

    if ($sql->execute()) {
        echo "<script>alert('Author deleted successfully!'); window.location.href='../home.php';</script>";
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
    <title>Delete Author</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h2>Delete Author</h2>

<form>
    <p>Are you sure you want to delete this author?</p>
    <button onclick="window.location.href='../home.php'">Go Back</button>
</form>

</body>
</html>
