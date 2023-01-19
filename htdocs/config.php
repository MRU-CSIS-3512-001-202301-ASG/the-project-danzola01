<?php
// Define database connection constants
$servername = "34.68.130.132";
$username = "root";
$password = "comp3512";
$dbname = "travel";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully";
}