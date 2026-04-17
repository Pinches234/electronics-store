<?php
$conn = new mysqli("localhost", "root", "", "electronics_store");

if ($conn->connect_error) {
    die("Connection failed");
}

$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);

$sql = "INSERT INTO users (username, email, password)
        VALUES ('$username', '$email', '$password')";

if ($conn->query($sql) === TRUE) {
    echo "Registered successfully!";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>