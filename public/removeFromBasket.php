<?php
require __DIR__ . '/../vendor/autoload.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the basket exists and the product name is passed
if (isset($_POST['product_name']) && isset($_SESSION['basket'])) {
    $productName = $_POST['product_name'];

    // Find the product by name in the basket and remove it
    foreach ($_SESSION['basket'] as $key => $product) {
        if ($product['name'] === $productName) {
            // Remove the product from the basket
            unset($_SESSION['basket'][$key]);
            // Reindex the array to avoid gaps
            $_SESSION['basket'] = array_values($_SESSION['basket']);
            break;
        }
    }
}

// Redirect back to the basket page
header("Location: basket.php");
exit;
