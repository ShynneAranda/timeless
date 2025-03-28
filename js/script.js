// Books
function editBook(isbn) {
    window.location.href = `crud/edit_book.php?isbn=${isbn}`;
}
function deleteBook(isbn) {
    if (confirm("Are you sure you want to delete this book?")) {
        window.location.href = `crud/delete_book.php?isbn=${isbn}`;
    }
}

// Check if search keyword exists
if (isset($_GET['search'])) {
    $keyword = $conn->real_escape_string($_GET['search']);

    // Search in authors
    $authors_query = "SELECT * FROM authors WHERE author_name LIKE '%$keyword%'";
    $authors_result = $conn->query($authors_query);

    // Search in categories
    $categories_query = "SELECT * FROM categories WHERE category LIKE '%$keyword%'";
    $categories_result = $conn->query($categories_query");

    $search_results = [
        'authors' => $authors_result,
        'categories' => $categories_result,
        // Include other results like books, members, borrowing_log
    ];
}

// Members
function editMember(id) {
    window.location.href = `crud/edit_member.php?member_id=${id}`;
}
function deleteMember(id) {
    if (confirm("Are you sure you want to delete this member?")) {
        window.location.href = `crud/delete_member.php?member_id=${id}`;
    }
}

// Borrowing Log
function editBorrow(id) {
    window.location.href = `crud/edit_borrow.php?borrow_id=${id}`;
}
function deleteBorrow(id) {
    if (confirm("Are you sure you want to delete this borrowing record?")) {
        window.location.href = `crud/delete_borrow.php?borrow_id=${id}`;
    }
}
