<?php

session_start();

$stylesheets = [
    // "style.css"
];

$page_title = "Browse/Filter";

// If the user is not logged in, redirect to the login page
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: admin.php");
}

// If the user is logged in, displat the browse page
else {
    require 'views/browse.view.php';
}