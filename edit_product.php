<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user'] != 'admin') {
    echo "Access denied!";
    exit();
}

$conn = new mysqli("localhost", "root", "", "electronics_store");

$id = $_GET['id'];

$result = $conn->query("SELECT * FROM products WHERE id=$id");
$product = $result->fetch_assoc();

include "header.php";
?>

<div class="edit-product-container">
    <h2>Edit Product</h2>

    <form action="update_product.php" method="POST" enctype="multipart/form-data" class="edit-product-form">
        <input type="hidden" name="id" value="<?php echo $product['id']; ?>">

        <label for="name">Product Name</label>
        <input type="text" name="name" value="<?php echo $product['name']; ?>" required>

        <label for="price">Price</label>
        <input type="number" name="price" value="<?php echo $product['price']; ?>" required>

        <label for="description">Description</label>
        <textarea name="description" rows="4" required><?php echo htmlspecialchars($product['description']); ?></textarea>

        <!-- Current image display -->
        <p>Current Image:</p>
        <img src="<?php echo $product['image']; ?>" alt="Current product image">

        <!-- Upload new image -->
        <label for="image">Upload New Image (optional)</label>
        <input type="file" name="image">

        <button type="submit">Update Product</button>
    </form>
</div>

<?php include "footer.php"; ?>