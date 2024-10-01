<?php
require '../../helpers.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../../App/partials/db.php';

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get data from the POST request
    $data = json_decode(file_get_contents('php://input'), true);
    $date = $data['date'];
    $location = $data['location'];

    // Check availability
    $stmt = $pdo->prepare("SELECT SUM(number_of_guests) AS total_guests 
                            FROM tbl_bookings 
                            WHERE date = :date AND location = :location");
    $stmt->bindParam(':date', $date);
    $stmt->bindParam(':location', $location);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    $totalGuests = $result['total_guests'] ?? 0;

    // Return availability status
    if ($totalGuests >= 10) {
        echo json_encode(['status' => 'full']);
    } else {
        echo json_encode(['status' => 'available']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
