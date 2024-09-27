<!DOCTYPE html>

<?php
require __DIR__ . '/../vendor/autoload.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../helpers.php';
require './products/fetchSingleProduct.php'; // This will now load the $product variable

// Assuming the image URL is in $product['image_url']
$image_url = $product['image_url'];


?>

<html>

<head>
    <?php loadPartial("head"); ?>
    <title><?= $product['name'] ?></title>
</head>

<body>

    <!-- Main Container -->
    <div class="relative h-screen">

        <!-- Left Image -->
        <?php loadPartial("leavesLeft"); ?>

        <!-- Content -->
        <div class="flex flex-row items-center w-full h-full">
            <div class="w-1/2 h-full bg-[#EEE7B6] flex items-center justify-center">
                <img src="<?= $image_url ?>PNG.png" class="h-2/3 w-2/3 z-10 object-scale-down" alt="<?= htmlspecialchars($product['name']) ?>"></img>
            </div>

            <div class="w-1/2 h-full bg-[#F5EFC6]">

                <!-- X Button -->
                <button onclick="window.location.href='/order.php';" class="absolute top-16 right-96 text-black font-bold text-3xl focus:outline-none z-10">
                    X
                </button>

                <p class="ml-8 mt-20 text-4xl font-bold break-words w-2/4"><?= htmlspecialchars($product['name']) ?></p>

                <p class="ml-8 mt-12 text-2xl font-bold"><?= htmlspecialchars($product['description']) ?></p>

                <!-- Buttons for allergen and nutritional information -->
                <div class="mt-8 ml-8 flex flex-col w-2/4 space-y-4">
                    <button
                        class="bg-[#FEFAE0] text-black text-left text-lg font-bold px-4 py-2 rounded-xl shadow-xl border border-black hover:bg-[#EEE7B6] focus:outline-none"
                        onclick="showAllergenInfo()">
                        Show Allergen Information
                    </button>
                    <button
                        class="bg-[#FEFAE0] text-black text-left text-lg font-bold px-4 py-2 rounded-xl shadow-xl border border-black hover:bg-[#EEE7B6] focus:outline-none"
                        onclick="showNutritionInfo()">
                        Show Nutritional Information
                    </button>
                </div>

                <!-- Conditionally displayed div -->
                <?php if ($product['food'] === 'N'): ?>
                    <!-- Form for adding to the basket -->
                    <form action="/order/addToBasket.php" method="POST" class="ml-8 mt-8">
                        <input type="hidden" name="name" value="<?= htmlspecialchars($product['name']) ?>">
                        <input type="hidden" name="size" id="sizeInput" value="Medium">
                        <input type="hidden" name="customisation" value="">
                        <input type="hidden" name="price" id="priceInput" value="<?= htmlspecialchars($product['price']) ?>">

                        <p class="mt-12 text-2xl font-bold">Size</p>

                        <div class="flex space-x-4 mt-4">
                            <!-- Size Buttons -->
                            <button id="SmallButton" type="button" onclick="selectSizeButton('Small', -0.50)" class="size-button w-24 h-24 bg-[#DACB96] text-gray-800 font-bold rounded-full hover:bg-[#bdaf7e]">
                                <i class="fa-solid fa-mug-hot text-xl"></i>
                            </button>
                            <button id="MediumButton" type="button" onclick="selectSizeButton('Medium', 0)" class="size-button w-24 h-24 bg-[#DACB96] text-gray-800 font-bold rounded-full hover:bg-[#bdaf7e]">
                                <i class="fa-solid fa-mug-hot text-2xl"></i>
                            </button>
                            <button id="LargeButton" type="button" onclick="selectSizeButton('Large', 0.50)" class="size-button w-24 h-24 bg-[#DACB96] text-gray-800 font-bold rounded-full hover:bg-[#bdaf7e]">
                                <i class="fa-solid fa-mug-hot text-3xl"></i>
                            </button>
                        </div>

                        <button id="submitButton" type="submit" class="mt-8 w-1/2 h-12 bg-[#D8903F] text-white font-bold rounded-xl text-center hover:bg-[#B3762D]">
                            Add to cart - <?= htmlspecialchars($product['price']) ?>
                        </button>
                    </form>

                    <!-- JavaScript to handle size selection -->
                    <script>
                        // Base price of the medium size
                        let basePrice = parseFloat(<?= htmlspecialchars($product['price']) ?>);
                        let currentPrice = basePrice;

                        function selectSizeButton(size, priceAdjustment) {
                            // Get all size buttons
                            const buttons = document.querySelectorAll('.size-button');

                            // Remove the special class from all buttons
                            buttons.forEach(button => {
                                button.classList.remove('bg-[#9e936a]');
                                button.classList.add('bg-[#DACB96]');
                            });

                            // Add the special class to the selected button
                            const selectedButton = document.getElementById(size + 'Button');
                            selectedButton.classList.remove('bg-[#DACB96]');
                            selectedButton.classList.add('bg-[#9e936a]');

                            // Update the size and price
                            currentPrice = (basePrice + priceAdjustment).toFixed(2);
                            document.getElementById('sizeInput').value = size;
                            document.getElementById('priceInput').value = currentPrice;

                            // Update the button text with the new price (including the £ symbol)
                            const submitButton = document.getElementById('submitButton');
                            submitButton.textContent = 'Add to cart - \u00A3' + currentPrice;
                        }

                        document.addEventListener("DOMContentLoaded", function() {
                            // Initialize with medium size
                            selectSizeButton('Medium', 0);
                        });
                    </script>


                <?php else: ?>
                    <!-- Form for adding to the basket -->
                    <form action="/order/addToBasket.php" method="POST" class="ml-8 mt-8">
                        <input type="hidden" name="name" value="<?= htmlspecialchars($product['name']) ?>">
                        <input type="hidden" name="food" value="<?= htmlspecialchars($product['food']) ?>">
                        <input type="hidden" name="size" value="">
                        <input type="hidden" name="customisation" value="">
                        <input type="hidden" name="price" value="<?= htmlspecialchars($product['price']) ?>">

                        <button type="submit" class="w-1/2 h-12 bg-[#D8903F] text-white font-bold rounded-xl text-center hover:bg-[#B3762D]">
                            Add to cart - £<?= htmlspecialchars($product['price']) ?>
                        </button>
                    </form>
                <?php endif; ?>

            </div>
        </div>

        <!-- Right Image -->
        <?php loadPartial("leavesRight"); ?>

    </div>
    <!-- Main Container End-->

    <script>
        function showAllergenInfo() {
            // Implement functionality to show allergen information
            alert("Allergen information displayed.");
        }

        function showNutritionInfo() {
            // Implement functionality to show nutritional information
            alert("Nutritional information displayed.");
        }
    </script>

</body>

</html>