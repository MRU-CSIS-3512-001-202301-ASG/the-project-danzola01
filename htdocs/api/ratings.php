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
$imageId = $_GET['imageId'];

// Run the query
$results = get_rating_for_image_id($dbh, $imageId);

// Build the response
$response = [
    'ratings' => $results
];

// Set the header to the correct content type
header('Content-Type: application/json');

// Echo the result of calling json_encode() on the built response
echo json_encode($response);