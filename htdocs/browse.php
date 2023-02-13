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

// Get the database connection
$config = require 'database/config.php';
$dbClass = new DatabaseHelper($config);
$dbh = $dbClass->getDb();

// Get query string information
$page = isset($_GET['page']) ? $_GET['page'] : 1;

$sort = $_GET['sort'] ?? 'country_AZ';

// Switch statement to determine the sort order
switch ($sort) {
    case 'country_AZ':
        $posts = get_information($dbh);
        break;
    case 'country_ZA':
        $posts = get_information($dbh);
        break;
    case 'city_AZ':
        break;
    case 'city_ZA':
        break;
    case 'rating_HL':
        break;
    case 'rating_LH':
        break;
}

// Call the database for the images and their information


// Get total pages that will be displayed
$total_pages = ceil($posts[0]['total_ratings'] / IMAGES_PER_PAGE);

// Calculate the offset for the query
$offset = ($page - 1) * IMAGES_PER_PAGE;


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
    header("");
    // set_rating($dbh, $_POST['image_id'], $_POST['new_rating']);
}
