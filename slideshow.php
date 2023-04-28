<?php

$directory = 'photos'; // Path to the main directory containing all the photos

// Recursive function to find all photos in a given directory
function findPhotos($directory)
{
    $result = array(); // Initialize an empty array to hold the paths of all photos

    // Get a list of all files and directories in the current directory
    $files = scandir($directory);

    // Loop through all files and directories
    foreach ($files as $file) {
        // Ignore . and .. directories
        if ($file == '.' || $file == '..') {
            continue;
        }

        // If the file is a directory, call this function recursively on it
        if (is_dir($directory . '/' . $file)) {
            $result = array_merge($result, findPhotos($directory . '/' . $file));
        }
        // If the file is a photo, add its path to the result array
        else if (is_file($directory . '/' . $file) && preg_match('/\.(jpg|jpeg|png|gif)$/', $file)) {
            $result[] = $directory . '/' . $file;
        }
    }

    return $result;
}

// Call the findPhotos function on the main directory and get the result
$photos = findPhotos($directory);

// Output the result as JSON
echo json_encode($photos);
