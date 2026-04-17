<?php
// Database connection with error handling
$conn = new mysqli("localhost", "root", "", "electronics_store");
if ($conn->connect_error) {
    echo "<p>Database connection failed: " . $conn->connect_error . "</p>";
    exit;
}

// Get category from URL parameter
$category = $_GET['category'] ?? '';

// Use prepared statement to prevent SQL injection
$stmt = $conn->prepare("SELECT * FROM products WHERE category = ?");
if (!$stmt) {
    echo "<p>Query preparation failed: " . $conn->error . "</p>";
    exit;
}
$stmt->bind_param("s", $category);
$stmt->execute();
$result = $stmt->get_result();

// Check if there are results
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $description = htmlspecialchars($row['description']);
        echo "
        <div class='product-card'>
            <img src='{$row['image']}' width='200' onclick=\"openModal('{$row['image']}')\" style='cursor:pointer;'>
            <h3>{$row['name']}</h3>
            <p class='product-description'>{$description}</p>
            <p class='price'>KSh {$row['price']}</p>
            <button onclick=\"addToCart('{$row['name']}', {$row['price']})\">
                Add to Cart
            </button>
        </div>
        ";
    }
} else {
    echo "<p>No products found in this category.</p>";
}

// Close statement and connection
$stmt->close();
$conn->close();
?>