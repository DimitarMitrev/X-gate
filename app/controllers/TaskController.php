<?php
require_once __DIR__ . '/../models/Task.php';
require_once __DIR__ . '/../helpers/auth.php';

class TaskController {
    public static function createTask($title, $description, $due_date, $project_id) {
        $user_id = getAuthenticatedUserId();
        if (!$user_id) {
            return json_encode(['error' => 'Unauthorized']);
        }

        if (Task::create($title, $description, $due_date, $project_id)) {
            return json_encode(['success' => 'Task created successfully']);
        } else {
            return json_encode(['error' => 'Failed to create task']);
        }
    }

    public static function listTasks($project_id) {
        $user_id = getAuthenticatedUserId();
        if (!$user_id) {
            return json_encode(['error' => 'Unauthorized']);
        }

        $tasks = Task::getByProjectId($project_id);
        return json_encode($tasks);
    }

    public static function updateTask($task_id, $title, $description, $due_date) {
        $user_id = getAuthenticatedUserId();
        if (!$user_id) {
            return json_encode(['error' => 'Unauthorized']);
        }

        if (Task::update($task_id, $title, $description, $due_date)) {
            return json_encode(['success' => 'Task updated successfully']);
        } else {
            return json_encode(['error' => 'Failed to update task']);
        }
    }

    public static function deleteTask($task_id) {
        $user_id = getAuthenticatedUserId();
        if (!$user_id) {
            return json_encode(['error' => 'Unauthorized']);
        }

        if (Task::delete($task_id)) {
            return json_encode(['success' => 'Task deleted successfully']);
        } else {
            return json_encode(['error' => 'Failed to delete task']);
        }
    }
}
?>
