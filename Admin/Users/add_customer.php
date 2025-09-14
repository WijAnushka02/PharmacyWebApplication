<?php
require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $contact = $_POST['contact'];

    $sql = "INSERT INTO Customer (Patient_name, DoB, Phone, Email, Address, Contact) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $name, $dob, $phone, $email, $address, $contact);

    if ($stmt->execute()) {
        echo "<p>New customer added successfully!</p>";
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
    <title>Add Customer</title>
</head>
<body>
    <h1>Add New Customer</h1>
    <form method="post" action="add_customer.php">
        Name: <input type="text" name="name" required><br>
        Date of Birth: <input type="date" name="dob"><br>
        Phone: <input type="text" name="phone"><br>
        Email: <input type="email" name="email"><br>
        Address: <input type="text" name="address"><br>
        Contact: <input type="text" name="contact"><br>
        <input type="submit" value="Add Customer">
    </form>
    <br><a href="customers.php">Back to Customers List</a>
</body>
</html>