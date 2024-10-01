<?php

// STart the session as we may need this in the future.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../App/partials/db.php';

// Get the postID from request (e.g., GET or POST)
$postID = isset($_GET['id']) ? (int)$_GET['id'] : 0;

try {
    // Create a PDO instance
    $pdo = new PDO($dsn, $user, $pass);
    // Set error mode to exception to catch errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch all posts from the database
    $stmt = $pdo->prepare("SELECT * FROM tbl_comments WHERE postID = :postID");
    $stmt->bindParam(':postID', $postID, PDO::PARAM_INT);

    $stmt->execute();
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
