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

if (isset($_GET['city'])) {

    // Gather the query string parameters
    $city = $_GET['city'];

    // Run the query
    $results = get_drops_in_city($dbh, $city);

    // Build the response
    $response = [
        'num_drops' => count($results),
    ];

    // Set the header to the correct content type
    header('Content-Type: application/json');

    // Echo the result of calling json_encode() on the built response
    echo json_encode($response);
} else {
    // Call the DB for the drops
    $results = get_drops($dbh);

    // Build the response
    $response = [
        'total_count' => count($results),
        'drops' => $results
    ];

    // Set the header to the correct content type
    header('Content-Type: application/json');

    // Echo the result of calling json_encode() on the built response
    echo json_encode($response);
}
