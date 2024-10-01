<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Database connection parameters
$host = 'localhost'; // Change if necessary
$db   = 'beanandbrew'; // Your database name
$user = 'root'; // Your database username
$pass = 'root'; // Your database password
$charset = 'utf8mb4';

// Set up the DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";


// Create a PDO instance
$pdo = new PDO($dsn, $user, $pass);
// Set error mode to exception to catch errors
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch data from the form
    $lesson_id = $_POST['lesson_id'];
    $event_date = $_POST['event_date'];
    $location = $_POST['location'];
    $capacity = $_POST['capacity'];

    // Prepare and execute the SQL query
    $stmt = $pdo->prepare("INSERT INTO tbl_events (lessonID, date, location, capacity) VALUES (?, ?, ?, ?)");
    $stmt->execute([$lesson_id, $event_date, $location, $capacity]);

    // Redirect or show success message
    header("Location: addEvents.php"); // Change to your events listing page
    exit();
}

// Fetch lessons for the dropdown
$lessons = $pdo->query("SELECT lessonID, title FROM tbl_lessons")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 p-6">
    <div class="max-w-xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h1 class="text-2xl font-bold mb-4">Add Event</h1>
        <form method="POST" action="">
            <div class="mb-4">
                <label for="lesson_id" class="block text-sm font-medium text-gray-700">Select Lesson</label>
                <select name="lesson_id" id="lesson_id" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="" disabled selected>Select a lesson</option>
                    <?php foreach ($lessons as $lesson): ?>
                        <option value="<?= $lesson['lessonID'] ?>"><?= $lesson['title'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label for="event_date" class="block text-sm font-medium text-gray-700">Event Date</label>
                <input type="datetime-local" name="event_date" id="event_date" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
            </div>

            <div class="mb-4">
                <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                <select name="location" id="location" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="" disabled selected>Select a location</option>
                    <option value="Harrogate">Harrogate</option>
                    <option value="Leeds">Leeds</option>
                    <option value="Knaresborough Castle">Knaresborough Castle</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="capacity" class="block text-sm font-medium text-gray-700">Event Capacity</label>
                <input type="number" name="capacity" id="capacity" required min="1" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" placeholder="Max capacity">
            </div>

            <div>
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded">
                    Add Event
                </button>
            </div>
        </form>
    </div>
</body>

</html>