<?php
$image_width = 400;
$image_height = 400;
$image = imageCreate($image_width, $image_height);
//Lets create some colors
$bg_color = ImageColorAllocate($image, 255, 255, 255);
$color1 = ImageColorAllocate($image, 154,185,153);
$color2 = ImageColorAllocate($image,252,206,170);
$color3 = ImageColorAllocate($image,244,131,125);
$color4 = ImageColorAllocate($image,235, 73,96);
$color5 = ImageColorAllocate($image,39,54,59);
ImageFilledArc($image, 200, 200, 200, 200, 0, 120, $color1, IMG_ARC_PIE);
ImageFilledArc($image, 200, 200, 200, 200, 120, 140, $color2, IMG_ARC_PIE);
ImageFilledArc($image, 200, 200, 200, 200, 140, 180, $color3, IMG_ARC_PIE);
ImageFilledArc($image, 200, 200, 200, 200, 180, 225, $color4, IMG_ARC_PIE);
ImageFilledArc($image, 200, 200, 200, 200, 225, 360, $color5, IMG_ARC_PIE);
ob_clean();
header ("Content-type: image/png");
ImagePng($image);
ImageDestroy($image);
?>