<?php

session_start();

$stylesheets = [
    "style.css"
];

$page_title = "Browse/Filter";

// Connect to the database
require './constants.php';
require 'database/DatabaseHelper.php';
require 'database/queryBuilder.php';

$config = require 'database/config.php';
$dbClass = new DatabaseHelper($config);
$dbh = $dbClass->getDb();

// Get the page number from the URL
$page = isset($_GET['page']) ? $_GET['page'] : 1;

$image_ids = get_imageID_from_userID($dbh);

$posts = [];

foreach ($image_ids as $image_id) {
    $posts[] = [
        'image' => get_image($dbh, $image_id['ImageID']),
        'city' => get_city($dbh, $image_id['ImageID']),
        'country' => get_country($dbh, $image_id['ImageID']),
        'latitude' => get_longitute($dbh, $image_id['ImageID']),
        'longitude' => get_latitude($dbh, $image_id['ImageID']),
        'rating' => get_rating($dbh, $image_id['ImageID']),
    ];
}

// If the user is not logged in, redirect to the login page
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: admin.php");
}

// If the user is logged in, display the browse page
else {
    require 'views/browse.view.php';
}

// receive the new rating from the form and update the value in the $post array
if (isset($_POST['new_rating'])) {
    set_rating($dbh, $_POST['image_id'], $_POST['new_rating']);
}
