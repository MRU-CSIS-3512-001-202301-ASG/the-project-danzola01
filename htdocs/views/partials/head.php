<!DOCTYPE html>

<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">

    <!-- Pico CSS -->
    <link rel="stylesheet" href="https://unpkg.com/@picocss/pico@latest/css/pico.min.css">

    <!-- CSS per resource -->
    <?php foreach ($stylesheets as $sheet) : ?>
    <link rel="stylesheet" href="css/<?= $sheet ?>">
    <?php endforeach; ?>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../images/favicon.ico">

    <!-- Page title -->
    <title><?= $page_title ?></title>
</head>

<body>