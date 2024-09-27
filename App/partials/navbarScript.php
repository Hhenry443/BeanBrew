<script>
    document.getElementById("orderNavButton").onclick = function() {
        // Redirect to basket.php if on order.php; otherwise, to order.php
        var currentPage = window.location.pathname;
        console.log(currentPage);
        if (currentPage === "/order.php") {
            location.href = "/basket.php";
        } else {
            location.href = "/order.php";
        }
    };

    document.getElementById("bookNavButton").onclick = function() {
        location.href = "/book.php";
    };

    document.getElementById("socialNavButton").onclick = function() {
        location.href = "/rate-my-cake.php";
    };

    document.getElementById("homeNavButton").onclick = function() {
        location.href = "/";
    };
</script>