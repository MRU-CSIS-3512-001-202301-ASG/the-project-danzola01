<?php

session_start();

$stylesheets = [
    "style.css"
];

$page_title = "Browse/Filter";

require 'database/db_handler.php';

// If the user is not logged in, redirect to the login page
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: admin.php");
}

// If the user is logged in, display the browse page
else {
    require 'helpers.php';
    require 'views/browse.view.php';
}

// receive the new rating from the form and update the value in the $post array
if (isset($_POST['new_rating'])) {
    $post['rating'] = $_POST['new_rating'];
}