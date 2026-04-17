
<?php include "header.php"; ?>

<!-- HERO SECTION -->
<div class="hero">
    <h1>Techlab Electronics ⚡</h1>
    <p>Smart Tech. Better Life.</p>
    <a href="products.php"><button>Shop Now</button></a>
</div>
<?php
$conn = new mysqli("localhost", "root", "", "electronics_store");

$result = $conn->query("SELECT * FROM products ORDER BY id DESC LIMIT 8");
?>

<h2 class="category-title">Latest Products</h2>

<div class="product-grid">

<?php while($row = $result->fetch_assoc()): ?>
    <div class="product-card">

        <img src="<?php echo $row['image']; ?>" width="200" onclick="openModal('<?php echo $row['image']; ?>')" style="cursor:pointer;">

        <h3><?php echo $row['name']; ?></h3>

        <p class="product-description"><?php echo htmlspecialchars($row['description']); ?></p>

        <p class="price">KSh <?php echo $row['price']; ?></p>

        <button onclick="addToCart('<?php echo $row['name']; ?>', <?php echo $row['price']; ?>)">
            Add to Cart
        </button>

    </div>
<?php endwhile; ?>

</div>

<!-- CATEGORIES -->
<div class="categories">
    <div class="cat" onclick="loadCategory('phones')">📱 Phones</div>
    <div class="cat" onclick="loadCategory('laptops')">💻 Laptops</div>
    <div class="cat" onclick="loadCategory('tv')">📺 TVs</div>
    <div class="cat" onclick="loadCategory('accessories')">🎧 Accessories</div>
</div>
<div id="products-container" class="product-grid"></div>


<!-- FEATURED PRODUCTS -->
<h2 style="padding-left:20px;">🔥 Featured Products</h2>

<div class="products">
<?php
$conn = new mysqli("localhost", "root", "", "electronics_store");
$result = $conn->query("SELECT * FROM products LIMIT 6");

while($row = $result->fetch_assoc()):
?>
    <div class="product">
        <img src="<?php echo $row['image']; ?>" width="200" onclick="openModal('<?php echo $row['image']; ?>')" style="cursor:pointer;">
        <h3><?php echo $row['name']; ?></h3>
        <p class="product-description"><?php echo htmlspecialchars($row['description']); ?></p>
        <p>KSh <?php echo $row['price']; ?></p>

        <button onclick="addToCart('<?php echo $row['name']; ?>', <?php echo $row['price']; ?>)">
            Add to Cart
        </button>
    </div>
<?php endwhile; ?>
</div>

<script src="script.js"></script>

<?php include "footer.php"; ?>
<script>
function loadCategory(category) {
    fetch("fetch_products.php?category=" + category)
        .then(res => {
            if (!res.ok) {
                throw new Error('Network response was not ok: ' + res.status);
            }
            return res.text();
        })
        .then(data => {
            document.getElementById("products-container").innerHTML = data;
        })
        .catch(error => {
            console.error('Error loading category:', error);
            document.getElementById("products-container").innerHTML = '<p>Error loading products. Check console for details.</p>';
        });
}

// LOAD DEFAULT CATEGORY
loadCategory('phones');
</script>

<script>
function openModal(src) {
    document.getElementById('modalImage').src = src;
    document.getElementById('imageModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('imageModal').style.display = 'none';
}
</script>

<!-- Modal for full image view -->
<div id="imageModal" onclick="closeModal()" style="display:none; position:fixed; z-index:1000; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.8);">
    <span onclick="closeModal(); event.stopPropagation();" style="position:absolute; top:20px; right:30px; color:white; font-size:30px; cursor:pointer;">&times;</span>
    <img id="modalImage" onclick="event.stopPropagation();" style="display:block; margin:auto; max-width:90%; max-height:90%; margin-top:50px;">
</div>