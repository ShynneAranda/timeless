<?php
require_once(__DIR__ . '/../db/database.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$borrow_id = intval($_GET['borrow_id'] ?? 0);
if ($borrow_id === 0) {
    die("<script>alert('Error: No Borrow ID provided!'); window.location.href='../home.php';</script>");
}

// Fetch borrowing details along with book title
$query = $conn->prepare("
    SELECT b.borrow_id, b.member_id, b.ISBN, b.borrow_date, b.deadline, b.return_date, books.title 
    FROM borrowing_log AS b
    JOIN books ON b.ISBN = books.ISBN
    WHERE b.borrow_id = ?
");
$query->bind_param("i", $borrow_id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows == 0) {
    die("<script>alert('Error: Borrowing record not found!'); window.location.href='../home.php';</script>");
}

$borrow = $result->fetch_assoc();
$query->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $member_id = $_POST['member_id'];
    $isbn = $_POST['isbn'];
    $borrow_date = $_POST['borrow_date'];
    $return_date = !empty($_POST['return_date']) ? $_POST['return_date'] : NULL;

    // Check if the new ISBN exists in books table
    $book_query = $conn->prepare("SELECT title FROM books WHERE ISBN = ?");
    $book_query->bind_param("s", $isbn);
    $book_query->execute();
    $book_result = $book_query->get_result();

    if ($book_result->num_rows == 0) {
        die("<script>alert('Error: Invalid ISBN, book not found!'); window.location.href='../home.php';</script>");
    }

    $book = $book_result->fetch_assoc();
    $book_query->close();

    // Calculate deadline (borrow_date + 7 days)
    $deadline = date('Y-m-d', strtotime($borrow_date . ' + 7 days'));

    // Update borrowing record
    $sql = $conn->prepare("UPDATE borrowing_log 
                           SET member_id=?, ISBN=?, borrow_date=?, deadline=?, return_date=? 
                           WHERE borrow_id=?");
    $sql->bind_param("issssi", $member_id, $isbn, $borrow_date, $deadline, $return_date, $borrow_id);

    if ($sql->execute()) {
        echo "<script>
            alert('Borrowing record updated successfully!');
            window.location.href = '../home.php'; 
        </script>";
    } else {
        echo "<script>alert('Error updating record: " . $conn->error . "');</script>";
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
    <title>Edit Borrowing Record</title>
    <link rel="stylesheet" href="../css/style.css">
    <script>
    function fetchBookTitle() {
    let isbn = document.getElementById("isbn").value.trim();
    if (isbn !== "") {
        fetch("/timeless/fetch_book_title.php?isbn=" + encodeURIComponent(isbn))
            .then(response => response.text())
            .then(data => {
                let titleInput = document.getElementById("title");
                if (data.includes("Book not found")) {
                    titleInput.value = ""; // Clear input if ISBN is invalid
                } else {
                    titleInput.value = data; // Set book title
                }
            })
            .catch(error => console.error("Error fetching book title:", error));
    } else {
        document.getElementById("title").value = "";
    }
}

</script>

</head>
<body>

<h2 class="edit-title">Edit Borrowing Record</h2>

<form method="POST">
    <label>Member ID:</label>
    <input type="number" name="member_id" value="<?php echo htmlspecialchars($borrow['member_id']); ?>" required><br>

    <label>ISBN:</label>
    <input type="text" id="isbn" name="isbn" value="<?php echo htmlspecialchars($borrow['ISBN']); ?>" required oninput="fetchBookTitle()"><br>

    <label>Book Title:</label>
<input type="text" id="title" value="<?php echo htmlspecialchars($borrow['title'] ?? ''); ?>" readonly>


    <label>Borrow Date:</label>
    <input type="date" name="borrow_date" value="<?php echo htmlspecialchars($borrow['borrow_date']); ?>" required><br>

    <label>Return Date:</label>
    <input type="date" name="return_date" value="<?php echo htmlspecialchars($borrow['return_date'] ?? ''); ?>"><br>

    <button type="submit">Update Borrowing Record</button>
</form>

</body>
</html>
