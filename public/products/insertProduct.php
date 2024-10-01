<?php
require '../App/partials/db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $food = $_POST['food'];
    $drink = $_POST['drink'];
    $type = $_POST['type'];
    $contains = $_POST['contains'];
    $image_url = $_POST['image_url'];

    try {
        // Create a new PDO instance
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Insert product data into tbl_display_products
        $stmt = $pdo->prepare("INSERT INTO tbl_display_products (name, description, price, food, drink, type, contains, image_url) 
                               VALUES (:name, :description, :price, :food, :drink, :type, :contains, :image_url)");
        $stmt->execute([
            ':name' => $name,
            ':description' => $description,
            ':price' => $price,
            ':food' => $food,
            ':drink' => $drink,
            ':type' => $type,
            ':contains' => $contains,
            ':image_url' => $image_url
        ]);

        $message = "Product added successfully!";
    } catch (PDOException $e) {
        $message = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <!-- Main Container -->
    <div class="max-w-4xl mx-auto py-12">
        <h1 class="text-3xl font-bold text-center mb-8">Add a New Product</h1>

        <?php if (!empty($message)): ?>
            <div class="bg-green-200 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <form action="insertProduct.php" method="POST" class="bg-white p-8 rounded-lg shadow-lg">
            <!-- Name Input -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Name:</label>
                <input type="text" name="name" id="name" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400">
            </div>

            <!-- Description Input -->
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-bold mb-2">Description:</label>
                <textarea name="description" id="description" rows="4" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400"></textarea>
            </div>

            <!-- Price Input -->
            <div class="mb-4">
                <label for="price" class="block text-gray-700 font-bold mb-2">Price:</label>
                <input type="text" name="price" id="price" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400">
            </div>

            <!-- Food Input -->
            <div class="mb-4">
                <label for="food" class="block text-gray-700 font-bold mb-2">Food:</label>
                <input type="text" name="food" id="food"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400">
            </div>

            <!-- Type Input -->
            <div class="mb-4">
                <label for="type" class="block text-gray-700 font-bold mb-2">Type:</label>
                <input type="text" name="type" id="type" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400">
            </div>

            <!-- Contains Input -->
            <div class="mb-4">
                <label for="contains" class="block text-gray-700 font-bold mb-2">Contains (Allergens):</label>
                <input type="text" name="contains" id="contains" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400">
            </div>

            <!-- Image URL Input -->
            <div class="mb-4">
                <label for="image_url" class="block text-gray-700 font-bold mb-2">Image URL:</label>
                <input type="text" name="image_url" id="image_url" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-gray-400">
            </div>

            <!-- Submit Button -->
            <div class="mt-6">
                <button type="submit" class="w-full bg-blue-500 text-white font-bold py-2 px-4 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    Add Product
                </button>
            </div>
        </form>
    </div>
</body>

</html>