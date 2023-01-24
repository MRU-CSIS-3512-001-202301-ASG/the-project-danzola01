<nav class="container-fluid">
    <ul>
        <li><a href="./" class="contrast"><strong>Good Travels</strong></a></li>
    </ul>
    <ul>
        <li>
            <?php
            if (isset($_SESSION['Email'])) {
                echo '<a href="./includes/logout.inc.php" class="contrast">Logout</a>';
            } else {
                echo '<a href="./register.php" class="contrast">Register</a>';
            }
            ?>
        </li>
        <li><a href="./" class="contrast">Home</a></li>
        <li><a href="./admin.php" class="contrast">Login</a></li>
    </ul>
</nav>