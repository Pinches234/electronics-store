<?php
session_start();
session_destroy();

// 🔁 REDIRECT BACK TO LOGIN
header("Location: login.html");
exit();
?>