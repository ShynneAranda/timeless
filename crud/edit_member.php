<?php
require_once(__DIR__ . '/../db/database.php');

// Check if member_id is set in the URL
if (!isset($_GET['member_id'])) {
    echo "<script>alert('Error: No member ID provided!'); window.location.href = '../home.php';</script>";
    exit;
}

$member_id = $_GET['member_id'];

// Fetch the member's current data
$sql = $conn->prepare("SELECT first_name, middle_name, last_name, email FROM members WHERE member_id = ?");
$sql->bind_param("i", $member_id);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows == 0) {
    echo "<script>alert('Error: Member not found!'); window.location.href = '../home.php';</script>";
    exit;
}

$member = $result->fetch_assoc();
$sql->close();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'] ?? '';
    $middle_name = $_POST['middle_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $email = $_POST['email'] ?? '';

    $update_sql = $conn->prepare("UPDATE members SET first_name=?, middle_name=?, last_name=?, email=? WHERE member_id=?");
    $update_sql->bind_param("ssssi", $first_name, $middle_name, $last_name, $email, $member_id);

    if ($update_sql->execute()) {
        echo "<script>
            alert('Member updated successfully!');
            window.location.href = '../home.php';
        </script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }

    $update_sql->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Edit Member</title>
    <link rel="stylesheet" href="../css/style.css">

</head>
<body>

<h2 class="edit-title">Edit Member</h2>

<form method="POST">
    First Name: <input type="text" name="first_name" value="<?= htmlspecialchars($member['first_name'] ?? '') ?>" required><br>
    Middle Name: <input type="text" name="middle_name" value="<?= htmlspecialchars($member['middle_name'] ?? '') ?>"><br>
    Last Name: <input type="text" name="last_name" value="<?= htmlspecialchars($member['last_name'] ?? '') ?>" required><br>
    Email: <input type="email" name="email" value="<?= htmlspecialchars($member['email'] ?? '') ?>" required><br>
    <button type="submit">Update Member</button>
</form>

</body>
</html>
