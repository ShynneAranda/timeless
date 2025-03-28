<?php
require_once(__DIR__ . '/../db/database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isbn = $_POST['isbn'];
    $title = $_POST['title'];
    $author_id = $_POST['author_id'];
    $category_id = $_POST['category_id'];
    $pubyear = $_POST['pubyear'];
    $book_language = $_POST['book_language'];

    $query = $conn->prepare("INSERT INTO books (ISBN, title, author_ID, category_id, pubyear, book_language) VALUES (?, ?, ?, ?, ?, ?)");
    $query->bind_param("ssiiss", $isbn, $title, $author_id, $category_id, $pubyear, $book_language);

    if ($query->execute()) {
        echo "<script>alert('Book added successfully!'); window.location.href = '../home.php';</script>";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Book</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h2 class="edit-title">Add a New Book</h2>

<form method="POST">
    <label>ISBN:</label>
    <input type="text" name="isbn" required><br>

    <label>Title:</label>
    <input type="text" name="title" required><br>

    <label>Author ID:</label>
    <input type="number" name="author_id" required><br>

    <label>Category ID:</label>
    <input type="number" name="category_id" required><br>

    <label>Publication Year:</label>
    <input type="number" name="pubyear" required><br>

    <label>Language:</label>
    <input type="text" name="book_language" required><br>

    <button type="submit">Add Book</button>
</form>

</body>
</html>
