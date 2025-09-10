<?php
header("Content-Type: application/json");
include "db.php";

$category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

// Get categories
$categories = [];
$result = $conn->query("SELECT * FROM categories");
while ($row = $result->fetch_assoc()) {
  $categories[] = $row;
}

// Get medications (all or by category)
$medications = [];
$sql = "SELECT * FROM medications";
if ($category_id > 0) {
  $sql .= " WHERE category_id=$category_id";
}
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
  $medications[] = $row;
}

echo json_encode(["categories" => $categories, "medications" => $medications]);
?>
