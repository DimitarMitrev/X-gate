<?php
session_start(); 


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

require_once '../app/database.php'; 

$user_id = $_SESSION['user_id']; 

try {
    // Fetch user's projects
    $stmt = $pdo->prepare("SELECT * FROM Project WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $projects = $stmt->fetchAll();
} catch (PDOException $e) {
    die("Error fetching projects: " . $e->getMessage()); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>

    <h1>Welcome to Your Dashboard</h1>
    <p>Hello, <?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?>!</p>

    <h2>Your Projects</h2>
    <ul>
        <?php if (!empty($projects)): ?>
            <?php foreach ($projects as $project): ?>
                <li><?php echo htmlspecialchars($project['name']); ?></li>
            <?php endforeach; ?>
        <?php else: ?>
            <li>No projects found.</li>
        <?php endif; ?>
    </ul>

    <a href="logout.php">Logout</a>

</body>
</html>
