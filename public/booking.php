<!DOCTYPE html>
<?php
require __DIR__ . '/../vendor/autoload.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../helpers.php';
require './booking/getBooking.php';

if ($_SESSION['userID'] != $booking['userID']) {
    redirect('/');
}
?>

<html>

<head>
    <?php loadPartial("head"); ?>
    <title>Booking Confirmation</title>
</head>

<body class="relative flex items-center justify-center h-screen bg-[#EEE7B6]">


    <?php loadPartial("leavesLeft"); ?>

    <div class="absolute top-8 flex justify-center w-full">
        <div class="bg-[#D8903F] w-2 h-96"></div>
        <div class="bg-gray-800 w-4 h-4 rounded-full absolute -top-2"></div>
    </div>

    <div class="relative bg-white shadow-lg p-4 w-2/5 rounded-lg text-center mt-32 transform rotate-2 hover:rotate-0 transition duration-300 ease-in-out">
        <img src="/images/booking_confirmation.jpg" alt="Booking Confirmation" class="rounded-md mb-4 object-cover w-full">
        <div class="text-gray-800 text-lg font-mono">
            <p class="font-bold text-xl"><?= htmlspecialchars($booking['name']) ?></p>
            <p><?= htmlspecialchars($booking['date']) ?> at <?= htmlspecialchars($booking['time']) ?></p>
            <p><?= htmlspecialchars($booking['location']) ?></p>
            <p>Guests: <?= htmlspecialchars($booking['number_of_guests']) ?></p>
        </div>
    </div>

    <?php loadPartial("leavesRight"); ?>

</body>

</html>