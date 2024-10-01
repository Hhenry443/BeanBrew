<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../App/partials/db.php';

try {
    // Create a PDO instance
    $pdo = new PDO($dsn, $user, $pass);
    // Set error mode to exception to catch errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the lesson id from request (e.g., GET or POST)
    $lesson_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($lesson_id) {
        // Prepare the statement to fetch a single product by its ID
        $stmt = $pdo->prepare("SELECT * FROM tbl_lessons WHERE lessonID = :lesson_id");
        $stmt->bindParam(':lesson_id', $lesson_id, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the single lesson
        $lesson = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$lesson) {
            $error_message = "Lesson not found.";
        }
    } else {
        $error_message = "Invalid product ID.";
    }
} catch (PDOException $e) {
    $error_message = "Connection failed: " . $e->getMessage();
}
