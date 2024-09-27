<!DOCTYPE html>

<?php
require __DIR__ . '/../vendor/autoload.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require '../helpers.php';

?>

<html>

<head>
    <?php loadPartial("head"); ?>
    <title>Home</title>
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
            <h1 class="text-3xl font-bold text-center mt-32">Where every sip tells a story...</h1>

            <?php loadPartial("basketIcon") ?>


            <hr class="border-line-brown border-t-[6px] w-1/2 mt-8">

            <img src="/images/cafeMain.jpg" class="h-5/12 w-5/12 mt-8">

            <hr class="border-line-brown border-t-[6px] w-1/2 mt-8">

            <div class="w-2/3 h-auto bg-text-box-colour rounded-lg mt-8">
                <h1 class="text-3xl text-center mt-4 font-bold">Our Story...</h1>

                <p class="mx-8 mb-8 mt-4">Once upon a time, in a land where misty forests met rolling hills, there existed a humble kingdom known as Bean and Brew. It wasn’t your ordinary kingdom – it was a magical realm where every brew was crafted with the enchantment of ancient spells and the finest beans guarded by wise gnomes and daring knights. <br><br>

                    Legend has it that Sir Roast-a-Lot, the brave knight of the Coffee Highlands, embarked on a quest to find the rarest, most aromatic beans in all the realms. Armed with a golden mug and an unwavering passion for perfect brews, he journeyed to the far corners of the earth, battling dragons made of steam and befriending mischievous wizards who lived in coffee-stained towers. <br><br>

                    One fateful day, Sir Roast-a-Lot stumbled upon the Brewstone, a mystical artifact said to unlock the true essence of flavor. Alongside Basil the Brew Wizard, keeper of the secret latte spells, and a band of gnomes who meticulously tended to the sacred coffee plants, they created the first ever Bean and Brew elixir.<br><br>

                    With every sip, this elixir brought joy and warmth, casting away the dullness of the day and filling the hearts of all who drank it with energy and cheer. From then on, Bean and Brew became known far and wide, a magical haven where every cup was brewed with love, adventure, and a sprinkle of ancient wizardry.<br><br>

                    Today, we carry on their tradition – crafting potions of perfection from the finest beans, mixed with a dash of enchantment. Whether you're a noble traveler seeking warmth or a local in need of a morning spell, our doors are always open.<br><br>

                    At Bean and Brew, every cup tells a story. What's yours?</p>
            </div>

            <hr class="border-line-brown border-t-[6px] w-1/2 mt-8">

            <div class="w-2/3 mt-8 flex justify-center items-center">
                <!-- Image -->
                <div class="w-1/2 flex justify-center">
                    <img src="/images/flatWhite.jpg" alt="Story Image" class="w-3/4 h-auto rounded-lg shadow-md">
                </div>

                <!-- Text Box -->
                <div class="w-1/2 bg-text-box-colour ml-8 p-6 rounded-lg shadow-md">
                    <h2 class="text-2xl font-bold mb-4">Our Coffee...</h2>
                    <p class="text-base">At Bean and Brew, our coffee isn’t just brewed – it’s conjured. Each cup is the result of careful alchemy, where the finest beans, handpicked by forest gnomes under the light of the moon, meet the ancient spells of our brewmasters. Grown in enchanted lands and roasted to perfection, our beans hold the spirit of adventure and the warmth of a hearth on a winter’s night. <br><br>

                        Every sip unveils layers of rich flavors, crafted to stir your soul and ignite your imagination. From velvety espressos that pack the strength of a knight’s sword to smooth lattes swirled with the wisdom of ancient wizards, our coffee brings magic to your day – one cup at a time.</p>
                </div>
            </div>

            <hr class="border-line-brown border-t-[6px] w-1/2 mt-8">

            <?php loadPartial("footer"); ?>

        </div>

        <!-- Right Image -->
        <?php loadPartial("leavesRight"); ?>


    </div>
    <!-- Main Container End-->
</body>


<?php loadPartial("navbarScript") ?>


</html>