<!DOCTYPE html>

<?php
require __DIR__ . '/../vendor/autoload.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../helpers.php';
require './posts/getSinglePost.php'; // This will now load the $post variable
require './posts/getComments.php'; // This is how we get the $comments variable

?>

<html>

<head>
    <?php loadPartial("head"); ?>
    <title><?= htmlspecialchars($post['title']) ?></title>
</head>

<body>

    <!-- Main Container -->
    <div class="relative h-screen">

        <!-- Content -->
        <div class="flex flex-row items-center w-full h-full">
            <div class="w-1/2 h-full bg-[#EEE7B6] flex items-center justify-center rounded-xl overflow-hidden">
                <img src="./<?= htmlspecialchars($post['imageURL']) ?>" class="h-2/3 w-2/3 z-10 object-scale-down" alt="<?= htmlspecialchars($post['title']) ?>">
            </div>

            <div class="w-1/2 h-full bg-[#F5EFC6]">

                <!-- X Button -->
                <button onclick="window.location.href='/ratemycake.php';" class="absolute top-16 right-96 text-black font-bold text-3xl focus:outline-none z-10">
                    X
                </button>

                <h1 class="mx-8 mt-20 text-4xl font-bold break-words w-2/4"><?= htmlspecialchars($post['title']) ?></h1>

                <p class="mx-8 mt-12 text-xl font-semibold">Posted by: <?= htmlspecialchars($post['username']) ?></p>

                <p class="mx-8 mt-8 text-2xl"><?= nl2br(htmlspecialchars($post['content'])) ?></p>

                <!-- Comments Section -->
                <div class="mx-8 mt-12">
                    <h2 class="text-2xl font-bold">Comments:</h2>
                    <div id="comments" class="mt-4">
                        <?php if (count($comments) > 0): ?>
                            <?php foreach ($comments as $comment): ?>
                                <div class="border-b border-gray-300 py-2">
                                    <strong class="text-lg"><?= htmlspecialchars($comment['username']) ?>:</strong>
                                    <p class="mt-1"><?= nl2br(htmlspecialchars($comment['comment'])) ?></p>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p>No comments yet.</p>
                        <?php endif; ?>
                    </div>

                    <form action="./posts/insertComment.php" method="POST" class="mt-4">
                        <input type="hidden" value="<?= $_SESSION['username'] ?>" name="username">
                        <input type="hidden" value="<?= $_GET['id'] ?>" name="postID">

                        <textarea name="comment" rows="3" class="w-full p-2 border border-gray-300 rounded" placeholder="Add a comment..."></textarea>
                        <button type="submit" class="mt-2 w-full h-12 bg-[#D8903F] text-white font-bold rounded-xl text-center hover:bg-[#B3762D]">
                            Submit Comment
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>
    <!-- Main Container End-->

</body>

</html>