<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../App/partials/db.php';

try {
    // Create a PDO instance
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the booking_id from request (e.g., GET)
    $booking_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($booking_id) {

        // Prepare the statement to fetch a booking by its ID
        $stmt = $pdo->prepare("SELECT * FROM tbl_lesson_booking WHERE lessonBookingID = :booking_id");
        $stmt->bindParam(':booking_id', $booking_id, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the booking data
        $booking = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$booking) {
            $error_message = "Booking not found.";
        }
    } else {
        $error_message = "Invalid Booking ID.";
    }
} catch (PDOException $e) {
    $error_message = "Connection failed: " . $e->getMessage();
}
