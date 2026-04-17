<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user'] != 'admin') {
    echo "Access denied!";
    exit();
}

$conn = new mysqli("localhost", "root", "", "electronics_store");

// HANDLE FORM SUBMISSION
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'] ?? ''; // Fix: Use null coalescing to avoid undefined key warning
    $gadgetCategory = $_POST['gadget_category'] ?? '';
    $spareCategory = $_POST['spare_category'] ?? '';

    if (!$gadgetCategory && !$spareCategory) {
        $error = "Please choose either a gadget category or a spare category.";
    } elseif ($gadgetCategory && $spareCategory) {
        $error = "Please choose only one category.";
    } else {
        $category = $spareCategory ?: $gadgetCategory;

        // IMAGE
        $imageName = $_FILES['image']['name'];
        $tmpName = $_FILES['image']['tmp_name'];
        $uploadPath = "uploads/" . $imageName;

        move_uploaded_file($tmpName, $uploadPath);

        $conn->query("INSERT INTO products (name, price, description, image, category)
                      VALUES ('$name', '$price', '$description', '$uploadPath', '$category')");
        $success = "Product added successfully.";
    }
}

// STATS
$products = $conn->query("SELECT COUNT(*) as total FROM products")->fetch_assoc();
$users = $conn->query("SELECT COUNT(*) as total FROM users")->fetch_assoc();

include "header.php";
?>

<div class="admin-container">

    <h2>Admin Dashboard 📊</h2>

    <div class="cards">
        <div class="card">
            <h3>Products</h3>
            <p><?php echo $products['total']; ?></p>
        </div>

        <div class="card">
            <h3>Users</h3>
            <p><?php echo $users['total']; ?></p>
        </div>
    </div>

    <hr>

    <h2>Add Product 🛒</h2>

    <form method="POST" enctype="multipart/form-data" class="product-form">

        <input type="text" name="name" placeholder="Product Name" required>

        <input type="number" name="price" placeholder="Price" required>

        <textarea name="description" placeholder="Product Description" rows="4" required></textarea>

        <select name="gadget_category">
            <option value="">Select gadget category</option>
            <option value="phones">Phones</option>
            <option value="laptops">Laptops</option>
            <option value="tv">TVs</option>
            <option value="accessories">Accessories</option>
        </select>

        <select name="spare_category">
            <option value="">Select spare category</option>
            <option value="screens">Screens</option>
            <option value="ics">ICs</option>
            <option value="adapters">Adapters</option>
            <option value="mp3">MP3 Players</option>
            <option value="amps">Audio Amps</option>
            <option value="speakers">Speakers</option>
            <option value="ports">Charging Ports</option>
            <option value="plates">Charging Plates</option>
            <option value="mouthpiece">Mouthpiece</option>
        </select>

        <input type="file" name="image" required>

        <button type="submit">Add Product</button>

    </form>

    <?php if (!empty($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <p class="success"><?php echo $success; ?></p>
    <?php endif; ?>

</div>

<?php include "footer.php"; ?>