<?php
require '../../helpers.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


// Database connection parameters
$host = 'localhost'; // Change if necessary
$db   = 'beanandbrew'; // Your database name
$user = 'henry'; // Your database username
$pass = ''; // Your database password
$charset = 'utf8mb4';

// Set up the DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    // Create a PDO instance
    $pdo = new PDO($dsn, $user, $pass);
    // Set error mode to exception to catch errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get the submitted form data
        $event_id = intval($_POST['event_id']);
        $name = $_POST['name'];
        $email = $_POST['email'];
        $guests = intval($_POST['guests']);
        $userID = $_POST['userID']; // from hidden input

        // Prepare an SQL statement to insert the data
        $stmt = $pdo->prepare("INSERT INTO tbl_lesson_booking (eventID, userID, name, email, guests) 
                               VALUES (:eventID, :userID, :name, :email, :guests)");

        // Bind parameters to the query
        $stmt->bindParam(':eventID', $eventID);
        $stmt->bindParam(':userID', $userID);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':guests', $guests);


        // Execute the statement
        if ($stmt->execute()) {
            // Get the ID of the last inserted row
            $lastInsertId = $pdo->lastInsertId();

            echo "Booking successfully inserted!";

            // Redirect to the booking confirmation page
            redirect('/lessonBooking.php?id=' . $lastInsertId);
        } else {
            echo "Failed to insert booking.";
        }
    }
} catch (PDOException $e) {
    // Handle any errors during the connection or execution
    echo "Database error: " . $e->getMessage();
}
