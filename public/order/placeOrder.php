<?php

require '../../helpers.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../../App/partials/db.php';

try {
    // Create a PDO instance
    $pdo = new PDO($dsn, $user, $pass);
    // Set error mode to exception to catch errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $basket = $_SESSION['basket'];
        $username = $_SESSION['username'];
        $userID = $_SESSION['userID'];
        if (isset($_SESSION['hamper'])) {
            $hamper = $_SESSION['hamper'];
        } else {
            $hamper = "N";
        }

        // Start a transaction
        $pdo->beginTransaction();

        // Insert the order into the 'orders' table
        $stmt = $pdo->prepare("INSERT INTO tbl_orders (userID, date_added, hamper) VALUES (:userID, NOW(), :hamper)");

        $stmt->bindParam(':userID', $userID);
        $stmt->bindParam(':hamper', $hamper);

        $stmt->execute();

        // Get the order ID
        $orderID = $pdo->lastInsertId();


        // Prepare to insert into 'products' table and 'order_products' table
        $stmtProduct = $pdo->prepare("INSERT INTO tbl_products (name, size, price) VALUES (:name, :size, :price)");
        $stmtOrderProduct = $pdo->prepare("INSERT INTO tbl_order_products (orderID, productID) VALUES (:orderID, :productID)");

        // Insert each product from the basket
        foreach ($basket as $item) {
            // Insert product into 'products' table
            $stmtProduct->bindParam(':name', $item['name']);
            $stmtProduct->bindParam(':size', $item['size']);
            $stmtProduct->bindParam(':price', $item['price']);
            $stmtProduct->execute();

            // Get the product ID
            $productID = $pdo->lastInsertId();

            // Insert into 'order_products' link table
            $stmtOrderProduct->bindParam(':orderID', $orderID);
            $stmtOrderProduct->bindParam(':productID', $productID);
            $stmtOrderProduct->execute();
        }

        // Commit the transaction
        $pdo->commit();

        session_start();

        // Check if the basket session variable exists and unset it
        if (isset($_SESSION['basket'])) {
            unset($_SESSION['basket']);
        }

        // Check if the hamper session variable exists and unset it
        if (isset($_SESSION['hamper'])) {
            unset($_SESSION['hamper']);
        }

        redirect('/');
    }
} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "Database error: " . $e->getMessage();
}
