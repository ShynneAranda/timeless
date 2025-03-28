<?php
require_once(__DIR__ . '/../db/database.php');

if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];

    $sql = $conn->prepare("DELETE FROM categories WHERE category_id = ?");
    $sql->bind_param("i", $category_id);

    if ($sql->execute()) {
        echo "<script>alert('Category deleted successfully!'); window.location.href='../home.php';</script>";
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
    <title>Delete Category</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h2>Delete Category</h2>

<form>
    <p>Are you sure you want to delete this category?</p>
    <button onclick="window.location.href='../home.php'">Go Back</button>
</form>

</body>
</html>
