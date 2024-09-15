<?php
session_start();
require_once '../app/Controllers/DashboardController.php';

if (!isset($_SESSION['user'])) {
    header('Location: /login.php');
    exit();
}

$dashboard = new DashboardController($_SESSION['user_id']);
$userCredits = $dashboard->getUserTrafficBalance();
$packages = $dashboard->getAvailablePackages();
$purchaseHistory = $dashboard->getPurchaseHistory();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <h2>User Dashboard</h2>
    <p>Your current traffic balance: <?= $userCredits ?> MB</p>

    <h3>Available Packages</h3>
    <ul>
        <?php foreach ($packages as $package): ?>
            <li><?= $package['name'] ?> - <?= $package['traffic_limit'] ?> MB for $<?= $package['price'] ?>
                <form action="/order.php" method="POST">
                    <input type="hidden" name="package_id" value="<?= $package['id'] ?>">
                    <button type="submit">Purchase</button>
                </form>
            </li>
        <?php endforeach; ?>
    </ul>

    <h3>Purchase History</h3>
    <ul>
        <?php foreach ($purchaseHistory as $order): ?>
            <li>Package: <?= $order['package_name'] ?> - Status: <?= $order['status'] ?></li>
        <?php endforeach; ?>
    </ul>
</body>
</html>
