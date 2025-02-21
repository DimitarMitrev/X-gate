<?php
require_once '../app/database.php';

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["error" => "Method Not Allowed"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);
$email = $data['email'] ?? '';
$password = $data['password'] ?? '';

$stmt = $pdo->prepare("SELECT id, name, password FROM User WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if (!$user || !password_verify($password, $user['password'])) {
    http_response_code(401);
    echo json_encode(["error" => "Invalid credentials"]);
    exit();
}

// Generate a new token
$token = bin2hex(random_bytes(32));

$stmt = $pdo->prepare("UPDATE User SET token = ? WHERE id = ?");
$stmt->execute([$token, $user['id']]);

echo json_encode(["message" => "Login successful", "token" => $token]);
?>
