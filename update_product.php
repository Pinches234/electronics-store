<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user'] != 'admin') {
    echo "Access denied!";
    exit();
}

$conn = new mysqli("localhost", "root", "", "electronics_store");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'] ?? '';

    // Check if a new image is uploaded
    if (!empty($_FILES['image']['name'])) {
        $imageName = $_FILES['image']['name'];
        $tmpName = $_FILES['image']['tmp_name'];
        $uploadPath = "uploads/" . $imageName;
        move_uploaded_file($tmpName, $uploadPath);
        $image = $uploadPath;
    } else {
        // Keep the old image
        $result = $conn->query("SELECT image FROM products WHERE id=$id");
        $product = $result->fetch_assoc();
        $image = $product['image'];
    }

    $conn->query("UPDATE products SET name='$name', price='$price', description='$description', image='$image' WHERE id=$id");

    header("Location: admin.php"); // Redirect back to admin page
}
?>