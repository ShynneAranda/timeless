<?php
require_once(__DIR__ . '/../db/database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $join_date = $_POST['join_date'];

    $query = $conn->prepare("INSERT INTO members (first_name, middle_name, last_name, email, phone_number, join_date) 
              VALUES (?, ?, ?, ?, ?, ?)");
    $query->bind_param("ssssss", $first_name, $middle_name, $last_name, $email, $phone_number, $join_date);

    if ($query->execute()) {
        echo "<script>alert('New member added successfully!'); window.location.href='../home.php';</script>";
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
    <title>Add Member</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h2 class="edit-title">Add a New Member</h2>

<form method="POST">
    <label>First Name:</label>
    <input type="text" name="first_name" required><br>

    <label>Middle Name:</label>
    <input type="text" name="middle_name"><br>

    <label>Last Name:</label>
    <input type="text" name="last_name" required><br>

    <label>Email:</label>
    <input type="email" name="email" required><br>

    <label>Phone Number:</label>
    <input type="text" name="phone_number" required><br>

    <label>Join Date:</label>
    <input type="date" name="join_date" required><br>

    <button type="submit">Add Member</button>
</form>

</body>
</html>
