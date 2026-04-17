<?php include "header.php"; ?>

<?php
$conn = new mysqli("localhost", "root", "", "electronics_store");

$type = $_GET['type'];

$result = $conn->query("SELECT * FROM products WHERE category='$type'");
?>

<h2 class="category-title">
    <?php echo ucfirst($type); ?>
</h2>

<p class="product-count">
    Showing <?php echo $result->num_rows; ?> products
</p>

<div class="product-grid">

<?php while($row = $result->fetch_assoc()): ?>
    <div class="product-card">

        <img src="<?php echo $row['image']; ?>">

        <h3><?php echo $row['name']; ?></h3>

        <p class="price">KSh <?php echo $row['price']; ?></p>

        <button onclick="addToCart('<?php echo $row['name']; ?>', <?php echo $row['price']; ?>)">
            Add to Cart
        </button>

    </div>
<?php endwhile; ?>

</div>

<script src="script.js"></script>

<?php include "footer.php"; ?>