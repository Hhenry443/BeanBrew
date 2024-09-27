<?php

require '../../helpers.php';

// Start the session at the beginning of the script
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Check if form data has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get the product data from POST
    $product = [
        'name' => $_POST['name'],
        'food' => $_POST['food'],
        'size' => $_POST['size'],
        'customisation' => $_POST['customisation'],
        'price' => $_POST['price'],
    ];

    // Initialize the basket session array if it doesn't exist
    if (!isset($_SESSION['basket'])) {
        $_SESSION['basket'] = [];
    }

    // Add the new product to the basket
    $_SESSION['basket'][] = $product;

    // Optional: Display a success message
    echo "Product added to the basket!";

    redirect('/order.php');
}
