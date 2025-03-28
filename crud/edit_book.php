<?php
require_once(__DIR__ . '/../db/database.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if ISBN is provided in the URL
if (!isset($_GET['isbn']) || empty($_GET['isbn'])) {
    die("<script>alert('Error: No ISBN provided!'); window.location.href='../home.php';</script>");
}

$isbn = $_GET['isbn'];

// Fetch book details
$query = $conn->prepare("SELECT * FROM books WHERE ISBN = ?");
$query->bind_param("s", $isbn);
$query->execute();
$result = $query->get_result();

if ($result->num_rows == 0) {
    die("<script>alert('Error: Book not found!'); window.location.href='../home.php';</script>");
}

$book = $result->fetch_assoc();
$query->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = htmlspecialchars($_POST['title']);
    $author_id = $_POST['author_id'];
    $category_id = $_POST['category_id'];
    $pubyear = $_POST['pubyear']; 

    // Prepare update statement
    $sql = $conn->prepare("UPDATE books SET title=?, author_ID=?, category_id=?, pubyear=? WHERE ISBN=?");
    $sql->bind_param("siiss", $title, $author_id, $category_id, $pubyear, $isbn);

    if ($sql->execute()) {
        echo "<script>
            alert('Book updated successfully!');
            window.location.href = '../home.php'; 
        </script>";
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
    <title>Edit Book</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h2 class="edit-title">Edit Book</h2>


<form method="POST">
    <label>Title:</label>
    <input type="text" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required><br>

    <label>Author ID:</label>
    <input type="number" name="author_id" value="<?php echo $book['author_ID']; ?>" required><br>

    <label>Category ID:</label>
    <input type="number" name="category_id" value="<?php echo $book['category_id']; ?>" required><br>

    <label>Publication Year:</label>
    <input type="number" name="pubyear" value="<?php echo $book['pubyear']; ?>" required><br>

    <button type="submit">Update Book</button>
</form>

</body>
</html>
