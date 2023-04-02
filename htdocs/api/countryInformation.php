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

// Grab the query string items
$countryISO = $_GET['countryISO'] ?? null;

// Run the query
$results = get_country_information($dbh, $countryISO);

// Build the response
$response = [
    'country_information' => $results
];

// Set the header to the correct content type
header('Content-Type: application/json');

// Echo the result of calling json_encode() on the built response
echo json_encode($response);