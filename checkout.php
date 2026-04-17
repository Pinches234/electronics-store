<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "electronics_store");

// Get cart data from frontend
$data = json_decode(file_get_contents("php://input"), true);

$username = $_SESSION['user'];

foreach ($data as $item) {
    $name = $item['name'];
    $price = $item['price'];

    $sql = "INSERT INTO orders (username, product_name, price)
            VALUES ('$username', '$name', '$price')";
    $conn->query($sql);
}

echo "Order placed successfully!";
?>