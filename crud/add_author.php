<?php 
require_once(__DIR__ . '/../db/database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $author_name = $_POST['author_name'];

    $query = $conn->prepare("INSERT INTO authors (author_name) VALUES (?)");
    $query->bind_param("s", $author_name);

    if ($query->execute()) {
        echo "<script>alert('Author added successfully!'); window.location.href = '../home.php';</script>";
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
    <title>Add Author</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h2 class="edit-title">Add a New Author</h2>

<form method="POST">
    <label>Author Name:</label>
    <input type="text" name="author_name" required><br>

    <button type="submit">Add Author</button>
</form>

</body>
</html>
