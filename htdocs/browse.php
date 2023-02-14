<?php

session_start();

$stylesheets = [
    "style.css"
];

$page_title = "Browse/Filter";

// Require helper for cloudinary
require './helpers/helpers.php';

// Connect to the database
require './constants.php';
require 'database/DatabaseHelper.php';
require 'database/queryBuilder.php';

// Get the database connection
$config = require 'database/config.php';
$dbClass = new DatabaseHelper($config);
$dbh = $dbClass->getDb();

// Get the sort order
$sort = $_GET['sort'] ?? 'country_AZ';

// Switch statement to determine the sort order
switch ($sort) {
    case 'country_AZ':
        $sort = 'countries.CountryName';
        break;
    case 'country_ZA':
        $sort = 'countries.CountryName DESC';
        break;
    case 'city_AZ':
        $sort = 3;
        break;
    case 'city_ZA':
        $sort = 3 . ' DESC';
        break;
    case 'rating_HL':
        $sort = 7 . ' DESC';
        break;
    case 'rating_LH':
        $sort = 7;
        break;
}

// Get current page number
$current_page = $_GET['page'] ?? 1;

// Calculate the offset for the query
$offset = ($current_page - 1) * IMAGES_PER_PAGE;

// Call the database for the images and their information

$posts = get_information($dbh, $sort, $offset);


// Get total pages that will be displayed
$total_pages = ceil($posts[0]['total_ratings'] / IMAGES_PER_PAGE);

// If the user is not logged in, redirect to the login page
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: admin.php");
}

// If the user is logged in, display the browse page
else {
    require 'views/browse.view.php';
}
