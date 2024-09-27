<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Get the number of items in the basket
$basketItemCount = isset($_SESSION['basket']) ? count($_SESSION['basket']) : 0;
?>

<!-- Basket Icon with Item Count -->
<a href="/basket.php">
    <div class="fixed top-24 right-16 mt-8 ml-96 h-24 w-24 rounded-full bg-[#D8903F] flex items-center justify-center border-2 border-[#67360A]">
        <div class="flex items-center space-x-2">
            <i class="fas fa-shopping-basket text-3xl text-white"></i>
            <?php if ($basketItemCount > 0): ?>
                <span class="absolute top-12 right-5 bg-red-600 text-white rounded-full px-2 py-1 text-sm font-bold"><?php echo $basketItemCount; ?></span>
            <?php endif; ?>
        </div>
    </div>
</a>