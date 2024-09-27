<?php

// STart the session as we may need this in the future.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Database connection parameters
$host = 'localhost'; // Database Host
$db   = 'beanandbrew'; // Database name
$user = 'henry'; // Database username
$pass = ''; // Database password
$charset = 'utf8mb4';

// Set up the DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    // Create a PDO instance
    $pdo = new PDO($dsn, $user, $pass);
    // Set error mode to exception to catch errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch all lessons from the database
    $stmt = $pdo->prepare("SELECT * FROM tbl_lessons");
    $stmt->execute();
    $lessons = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
