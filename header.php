
<?php session_start(); ?>

<!DOCTYPE html>
<html>
<head>
    <title>Techlab Electronics</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="navbar">

    <!-- LOGO -->
    <div class="logo">
        <img src="logo.png" width="40">
        <span>Techlab Electronics</span>
    </div>

    <!-- NAV LINKS (LEFT) -->
  <nav class="nav-links">
    <a href="index.php">Home</a>
    <a href="products.php">Shop</a>

    <div class="dropdown">
        <a href="#">Spares ▼</a>

        <div class="dropdown-content">
            <a href="category.php?type=screens">Screens</a>
            <a href="category.php?type=ics">ICs</a>
            <a href="category.php?type=adapters">Adapters</a>
            <a href="category.php?type=mp3">MP3 Players</a>
            <a href="category.php?type=amps">Audio Amps</a>
            <a href="category.php?type=speakers">Speakers</a>
            <a href="category.php?type=ports">Charging Ports</a>
            <a href="category.php?type=plates">Charging Plates</a>
            <a href="category.php?type=mouthpiece">Mouthpiece</a>
        </div>
    </div>
</nav>

    <!-- SEARCH (SHORTER) -->
    <div class="search-box">
        <form method="GET" action="search.php" style="display:flex;">
            <input type="text" name="query" placeholder="Search..." required style="width: 150px;">
            <button type="submit">🔍</button>
        </form>
    </div>

    <!-- NAV LINKS (RIGHT) -->
    <nav>
        <a href="cart.php" class="cart-link">
            🛒 <span id="cart-count">0</span>
        </a>
        <a href="dashboard.php">👤</a>

        <?php if(isset($_SESSION['user'])): ?>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.html">Login</a>
        <?php endif; ?>
    </nav>

</header>