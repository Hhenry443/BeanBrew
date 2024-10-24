<?php
require '../../helpers.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Loads Database connection partial
require '../../App/partials/db.php';

// Check if the username is set in the session
if (!isset($_SESSION['username'])) {
    redirect('/login.php'); // Redirect to home page if username is not set
}

try {
    // Create a PDO instance
    $pdo = new PDO($dsn, $user, $pass);
    // Set error mode to exception to catch errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get the submitted form data
        $username = $_POST['username'];
        $comment = $_POST['comment'];
        $postID = $_POST['postID'];


        // Prepare an SQL statement to insert the data
        $stmt = $pdo->prepare("INSERT INTO tbl_comments (postID, username, comment) 
                               VALUES (:postID, :username, :comment)");

        // Bind parameters to the query
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':comment', $comment);
        $stmt->bindParam(':postID', $postID);


        // Execute the statement
        if ($stmt->execute()) {
            // Get the ID of the last inserted row
            $lastInsertId = $pdo->lastInsertId();

            echo "Comment successfully inserted!";

            // Redirect to the booking confirmation page
            redirect('/post.php?id=' . $postID);
        } else {
            echo "Failed to insert booking.";
        }
    }
} catch (PDOException $e) {
    // Handle any errors during the connection or execution
    echo "Database error: " . $e->getMessage();
}
