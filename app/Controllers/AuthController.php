<?php
session_start();
require_once '../config/database.php';
require_once '../app/Models/User.php';

class AuthController {
    private $db;

    public function __construct() {
        $config = require '../config/database.php';
        $this->db = new PDO(
            "mysql:host={$config['host']};dbname={$config['dbname']};charset={$config['charset']}",
            $config['username'],
            $config['password'],
            $config['options']
        );
    }

    public function register($username, $password) {
        $user = new User($this->db);
        if ($user->create($username, $password)) {
            $_SESSION['user'] = $username;
            header('Location: /dashboard.php');
        } else {
            echo "User already exists.";
        }
    }

    public function login($username, $password) {
        $user = new User($this->db);
        if ($user->verify($username, $password)) {
            $_SESSION['user'] = $username;
            $_SESSION['is_admin'] = $user->isAdmin($username);
            header('Location: /dashboard.php');
        } else {
            echo "Invalid login.";
        }
    }

    public function logout() {
        session_destroy();
        header('Location: /login.php');
    }

    public function changePassword($username, $newPassword) {
        $user = new User($this->db);
        if ($user->updatePassword($username, $newPassword)) {
            echo "Password updated successfully.";
        } else {
            echo "Password update failed.";
        }
    }
}
?>
