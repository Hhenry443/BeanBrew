<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../App/partials/db.php';

try {
    // Create a PDO instance
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the lesson ID from session
    $lesson_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($lesson_id) {
        // Prepare the statement to fetch future events for the specific lesson, 
        // along with the count of guests booked and the capacity
        $stmt = $pdo->prepare("
            SELECT e.eventID, e.date, e.location, e.capacity, 
                COALESCE(SUM(b.guests), 0) AS booked_guests 
            FROM tbl_events e
            LEFT JOIN tbl_lesson_booking b ON e.eventID = b.eventID
            WHERE e.lessonID = :lesson_id AND e.date > NOW()
            GROUP BY e.eventID
        ");
        $stmt->bindParam(':lesson_id', $lesson_id, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch all future events
        $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($events) {
            // Calculate remaining spaces for each event
            foreach ($events as &$event) {
                $event['spaces_left'] = $event['capacity'] - $event['booked_guests'];
            }
        } else {
            $events = []; // Return an empty array if no future events are found
        }
    } else {
        $events = []; // Return an empty array if lesson ID is not set
    }
} catch (PDOException $e) {
    // Handle the error (logging, user feedback, etc.)
    $error_message = "Connection failed: " . $e->getMessage();
    $events = []; // Return an empty array on error
}

// Return the events array to be included in other scripts
return $events;
