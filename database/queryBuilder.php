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
    // This query may or may not have been heavily aided by AI
    $sql = <<<STMT
    SELECT CountryName,
        ISO,
        imagedetails.Path AS Path,
        imagedetails.ImageID AS ImageID
    FROM countries
    LEFT JOIN imagedetails ON countries.ISO = imagedetails.CountryCodeISO
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
    SELECT DISTINCT cities.AsciiName AS CityName,
        cities.Population,
        cities.Elevation,
        cities.TimeZone,
        imagedetails.Path,
        imagedetails.ImageID
    FROM cities
    LEFT JOIN imagedetails ON cities.CityCode = imagedetails.CityCode
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
        CurrencyName AS Currency,
        TopLevelDomain AS Domain,
        CountryDescription AS Description,
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

function get_languages($dbh)
{
    $sql = <<<STMT
    SELECT  name,
            iso
    FROM languages
    ORDER BY name
    STMT;

    $stmt = $dbh->prepare($sql);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

function get_rating_for_image_id($dbh, $image_id)
{
    $sql = <<<STMT
    SELECT imageid,
       COUNT(CASE WHEN rating = 1 THEN 1 ELSE NULL END) AS rating_1_count,
       COUNT(CASE WHEN rating = 2 THEN 1 ELSE NULL END) AS rating_2_count,
       COUNT(CASE WHEN rating = 3 THEN 1 ELSE NULL END) AS rating_3_count,
       COUNT(CASE WHEN rating = 4 THEN 1 ELSE NULL END) AS rating_4_count,
       COUNT(CASE WHEN rating = 5 THEN 1 ELSE NULL END) AS rating_5_count
    FROM imagerating
    WHERE ImageID = :image_id
    GROUP BY imageid
    STMT;

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':image_id', $image_id);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

function get_photo_info_from_image_id($dbh, $image_id)
{
    $sql = <<<STMT
    SELECT imagedetails.Title,
        imagedetails.Latitude,
        imagedetails.Longitude,
        userslogin.UserName,
        cities.AsciiName,
        countries.CountryName,
        imagedetails.Description
    FROM imagedetails
    LEFT JOIN cities ON imagedetails.CityCode = cities.CityCode
    LEFT JOIN countries ON imagedetails.CountryCodeISO = countries.ISO
    LEFT JOIN userslogin ON imagedetails.UserID = userslogin.UserID
    WHERE ImageID = :image_id
    STMT;

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':image_id', $image_id);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

function get_rating_info_from_image_id($dbh, $image_id)
{
    $sql = <<<STMT
    SELECT imagerating.Rating,
        users.FirstName,
        users.LastName
    FROM imagerating
    LEFT JOIN users ON imagerating.UserID = users.UserID
    WHERE imagerating.ImageID = :image_id
    ORDER BY imagerating.Rating DESC
    STMT;

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':image_id', $image_id);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}