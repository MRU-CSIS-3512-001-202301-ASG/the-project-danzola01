<?php
// Define database connection constants
$servername = "34.28.3.253";
$username = "root";
$password = "comp3512";
$dbname = "travel";

// Create connection
 $conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function insert_into_users($conn, $userID, $firstName, $lastName, $city, $region, $country, $postal, $phone, $email, $privacy)
{
    $sql = "INSERT INTO users (UserID, FirstName, LastName, City, Region, Country, Postal, Phone, Email, Privacy)
    VALUES ('$userID', '$firstName', '$lastName', '$city', '$region', '$country', '$postal', '$phone', '$email', '$privacy')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// testing the function
$userID = "123";
$firstName = "John";
$lastName = "Doe";
$city = "Toronto";
$region = "Ontario";
$country = "Canada";
$postal = "M5H 2N2";
$phone = "416-123-4567";
$email = "john@doe.com";
$privacy = "1";

insert_into_users($conn, $UserID, $FirstName, $LastName, $City, $Region, $Country, $Postal, $Phone, $Email, $Privacy);


$conn->close();
