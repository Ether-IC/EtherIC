<?php
class Order {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function createOrder($userId, $packageId) {
        $stmt = $this->db->prepare("INSERT INTO orders (user_id, package_id, status) VALUES (?, ?, 'pending')");
        return $stmt->execute([$userId, $packageId]);
    }

    public function getOrdersByUserId($userId) {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function getAllOrders() {
        $stmt = $this->db->query("SELECT orders.*, users.username, packages.name AS package_name 
                                  FROM orders
                                  JOIN users ON orders.user_id = users.id
                                  JOIN packages ON orders.package_id = packages.id
                                  ORDER BY orders.created_at DESC");
        return $stmt->fetchAll();
    }

    public function updateStatus($orderId, $status) {
        $stmt = $this->db->prepare("UPDATE orders SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $orderId]);
    }
}
?>
