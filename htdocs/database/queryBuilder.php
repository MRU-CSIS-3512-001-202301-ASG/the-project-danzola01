<?php

/**
 * Returns all of the information for the current page
 *
 * @param PDO $dbh
 * @param int $user_id - user ID (default = TARGET_USER)
 * @param int $offset - offset for pagination
 * @param int $limit - limit for pagination
 * @return array $results - array of image information
 */
function get_information($dbh, $order, $offset, $user_id = TARGET_USER, $limit = IMAGES_PER_PAGE)
{
    $sql = <<<STMT
    SELECT imagerating.ImageID,
           imagedetails.Path,
           cities.AsciiName AS CityName,
           countries.CountryName,
           imagedetails.Longitude,
           imagedetails.Latitude,
           imagerating.Rating,
           (SELECT COUNT(*)
           FROM imagerating
           WHERE UserID = :user_id) AS total_ratings
    FROM imagedetails
    INNER JOIN cities ON cities.CityCode = imagedetails.CityCode
    INNER JOIN countries ON countries.ISO = imagedetails.CountryCodeISO
    LEFT JOIN imagerating ON imagerating.ImageID = imagedetails.ImageID
    WHERE imagerating.UserID = :user_id
    ORDER BY $order
    LIMIT :offset, :limit
    STMT;

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

/**
 * Changes the rating of the image on the database
 *
 * @param PDO $dbh
 * @param int $image_id
 * @param int $rating - new rating
 * @param int $target - user ID
 */
function set_rating($dbh, $image_id, $rating, $target = TARGET_USER)
{
    $sql = <<<STMT
    UPDATE imagerating
    SET Rating=:rating
    WHERE ImageID=:image_id
    AND UserID=:user_id
    STMT;

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':image_id', $image_id);
    $stmt->bindParam(':rating', $rating);
    $stmt->bindParam(':user_id', $target);
    $stmt->execute();
}

function get_digest($dbh, $username)
{
    $sql = <<<STMT
    SELECT digest
    FROM admins
    WHERE username=:username
    STMT;

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}
