<?php

/**
 * Returns an array of image IDs for a given user ID, ordered by country name
 *
 * @param PDO $dbh
 * @param int $userID
 * @param int $offset - offset for pagination
 * @param int $limit - limit for pagination
 * @return array $results - array of image IDs ordered by country name
 */
function get_imageID_from_userID_sort_country_AZ($dbh, $offset, $userID = TARGET_USER, $limit = IMAGES_PER_PAGE)
{
    $sql = <<<STMT
    SELECT imagerating.ImageID
    FROM countries
    INNER JOIN imagedetails
    ON countries.ISO = imagedetails.CountryCodeISO
    INNER JOIN imagerating
    ON imagerating.ImageID = imagedetails.ImageID
    WHERE imagerating.UserID = :id
    ORDER BY countries.CountryName
    LIMIT :offset, :limit
    STMT;

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $userID);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

/**
 * Returns an array of image IDs for a given user ID, ordered by descending country name
 *
 * @param PDO $dbh
 * @param int $userID
 * @param int $offset - offset for pagination
 * @param int $limit - limit for pagination
 * @return array $results - array of image IDs ordered by descending country name
 */
function get_imageID_from_userID_sort_country_ZA($dbh, $offset, $userID = TARGET_USER, $limit = IMAGES_PER_PAGE)
{
    $sql = <<<STMT
    SELECT imagerating.ImageID
    FROM countries
    INNER JOIN imagedetails
    ON countries.ISO = imagedetails.CountryCodeISO
    INNER JOIN imagerating
    ON imagerating.ImageID = imagedetails.ImageID
    WHERE imagerating.UserID = :id
    ORDER BY countries.CountryName DESC
    LIMIT :offset, :limit;
    STMT;

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $userID);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

/**
 * Returns an array of image IDs for a given user ID, ordered by city name
 *
 * @param PDO $dbh
 * @param int $userID
 * @param int $offset - offset for pagination
 * @param int $limit - limit for pagination
 * @return array $results - array of image IDs ordered by city name
 */
function get_imageID_from_userID_sort_city_AZ($dbh, $offset, $userID = TARGET_USER, $limit = IMAGES_PER_PAGE)
{
    $sql = <<<STMT
    SELECT imagerating.ImageID
    FROM cities
    INNER JOIN imagedetails
    ON cities.CityCode = imagedetails.CityCode
    INNER JOIN imagerating
    ON imagerating.ImageID = imagedetails.ImageID
    WHERE imagerating.UserID = :id
    ORDER BY cities.AsciiName
    LIMIT :offset, :limit
    STMT;

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $userID);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}
// TODO - NOT WORKING
/**
 * Returns an array of image IDs for a given user ID, ordered by descending city name
 *
 * @param PDO $dbh
 * @param int $userID
 * @param int $offset - offset for pagination
 * @param int $limit - limit for pagination
 * @return array $results - array of image IDs ordered by descending city name
 */
function get_imageID_from_userID_sort_city_ZA($dbh, $offset, $userID = TARGET_USER, $limit = IMAGES_PER_PAGE)
{
    $sql = <<<STMT
    SELECT imagerating.ImageID
    FROM cities
    INNER JOIN imagedetails
    ON cities.CityCode = imagedetails.CityCode
    INNER JOIN imagerating
    ON imagerating.ImageID = imagedetails.ImageID
    WHERE imagerating.UserID = :id
    ORDER BY cities.AsciiName DESC
    LIMIT :offset, :limit
    STMT;

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $userID);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

// TODO - NOT WORKING
/**
 * Returns an array of image IDs for a given user ID, ordered by rating 5-->1
 *
 * @param PDO $dbh
 * @param int $userID
 * @param int $offset - offset for pagination
 * @param int $limit - limit for pagination
 * @return array $results - array of image IDs ordered by rating 5-->1
 */
function get_imageID_from_userID_sort_rating_HL($dbh, $offset, $userID = TARGET_USER, $limit = IMAGES_PER_PAGE)
{
    $sql = <<<STMT
    SELECT imagerating.ImageID
    FROM imagerating
    WHERE imagerating.UserID = :id
    ORDER BY imagerating.Rating DESC
    LIMIT :offset, :limit
    STMT;

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $userID);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll();
    return $results;
}

/**
 * Returns an array of image IDs for a given user ID, ordered by rating 1-->5
 *
 * @param PDO $dbh
 * @param int $userID
 * @param int $offset - offset for pagination
 * @param int $limit - limit for pagination
 * @return array $results - array of image IDs ordered by rating 1-->5
 */
function get_imageID_from_userID_sort_rating_LH($dbh, $offset, $userID = TARGET_USER, $limit = IMAGES_PER_PAGE)
{
    $sql = <<<STMT
    SELECT imagerating.ImageID
    FROM imagerating
    WHERE imagerating.UserID = :id
    ORDER BY imagerating.Rating
    LIMIT :offset, :limit
    STMT;

    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $userID);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

/**
 * Returns the link to the image on Cloudinary
 *
 * @param string $path - filename of image
 * @return string link to image on Cloudinary
 */
function cloudinary_src($path)
{
    return "https://res.cloudinary.com/dqg3qyjio/image/upload/t_browse/v1674841639/3512-2023-01-project-images/{$path}";
}

/**
 * Returns all of the information for the current page
 *
 * @param PDO $dbh
 * @param int $user_id - user ID (default = TARGET_USER)
 * @param int $offset - offset for pagination
 * @param int $limit - limit for pagination
 * @return array $results - array of image information
 */
function get_information($dbh, $user_id = TARGET_USER, $offset = 0, $limit = IMAGES_PER_PAGE)
{
    $sql = <<<STMT
    SELECT imagedetails.Path,
           cities.AsciiName AS CityName,
           countries.CountryName,
           imagedetails.Longitude,
           imagedetails.Latitude,
           imagerating.Rating,
           (SELECT COUNT(*)
           FROM imagerating
           WHERE UserID = 23) AS total_ratings
    FROM imagedetails
    INNER JOIN cities ON cities.CityCode = imagedetails.CityCode
    INNER JOIN countries ON countries.ISO = imagedetails.CountryCodeISO
    LEFT JOIN imagerating ON imagerating.ImageID = imagedetails.ImageID
    WHERE imagerating.UserID = :user_id
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
