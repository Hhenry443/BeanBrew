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
        $name = $_POST['name'];
        $date = $_POST['date'];
        $time = $_POST['time'];
        $location = $_POST['location'];
        $guests = $_POST['guests'];
        $userID = $_POST['userID']; // from hidden input

        // Check current availability
        $stmt = $pdo->prepare("SELECT SUM(number_of_guests) AS total_guests 
FROM tbl_bookings 
WHERE date = :date AND location = :location");
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':location', $location);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $totalGuests = $result['total_guests'] ?? 0;

        // Check if adding new guests exceeds the limit
        if ($totalGuests + $guests > 10) {
            echo json_encode(['status' => 'full']);
            exit; // Stop execution
        } else {
            echo json_encode(['status' => 'available']);
        }


        // Prepare an SQL statement to insert the data
        $stmt = $pdo->prepare("INSERT INTO tbl_bookings (name, date, time, location, number_of_guests, userID) 
                               VALUES (:name, :date, :time, :location, :guests, :userID)");

        // Bind parameters to the query
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':time', $time);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':guests', $guests);
        $stmt->bindParam(':userID', $userID);

        // Execute the statement
        if ($stmt->execute()) {
            // Get the ID of the last inserted row
            $lastInsertId = $pdo->lastInsertId();

            echo "Booking successfully inserted!";

            // Redirect to the booking confirmation page
            redirect('/booking.php?id=' . $lastInsertId);
        } else {
            echo "Failed to insert booking.";
        }
    }
} catch (PDOException $e) {
    // Handle any errors during the connection or execution
    echo "Database error: " . $e->getMessage();
}
