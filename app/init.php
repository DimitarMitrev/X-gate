<?php
if(session_status()=== PHP_SESSION_NONE) 
session_start(); // Ensure session is always started

// Load configuration
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/database.php';

// Load helpers
require_once __DIR__ . '/helpers/auth.php';

// Load controllers
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/ProjectController.php';
require_once __DIR__ . '/controllers/TaskController.php';

// Load models
require_once __DIR__ . '/models/User.php';
require_once __DIR__ . '/models/Project.php';
require_once __DIR__ . '/models/Task.php';

// Ensure user authentication is checked where needed
if (isset($_SESSION['user_id'])) {
    $currentUserId = $_SESSION['user_id'];
}
?>
