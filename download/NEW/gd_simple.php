<?php

// Создайте изображение указанных размеров
$image = imageCreate(300,200);

// Создайте цвет (этот первый вызов imageColorAllocate
// также автоматически устанавливает цвет фона изображения)
$colorRed = imageColorAllocate($image, 255,0,0);

// Создайте другой цвет
$colorYellow = imageColorAllocate($image, 255,255,0);

// Нарисуйте прямоугольник
imageFilledRectangle($image, 50, 50, 250, 150, $colorYellow);

// Установите тип изображения и отправьте вывод.
header("Content-type: image/jpeg");
imageJpeg($image);

// Освободите память
imageDestroy($image);

?>


