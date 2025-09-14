<?php
require_once 'db_connect.php';

$sql = "SELECT Customer_ID, Patient_name, DoB, Phone, Email FROM Customer";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Customers</title>
</head>
<body>
    <h1>Customer List</h1>
    <a href="add_customer.php">Add New Customer</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>DoB</th>
            <th>Phone</th>
            <th>Email</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["Customer_ID"] . "</td>";
                echo "<td>" . $row["Patient_name"] . "</td>";
                echo "<td>" . $row["DoB"] . "</td>";
                echo "<td>" . $row["Phone"] . "</td>";
                echo "<td>" . $row["Email"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No customers found.</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>