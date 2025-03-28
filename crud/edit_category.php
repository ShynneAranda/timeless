<?php
require_once(__DIR__ . '/../db/database.php');

// Check if category_id is provided in the URL
if (!isset($_GET['category_id']) || empty($_GET['category_id'])) {
    die("<script>alert('Error: No category ID provided!'); window.location.href='../home.php';</script>");
}

$category_id = $_GET['category_id'];

// Fetch category details
$query = $conn->prepare("SELECT * FROM categories WHERE category_id = ?");
$query->bind_param("i", $category_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows == 0) {
    die("<script>alert('Error: Category not found!'); window.location.href='../home.php';</script>");
}

$category = $result->fetch_assoc();
$query->close();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $category_value = htmlspecialchars($_POST['category']); // Renamed variable to avoid overwriting array

    // Update the category
    $sql = $conn->prepare("UPDATE categories SET category=? WHERE category_id=?");
    $sql->bind_param("si", $category_value, $category_id);

    if ($sql->execute()) {
        echo "<script>
            alert('Category updated successfully!');
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
    <title>Edit Category</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h2 class="edit-title">Edit Category</h2>

<form method="POST">
    <label>Category Name:</label>
    <input type="text" name="category" value="<?php echo htmlspecialchars($category['category']); ?>" required>

    <button type="submit">Update Category</button>
</form>

</body>
</html>
