<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/timeless/db/database.php');


header("Content-Type: text/plain"); // Ensure it's plain text

$isbn = $_GET['isbn'] ?? '';

if (!empty($isbn)) {
    $query = $conn->prepare("SELECT title FROM books WHERE ISBN = ?");
    $query->bind_param("s", $isbn);
    $query->execute();
    $result = $query->get_result();

    if ($row = $result->fetch_assoc()) {
        echo trim($row['title']); // Ensure no extra spaces
    } else {
        echo "Book not found";
    }

    $query->close();
}

$conn->close();
?>
