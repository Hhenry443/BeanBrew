<?php
require __DIR__ . '/../../vendor/autoload.php';
require '../../helpers.php';
require '.././products/fetchProducts.php'; // Ensure this includes the correct database connection

// Get the filter parameters from the request
$category = isset($_GET['category']) ? urldecode($_GET['category']) : 'All';
$type = isset($_GET['type']) ? $_GET['type'] : 'food';

// Debugging: Output received parameters
error_log("Received category: $category");
error_log("Received type: $type");

// Query to fetch products based on category and type
$filteredProducts = [];

try {
    // Prepare SQL query based on the filters
    if ($category === 'All') {
        // If category is 'All' or 'All Food'/'All Drinks', just filter by type
        $stmt = $pdo->prepare("SELECT * FROM tbl_display_products WHERE food = :food");
    } else if ($category === 'All Food' || $category === 'All Drinks') {
        // Otherwise, filter by both food and category
        $stmt = $pdo->prepare("SELECT * FROM tbl_display_products WHERE type = :category");
        $stmt->bindValue(':category', $category);
    } else {
        // Otherwise, filter by both food and category
        $stmt = $pdo->prepare("SELECT * FROM tbl_display_products WHERE food = :food AND type = :category");
        $stmt->bindValue(':category', $category);
    }

    // Bind the type value to the statement
    $stmt->bindValue(':food', $type === 'food' ? 'Y' : 'N');

    // Execute the query
    $stmt->execute();
    $filteredProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Debugging: Log the error
    error_log("SQL Error: " . $e->getMessage());
}

// Return the products as JSON
header('Content-Type: application/json');
echo json_encode($filteredProducts);
