<?php
$conn = new mysqli("localhost", "root", "", "electronics_store");

$name = $_POST['name'];
$price = $_POST['price'];
$category = $_POST['category']; // ✅ ADD THIS

// HANDLE IMAGE
$imageName = $_FILES['image']['name'];
$tmpName = $_FILES['image']['tmp_name'];

$uploadPath = "uploads/" . $imageName;

// MOVE FILE TO UPLOADS FOLDER
move_uploaded_file($tmpName, $uploadPath);

// SAVE TO DATABASE
$sql = "INSERT INTO products (name, price, image, category)
        VALUES ('$name', '$price', '$uploadPath', '$category')";

if ($conn->query($sql) === TRUE) {
    echo "Product added successfully!";
} else {
    echo "Error: " . $conn->error;
}
?>