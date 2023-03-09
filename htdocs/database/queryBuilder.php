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

function get_information_filtered($dbh, $order, $offset, $country_filter = '%', $city_filter = '%', $rating_filter = '%', $user_id = TARGET_USER, $limit = IMAGES_PER_PAGE)
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
        AND countries.CountryName LIKE '%' :country_filter '%'
        AND cities.AsciiName LIKE '%' :city_filter '%'
        AND imagerating.Rating LIKE '%' :rating_filter '%'
    ORDER BY $order
    LIMIT :offset, :limit
    STMT;

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->bindParam(':country_filter', $country_filter);
    $stmt->bindParam(':city_filter', $city_filter);
    $stmt->bindParam(':rating_filter', $rating_filter);
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
function set_rating($dbh, $rating, $image_id, $user_id = TARGET_USER)
{
    $sql = <<<STMT
    UPDATE imagerating
    SET Rating=:rating
    WHERE ImageID=:image_id
    AND UserID=:user_id
    STMT;

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':rating', $rating);
    $stmt->bindParam(':image_id', $image_id);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
}

/**
 * Retrieves the digest (password hash) for the user
 *
 * @param PDO $dbh
 * @param string $username
 *
 * @return array $results - array of digest
 */
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
    $results = $stmt->fetchAll(PDO::FETCH_COLUMN);
    return $results;
}

/**
 * Creates a new admin user
 *
 * @param PDO $dbh
 * @param string $username - username
 * @param string $password - (unhashed)
 */
function create_admin($dbh, $username, $password)
{
    $digest = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);

    $sql = <<<STMT
        INSERT INTO admins(username, digest)
        VALUES (:user, :digest)
    STMT;

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user', $username);
    $stmt->bindParam(':digest', $digest);
    $stmt->execute();
}
