<?php

header('Content-Type: application/json');

// Database credentials
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pharmacy_db3";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    http_response_code(500);
    die(json_encode(['error' => 'Database connection failed: ' . $conn->connect_error]));
}

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        // Handle GET requests to fetch medicine data
        $sql = "SELECT m.Medicine_ID, m.Medicine_name, m.Description, s.Quantity_in_stock, s.Exp_Date, s.Unit_price
                FROM medicine m
                JOIN stock s ON m.Medicine_ID = s.Medicine_ID";
        
        $result = $conn->query($sql);
        
        $medicines = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // In a real application, you would also need to get the dosage and supplier
                // information from other tables like `staff_supplies_medicine` and `supplier`.
                // This example simplifies it to the main inventory data.
                $medicines[] = [
                    'id' => $row['Medicine_ID'],
                    'name' => $row['Medicine_name'],
                    'dosage' => $row['Description'], // Using Description as a placeholder for Dosage
                    'quantity' => $row['Quantity_in_stock'],
                    'expiry' => $row['Exp_Date'],
                    'reorder' => null, // No reorder threshold in schema, so this is null
                    'supplier' => null // No direct link from medicine to supplier in this simplified query
                ];
            }
        }
        echo json_encode($medicines);
        break;

    case 'POST':
        // Handle POST requests to add a new medicine
        $data = json_decode(file_get_contents('php://input'), true);

        // First, insert into the `medicine` table
        $sql_medicine = "INSERT INTO medicine (Medicine_name, Description) VALUES (?, ?)";
        $stmt_medicine = $conn->prepare($sql_medicine);
        $stmt_medicine->bind_param("ss", $data['name'], $data['dosage']);
        $stmt_medicine->execute();
        $medicine_id = $conn->insert_id;
        $stmt_medicine->close();

        if ($medicine_id) {
            // Then, insert into the `stock` table
            $sql_stock = "INSERT INTO stock (Medicine_ID, Quantity_in_stock, Exp_Date, Unit_price) VALUES (?, ?, ?, ?)";
            $stmt_stock = $conn->prepare($sql_stock);
            // Assuming unit price is 0 for simplicity, and reorder threshold is not in the schema
            $unit_price = 0;
            $stmt_stock->bind_param("iisi", $medicine_id, $data['quantity'], $data['expiry'], $unit_price);
            $stmt_stock->execute();
            $stmt_stock->close();
            
            echo json_encode(['message' => 'Medicine added successfully!', 'id' => $medicine_id]);
        } else {
            http_response_code(500);
            echo json_encode(['error' => 'Failed to add medicine.']);
        }
        break;

    case 'PUT':
        // Handle PUT requests to update a medicine
        parse_str(file_get_contents("php://input"), $put_vars);
        $data = json_decode($put_vars['data'], true);

        // Update `medicine` table
        $sql_medicine = "UPDATE medicine SET Medicine_name = ?, Description = ? WHERE Medicine_ID = ?";
        $stmt_medicine = $conn->prepare($sql_medicine);
        $stmt_medicine->bind_param("ssi", $data['name'], $data['dosage'], $data['id']);
        $stmt_medicine->execute();
        $stmt_medicine->close();

        // Update `stock` table
        $sql_stock = "UPDATE stock SET Quantity_in_stock = ?, Exp_Date = ? WHERE Medicine_ID = ?";
        $stmt_stock = $conn->prepare($sql_stock);
        $stmt_stock->bind_param("isi", $data['quantity'], $data['expiry'], $data['id']);
        $stmt_stock->execute();
        $stmt_stock->close();

        echo json_encode(['message' => 'Medicine updated successfully!']);
        break;

    case 'DELETE':
        // Handle DELETE requests
        $id = $_GET['id'];

        // First, delete from the `stock` table due to foreign key constraints
        $sql_stock = "DELETE FROM stock WHERE Medicine_ID = ?";
        $stmt_stock = $conn->prepare($sql_stock);
        $stmt_stock->bind_param("i", $id);
        $stmt_stock->execute();
        $stmt_stock->close();

        // Then, delete from the `medicine` table
        $sql_medicine = "DELETE FROM medicine WHERE Medicine_ID = ?";
        $stmt_medicine = $conn->prepare($sql_medicine);
        $stmt_medicine->bind_param("i", $id);
        $stmt_medicine->execute();
        $stmt_medicine->close();

        echo json_encode(['message' => 'Medicine deleted successfully!']);
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method Not Allowed']);
        break;
}

$conn->close();
?>