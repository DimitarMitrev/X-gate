<?php
if(session_status() === PHP_SESSION_NONE ){
    session_start();
}
 // Ensure session is started

// Check if user is authenticated
function isAuthenticated() {
    return isset($_SESSION['user_id']);
}

// Get the authenticated user's ID
function getAuthenticatedUserId() {
    return $_SESSION['user_id'] ?? null;
}

// Redirect if not authenticated (for web-based pages)
function requireAuth() {
    if (!isAuthenticated()) {
        header("Location: /public/index.php");
        exit();
    }
}

// JSON-based authentication check (for API requests)
function requireAuthAPI() {
    if (!isAuthenticated()) {
        echo json_encode(['error' => 'Unauthorized']);
        http_response_code(401);
        exit();
    }
}
?>
