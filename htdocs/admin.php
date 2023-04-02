<?php
// Start the PHP session
session_start();

// Link to the stylesheet
$stylesheets = [
    "style.css"
];

// Set the page title
$page_title = "Admin Portal";

// Connect to the database
require './constants.php';
require '../database/DatabaseHelper.php';
require '../database/queryBuilder.php';

// Get the database connection
$config = require '../database/config.php';
$dbClass = new DatabaseHelper($config);
$dbh = $dbClass->getDb();

// Array rhat will hold any errors to be displayed
$errors = [];

// Flags that will be used for the invalid class on the form fields
$invalid_username = null;
$invalid_password = null;

// Arriving here via GET -> display the form
if ($_SERVER['REQUEST_METHOD'] === "GET") {
    require 'views/admin.view.php';
}

// Arriving here via POST -> process the form
else if ($_SERVER['REQUEST_METHOD'] === "POST") {

    // Ensure that the username is not empty
    if (strlen($_POST['username']) === 0) {
        $errors['username'] = "A username is required!";
        $invalid_username = "true";
    }

    // Ensure that the password is not empty
    if (strlen($_POST['password']) === 0) {
        $errors['password'] = "A password is required!";
        $invalid_password = "true";
    }

    // Validate the username and password
    $username = $_POST['username'];
    $retrieved_digest = get_digest($dbh, $username);

    // If the username does not exist in the DB, an empty array is returned
    if (empty($retrieved_digest)) {
        $errors['validation'] = "You have entered an invalid username or password!";
    }
    // Using password_verify() to compare the password
    else {
        if (password_verify($_POST['password'], $retrieved_digest[0]) === false) {
            $errors['validation'] = "You have entered an invalid username or password!";
            $invalid_password = "true";
            $invalid_username = "true";
        }
    }

    // If there are no errors, redirect to the browse page, otherwise display the form again
    if (empty($errors)) {
        // Set some session variables for the user
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $_POST['username'];
        // Redirect to the browse page
        header("Location: browse.php");
    } else {
        require 'views/admin.view.php';
    }
}

// Arriving here via any other method (just in case) -> redirect to the form
else {
    header("Location: admin.php");
}
