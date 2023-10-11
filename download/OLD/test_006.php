<?php
$img = imageCreate(400, 400);
$back = imageColorAllocate($img, 0, 0, 0);
$front = imageColorAllocate($img, 255, 255, 255);

$sd = 45.5;
$ed = 130.5;

imageFilledArc($img, 200, 200, 300, 300, $sd, $ed,
    $front, IMG_ARC_PIE|IMG_ARC_NOFILL|IMG_ARC_EDGED);
imageArc($img, 200, 230, 300, 300, $sd, $ed, $front);

imageLine($img,
    cos(deg2rad($sd))*150+200, sin(deg2rad($sd))*150+200,
    cos(deg2rad($sd))*150+200, sin(deg2rad($sd))*150+230,
    $front);
imageLine($img,
    cos(deg2rad($ed))*150+200, sin(deg2rad($ed))*150+200,
    cos(deg2rad($ed))*150+200, sin(deg2rad($ed))*150+230,
    $front);

header('Content-type: image/png');
imagepng($img);
imagedestroy($img);
?>

    And this is how it should be...

<?php
$img = imageCreate(400, 400);
$back = imageColorAllocate($img, 0, 0, 0);
$front = imageColorAllocate($img, 255, 255, 255);

$sd = floor(45.5);
$ed = floor(130.5);

imageFilledArc($img, 200, 200, 300, 300, $sd, $ed,
    $front, IMG_ARC_PIE|IMG_ARC_NOFILL|IMG_ARC_EDGED);
imageArc($img, 200, 230, 300, 300, $sd, $ed, $front);

imageLine($img,
    cos(deg2rad($sd))*150+200, sin(deg2rad($sd))*150+200,
    cos(deg2rad($sd))*150+200, sin(deg2rad($sd))*150+230,
    $front);
imageLine($img,
    cos(deg2rad($ed))*150+200, sin(deg2rad($ed))*150+200,
    cos(deg2rad($ed))*150+200, sin(deg2rad($ed))*150+230,
    $front);

header('Content-type: image/png');
imagepng($img);
imagedestroy($img);
?>