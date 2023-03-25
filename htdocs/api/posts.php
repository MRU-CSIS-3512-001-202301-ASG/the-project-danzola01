<?php
/*The flow of each of these files follows the same pattern:
    - do any necessary requires
    - grab any necessary query string items
    - run a database query
    - build the response needed using the results of the query
    - set the header to the correct content type
    - echo the result of calling json_encode() on the built response
*/

// Connect to the database
require '../constants.php';
require '../../database/DatabaseHelper.php';
require '../../database/queryBuilder.php';

// Get the database connection
$config = require '../../database/config.php';
$dbClass = new DatabaseHelper($config);
$dbh = $dbClass->getDb();

// Get the query string items
$country = $_GET['country'] ?? "";
$iso = $_GET['iso'] ?? "";

if (isset($_GET['iso'])) {
    // Call the DB for the city names
    $results = get_cities_from_country($dbh, $iso);

    // Build the response
    $response = [
        'cities' => $results
    ];
} else {
    // Call the DB for the posts
    $results = get_country_list($dbh, $country);

    // Build the response
    $response = [
        'countries' => $results
    ];
}

// Set the header to the correct content type
header('Content-Type: application/json');

// Echo the result of calling json_encode() on the built response
echo json_encode($response);