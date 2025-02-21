<?php
require_once __DIR__ . '/../init.php';
require_once __DIR__ . '/../helpers/auth.php';

class ProjectController {
    // Create a new project
    public static function createProject($name, $description) {
        global $pdo;

        if (!isAuthenticated()) {
            return json_encode(["error" => "Unauthorized"]);
        }

        $stmt = $pdo->prepare("INSERT INTO Project (name, description, user_id) VALUES (?, ?, ?)");
        if ($stmt->execute([$name, $description, $_SESSION['user_id']])) {
            return json_encode(["success" => "Project created!"]);
        }
        return json_encode(["error" => "Project creation failed"]);
    }

    // Retrieve projects for the authenticated user
    public static function listProjects() {
        global $pdo;

        if (!isAuthenticated()) {
            return json_encode(["error" => "Unauthorized"]);
        }

        $stmt = $pdo->prepare("SELECT * FROM Project WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        return json_encode($stmt->fetchAll());
    }

    // Update a project (only if it belongs to the user)
    public static function updateProject($project_id, $name, $description) {
        global $pdo;

        if (!isAuthenticated()) {
            return json_encode(["error" => "Unauthorized"]);
        }

        $stmt = $pdo->prepare("UPDATE Project SET name = ?, description = ? WHERE id = ? AND user_id = ?");
        if ($stmt->execute([$name, $description, $project_id, $_SESSION['user_id']])) {
            return json_encode(["success" => "Project updated!"]);
        }
        return json_encode(["error" => "Project update failed"]);
    }

    // Delete a project (only if it belongs to the user)
    public static function deleteProject($project_id) {
        global $pdo;

        if (!isAuthenticated()) {
            return json_encode(["error" => "Unauthorized"]);
        }

        $stmt = $pdo->prepare("DELETE FROM Project WHERE id = ? AND user_id = ?");
        if ($stmt->execute([$project_id, $_SESSION['user_id']])) {
            return json_encode(["success" => "Project deleted!"]);
        }
        return json_encode(["error" => "Project deletion failed"]);
    }
}
?>
