<?php include "header.php"; ?>

<?php
$conn = new mysqli("localhost", "root", "", "electronics_store");
$result = $conn->query("SELECT * FROM products");
?>

<div class="products">

<?php while($row = $result->fetch_assoc()): ?>
    <div class="product">
        <img src="<?php echo $row['image']; ?>" width="200" onclick="openModal('<?php echo $row['image']; ?>')" style="cursor:pointer;">
        <h3><?php echo $row['name']; ?></h3>
        <p class="product-description"><?php echo htmlspecialchars($row['description']); ?></p>
        <p>KSh <?php echo $row['price']; ?></p>

        <button onclick="addToCart('<?php echo $row['name']; ?>', <?php echo $row['price']; ?>)">
            Add to Cart
        </button>
        <a href="edit_product.php?id=<?php echo $row['id']; ?>">
    <button>Edit</button>
</a>
<?php if(isset($_SESSION['user']) && $_SESSION['user'] == 'admin'): ?>

    <a href="delete_product.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Delete this product?')">
        <button style="background:red;">Delete</button>
    </a>

<?php endif; ?>
    </div>
<?php endwhile; ?>

</div>

<!-- Modal for full image view -->
<div id="imageModal" style="display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.8);">
    <span onclick="closeModal()" style="position:absolute; top:20px; right:30px; color:white; font-size:30px; cursor:pointer;">&times;</span>
    <img id="modalImage" style="display:block; margin:auto; max-width:90%; max-height:90%; margin-top:50px;">
</div>

<script>
function openModal(src) {
    document.getElementById('modalImage').src = src;
    document.getElementById('imageModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('imageModal').style.display = 'none';
}
</script>

<script src="script.js"></script>

<?php include "footer.php"; ?>