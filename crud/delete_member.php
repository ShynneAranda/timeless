<?php
require_once(__DIR__ . '/../db/database.php');

if (isset($_GET['member_id'])) {
    $member_id = $_GET['member_id'];

    $sql = $conn->prepare("DELETE FROM members WHERE member_id = ?");
    $sql->bind_param("i", $member_id);

    if ($sql->execute()) {
        echo "<script>alert('Member deleted successfully!'); window.location.href='../home.php';</script>";
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
    <title>Delete Member</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<h2>Delete Member</h2>

<form>
    <p>Are you sure you want to delete this member?</p>
    <button onclick="window.location.href='../home.php'">Go Back</button>
</form>

</body>
</html>
