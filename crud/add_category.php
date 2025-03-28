<?php 
require_once(__DIR__ . '/../db/database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category = $_POST['category'];

    $query = $conn->prepare("INSERT INTO categories (category) VALUES (?)");
    $query->bind_param("s", $category);

    if ($query->execute()) {
        echo "<script>alert('Category added successfully!'); window.location.href = '../home.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }

    $query->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Category</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h2 class="edit-title">Add a New Category</h2>

<form method="POST">
    <label>Category Name:</label>
    <input type="text" name="category" required><br>

    <button type="submit">Add Category</button>
</form>

</body>
</html>
