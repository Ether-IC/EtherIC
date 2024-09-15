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
