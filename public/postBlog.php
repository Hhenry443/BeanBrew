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

?>

<html>

<head>
    <?php loadPartial("head"); ?>
    <title>Create Blog Post</title>
</head>

<body>

    <!-- Navbar -->
    <?php loadPartial("navbar"); ?>
    <!-- Navbar End-->

    <!-- Main Container -->
    <div class="relative h-screen">

        <!-- Content -->
        <div class="absolute top-0 left-0 right-0 flex flex-col items-center z-10">

            <!-- Left Image -->
            <?php loadPartial("leavesLeft"); ?>

            <!-- Centered Title -->
            <h1 class="text-3xl font-bold text-center mt-32">Create a New Blog Post</h1>

            <hr class="border-line-brown border-t-[6px] w-1/2 mt-8">

            <!-- Blog Post Form -->
            <div class="mt-8 w-1/2 bg-[#f8f3ed] p-6 rounded-xl">
                <form action="./posts/submitPost.php" method="POST" enctype="multipart/form-data" class="flex flex-col space-y-4">

                    <!-- Hidden Username -->
                    <input type="hidden" name="username" value="<?php echo htmlspecialchars($_SESSION['username']); ?>">

                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" id="title" name="title" required class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <!-- Content -->
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                        <textarea id="content" name="content" rows="4" required class="mt-1 p-2 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"></textarea>
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700">Upload Image</label>
                        <input type="file" id="image" name="image" accept="image/*" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="mt-4 bg-[#d4852b] hover:bg-[#b77b24] text-white py-2 px-4 rounded-md">
                        Submit Post
                    </button>
                </form>
            </div>

            <hr class="border-line-brown border-t-[6px] w-1/2 mt-8">

        </div>

        <!-- Right Image -->
        <?php loadPartial("leavesRight"); ?>

    </div>
    <!-- Main Container End-->

    <?php loadPartial("navbarScript") ?>

</body>

</html>