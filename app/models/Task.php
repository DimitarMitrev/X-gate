<?php
require_once __DIR__ . '/../database.php';

class Task {
    public static function create($title, $description, $due_date, $project_id) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO Task (title, description, due_date, project_id) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$title, $description, $due_date, $project_id]);
    }

    public static function getByProjectId($project_id) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM Task WHERE project_id = ?");
        $stmt->execute([$project_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function update($task_id, $title, $description, $due_date) {
        global $pdo;
        $stmt = $pdo->prepare("UPDATE Task SET title = ?, description = ?, due_date = ? WHERE id = ?");
        return $stmt->execute([$title, $description, $due_date, $task_id]);
    }

    public static function delete($task_id) {
        global $pdo;
        $stmt = $pdo->prepare("DELETE FROM Task WHERE id = ?");
        return $stmt->execute([$task_id]);
    }
}
?>
