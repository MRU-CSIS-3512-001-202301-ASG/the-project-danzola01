<?php

/**
 * Returns an array of image IDs for a given user ID
 * 
 * @param PDO $dbh
 * @param int $userID
 * @param int $offset - offset for pagination
 * @param int $limit - limit for pagination
 * @return array $results - array of image IDs
 */
function get_imageID_from_userID($dbh, $offset, $userID = TARGET_USER, $limit = IMAGES_PER_PAGE)
{
    $sql = <<<STMT
    SELECT ImageID 
    FROM imagerating 
    WHERE UserID = :id 
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
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    return "https://res.cloudinary.com/dqg3qyjio/image/upload/v1674841639/3512-2023-01-project-images/{$path}";
}

/**
 * Gets the image from the database and returns the link to the image on Cloudinary
 * 
 * @param PDO $dbh
 * @param int $image_id
 * @return string link to image on Cloudinary
 */
function get_image($dbh, $image_id)
{
    $sql = "SELECT imagedetails.Path FROM imagedetails WHERE ImageID = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $image_id);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return cloudinary_src($results[0]['Path']);
}

/**
 * Gets the city of the image from the database
 * 
 * @param PDO $dbh
 * @param int $image_id
 * @return string Name of city
 */
function get_city($dbh, $image_id)
{
    $sql = "SELECT cities.AsciiName FROM cities INNER JOIN imagedetails ON cities.CityCode = imagedetails.CityCode WHERE imagedetails.ImageID = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $image_id);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results[0]['AsciiName'];
}

/**
 * Gets the country of the image from the database
 * 
 * @param PDO $dbh
 * @param int $image_id
 * @return string Name of country
 */
function get_country($dbh, $image_id)
{
    $sql = "SELECT countries.CountryName FROM countries INNER JOIN imagedetails ON countries.ISO = imagedetails.CountryCodeISO WHERE imagedetails.ImageID = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $image_id);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results[0]['CountryName'];
}

/**
 * Gets the longitude of the image from the database
 * 
 * @param PDO $dbh
 * @param int $image_id
 * @return string Longitude of image
 */
function get_longitute($dbh, $image_id)
{
    $sql = "SELECT Longitude FROM imagedetails WHERE ImageID = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $image_id);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results[0]['Longitude'];
}

/**
 * Gets the latitude of the image from the database
 * 
 * @param PDO $dbh
 * @param int $image_id
 * @return string Latitude of image
 */
function get_latitude($dbh, $image_id)
{
    $sql = "SELECT Latitude FROM imagedetails WHERE ImageID = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $image_id);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results[0]['Latitude'];
}

/**
 * Gets the rating of the image from the database
 * 
 * @param PDO $dbh
 * @param int $image_id
 * @return string Rating of image
 */
function get_rating($dbh, $image_id)
{
    $sql = "SELECT Rating FROM imagerating WHERE ImageID = :id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':id', $image_id);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results[0]['Rating'];
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
    $sql = "UPDATE imagerating SET Rating=:rating WHERE ImageID=:image_id AND UserID=:user_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':image_id', $image_id);
    $stmt->bindParam(':rating', $rating);
    $stmt->bindParam(':user_id', $target);
    $stmt->execute();
}

/**
 * Gets the number of images in the database
 * 
 * @param PDO $dbh
 * @return int number of images
 */
function get_image_count($dbh, $target = TARGET_USER)
{
    $sql = "SELECT COUNT(*) FROM imagerating WHERE UserID= :user_id";
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':user_id', $target);
    $stmt->execute();
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $results[0]['COUNT(*)'];
}
