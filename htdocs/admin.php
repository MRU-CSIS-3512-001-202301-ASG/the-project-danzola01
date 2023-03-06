<?php

session_start();

$stylesheets = [
    "style.css"
];

$page_title = "Admin Portal";

// Connect to the database
require './constants.php';
require 'database/DatabaseHelper.php';
require 'database/queryBuilder.php';

// Get the database connection
$config = require 'database/config.php';
$dbClass = new DatabaseHelper($config);
$dbh = $dbClass->getDb();

$invalid_username = "";
$invalid_password = "";

$errors = [];

// Arriving here via GET -> display the form
if ($_SERVER['REQUEST_METHOD'] === "GET") {
    require 'views/admin.view.php';
}

// Arriving here via POST -> process the form
else if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Ensure that the username is not empty
    if (strlen($_POST['username']) === 0) {
        $errors['username'] = "A username is required!";
        $invalid_username = "aria-invalid='true'";
    }

    if (empty($_POST['password']) === 0) {
        $errors['password'] = "A password is required!";
        $invalid_password = "aria-invalid='true'";
    }

    // Validate the username and password
    $username = $_POST['username'];
    $retrieved_digest = get_digest($dbh, $username);

    // If array is empty, the username does not exist
    if (!empty($retrieved_digest) && password_verify($_POST['password'], $retrieved_digest[0]['digest']) === false) {
        $errors[] = "You have entered an invalid username or password!";
    }


    // If there are no errors, redirect to the admin page, otherwise display the form again
    if (empty($errors)) {

        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $_POST['username'];
        // TODO: If the user authenticates correctly, the login status is saved using PHP session state, and the form redirects to the Browse/Filter Page.
        header("Location: browse.php");
    } else {
        require 'views/admin.view.php';
    }
}

// Arriving here via any other method -> redirect to the form
else {
    header("Location: admin.php");
}
