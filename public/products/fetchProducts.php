<?php

// STart the session as we may need this in the future.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../App/partials/db.php';

try {
    // Create a PDO instance
    $pdo = new PDO($dsn, $user, $pass);
    // Set error mode to exception to catch errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch all products from the database
    $stmt = $pdo->prepare("SELECT * FROM tbl_display_products");
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
