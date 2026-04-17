<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.html");
    exit();
}

include "header.php";
?>

<h2 style="padding:20px;">Welcome, <?php echo $_SESSION['user']; ?> 🔥</h2>

<?php include "footer.php"; ?>