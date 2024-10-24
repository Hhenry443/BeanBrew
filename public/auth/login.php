<?php

require '../../helpers.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$username = $_POST['username'];
$password = $_POST['password'];

require '../../App/partials/db.php';

try {
    // Create a PDO instance
    $pdo = new PDO($dsn, $user, $pass);
    // Set error mode to exception to catch errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // Prepare an SQL statement to select the user
        $stmt = $pdo->prepare("SELECT * FROM tbl_users WHERE username = :username");
        $stmt->bindParam(':username', $username);

        // Execute the statement
        $stmt->execute();

        // Fetch the user data
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user) {
            // User not found
            $_SESSION["error_message"] = 'Incorrect Credentials';
            redirect('../login.php');
            exit;
        }

        // Check if password is correct
        if (!password_verify($password, $user['password'])) {
            $_SESSION["error_message"] = 'Incorrect Credentials';
            redirect('../login.php');
            exit;
        }

        // Set session variables
        $_SESSION["username"] = $user['username'];
        $_SESSION["userID"] = $user['user_id'];

        // Redirect to the home page
        redirect('/');
    }
} catch (PDOException $e) {
    // Handle any errors during the connection or execution
    echo "Database error: " . $e->getMessage();
}
