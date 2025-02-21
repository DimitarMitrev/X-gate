<?php
require_once '../app/init.php'; // Ensure paths are correct
require_once '../app/controllers/AuthController.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = AuthController::register($_POST['name'], $_POST['email'], $_POST['password']);

    if ($result === "success") {
        header("Location: login.php"); 
        exit();
    } else {
        echo "<script>alert('Registration failed: $result'); window.location.href='index.php';</script>";
        exit();
    }
}
?>
