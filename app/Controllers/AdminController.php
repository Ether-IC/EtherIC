<?php
require_once '../app/Models/User.php';
require_once '../app/Models/Package.php';
require_once '../app/Models/Order.php';

class AdminController {
    private $db;

    public function __construct() {
        $config = require '../config/database.php';
        $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}";
        $this->db = new PDO($dsn, $config['username'], $config['password'], $config['options']);
    }

    public function getAllUsers($page = 1, $limit = 20) {
        $offset = ($page - 1) * $limit;
        $stmt = $this->db->prepare("SELECT id, username, credits, is_admin, created_at, last_login FROM users LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getTotalUsers() {
        $stmt = $this->db->query("SELECT COUNT(id) as total FROM users");
        return $stmt->fetch()['total'];
    }

    public function changeAdminPassword($newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE is_admin = 1 AND id = 1");
        return $stmt->execute([$hashedPassword]);
    }

    public function getAllPackages() {
        $package = new Package($this->db);
        return $package->getAllPackages();
    }

    public function addPackage($name, $price, $trafficLimit) {
        $package = new Package($this->db);
        return $package->addPackage($name, $price, $trafficLimit);
    }

    public function updatePackage($id, $name, $price, $trafficLimit) {
        $package = new Package($this->db);
        return $package->updatePackage($id, $name, $price, $trafficLimit);
    }

    public function getAllOrders() {
        $order = new Order($this->db);
        return $order->getAllOrders();
    }

    public function updateOrderStatus($orderId, $status) {
        $order = new Order($this->db);
        return $order->updateStatus($orderId, $status);
    }
}
?>
