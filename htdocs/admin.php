<?php

session_start();

$stylesheets = [
    // "style.css"
];

$page_title = "Login Page";

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

    // TODO: Currently using hard-coded values for username and password.
    if ($_POST['username'] !== "root" || $_POST['password'] !== "root") {
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