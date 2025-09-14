<?php
require_once 'db_connect.php';

$sql = "SELECT Pharmacist_ID, Pharmacist_name, License_No, Email FROM Staff";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Staff</title>
</head>
<body>
    <h1>Staff List</h1>
    <a href="add_staff.php">Add New Staff</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>License No</th>
            <th>Email</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["Pharmacist_ID"] . "</td>";
                echo "<td>" . $row["Pharmacist_name"] . "</td>";
                echo "<td>" . $row["License_No"] . "</td>";
                echo "<td>" . $row["Email"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No staff found.</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>