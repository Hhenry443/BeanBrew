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

    // Get the product_id from request (e.g., GET or POST)
    $product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

    if ($product_id) {
        // Prepare the statement to fetch a single product by its ID
        $stmt = $pdo->prepare("SELECT * FROM tbl_display_products WHERE itemID = :product_id");
        $stmt->bindParam(':product_id', $product_id, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the single product
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$product) {
            $error_message = "Product not found.";
        }
    } else {
        $error_message = "Invalid product ID.";
    }
} catch (PDOException $e) {
    $error_message = "Connection failed: " . $e->getMessage();
}
