<?php
require_once 'auth.php'; // Ensure token is verified
header("Content-Type: application/json");

// Get authenticated user
$user = verifyToken();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $project_id = $_GET['project_id'] ?? '';

    $stmt = $pdo->prepare("SELECT id, name FROM Task WHERE project_id = ? AND user_id = ?");
    $stmt->execute([$project_id, $user['id']]);
    $tasks = $stmt->fetchAll();

    echo json_encode(["tasks" => $tasks]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $project_id = $data['project_id'] ?? '';
    $name = $data['name'] ?? '';

    if (!$project_id || !$name) {
        http_response_code(400);
        echo json_encode(["error" => "Project ID and Task name are required"]);
        exit();
    }

    // Insert new task
    $stmt = $pdo->prepare("INSERT INTO Task (name, project_id, user_id) VALUES (?, ?, ?)");
    $stmt->execute([$name, $project_id, $user['id']]);

    http_response_code(201);
    echo json_encode(["message" => "Task created successfully"]);
    exit();
}

http_response_code(405);
echo json_encode(["error" => "Method Not Allowed"]);
?>
