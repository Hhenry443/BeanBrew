<?php
require '../../helpers.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../../App/partials/db.php';

try {
    // Create a PDO instance
    $pdo = new PDO($dsn, $user, $pass);
    // Set error mode to exception to catch errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get the submitted form data
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $name = $_POST['name'];

        // Check if password is less than 6 characters
        if (strlen($password) < 6) {
            $_SESSION['error'] = "Password must be greater than 6 characters.";
            redirect('/signup.php');
            die;
        }

        // Check if username or email already exists
        $stmt = $pdo->prepare("SELECT * FROM tbl_users WHERE username = :username OR email = :email");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // User or email already exists
            $_SESSION['error'] = "Username or Email already taken. Please choose a different one.";
            redirect('/signup.php');
            die;
        }

        // If no existing user, proceed to insert the data
        $stmt = $pdo->prepare("INSERT INTO tbl_users (username, password, email, name) VALUES (:username, :password, :email, :name)");

        // Bind parameters to the query
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':name', $name);

        // Execute the statement
        if ($stmt->execute()) {
            // Get the ID of the last inserted row
            $lastInsertId = $pdo->lastInsertId();

            echo "Data successfully inserted!";

            // Set session variables
            $_SESSION["username"] = $username;
            $_SESSION["userID"] = $lastInsertId;

            // Redirect to the home page
            redirect('/');
        } else {
            echo "Failed to insert data.";
        }
    }
} catch (PDOException $e) {
    // Handle any errors during the connection or execution
    echo "Database error: " . $e->getMessage();
}
