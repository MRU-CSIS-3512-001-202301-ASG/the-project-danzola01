<?php

// This project will only focus on posts made by the user with ID 23
$target_user = 23;

function connect()
{
    $servername = "34.68.130.132";
    $username = "root";
    $password = "comp3512";
    $dbname = "travel";

    try {
        $dbh = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        return $dbh;
    } catch (PDOException $e) {
        print "Connection failed: " . $e->getMessage() . "<br/>";
        die();
    }
}

function get_imageID_from_userID($dbh, $userID)
{
    // $dbh = connect();
    $sql = "SELECT ImageID FROM imagedetails where UserID = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $userID);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

function cloudinary_src($path)
{
    return "https://res.cloudinary.com/dqg3qyjio/image/upload/v1674841639/3512-2023-01-project-images/{$path}";
}

function get_image($dbh, $image_id)
{
    $sql = "SELECT Path FROM imagedetails WHERE ImageID = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $image_id);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return cloudinary_src($results[0]['Path']);
}

function get_city($dbh, $image_id)
{
    $sql = "SELECT cities.AsciiName FROM cities INNER JOIN imagedetails ON cities.CityCode = imagedetails.CityCode WHERE imagedetails.ImageID = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $image_id);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results[0]['AsciiName'];
}

function get_country($dbh, $image_id)
{
    $sql = "SELECT countries.CountryName FROM countries INNER JOIN imagedetails on countries.ISO = imagedetails.CountryCodeISO where imagedetails.ImageID = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $image_id);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results[0]['CountryName'];
}

function get_longitute($dbh, $image_id)
{
    $sql = "SELECT Longitude FROM imagedetails where ImageID = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $image_id);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results[0]['Longitude'];
}

function get_latitude($dbh, $image_id)
{
    $sql = "SELECT Latitude FROM imagedetails where ImageID = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $image_id);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results[0]['Latitude'];
}

function get_rating($dbh, $image_id)
{
    $sql = "SELECT Rating FROM imagerating where ImageID = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $image_id);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results[0]['Rating'];
}

$dbh = connect();

$image_ids = get_imageID_from_userID($dbh, $target_user);

$posts = [];

foreach ($image_ids as $image_id) {
    $posts[] = [
        'image' => get_image($dbh, $image_id['ImageID']),
        'city' => get_city($dbh, $image_id['ImageID']),
        'country' => get_country($dbh, $image_id['ImageID']),
        'latitude' => get_longitute($dbh, $image_id['ImageID']),
        'longitude' => get_latitude($dbh, $image_id['ImageID']),
        'rating' => get_rating($dbh, $image_id['ImageID']),
    ];
}