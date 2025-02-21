<?php
session_start();

if (isset($_SESSION['user_id']) && basename($_SERVER['PHP_SELF'])==='index.php') {
   header("Location: dashboard.php");
    session_destroy();
    exit();
 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Register</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>

    <header>
        <h1>Internship task X Gate</h1>
    </header>

    <main>
        <section>
            <h2>Login</h2>
            <form action="login.php" method="POST">
                <label for="login-email">Email:</label>
                <input type="email" id="login-email" name="email" required>

                <label for="login-password">Password:</label>
                <input type="password" id="login-password" name="password" required>

                <button type="submit">Login</button>
            </form>
        </section>

        <hr>

        <section>
            <h2>Register</h2>
           <!-- index.php -->
                <form action="register.php" method="POST"> <!-- Relative path -->   
                <label for="register-name">Name:</label>
                <input type="text" id="register-name" name="name" required>

                <label for="register-email">Email:</label>
                <input type="email" id="register-email" name="email" required>

                <label for="register-password">Password:</label>
                <input type="password" id="register-password" name="password" required>

                <button type="submit">Register</button>
            </form>
        </section>
    </main>

</body>
</html>
