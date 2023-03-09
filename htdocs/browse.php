<?php
// Start the PHP session
session_start();

// Link to the stylesheet
$stylesheets = [
    "style.css"
];

// Set the page title
$page_title = "Browse/Filter";

// If the user is not logged in, redirect to the login page
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: admin.php");
}

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

// If the user has selected a sort order, set a cookie
if (isset($_GET['sort'])) {
    setcookie('sort', $_GET['sort'], strtotime('+1day'));
    $sort = $_GET['sort'];
}
// If the user has not selected a sort order, but there is a cookie, use the cookie
else if (isset($_COOKIE['sort'])) {
    $sort = $_COOKIE['sort'];
}

// Switch statement to determine the sort order
switch ($sort) {
    case 'country_AZ':
        $sort = 'countries.CountryName';
        break;
    case 'country_ZA':
        $sort = 'countries.CountryName DESC';
        break;
    case 'city_AZ':
        $sort = 'cities.AsciiName';
        break;
    case 'city_ZA':
        $sort = 'cities.AsciiName DESC';
        break;
    case 'rating_HL':
        $sort = 'imagerating.Rating DESC';
        break;
    case 'rating_LH':
        $sort = 'ratings.Rating';
        break;
}

// Get current page number
$current_page = $_GET['page'] ?? 1;

// Calculate the offset for the query
$offset = ($current_page - 1) * IMAGES_PER_PAGE;

// Call the database for the images and their information
$posts = get_information($dbh, $sort, $offset);

if (isset($_GET['search_country']) || isset($_GET['search_city']) || isset($_GET['search_rating'])) {
    $search_country = $_GET['search_country'] ?? "";
    $search_city = $_GET['search_city'] ?? "";
    $search_rating = $_GET['search_rating'] ?? "";
    $posts = get_information_filtered($dbh, $sort, $offset, $search_country, $search_city, $search_rating);
}


// Get total pages that will be displayed
if (empty($posts)) {
    $total_pages = 1;
} else {
    $total_pages = ceil($posts[0]['total_ratings'] / IMAGES_PER_PAGE);
}

// If the user is logged in, display the browse page
require 'views/browse.view.php';