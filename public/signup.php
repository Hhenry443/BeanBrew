<!DOCTYPE html>

<?php

require __DIR__ . '/../vendor/autoload.php';
require '../helpers.php';
?>

<html>

<head>
    <?php loadPartial("head"); ?>
    <title>Sign Up</title>
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
            <h1 class="text-3xl font-bold mt-32">Sign Up</h1>

            <hr class="border-line-brown border-t-[6px] w-1/2 mt-8">
            <?php if (isset($_SESSION['error'])) : ?>
                <script>
                    alert("<?= $_SESSION['error'] ?>")
                </script>
            <?php endif ?>
            <?php unset($_SESSION['error']); ?>

            <div class="h-96 w-2/5 bg-[#f8f3ed] flex justify-center mt-8 rounded-xl">
                <form class="w-1/2 text-center" method="post" action="/auth/register.php">
                    <input name="username" type="text" placeholder="Username"
                        class="w-full h-12 bg-[#FFF5E1] text-[#67360A] border border-[#D8903F] rounded-xl text-center mt-6 placeholder-[#A78A7F]">
                    <input name="password" type="password" placeholder="Password"
                        class="w-full h-12 bg-[#FFF5E1] text-[#67360A] border border-[#D8903F] rounded-xl text-center mt-6 placeholder-[#A78A7F]">
                    <input name="email" type="email" placeholder="Email"
                        class="w-full h-12 bg-[#FFF5E1] text-[#67360A] border border-[#D8903F] rounded-xl text-center mt-6 placeholder-[#A78A7F]">
                    <input name="name" type="text" placeholder="Full Name"
                        class="w-full h-12 bg-[#FFF5E1] text-[#67360A] border border-[#D8903F] rounded-xl text-center mt-6 placeholder-[#A78A7F]">
                    <div class="flex justify-between mt-6">
                        <input type="submit" value="Sign Up"
                            class="w-1/2 h-12 bg-[#D8903F] text-white font-bold rounded-xl text-center hover:bg-[#B3762D]">
                        <a href="/login.php" class="w-1/2 h-12 bg-[#FFF5E1] text-[#67360A] border border-[#D8903F] font-bold rounded-xl text-center flex items-center justify-center ml-2 hover:bg-[#F3E0C6]">Login Instead</a>
                    </div>
                </form>
            </div>

            <hr class="border-line-brown border-t-[6px] w-1/2 mt-8">
        </div>

        <!-- Right Image -->
        <?php loadPartial("leavesRight"); ?>

    </div>
    <!-- Main Container End-->

</body>

<?php loadPartial("navbarScript") ?>

</html>