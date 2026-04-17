
<?php include "header.php"; ?>

<?php
$conn = new mysqli("localhost", "root", "", "electronics_store");

$query = $_GET['query'] ?? '';
$query = trim($query);

if (empty($query)) {
    echo "<p>Please enter a search term.</p>";
} else {
    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE ? OR description LIKE ?");
    $searchTerm = "%" . $query . "%";
    $stmt->bind_param("ss", $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h2>Search Results for: " . htmlspecialchars($query) . "</h2>";
        echo "<div class='products'>";

        while ($row = $result->fetch_assoc()) {
            echo "
            <div class='product'>
                <img src='{$row['image']}' width='200' onclick=\"openModal('{$row['image']}')\" style='cursor:pointer;'>
                <h3>{$row['name']}</h3>
                <p class='product-description'>" . htmlspecialchars($row['description']) . "</p>
                <p>KSh {$row['price']}</p>
                <button onclick=\"addToCart('{$row['name']}', {$row['price']})\">
                    Add to Cart
                </button>
            </div>
            ";
        }
        echo "</div>";
    } else {
        echo "<h2>No products found for: " . htmlspecialchars($query) . "</h2>";
    }

    $stmt->close();
}

$conn->close();
?>

<script src="script.js"></script>

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

<?php include "footer.php"; ?>