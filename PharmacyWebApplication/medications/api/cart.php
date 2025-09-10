<?php
session_start();
header("Content-Type: application/json");
include "db.php";

// Initialize cart
if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];
}

// Handle POST (add item)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents("php://input"), true);
  $id = $data['id'];
  $qty = $data['quantity'];

  if (isset($_SESSION['cart'][$id])) {
    $_SESSION['cart'][$id] += $qty;
  } else {
    $_SESSION['cart'][$id] = $qty;
  }
}

// Handle DELETE (remove item)
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
  $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
  if ($id > 0 && isset($_SESSION['cart'][$id])) {
    unset($_SESSION['cart'][$id]);
  }
}

// Fetch cart with details
$cart = [];
$total = 0;
foreach ($_SESSION['cart'] as $id => $qty) {
  $result = $conn->query("SELECT * FROM medications WHERE id=$id");
  if ($row = $result->fetch_assoc()) {
    $item_total = $row['price'] * $qty;
    $cart[] = [
      "id" => $row['id'],
      "name" => $row['name'],
      "price" => $row['price'],
      "quantity" => $qty,
      "total" => $item_total
    ];
    $total += $item_total;
  }
}

echo json_encode($cart);
?>