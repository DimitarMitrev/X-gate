<?php
require_once '../app/database.php';

function verifyToken() {
    global $pdo;

    if (!isset($_SERVER['HTTP_AUTHORIZATION'])) {
        http_response_code(401);
        echo json_encode(["error" => "No token provided"]);
        exit();
    }

    $token = trim(str_replace("Bearer", "", $_SERVER['HTTP_AUTHORIZATION']));

    $stmt = $pdo->prepare("SELECT id, name FROM User WHERE token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    if (!$user) {
        http_response_code(401);
        echo json_encode(["error" => "Invalid token"]);
        exit();
    }

    return $user; 
}
?>
