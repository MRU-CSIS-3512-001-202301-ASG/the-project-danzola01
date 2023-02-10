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

// Get total pages that will be displayed
$total_pages = ceil(get_image_count($dbh) / IMAGES_PER_PAGE);

$offset = ($page - 1) * IMAGES_PER_PAGE;

// Determine the sort order
if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
} else {
    $sort = 'country_AZ';
}

// Switch statement to determine the sort order
switch ($sort) {
    case 'country_AZ':
        $image_ids = get_imageID_from_userID_sort_country_AZ($dbh, $offset);
        break;
    case 'country_ZA':
        $image_ids = get_imageID_from_userID_sort_country_ZA($dbh, $offset);
        break;
    case 'city_AZ':
        $image_ids = get_imageID_from_userID_sort_city_AZ($dbh, $offset);
        break;
    case 'city_ZA':
        $image_ids = get_imageID_from_userID_sort_city_ZA($dbh, $offset);
        break;
    case 'rating_HL':
        $image_ids = get_imageID_from_userID_sort_rating_HL($dbh, $offset);
        break;
    case 'rating_LH':
        $image_ids = get_imageID_from_userID_sort_rating_LH($dbh, $offset);
        break;
}

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
