<?php
session_start();

// 🔒 SECURITY CHECK (ONLY ADMIN)
if (!isset($_SESSION['user']) || $_SESSION['user'] != 'admin') {
    echo "Access denied!";
    exit();
}

// CONNECT DATABASE
$conn = new mysqli("localhost", "root", "", "electronics_store");

// GET PRODUCT ID
$id = $_GET['id'];

// DELETE PRODUCT
$conn->query("DELETE FROM products WHERE id=$id");

// REDIRECT BACK
header("Location: products.php");
exit();
?>