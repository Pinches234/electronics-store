// LOAD CART FROM STORAGE
let cart = JSON.parse(localStorage.getItem("cart")) || [];

// ADD TO CART
function addToCart(name, price) {
    cart.push({ name, price });
    localStorage.setItem("cart", JSON.stringify(cart));

    updateCartCount(); // update counter

    alert(name + " added to cart!");
}

// UPDATE CART COUNT (NAVBAR)
function updateCartCount() {
    let cartData = JSON.parse(localStorage.getItem("cart")) || [];

    let countElement = document.getElementById("cart-count");

    if (countElement) {
        countElement.innerText = cartData.length;
    }
}

// DISPLAY CART ITEMS
function displayCart() {
    let cartItems = document.getElementById("cart-items");
    let total = document.getElementById("total");

    if (!cartItems || !total) return;

    cartItems.innerHTML = "";
    let totalPrice = 0;

    cart.forEach((item, index) => {
        totalPrice += item.price;

        cartItems.innerHTML += `
            <div style="margin-bottom:10px;">
                <p>${item.name} - KSh ${item.price}</p>
                <button onclick="removeItem(${index})">Remove</button>
            </div>
        `;
    });

    total.innerText = "Total: KSh " + totalPrice;
}

// REMOVE ITEM
function removeItem(index) {
    cart.splice(index, 1);
    localStorage.setItem("cart", JSON.stringify(cart));

    updateCartCount(); // update counter
    displayCart();
}

function showFileName() {
    let input = document.getElementById("fileInput");
    let text = document.getElementById("upload-text");

    if (input.files.length > 0) {
        text.innerText = "Selected: " + input.files[0].name;
    }
}

function previewImage(event) {
    let file = event.target.files[0];
    let preview = document.getElementById("preview");
    let text = document.getElementById("upload-text");

    if (file) {
        let reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = "block";
            text.innerText = "Preview:";
        };

        reader.readAsDataURL(file);
    }
}
// CHECKOUT
function checkout() {
    fetch("checkout.php", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(cart)
    })
    .then(res => res.text())
    .then(data => {
        alert(data);

        localStorage.removeItem("cart");
        cart = [];

        updateCartCount(); // reset counter

        window.location.href = "dashboard.php";
    });
}

// RUN WHEN PAGE LOADS
window.onload = function () {
    updateCartCount();

    if (typeof displayCart === "function") {
        displayCart();
    }
};