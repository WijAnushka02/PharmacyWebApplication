<?php
require_once 'db_connect.php';

$sql = "SELECT M.Medicine_ID, M.Medicine_name, M.Description, S.Quantity_in_stock, S.Unit_price
        FROM Medicine M
        JOIN Stock S ON M.Medicine_ID = S.Medicine_ID";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Medicine</title>
</head>
<body>
    <h1>Medicine Inventory</h1>
    <a href="add_medicine.php">Add New Medicine</a>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th>Quantity in Stock</th>
            <th>Unit Price</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["Medicine_ID"] . "</td>";
                echo "<td>" . $row["Medicine_name"] . "</td>";
                echo "<td>" . $row["Description"] . "</td>";
                echo "<td>" . $row["Quantity_in_stock"] . "</td>";
                echo "<td>" . $row["Unit_price"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No medicine found.</td></tr>";
        }
        $conn->close();
        ?>
    </table>
</body>
</html>