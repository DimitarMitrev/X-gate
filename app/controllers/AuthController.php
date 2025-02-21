<?php
require_once __DIR__ . '/../init.php'; // Load DB connection & session
require_once __DIR__ . '/../helpers/auth.php'; // Auth helper functions

class AuthController {
    // User Registration
    public static function register($name, $email, $password) {
        global $pdo;

        // Check if user already exists
        $stmt = $pdo->prepare("SELECT id FROM User WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            return "Email is already registered!";
        }

        // Hash password before storing
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into database
        $stmt = $pdo->prepare("INSERT INTO User (name, email, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$name, $email, $hashedPassword])) {
            return "Registration successful!";
        }

        return "Registration failed!";
    }

    // User Login
    public static function login($email, $password) {
        global $pdo;

        // Fetch user by email
        $stmt = $pdo->prepare("SELECT id, name, password FROM User WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            return "Login successful!";
        }

        return "Invalid email or password!";
    }

    // Logout function
    public static function logout() {
        session_destroy();
        return "Logged out successfully!";
    }
}
?>
