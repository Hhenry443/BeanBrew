<!DOCTYPE html>

<?php
require __DIR__ . '/../vendor/autoload.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../helpers.php';
require './posts/getPosts.php';


?>
<html lang="en">

<head>
    <?php loadPartial("head"); ?>
    <title>Forum</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
            <h1 class="text-3xl font-bold text-center mt-32">Forum Posts</h1>
            <?php loadPartial("postBlogIcon") ?>


            <hr class="border-line-brown border-t-[6px] w-1/2 mt-8">

            <!-- Posts Section -->
            <div class="mt-8 w-3/5 space-y-6">
                <?php foreach ($posts as $post): ?>
                    <a href="post.php?id=<?php echo htmlspecialchars($post['postID']); ?>" class="block">
                        <div class="bg-[#f8f3ed] rounded-xl shadow-md p-6">
                            <div class="flex items-center space-x-4 mb-4">
                                <img src="./<?php echo $post['imageURL']; ?>" alt="Post Image" class="w-16 h-16 rounded-full">
                                <div>
                                    <h2 class="text-xl font-semibold"><?php echo htmlspecialchars($post['title']); ?></h2>
                                    <p class="text-gray-500">Posted by <?php echo htmlspecialchars($post['username']); ?></p>
                                </div>
                            </div>
                            <p class="text-gray-700"><?php echo nl2br(htmlspecialchars($post['content'])); ?></p>
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

    <?php loadPartial("navbarScript"); ?>
</body>

</html>