<?php
session_start();
require_once __DIR__ . '/../lib/db.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $adminUser = 'admin';
    $adminPass = 'ChangeMe123!'; 

    $u = $_POST['username'] ?? '';
    $p = $_POST['password'] ?? '';

    if($u === $adminUser && $p === $adminPass) {
        $_SESSION['admin_logged_in'] = true;
        header('Location: categories.php'); exit;
    } else {
        $error = "Invalid credentials";
    }
}
?>

