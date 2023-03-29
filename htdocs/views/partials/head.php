<!DOCTYPE html>

<html lang="en" data-theme="dark">

<head>
    <meta charset="UTF-8">

    <!-- Pico CSS -->
    <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@latest/css/pico.min.css">

    <!-- CSS per resource -->
    <?php foreach ($stylesheets as $sheet) : ?>
    <link rel="stylesheet" href="css/<?= $sheet ?>">
    <?php endforeach; ?>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../../images/favicon.ico">

    <!-- Page title -->
    <title><?= $page_title ?></title>
</head>

<body>
    <!-- Nav -->
    <nav class="container-fluid">
        <ul>
            <li><a href="./" class="contrast bold ">We Plan, You Travel ✈️</a></li>
        </ul>
        <!-- If the current page is browse.php, display -->
        <?php if (basename($_SERVER['PHP_SELF']) == 'browse.php') : ?>
        <ul>
            <li>
                <!-- logout button -->
                <form action=" browse.php" method="post" class="margin_5">
                    <button type="submit" name="logout" class="contrast">Logout</button>
                </form>
            </li>
        </ul>
        <?php endif; ?>
    </nav>