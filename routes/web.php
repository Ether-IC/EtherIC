<?php
require_once '../app/Controllers/AuthController.php';
require_once '../app/Controllers/AdminController.php';
require_once '../app/Controllers/TestController.php';
require_once '../app/Controllers/DashboardController.php';

// 注册
if ($_SERVER['REQUEST_URI'] === '/register.php') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $auth = new AuthController();
        $auth->register($_POST['username'], $_POST['password']);
    }
}

// 登录
if ($_SERVER['REQUEST_URI'] === '/login.php') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $auth = new AuthController();
        $auth->login($_POST['username'], $_POST['password']);
    }
}

// 管理员修改密码
if ($_SERVER['REQUEST_URI'] === '/change_admin_password.php') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $admin = new AdminController();
        $admin->changeAdminPassword($_POST['new_password']);
    }
}

// 压力测试
if ($_SERVER['REQUEST_URI'] === '/start_test.php') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $test = new TestController();
        $test->startTest($_POST['target_url'], isset($_POST['use_tor']));
    }
}
?>
