<!DOCTYPE html>

<?php
require __DIR__ . '/../vendor/autoload.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../helpers.php';

// Check if the username is set in the session
if (!isset($_SESSION['username'])) {
    redirect('/login.php'); // Redirect to home page if username is not set
}

require './lessons/getLessons.php';

?>

<html>

<head>
    <?php loadPartial("head"); ?>
    <title>Booking</title>
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

            <!-- Centered Title -->
            <h1 class="text-3xl font-bold text-center mt-32">Book your next coffee adventure!</h1>

            <hr class="border-line-brown border-t-[6px] w-1/2 mt-8">

            <div class="mt-8 rounded-2xl bg-[#e1aa6b] py-4 px-8">
                <p class="text-xl">What would you like to book?</p>
            </div>

            <div class="mt-8 w-96 grid grid-cols-2 justify-items-center justify-center">
                <div id="tableButton" class="flex bg-[#b77b24] w-36 h-10 justify-center items-center rounded-xl cursor-pointer hover:bg-[#b77b24] transition-colors">
                    <p>Table</p>
                </div>
                <div id="lessonButton" class="flex bg-[#d4852b] w-36 h-10 justify-center items-center rounded-xl cursor-pointer hover:bg-[#b77b24] transition-colors">
                    <p>Lesson</p>
                </div>
            </div>

            <hr class="border-line-brown border-t-[6px] w-1/2 mt-8">

            <!-- Content Divs -->
            <div id="tableContent" class="mt-8 w-2/5 bg-[#f8f3ed] p-6 rounded-xl">
                <p class="text-lg font-semibold mb-4">Book a Table:</p>
                <form action="/booking/submitBooking.php" method="POST" class="flex flex-col space-y-4">

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Name for Booking</label>
                        <input type="text" id="name" name="name" required class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <!-- Date -->
                    <div>
                        <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                        <select id="date" name="date" required class="mt-1 block w-full p-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <?php
                            // Generate dates for the next week
                            $today = new DateTime();
                            for ($i = 0; $i < 7; $i++) {
                                $date = $today->modify('+1 day')->format('d-m-Y');
                                echo "<option value=\"$date\">$date</option>";
                            }
                            ?>
                        </select>
                        <div id="availabilityMessage" class="mt-2 text-sm"></div>
                    </div>

                    <!-- Time -->
                    <div>
                        <label for="time" class="block text-sm font-medium text-gray-700">Time</label>
                        <select id="time" name="time" required class="mt-1 block w-full p-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="9:00 AM">9:00 AM</option>
                            <option value="10:00 AM">10:00 AM</option>
                            <option value="11:00 AM">11:00 AM</option>
                            <option value="12:00 PM">12:00 PM</option>
                            <option value="1:00 PM">1:00 PM</option>
                            <option value="2:00 PM">2:00 PM</option>
                            <option value="3:00 PM">3:00 PM</option>
                            <option value="4:00 PM">4:00 PM</option>
                        </select>
                    </div>

                    <!-- Location -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                        <select id="location" name="location" required class="mt-1 block w-full p-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <option value="Harrogate">Harrogate</option>
                            <option value="Leeds">Leeds</option>
                            <option value="Knaresborough Castle">Knaresborough Castle</option>
                        </select>
                    </div>

                    <!-- Number of Guests -->
                    <div>
                        <label for="guests" class="block text-sm font-medium text-gray-700">Number of Guests (Max 10)</label>
                        <input type="number" id="guests" name="guests" min="1" max="10" required class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <!-- Hidden User ID -->
                    <input type="hidden" name="userID" value="<?php echo $_SESSION['userID']; ?>">

                    <!-- Submit Button -->
                    <button id="bookingSubmit" type="submit" class="mt-4 bg-[#d4852b] hover:bg-[#b77b24] text-white py-2 px-4 rounded-md">
                        Submit Booking
                    </button>
                </form>
            </div>

            <div id="lessonContent" class="mt-8 hidden flex justify-around w-3/5">
                <?php foreach ($lessons as $lesson): ?>
                    <a href="lessonPage.php?id=<?php echo $lesson['lessonID']; ?>" class="block">
                        <div class="relative w-64 h-96 bg-gray-100 rounded-xl overflow-hidden group border border-2 ">
                            <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('/images/lessons/<?php echo $lesson['image_url']; ?>');"></div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black via-transparent to-transparent opacity-50"></div>
                            <div class="absolute bottom-0 left-0 w-full h-1/3 bg-gray-100 transform translate-y-full transition-transform duration-300 ease-in-out group-hover:translate-y-0 flex flex-col items-center">
                                <div class="mt-4 text-gray-900 font-bold"><?= $lesson['title'] ?></div>
                                <div class="mt-2 text-gray-900 font-semibold text-center"><?= $lesson['short_description'] ?></div>
                            </div>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>


            <hr class="border-line-brown border-t-[6px] w-1/2 mt-8">

        </div>

        <!-- Right Image -->
        <?php loadPartial("leavesRight"); ?>

    </div>
    <!-- Main Container End-->

    <script>
        document.getElementById('tableButton').onclick = function() {
            document.getElementById('tableContent').classList.toggle('hidden');
            document.getElementById('lessonContent').classList.add('hidden');
            this.classList.toggle('bg-[#b77b24]');
            this.classList.toggle('bg-[#d4852b]');
            document.getElementById('lessonButton').classList.remove('bg-[#b77b24]');
            document.getElementById('lessonButton').classList.add('bg-[#d4852b]');
        };

        document.getElementById('lessonButton').onclick = function() {
            document.getElementById('lessonContent').classList.toggle('hidden');
            document.getElementById('tableContent').classList.add('hidden');
            this.classList.toggle('bg-[#b77b24]');
            this.classList.toggle('bg-[#d4852b]');
            document.getElementById('tableButton').classList.remove('bg-[#b77b24]');
            document.getElementById('tableButton').classList.add('bg-[#d4852b]');
        };
    </script>

    <script>
        document.getElementById('date').addEventListener('change', function() {
            const date = this.value;
            const location = document.getElementById('location').value; // Get selected location

            fetch('/booking/checkBooking.php', { // Adjust the path to your PHP file
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        date: date,
                        location: location
                    }),
                })
                .then(response => response.json())
                .then(data => {
                    const messageDiv = document.getElementById('availabilityMessage');
                    if (data.status === 'full') {
                        messageDiv.textContent = 'This date is fully booked.';
                        messageDiv.className = 'mt-2 text-sm text-red-500'; // Change text color to red
                        document.getElementById('submitButton').disabled = true;
                        document.getElementById('date').classList.add('border-red-500'); // Optional: Add red border
                    } else {
                        messageDiv.textContent = 'This date is available.';
                        messageDiv.className = 'mt-2 text-sm text-green-500'; // Change text color to green
                        document.getElementById('submitButton').disabled = false;
                        document.getElementById('date').classList.remove('border-red-500'); // Remove red border if available
                    }
                })
                .catch(error => {
                    console.error('Error checking availability:', error);
                });
        });
    </script>



</body>

<?php loadPartial("navbarScript") ?>

</html>