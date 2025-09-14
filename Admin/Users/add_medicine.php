<?php
require_once 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $quantity = $_POST['quantity'];
    $exp_date = $_POST['exp_date'];
    $unit_price = $_POST['unit_price'];

    $conn->begin_transaction();

    try {
        // Insert into Medicine table
        $sql_medicine = "INSERT INTO Medicine (Medicine_name, Description) VALUES (?, ?)";
        $stmt_medicine = $conn->prepare($sql_medicine);
        $stmt_medicine->bind_param("ss", $name, $description);
        $stmt_medicine->execute();
        $medicine_id = $conn->insert_id; // Get the ID of the new medicine

        // Insert into Stock table
        $sql_stock = "INSERT INTO Stock (Medicine_ID, Quantity_in_stock, Exp_Date, Unit_price) VALUES (?, ?, ?, ?)";
        $stmt_stock = $conn->prepare($sql_stock);
        $stmt_stock->bind_param("iisi", $medicine_id, $quantity, $exp_date, $unit_price);
        $stmt_stock->execute();

        $conn->commit();
        echo "<p>New medicine and stock added successfully!</p>";

    } catch (Exception $e) {
        $conn->rollback();
        echo "<p>Error: " . $e->getMessage() . "</p>";
    }
    
    $stmt_medicine->close();
    $stmt_stock->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Medicine</title>
</head>
<body>
    <h1>Add New Medicine</h1>
    <form method="post" action="add_medicine.php">
        Name: <input type="text" name="name" required><br>
        Description: <input type="text" name="description"><br>
        Quantity in Stock: <input type="number" name="quantity" required><br>
        Expiration Date: <input type="date" name="exp_date" required><br>
        Unit Price: <input type="text" name="unit_price" required><br>
        <input type="submit" value="Add Medicine">
    </form>
    <br><a href="medicine.php">Back to Medicine List</a>
</body>
</html>