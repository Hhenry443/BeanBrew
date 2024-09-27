<!DOCTYPE html>

<?php
require __DIR__ . '/../vendor/autoload.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../helpers.php';

// Redirect to login page if userID is not set
if (!isset($_SESSION['userID'])) {
    redirect('/login.php');
    exit(); // Ensures that no further code is executed after redirect
}

require './products/fetchProducts.php';
?>

<html>


<head>
    <?php loadPartial("head"); ?>
    <title>Order</title>
</head>

<body>

    <!-- Navbar -->
    <?php loadPartial("navbar"); ?>
    <!-- Navbar End-->

    <!-- Main Container -->
    <div class="relative h-screen">


        <!-- Left Image -->
        <?php loadPartial("leavesLeft"); ?>

        <!-- Content -->
        <div class="absolute top-0 left-0 right-0 flex flex-col items-center z-10">
            <h1 class="text-3xl font-bold mt-32">Pre-Order Today!</h1>

            <?php loadPartial("basketIcon") ?>

            <hr class="border-line-brown border-t-[6px] w-1/2 mt-8">


            <div class="flex justify-center space-x-6 mt-8">
                <button onclick="showDiv('food')" class="flex flex-col items-center">
                    <i class="fas fa-birthday-cake text-5xl text-orange-800 hover:text-[#67360A]"></i>
                    <span id="foodText" class="mt-2 text-lg">Food</span>
                </button>
                <button onclick="showDiv('drink')" class="flex flex-col items-center">
                    <i class="fas fa-coffee text-5xl text-orange-800 hover:text-[#67360A]"></i>
                    <span id="drinkText" class="mt-2 text-lg">Drink</span>
                </button>
            </div>

            <div id="food" class="hidden mt-8">
                <div class="relative inline-block">
                    <!-- Dropdown Button (Rectangle) -->
                    <button id="fooddropdownButton" class="w-96 bg-white text-gray-800 font-bold ring-2 ring-gray-800 px-6 py-3 text-left rounded-xl shadow-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:shadow-xl">
                        All Food
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="fooddropdownMenu" class="absolute left-0 w-96 bg-white border border-gray-300 rounded-md shadow-lg mt-1 hidden">
                        <a href="#" class="block px-4 py-3 text-gray-700 hover:bg-gray-100" data-value="All Food">All Food</a>
                        <a href="#" class="block px-4 py-3 text-gray-700 hover:bg-gray-100" data-value="Breakfast">Breakfast</a>
                        <a href="#" class="block px-4 py-3 text-gray-700 hover:bg-gray-100" data-value="Lunch">Lunch</a>
                        <a href="#" class="block px-4 py-3 text-gray-700 hover:bg-gray-100" data-value="Pastries & Sweets">Pastries & Sweets</a>
                        <a href="#" class="block px-4 py-3 text-gray-700 hover:bg-gray-100" data-value="Snacks">Snacks</a>
                    </div>
                </div>
            </div>

            <div id="drink" class="hidden mt-8">

                <div class="relative inline-block">
                    <!-- Dropdown Button (Rectangle) -->
                    <button id="drinkdropdownButton" class="w-96 bg-white text-gray-800 font-bold ring-2 ring-gray-800 px-6 py-3 text-left rounded-xl shadow-lg hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:shadow-xl">
                        All Drinks
                    </button>
                    <!-- Dropdown Menu -->

                    <div id="drinkdropdownMenu" class="absolute left-0 w-96 bg-white border border-gray-300 rounded-md shadow-lg mt-1 hidden">
                        <a href="#" class="block px-4 py-3 text-gray-700 hover:bg-gray-100" data-value="All Drinks">All Drinks</a>
                        <a href="#" class="block px-4 py-3 text-gray-700 hover:bg-gray-100" data-value="Frappé">Frappé</a>
                        <a href="#" class="block px-4 py-3 text-gray-700 hover:bg-gray-100" data-value="Coffee Over Ice">Coffee Over Ice</a>
                        <a href="#" class="block px-4 py-3 text-gray-700 hover:bg-gray-100" data-value="Coffee">Coffee</a>
                        <a href="#" class="block px-4 py-3 text-gray-700 hover:bg-gray-100" data-value="Other Cold Drinks">Other Cold Drinks</a>
                        <a href="#" class="block px-4 py-3 text-gray-700 hover:bg-gray-100" data-value="Other Hot Drinks">Other Hot Drinks</a>
                        <a href="#" class="block px-4 py-3 text-gray-700 hover:bg-gray-100" data-value="Iced Tea">Iced Tea</a>
                        <a href="#" class="block px-4 py-3 text-gray-700 hover:bg-gray-100" data-value="Tea">Tea</a>
                        <a href="#" class="block px-4 py-3 text-gray-700 hover:bg-gray-100" data-value="Fruit Coolers">Fruit Coolers</a>
                    </div>
                </div>
            </div>

            <hr class="border-line-brown border-t-[6px] w-1/2 mt-8">

            <div id="foodProducts" class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 w-3/5">
                <?php foreach ($products as $product): ?>
                    <?php if ($product['food'] === 'Y'): ?>
                        <a href="itemPage.php?id=<?php echo htmlspecialchars($product['itemID']); ?>" class="block">
                            <div class="border border-gray-300 rounded-lg shadow-lg p-4 product h-96" data-type="<?php echo htmlspecialchars($product['type']); ?>">
                                <h2 class="text-xl font-bold text-center mb-4"><?php echo htmlspecialchars($product['name']); ?></h2>
                                <img src="<?php echo htmlspecialchars($product['image_url']); ?>PNG.png" alt="<?php echo htmlspecialchars($product['name']); ?>" class="w-full h-48 object-contain mb-4">
                                <p class="text-center font-semibold text-gray-700 text-lg"><?php echo htmlspecialchars($product['description']); ?></p>
                                <p class="text-center text-lg text-orange-800 font-bold mt-4">£<?php echo htmlspecialchars($product['price']); ?></p>
                            </div>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>

            <div id="drinkProducts" class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 w-3/5">
                <?php foreach ($products as $product): ?>
                    <?php if ($product['food'] === 'N'): ?>
                        <a href="itemPage.php?id=<?php echo htmlspecialchars($product['itemID']); ?>" class="block">
                            <div class="border border-gray-300 rounded-lg shadow-lg p-4 product h-96" data-type="<?php echo htmlspecialchars($product['type']); ?>">
                                <h2 class="text-xl font-bold text-center mb-4"><?php echo htmlspecialchars($product['name']); ?></h2>
                                <img src="<?php echo htmlspecialchars($product['image_url']); ?>PNG.png" alt="<?php echo htmlspecialchars($product['name']); ?>" class="w-full h-48 object-contain mb-4">
                                <p class="text-center text-lg"><?php echo htmlspecialchars($product['description']); ?></p>
                                <p class="text-center text-lg text-orange-800 font-bold mt-4">£<?php echo htmlspecialchars($product['price']); ?></p>
                            </div>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>



            <hr class="border-line-brown border-t-[6px] w-1/2 mt-8">

            <?php loadPartial("footer"); ?>
        </div>

        <!-- Right Image -->
        <?php loadPartial("leavesRight"); ?>


    </div>
    <!-- Main Container End-->
</body>


<?php loadPartial("navbarScript") ?>

<script src="/js/filter.js"> </script>
<script src="/js/orderPageFunctions.js"></script>

</html>