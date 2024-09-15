<?php
class User {
    private $db;

    public function __construct($dbConnection) {
        $this->db = $dbConnection;
    }

    public function create($username, $password) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        try {
            $stmt = $this->db->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
            return $stmt->execute([$username, $hashedPassword]);
        } catch (PDOException $e) {
            error_log('Error creating user: ' . $e->getMessage());
            return false;
        }
    }

    public function verify($username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $this->updateLastLogin($user['id']);
            return true;
        }

        return false;
    }

    public function updatePassword($username, $newPassword) {
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
        try {
            $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE username = ?");
            return $stmt->execute([$hashedPassword, $username]);
        } catch (PDOException $e) {
            error_log('Error updating password: ' . $e->getMessage());
            return false;
        }
    }

    public function getAllUsers() {
        $stmt = $this->db->query("SELECT id, username, is_admin, credits, created_at, last_login FROM users");
        return $stmt->fetchAll();
    }

    public function isAdmin($username) {
        $stmt = $this->db->prepare("SELECT is_admin FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        return $user && $user['is_admin'] == 1;
    }

    private function updateLastLogin($userId) {
        $stmt = $this->db->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
        $stmt->execute([$userId]);
    }
}
?>
