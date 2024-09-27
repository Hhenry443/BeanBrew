<?php
require __DIR__ . '/../vendor/autoload.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../helpers.php';

// Retrieve basket from session
$basket = isset($_SESSION['basket']) ? $_SESSION['basket'] : [];
$total = 0;

// Check if all items are food
$allFood = !empty($basket) && array_reduce($basket, function ($carry, $product) {
    return $carry && $product['food'] === 'Y';
}, true);

// Handle Hamper logic
if (isset($_POST['toggle_hamper'])) {
    if (isset($_SESSION['hamper'])) {
        unset($_SESSION['hamper']);  // Remove hamper
    } else {
        $_SESSION['hamper'] = 'Y';  // Add hamper
    }
}

// Add hamper cost if it's set
if (isset($_SESSION['hamper'])) {
    $total += 1.50;
}
?>


<html>

<head>
    <?php loadPartial("head"); ?>
    <title>Your Basket</title>
</head>

<body>

    <!-- Navbar -->
    <?php loadPartial("navbar"); ?>
    <!-- Navbar End -->

    <!-- Main Container -->
    <div class="relative h-screen">

        <!-- Left Image -->
        <?php loadPartial("leavesLeft"); ?>

        <!-- Content -->
        <div class="absolute top-0 left-0 right-0 flex flex-col items-center z-10">

            <h1 class="text-3xl font-bold mt-32">Your Basket:</h1>

            <!-- Basket Items -->
            <div class="w-full max-w-4xl mt-8 px-4">
                <?php if (empty($basket)) : ?>
                    <p class="text-xl text-center">Your basket is currently empty.</p>
                <?php else : ?>
                    <div class="flex flex-col space-y-4">
                        <?php foreach ($basket as $product) : ?>
                            <div class="flex justify-between items-center bg-white p-4 rounded shadow">
                                <div>
                                    <p class="text-lg font-semibold"><?= htmlspecialchars($product['name']) ?></p>
                                    <?php if (!empty($product['size'])) : ?>
                                        <p class="text-sm text-gray-500">Size: <?= htmlspecialchars($product['size']) ?></p>
                                    <?php endif; ?>
                                    <?php if (!empty($product['customisation'])) : ?>
                                        <p class="text-sm text-gray-500">Customisation: <?= htmlspecialchars($product['customisation']) ?></p>
                                    <?php endif; ?>
                                    <p class="text-sm text-gray-500">Price: £<?= htmlspecialchars($product['price']) ?></p>
                                </div>
                                <div>
                                    <form action="removeFromBasket.php" method="POST" class="inline-block ml-4">
                                        <input type="hidden" name="product_name" value="<?= $product['name'] ?>">
                                        <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded">Remove</button>
                                    </form>
                                </div>
                            </div>
                            <?php $total += floatval(str_replace('£', '', $product['price'])); ?>
                        <?php endforeach; ?>
                    </div>

                    <!-- Total -->
                    <div class="mt-6 text-right">
                        <p class="text-2xl font-bold">Total: £<?= number_format($total, 2) ?></p>
                        <form class="mt-4 w-full flex justify-end" method="post" action="/order/placeOrder.php">
                            <input type="submit" value="Order"
                                class="w-32 h-12 bg-[#D8903F] text-white font-bold rounded-xl text-center hover:bg-[#B3762D]">
                        </form>
                    </div>

                    <?php if ($allFood) : ?>
                        <div class="mt-6 text-right">
                            <form method="post">
                                <input type="hidden" name="toggle_hamper" value="1">
                                <button type="submit" class="w-32 h-12 bg-green-500 text-white font-bold rounded-xl text-center hover:bg-green-700">
                                    <?php if (isset($_SESSION['hamper'])) : ?>
                                        Remove Hamper -£1.50
                                    <?php else : ?>
                                        Hamper? +£1.50
                                    <?php endif; ?>
                                </button>
                            </form>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right Image -->
        <?php loadPartial("leavesRight"); ?>

    </div>
    <!-- Main Container End -->

</body>

<?php loadPartial("navbarScript") ?>

</html>