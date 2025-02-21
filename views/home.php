<?php 
session_start();
require_once '../app/helpers/auth.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Task Manager</title>
    <link rel="stylesheet" href="/public/style.css">
</head>
<body>
    <?php include 'header.php'; ?>
    
    <div class="container">
        <h1>Welcome to Task Manager</h1>
        <?php if (!isAuthenticated()): ?>
            <p><a href="/views/auth/login.php">Login</a> or <a href="/views/auth/register.php">Register</a></p>
        <?php else: ?>
            <p>Welcome, <b><?php echo $_SESSION['user_name']; ?></b>!</p>
            <a href="/views/user/dashboard.php">Go to Dashboard</a>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>
