<?php
require_once '../app/Models/User.php';
require_once '../app/Models/Order.php';
require_once '../app/Models/Package.php';

class DashboardController {
    private $db;
    private $userId;

    public function __construct($userId) {
        $config = require '../config/database.php';
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
        $this->db = new PDO($dsn, $config['username'], $config['password'], $config['options']);
        $this->userId = $userId;
    }

    public function getUserTrafficBalance() {
        $stmt = $this->db->prepare("SELECT credits FROM users WHERE id = ?");
        $stmt->execute([$this->userId]);
        return $stmt->fetch()['credits'];
    }

    public function getAvailablePackages() {
        $package = new Package($this->db);
        return $package->getAllPackages();
    }

    public function placeOrder($packageId) {
        $package = new Package($this->db);
        $order = new Order($this->db);
        $packageDetails = $package->getPackageById($packageId);

        if (!$packageDetails) {
            return false;
        }

        return $order->createOrder($this->userId, $packageId);
    }

    public function getPurchaseHistory() {
        $order = new Order($this->db);
        return $order->getOrdersByUserId($this->userId);
    }
}
?>
