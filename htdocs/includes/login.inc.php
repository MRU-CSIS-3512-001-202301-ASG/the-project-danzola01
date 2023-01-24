<?php

// Ensure that the files is being properly accessed
if (isset($_POST['submit'])) {

    // Grabbing the data from the form
    $Email = $_POST['email'];
    $Password = $_POST['password'];

    // Instantiate SignupContr class
    include '../classes/dbh.classes.php';
    include '../classes/login.classes.php';
    include '../classes/login-contr.classes.php';
    $login = new LoginContr($Email, $Password);


    // Running error handlers and user registration
    $login->loginUser();

    // Redirecting to the home page
    header("location: ../index.php?error=none");
}