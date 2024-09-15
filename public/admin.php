<?php
session_start();
require_once '../app/Controllers/AdminController.php';

if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
    header('Location: /login.php');
    exit();
}

$admin = new AdminController();
$users = $admin->getAllUsers();
$packages = $admin->getAllPackages();
$orders = $admin->getAllOrders();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <h2>Admin Dashboard</h2>

    <h3>Manage Users</h3>
    <ul>
        <?php foreach ($users as $user): ?>
            <li><?= $user['username'] ?> - Credits: <?= $user['credits'] ?> MB</li>
        <?php endforeach; ?>
    </ul>

    <h3>Manage Packages</h3>
    <ul>
        <?php foreach ($packages as $package): ?>
            <li><?= $package['name'] ?> - <?= $package['traffic_limit'] ?> MB - $<?= $package['price'] ?></li>
        <?php endforeach; ?>
    </ul>

    <h3>Orders</h3>
    <ul>
        <?php foreach ($orders as $order): ?>
            <li>User: <?= $order['username'] ?> - Package: <?= $order['package_name'] ?> - Status: <?= $order['status'] ?></li>
        <?php endforeach; ?>
    </ul>

    <h3>Change Admin Password</h3>
    <form action="/change_admin_password.php" method="POST">
        <label>New Password:</label>
        <input type="password" name="new_password" required minlength="6" maxlength="255">
        <button type="submit">Change Password</button>
    </form>
</body>
</html>
