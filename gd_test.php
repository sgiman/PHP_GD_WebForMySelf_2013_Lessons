<?php
/********************************************************
 * PHP8: GD2 LIBRARY
 * Основы работы с библиотекой GD - WebForMySelf (2013)
 * https://youtu.be/QhazdpLg8zQ?si=AQv5vUtnH-b9F5i3
 ********************************************************
 * Writing by sgiman @ 2023-10
 */

//--- NEW IMAGE (CANVAS) ---
$image_width = 300;
$image_height = 300;
$img = imageCreate($image_width, $image_height);

//--- LOAD IMAGE (JPG) ---
$im1 = imagecreatefromjpeg('ironrod.jpg');
$width = imagesx($im1);
$height = imagesy($im1);

//--- ЦВЕТ ---
$bg_color = ImageColorAllocate($img, 55, 55, 255);
$black = ImageColorAllocate($img, 0, 0, 0);
$white = ImageColorAllocate($img, 255, 255, 255);
$red = ImageColorAllocate($img, 255, 0, 0);
$green = ImageColorAllocate($img, 0, 255, 0);
$blue = ImageColorAllocate($img, 0, 0, 255);
$yellow = ImageColorAllocate($img, 255, 255, 0);

//--- ГЕОМЕТРИЯ ---
//$cenX = $image_width/2;
//$cenY = $image_height/2;
//imagefilledrectangle($img,50,50,350,350,$red);
//imagefilledellipse($img,$cenX,$cenY, $cenX,$cenY, $yellow);
//imagearc($img,$cenX,$cenY,100, 100, 0,180,$black);

imagefilledrectangle($img,0,0, 300,300, $blue);
imagearc($img, 150,150, 300,300, 0,360, $white);
imagearc($img, 100,100, 50,50, 0,360, $white);
imagearc($img, 200,100, 50,50, 0,360, $white);
imagearc($img, 150,200, 150,100, 25,155, $white);

//--- Символы ---
$string = "World";
//imagechar($img, 5, 150, 200, $string, $white); // hor
//imagecharup($img, 5, 150, 200, $string, $white);   // vert

//--- Индексы цвета ---
//var_dump($white);   // index 2
//var_dump($red);     // index 3
//var_dump(imagecolorat($img,20,10));   // color index 5
//$in = imagecolorat($img,20,10);
//print_r(imagecolorsforindex($img,$in));   // получить индекс цвета
//exit();

//--- Искривляющая матрица ---
//$arr = array(array(1,2,1),array(-1,1,1),array(0,0,-1));
//imageconvolution($img, $arr, 5, 200);

//--- Наложенине (копирование) изображений ---
imagecopy($img, $im1, 100,200, 180,0, 150,150);   // копирование
//imagecopymerge($img, $im1, 100,200, 180,0, 150,150, 50);   // наложенние (с прозрачностью)
//imagecopymergegray($img, $im1, 100,200, 180,0, 150,150, 50); // BW - черно-белое

//--- SIZE (merge) ---
// Cкопировать с измененением размера
imagecopyresampled($img, $im1, 10,10, 0,0, 210,150, $width,$height);
//imagecopyresampled($img, $im1, 10,10, 0,0, 210,150, 200,200);

//--- ЛИНИЯ ---
//imageline($img, 80,80, 180,180, $black);

//--- МНОГОУГОЛЬНИК ---
$points = array(
    40,50,
    20,240,
    60,60,
    240,20,
    50,40,
    10,10
);
imagefilledpolygon($img, $points, 6, $white);

//--- TEXT ---
$font = "fonts/georgia.ttf";
imagettftext($img, 30,0, 150,195, $white, $font, "TEXT!!!");

/* ... */

header ("Content-type: image/png");
ImagePng($img);
ImageDestroy($img);
