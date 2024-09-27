<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Determine the current page
$current_page = basename($_SERVER['PHP_SELF']);
?>

<div class="fixed z-40 w-full bg-[#D8903F] h-24 flex justify-between items-center px-4">
    <!-- Left Buttons Group -->
    <div class="flex w-1/3 place-content-evenly">
        <!-- Conditionally Render the Order/Basket Button -->
        <?php if ($current_page == 'order.php'): ?>
            <button id="orderNavButton" class="bg-[#D8903F] w-1/2 h-24 border-r border-[#67360A]">
                <p class="text-2xl font-bold">Basket</p>
            </button>
        <?php else: ?>
            <button id="orderNavButton" class="bg-[#D8903F] w-1/2 h-24 border-r border-[#67360A]">
                <p class="text-2xl font-bold">Order</p>
            </button>
        <?php endif; ?>
        <button id="bookNavButton" class="bg-[#D8903F] w-1/2 h-24 border-r border-[#67360A]">
            <p class="text-2xl font-bold">Booking</p>
        </button>
    </div>

    <!-- Middle Button (absolute, positioned outside the div) -->
    <button id="homeNavButton" class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-[#67360A] h-32 w-1/3 rounded-lg shadow-lg z-20">
        <p class="text-4xl font-bold text-white">Bean & Brew</p>
    </button>

    <!-- Right Buttons Group -->
    <div class="flex w-1/3 place-content-evenly">
        <button id="socialNavButton" class="bg-[#D8903F] w-1/2 h-24 border-l border-[#67360A]">
            <p class="text-2xl font-bold">Social</p>
        </button>

        <?php if (isset($_SESSION["username"])) : ?>
            <!-- Logout Button -->
            <button id="logOutNavButton" class="bg-[#D8903F] w-1/2 h-24 border-l border-[#67360A]" onclick="window.location.href='/logout.php'">
                <p class="text-2xl font-bold">Logout</p>
            </button>
        <?php else: ?>
            <!-- Register Button -->
            <button id="loginNavButton" class="bg-[#D8903F] w-1/2 h-24 border-l border-[#67360A]" onclick="window.location.href='/login.php'">
                <p class="text-2xl font-bold">Login</p>
            </button>
        <?php endif; ?>

    </div>
</div>