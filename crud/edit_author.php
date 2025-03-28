<?php
require_once(__DIR__ . '/../db/database.php');

if (!isset($_GET['author_id']) || empty($_GET['author_id'])) {
    die("<script>alert('Error: No Author ID provided!'); window.location.href='../home.php';</script>");
}

$author_id = $_GET['author_id'];

$query = $conn->prepare("SELECT * FROM authors WHERE author_id = ?");
$query->bind_param("i", $author_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows == 0) {
    die("<script>alert('Error: Author not found!'); window.location.href='../home.php';</script>");
}

$author = $result->fetch_assoc();
$query->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $author_name = htmlspecialchars($_POST['author_name']);

    $sql = $conn->prepare("UPDATE authors SET author_name=? WHERE author_id=?");
    $sql->bind_param("si", $author_name, $author_id);

    if ($sql->execute()) {
        echo "<script>
            alert('Author updated successfully!');
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
    <title>Edit Author</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h2 class="edit-title">Edit Author</h2>

<form method="POST">
    <label>Author Name:</label>
    <input type="text" name="author_name" value="<?php echo htmlspecialchars($author['author_name']); ?>" required><br>

    <button type="submit">Update Author</button>
</form>

</body>
</html>
