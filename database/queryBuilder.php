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
    $stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
    $stmt->bindParam(':image_id', $image_id, PDO::PARAM_INT);
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

/**
 * Used for the ddrop endpoint, it has no query parameters and will output
 * the city, country, and lat/long values of all currently active dead drops.
 *
 * @param PDO $dbh
 *
 * @return array $results - array of dead drops
 */
function get_drops($dbh, $user_id = TARGET_USER)
{
    $sql = <<<STMT
    SELECT cities.AsciiName AS city,
           countries.CountryName AS country,
           imagedetails.Longitude AS "long",
           imagedetails.Latitude AS "lat"
    FROM imagedetails
    INNER JOIN cities ON cities.CityCode = imagedetails.CityCode
    INNER JOIN countries ON countries.ISO = imagedetails.CountryCodeISO
    LEFT JOIN imagerating ON imagerating.ImageID = imagedetails.ImageID
    WHERE imagerating.UserID = :user_id
        AND imagerating.Rating = 3
    STMT;

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

/**
 * Used for the ddrop.php?city={city_id} endpoint, it has city as a query parameter and
 * will output the city, country, and lat/long values of all currently active dead drops
 * that match the city.
 *
 * @param PDO $dbh
 * @param string $city_id
 *
 * @return array $results - array of city, country, long, lat
 */
function get_drops_in_city($dbh, $city_id, $user_id = TARGET_USER)
{
    $sql = <<<STMT
    SELECT cities.AsciiName AS city,
           countries.CountryName AS country,
           imagedetails.Longitude AS "long",
           imagedetails.Latitude AS "lat"
    FROM imagedetails
    INNER JOIN cities ON cities.CityCode = imagedetails.CityCode
    INNER JOIN countries ON countries.ISO = imagedetails.CountryCodeISO
    LEFT JOIN imagerating ON imagerating.ImageID = imagedetails.ImageID
    WHERE imagerating.UserID = :user_id
        AND imagerating.Rating = 3
        AND cities.CityCode = :city_id
    STMT;

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':city_id', $city_id);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}
/**
 * TODO
 *
 * @param PDO $dbh
 * @param string $city_id
 *
 * @return array $results - array of countries with their ISO codes
 */
function get_country_list($dbh)
{
    $sql = <<<STMT
    SELECT DISTINCT CountryName,
        ISO
    FROM countries
    ORDER BY CountryName
    STMT;

    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

// TODO
function get_cities_from_country($dbh, $iso = '%')
{
    $sql = <<<STMT
    SELECT DISTINCT cities.AsciiName AS CityName
    FROM cities
    WHERE cities.CountryCodeISO = :iso
    ORDER BY cities.AsciiName
    STMT;

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':iso', $iso);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

function get_country_information($dbh, $iso)
{
    $sql = <<<STMT
    SELECT CountryName,
        Area,
        Population,
        Capital,
        CurrencyName,
        TopLevelDomain,
        CountryDescription,
        Languages,
        Neighbours
    FROM countries
    WHERE ISO = :iso
    STMT;

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':iso', $iso);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}