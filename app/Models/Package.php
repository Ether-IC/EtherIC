<?php
class Package {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function getAllPackages() {
        $stmt = $this->db->query("SELECT * FROM packages ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    public function getPackageById($packageId) {
        $stmt = $this->db->prepare("SELECT * FROM packages WHERE id = ?");
        $stmt->execute([$packageId]);
        return $stmt->fetch();
    }

    public function addPackage($name, $price, $trafficLimit) {
        $stmt = $this->db->prepare("INSERT INTO packages (name, price, traffic_limit) VALUES (?, ?, ?)");
        return $stmt->execute([$name, $price, $trafficLimit]);
    }

    public function updatePackage($id, $name, $price, $trafficLimit) {
        $stmt = $this->db->prepare("UPDATE packages SET name = ?, price = ?, traffic_limit = ? WHERE id = ?");
        return $stmt->execute([$name, $price, $trafficLimit, $id]);
    }
}
?>
