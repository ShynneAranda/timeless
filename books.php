<?php
require_once('db/database.php');

$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
}
$search = $conn->real_escape_string($_GET['search']);

$query = "SELECT b.ISBN, b.title, a.author_name, c.category_name, b.pubyear, b.book_language 
          FROM books b
          JOIN authors a ON b.author_ID = a.author_ID
          JOIN categories c ON b.category_id = c.category_id
          WHERE b.title LIKE '%$search%' OR a.author_name LIKE '%$search%' OR b.ISBN LIKE '%$search%'";

$result = $conn->query($query);
?>

<form method="GET">
    <input type="text" name="search" placeholder="Search by Title, Author, or ISBN" value="<?php echo $search; ?>">
    <button type="submit">Search</button>
</form>

<table border="1">
    <tr>
        <th>ISBN</th>
        <th>Title</th>
        <th>Author</th>
        <th>Category</th>
        <th>Publication Year</th>
        <th>Language</th>
        <th>Actions</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['ISBN']; ?></td>
            <td><?php echo $row['title']; ?></td>
            <td><?php echo $row['author_name']; ?></td>
            <td><?php echo $row['category']; ?></td>
            <td><?php echo $row['pubyear']; ?></td>
            <td><?php echo $row['book_language']; ?></td>
            <td>
                <a href="crud/edit_book.php?isbn=<?php echo $row['ISBN']; ?>">Edit</a> |
                <a href="crud/delete_book.php?isbn=<?php echo $row['ISBN']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
            </td>
        </tr>
        

    <?php } ?>
</table>
