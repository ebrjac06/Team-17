<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$isLoggedIn = isset($_SESSION["user"]);
?>

<header>
    <div class="logo">
        <a href="index.html">
            <img src="DRIP & CO LOGO.png" alt="Drip & Co Logo" style="width:140px;height:100px;">
        </a>
    </div>

    <div class="search-box">
        <input type="text" id="searchInput" placeholder="Search">
        <div id="searchResults"></div>
    </div>

    <div class="icons">
        <a href="">
            <img src="images/heart.png" alt="Wishlist" style="width: 50px; height: 50px;">
        </a>

        <a href="Basket Page.html">
            <img src="images/Basket.png" alt="Basket" style="width: 30px; height: 30px;">
        </a>

        <?php if ($isLoggedIn): ?>
            <a href="#">
                <img src="images/User.png" alt="Account" style="width: 50px; height: 50px;">
            </a>
            
            <a href="logout.php" class="logout-btn-header" style="background: #003b49; color: white; padding: 10px 18px; border-radius: 8px; text-decoration: none; font-weight: bold; font-size: 14px; display: inline-flex; align-items: center; margin-left: 10px;">
                Logout
            </a>
        <?php else: ?>
            <a href="login.php">
                <img src="images/User.png" alt="Account" style="width: 50px; height: 50px;">
            </a>
        <?php endif; ?>

        <button class="dark-button" onclick="darkmode()" aria-pressed="false" aria-label="Toggle dark mode">
            <i class="fa fa-moon-o" aria-hidden="true"></i>
        </button>
    </div>
</header>

<nav>
    <a href="Mens page.html">Mens</a>
    <a href="Womens Page.html">Womens</a>
    <a href="contact us.html">Contact Us</a>
    <a href="About us.html">About Us</a>
</nav>
