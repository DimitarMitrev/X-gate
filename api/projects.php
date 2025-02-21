<?php
require_once 'auth.php'; // Ensure token is verified
header("Content-Type: application/json");

// Get authenticated user
$user = verifyToken();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Fetch user's projects
    $stmt = $pdo->prepare("SELECT id, name FROM Project WHERE user_id = ?");
    $stmt->execute([$user['id']]);
    $projects = $stmt->fetchAll();

    echo json_encode(["projects" => $projects]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $name = $data['name'] ?? '';

    if (!$name) {
        http_response_code(400);
        echo json_encode(["error" => "Project name is required"]);
        exit();
    }

    // Insert new project
    $stmt = $pdo->prepare("INSERT INTO Project (name, user_id) VALUES (?, ?)");
    $stmt->execute([$name, $user['id']]);

    http_response_code(201);
    echo json_encode(["message" => "Project created successfully"]);
    exit();
}

http_response_code(405);
echo json_encode(["error" => "Method Not Allowed"]);
?>
