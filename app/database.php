<?php
$databasePath = realpath(__DIR__ . '/../database/mydatabase.db'); // Ensure correct path

if (!$databasePath || !file_exists($databasePath)) {
    exit(" Database file not found. Check the path in database.php: " . __DIR__);
}

$dsn = "sqlite:" . $databasePath;
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Enable detailed errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Fetch data as associative arrays
    PDO::ATTR_EMULATE_PREPARES => false, // Use real prepared statements
];

try {
    $pdo = new PDO($dsn, null, null, $options);

    // Ensure foreign keys are enabled (important for relationships)
    $pdo->exec("PRAGMA foreign_keys = ON;");

} catch (PDOException $e) {
    exit(" Database connection failed: " . $e->getMessage());
}
?>
