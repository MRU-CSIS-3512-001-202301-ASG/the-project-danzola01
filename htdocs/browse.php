<?php

session_start();

$stylesheets = [
    "style.css"
];

$page_title = "Browse/Filter";

require 'temp.data.php';

// If the user is not logged in, redirect to the login page
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: admin.php");
}

// If the user is logged in, displat the browse page
else {
    require 'helpers.php';
    require 'views/browse.view.php';
}