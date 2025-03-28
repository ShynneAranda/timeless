<?php
require_once(__DIR__ . '/../db/database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $member_id = $_POST['member_id'];
    $isbn = $_POST['isbn'];
    $borrow_date = $_POST['borrow_date'];
    $return_date = $_POST['return_date'];

    // Calculate deadline (7 days after borrow_date)
    $deadline = date('Y-m-d', strtotime($borrow_date . ' + 7 days'));

    // Use prepared statement to insert data
    $sql = $conn->prepare("INSERT INTO borrowing_log (member_id, ISBN, borrow_date, deadline, return_date) 
                           VALUES (?, ?, ?, ?, ?)");
    $sql->bind_param("issss", $member_id, $isbn, $borrow_date, $deadline, $return_date);

    if ($sql->execute()) {
        echo "<script>
            alert('New borrow log added successfully!');
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
    <title>Add Borrowing Record</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h2 class="edit-title">Add Borrowing Record</h2>

<form method="POST">
    Member ID: <input type="number" name="member_id" required><br>
    ISBN: <input type="text" name="isbn" required><br>
    Borrow Date: <input type="date" name="borrow_date" required><br>
    Return Date: <input type="date" name="return_date"><br>
    <button type="submit">Add Borrowing Record</button>
</form>

</body>
</html>
