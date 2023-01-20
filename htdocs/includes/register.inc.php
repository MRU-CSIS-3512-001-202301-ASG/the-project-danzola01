<?php

// Ensure that the files is being properly accessed
if (isset($_POST['submit'])) {

    // Grabbing the data from the form
    $FirstName = $_POST['first'];
    $LastName = $_POST['last'];
    $Address = $_POST['address'];
    $City = $_POST['city'];
    $Region = $_POST['region'];
    $Country = $_POST['country'];
    $Postal = $_POST['postal'];
    $Phone = $_POST['phone'];
    $Email = $_POST['email'];
    $Password = $_POST['password'];
    $PasswordRepeat = $_POST['password-repeat'];

    // Instantiate SignupContr class
    include '../classes/dbh.classes.php';
    include '../classes/register.classes.php';
    include '../classes/register-contr.classes.php';
    $signup = new RegisterController($FirstName, $LastName, $Address, $City, $Region, $Country, $Postal, $Phone, $Email, $Password, $PasswordRepeat);


    // Running error handlers and user registration
    $signup->registerUser();

    // Redirecting to the home page
    header("location: ../index.php?error=none");
}