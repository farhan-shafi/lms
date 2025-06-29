<?php
// Create a default user avatar image
$width = 200;
$height = 200;
$image = imagecreatetruecolor($width, $height);

// Set background color (light blue)
$bg_color = imagecolorallocate($image, 100, 150, 235);
imagefill($image, 0, 0, $bg_color);

// Set text color (white)
$text_color = imagecolorallocate($image, 255, 255, 255);

// Draw a circle for the avatar
$circle_color = imagecolorallocate($image, 80, 120, 200);
imagefilledellipse($image, $width/2, $height/2, $width-40, $height-40, $circle_color);

// Draw the user silhouette
$head_color = imagecolorallocate($image, 255, 255, 255);
imagefilledellipse($image, $width/2, $height/2 - 15, 60, 60, $head_color);
imagefilledrectangle($image, $width/2 - 40, $height/2 + 20, $width/2 + 40, $height/2 + 80, $head_color);

// Output the image as PNG
header('Content-Type: image/png');
imagepng($image, __DIR__ . '/default.png');
imagedestroy($image);

echo "Default avatar created successfully.";
?>
