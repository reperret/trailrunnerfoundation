<?php

// Get reference to uploaded image
$image_file = $_FILES["image"];

// Exit if no file uploaded
if (!isset($image_file)) {
    die('No file uploaded.');
}

// Exit if image file is zero bytes
if (filesize($image_file["tmp_name"]) <= 0) {
    die('Uploaded file has no contents.');
}

// Exit if is not a valid image file
$image_type = exif_imagetype($image_file["tmp_name"]);
if (!$image_type) {
    die('Uploaded file is not an image.');
}

// Get file extension based on file type, to prepend a dot we pass true as the second parameter
$image_extension = image_type_to_extension($image_type, true);

// Create a unique image name
$image_name = bin2hex(random_bytes(16)) . $image_extension;

// Move the temp image file to the images directory
$test=move_uploaded_file($image_file["tmp_name"], __DIR__ . "/images/" . $image_name);

echo "OK?";
echo $test;

?>
