<?php
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: /login.php');
    exit();
}

// Show the dashboard
header('Location: /dashboard.php');
?>
