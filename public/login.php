<?php
session_start(); // Start session

require_once '../app/init.php';
require_once '../app/controllers/AuthController.php';


if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

   
    $result = AuthController::login($email, $password);

    if (is_array($result) && isset($result['id'])) {
        
        $_SESSION['user_id'] = $result['id'];
        $_SESSION['user_name'] = $result['name'];

        header("Location: dashboard.php"); 
        exit();
    } else {
        echo "<script>alert('Login failed: " . htmlspecialchars($result) . "');</script>";
    }
}
?>
