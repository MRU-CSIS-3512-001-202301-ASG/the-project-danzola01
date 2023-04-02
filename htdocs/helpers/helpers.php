<?php

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
