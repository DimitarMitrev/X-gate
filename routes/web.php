<?php
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/ProjectController.php';
require_once __DIR__ . '/../app/controllers/TaskController.php';
require_once __DIR__ . '/../app/helpers/auth.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'register') {
        echo AuthController::register($_POST['name'], $_POST['email'], $_POST['password']);
    } elseif ($_POST['action'] === 'login') {
        echo AuthController::login($_POST['email'], $_POST['password']);
    } elseif ($_POST['action'] === 'create_project') {
        requireAuth();
        echo ProjectController::createProject($_POST['name'], $_POST['description']);
    } elseif ($_POST['action'] === 'create_task') {
        requireAuth();
        echo TaskController::createTask($_POST['title'], $_POST['description'], $_POST['due_date'], $_POST['project_id']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['logout'])) {
        echo AuthController::logout();
    } elseif ($_GET['action'] === 'list_projects') {
        requireAuth();
        echo ProjectController::listProjects();
    } elseif ($_GET['action'] === 'list_tasks') {
        requireAuth();
        echo TaskController::listTasks($_GET['project_id']);

    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    requireAuth();
    parse_str(file_get_contents("php://input"), $_PUT);
    
    if ($_PUT['action'] === 'update_project') {
        echo ProjectController::updateProject($_PUT['project_id'], $_PUT['name'], $_PUT['description']);
    } elseif ($_PUT['action'] === 'update_task') {
        echo TaskController::updateTask($_PUT['task_id'], $_PUT['title'], $_PUT['description'], $_PUT['due_date']);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    requireAuth();
    parse_str(file_get_contents("php://input"), $_DELETE);
    
    if ($_DELETE['action'] === 'delete_project') {
        echo ProjectController::deleteProject($_DELETE['project_id']);
    } elseif ($_DELETE['action'] === 'delete_task') {
        echo TaskController::deleteTask($_DELETE['task_id']);
    }
}
?>
