<!DOCTYPE html>

<?php
require __DIR__ . '/../vendor/autoload.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['userID'])) {
    redirect('/');
}

require '../helpers.php';
require './lessons/fetchSingleLesson.php'; // This will now load the $product variable

// Load events from getEvents
$events = require './events/getEvents.php'; // Ensure this returns an associative array of events


// Initialize variables
$filteredEvents = [];
$selectedLocation = '';

// Check if a location is set and filter events accordingly
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['location'])) {
        $selectedLocation = $_POST['location'];

        // Filter events based on the selected location
        $filteredEvents = array_filter($events, function ($event) use ($selectedLocation) {
            return stripos($event['location'], $selectedLocation) !== false; // Adjust the 'location' field name as necessary
        });
    }
}
?>

<html>

<head>
    <?php loadPartial("head"); ?>
    <title><?= $lesson['title'] ?></title>
</head>

<body>

    <!-- Main Container -->
    <div class="relative h-screen">

        <!-- Left Image -->
        <?php loadPartial("leavesLeft"); ?>

        <!-- Content -->
        <div class="flex flex-row items-center w-full h-full">
            <div class="w-full h-full bg-[#F5EFC6] flex items-center justify-center">
                <div class="p-6 bg-white rounded-lg shadow-lg">
                    <h2 class="text-2xl font-bold mb-4">Book Your Lesson</h2>

                    <!-- Location Selection Form -->
                    <form action="" method="POST" id="locationForm">
                        <label for="location" class="block mb-2">Select Your Location:</label>
                        <select name="location" id="location" required class="mb-4 w-full p-2 border rounded">
                            <option value="">Choose a location</option>
                            <option value="Leeds" <?= $selectedLocation === 'Leeds' ? 'selected' : ''; ?>>Leeds</option>
                            <option value="Harrogate" <?= $selectedLocation === 'Harrogate' ? 'selected' : ''; ?>>Harrogate</option>
                            <option value="Knaresborough Castle" <?= $selectedLocation === 'Knaresborough Castle' ? 'selected' : ''; ?>>Knaresborough Castle</option>
                        </select>
                        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Filter Events</button>
                    </form>

                    <!-- Event Selection Form -->
                    <?php if (!empty($filteredEvents)): ?>
                        <form action="/lessons/processLessonBooking.php" method="POST">
                            <label for="event" class="block mb-2 mt-2">Choose a Date:</label>
                            <select name="event_id" id="event" class="mb-4 w-full p-2 border rounded" required>
                                <option value="">Select a date</option>
                                <?php foreach ($filteredEvents as $event): ?>
                                    <?php
                                    $dateTime = new DateTime($event['date']);
                                    $formattedDate = $dateTime->format('d-m-Y H:i'); // Format as d-m-y H:i
                                    ?>
                                    <option value="<?= $event['eventID']; ?>"><?= $formattedDate; ?> - (Spaces left: <?= $event['spaces_left']; ?>)</option>
                                <?php endforeach; ?>
                            </select>

                            <label for="name" class="block mb-2">Your Name:</label>
                            <input type="text" name="name" id="name" required class="mb-4 w-full p-2 border rounded" placeholder="Enter your name">

                            <label for="email" class="block mb-2">Your Email:</label>
                            <input type="email" name="email" id="email" required class="mb-4 w-full p-2 border rounded" placeholder="Enter your email">

                            <label for="guests" class="block mb-2">Guests:</label>
                            <input type="number" max="<?= isset($event) ? $event['spaces_left'] : 0; ?>" name="guests" id="guests" required class="mb-4 w-full p-2 border rounded" placeholder="Number of Guests">

                            <input name="userID" type="hidden" value="<?= $_SESSION['userID'] ?>">

                            <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Sign Up</button>
                        </form>
                    <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
                        <p class="mt-4 text-red-500">No events available for the selected location.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Image -->
    <?php loadPartial("leavesRight"); ?>

    </div>
    <!-- Main Container End-->

</body>

</html>