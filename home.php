
<?php 
require_once('db/database.php');

// Fetch all data for initial display
$books = $conn->query("SELECT b.ISBN, b.title, a.author_name, c.category, b.pubyear, b.book_language
                     FROM books b
                     LEFT JOIN authors a ON b.author_ID = a.author_id
                     LEFT JOIN categories c ON b.category_id = c.category_id");

$members = $conn->query("SELECT member_id, CONCAT(first_name, ' ', middle_name, ' ', last_name) AS name, email, phone_number, join_date
                       FROM members");

$borrowing_log = $conn->query("SELECT bl.borrow_id, 
                                      CONCAT(m.first_name, ' ', m.middle_name, ' ', m.last_name) AS member_name, 
                                      b.title, bl.borrow_date, bl.deadline, bl.return_date
                              FROM borrowing_log bl
                              LEFT JOIN members m ON bl.member_id = m.member_id
                              LEFT JOIN books b ON bl.ISBN = b.ISBN");

$categories = $conn->query("SELECT category_id, category FROM categories");

// Search functionality
$search_query = isset($_GET['query']) ? trim($_GET['query']) : '';
$search_active = !empty($search_query);
$search_results = [
    'books' => null,
    'members' => null,
    'borrowing_log' => null,
    'categories' => null,
    'authors' => null
];if ($search_active) {
    $search = $conn->real_escape_string($search_query);

    $search_results['books'] = $conn->query("SELECT b.ISBN, b.title, a.author_name, c.category, b.pubyear, b.book_language
                                             FROM books b
                                             LEFT JOIN authors a ON b.author_ID = a.author_id
                                             LEFT JOIN categories c ON b.category_id = c.category_id
                                             WHERE b.ISBN LIKE '%$search%'
                                             OR b.title LIKE '%$search%' 
                                             OR a.author_name LIKE '%$search%' 
                                             OR c.category LIKE '%$search%'");

    $search_results['members'] = $conn->query("SELECT member_id, CONCAT(first_name, ' ', middle_name, ' ', last_name) AS name, email, phone_number, join_date
                                               FROM members
                                               WHERE first_name LIKE '%$search%' 
                                               OR middle_name LIKE '%$search%' 
                                               OR last_name LIKE '%$search%' 
                                               OR email LIKE '%$search%'");

    $search_results['borrowing_log'] = $conn->query("SELECT bl.borrow_id, 
                                                    CONCAT(m.first_name, ' ', m.middle_name, ' ', m.last_name) AS member_name, 
                                                    b.title, bl.borrow_date, bl.deadline, bl.return_date
                                                    FROM borrowing_log bl
                                                    LEFT JOIN members m ON bl.member_id = m.member_id
                                                    LEFT JOIN books b ON bl.ISBN = b.ISBN
                                                    WHERE m.first_name LIKE '%$search%' 
                                                    OR m.middle_name LIKE '%$search%' 
                                                    OR m.last_name LIKE '%$search%' 
                                                    OR b.title LIKE '%$search%'");

    $search_results['categories'] = $conn->query("SELECT category_id, category 
                                                  FROM categories
                                                  WHERE category LIKE '%$search%'");

    $search_results['authors'] = $conn->query("SELECT author_id, author_name 
                                               FROM authors
                                               WHERE author_name LIKE '%$search%'");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Home - Timeless Vault</title>
    <link rel="stylesheet" href="css/style-home.css">
</head>
<body>

    <div class="container">
    <div class="top-bar">
    <a href="logout.php" class="logout-btn">Logout</a> <!-- Move inside -->
    <div class="top-bar-center">
        <a href="crud/add_author.php" class="top-btn">Add Authors</a>
        <a href="crud/add_category.php" class="top-btn">Add Categories</a>
        <a href="crud/add_book.php" class="top-btn">Add Book</a>
        <a href="crud/add_member.php" class="top-btn">Add Member</a>
        <a href="crud/add_borrow.php" class="top-btn">Add Borrowing Log</a>
        
    </div>
</div>


        <h2 class="search-title">Search</h2>

        <!-- Search Form (Correctly Positioned) -->
        <form action="" method="GET" class="search-form">
            <input type="text" name="query" class="search-input" placeholder="Search anything..." value="<?= htmlspecialchars($search_query) ?>">
            <button type="submit" class="search-btn">Search</button>
        </form>

        <h2>Books</h2>
        <div class="table-container">
            <table>
                <tr>
                    <th>ISBN</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th>Publication Year</th>
                    <th>Language</th>
                    <th>Actions</th>
                </tr>
                <?php 
                $data = $search_active ? $search_results['books'] : $books;
                while ($row = $data->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['ISBN']; ?></td>
                        <td><?= $row['title']; ?></td>
                        <td><?= $row['author_name']; ?></td>
                        <td><?= $row['category']; ?></td>
                        <td><?= $row['pubyear']; ?></td>
                        <td><?= $row['book_language']; ?></td>
                        <td>
                            <a href="crud/edit_book.php?isbn=<?= urlencode($row['ISBN']); ?>" class="action-btn edit-btn">Edit</a>
                            <a href="crud/delete_book.php?isbn=<?= urlencode($row['ISBN']); ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>

        <h2>Borrowing Log</h2>
        <div class="table-container">
            <table>
                <tr>
                    <th>Borrow ID</th>
                    <th>Member</th>
                    <th>Book</th>
                    <th>Borrow Date</th>
                    <th>Deadline</th>
                    <th>Return Date</th>
                    <th>Actions</th>
                </tr>
                <?php 
                $data = $search_active ? $search_results['borrowing_log'] : $borrowing_log;
                while ($row = $data->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['borrow_id']; ?></td>
                        <td><?= $row['member_name']; ?></td>
                        <td><?= $row['title']; ?></td>
                        <td><?= $row['borrow_date']; ?></td>
                        <td><?= $row['deadline']; ?></td>
                        <td><?= $row['return_date'] ? $row['return_date'] : 'Not Returned'; ?></td>
                        <td>
                            <a href="crud/edit_borrow.php?borrow_id=<?= $row['borrow_id']; ?>" class="action-btn edit-btn">Edit</a>
                            <a href="crud/delete_borrow.php?borrow_id=<?= $row['borrow_id']; ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>

        <h2>Members</h2>
        <div class="table-container">
            <table>
                <tr>
                    <th>Member ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Join Date</th>
                    <th>Actions</th>
                </tr>
                <?php 
                $data = $search_active ? $search_results['members'] : $members;
                while ($row = $data->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['member_id']; ?></td>
                        <td><?= $row['name']; ?></td>
                        <td><?= $row['email']; ?></td>
                        <td><?= $row['phone_number']; ?></td>
                        <td><?= $row['join_date']; ?></td>
                        <td>
                            <a href="crud/edit_member.php?member_id=<?= urlencode($row['member_id']); ?>" class="action-btn edit-btn">Edit</a>
                            <a href="crud/delete_member.php?member_id=<?= urlencode($row['member_id']); ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
        <h2>Authors</h2>
<div class="table-container">
    <table id="authors-table"> <!-- Add the id here -->
        <tr>
            <th>Author ID</th>
            <th>Author Name</th>
            <th>Actions</th>
        </tr>
        <?php 
        $data = $search_active ? $search_results['authors'] : $conn->query("SELECT author_id, author_name FROM authors");
        while ($row = $data->fetch_assoc()): ?>
            <tr>
                <td><?= $row['author_id']; ?></td>
                <td><?= $row['author_name']; ?></td>
                <td>
                    <a href="crud/edit_author.php?author_id=<?= urlencode($row['author_id']); ?>" class="action-btn edit-btn">Edit</a>
                    <a href="crud/delete_author.php?author_id=<?= urlencode($row['author_id']); ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>


<h2>Categories</h2>
<div class="table-container">
<table id="categories-table">
        <tr>
            <th>Category ID</th>
            <th>Category Name</th>
            <th>Actions</th>
        </tr>
        <?php 
        $data = $search_active ? $search_results['categories'] : $categories;
        while ($row = $data->fetch_assoc()): ?>
            <tr>
                <td><?= $row['category_id']; ?></td>
                <td><?= $row['category']; ?></td>
                <td>
                    <a href="crud/edit_category.php?category_id=<?= $row['category_id']; ?>" class="action-btn edit-btn">Edit</a>
                    <a href="crud/delete_category.php?category_id=<?= $row['category_id']; ?>" class="action-btn delete-btn" onclick="return confirm('Are you sure?')">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</div>




</body>
</html>
