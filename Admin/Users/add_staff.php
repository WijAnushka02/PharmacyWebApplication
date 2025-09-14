<?php
require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $license = $_POST['license'];
    $phone = $_POST['phone'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];

    $sql = "INSERT INTO Staff (Pharmacist_name, License_No, Phone, Contact, Email) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $name, $license, $phone, $contact, $email);

    if ($stmt->execute()) {
        echo "<p>New staff member added successfully!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Staff</title>
</head>
<body>
    <h1>Add New Staff Member</h1>
    <form method="post" action="add_staff.php">
        Name: <input type="text" name="name" required><br>
        License No: <input type="text" name="license" required><br>
        Phone: <input type="text" name="phone"><br>
        Contact: <input type="text" name="contact"><br>
        Email: <input type="email" name="email"><br>
        <input type="submit" value="Add Staff">
    </form>
    <br><a href="staff.php">Back to Staff List</a>
</body>
</html>