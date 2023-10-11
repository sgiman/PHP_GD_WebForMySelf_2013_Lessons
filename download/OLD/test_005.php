<?php

// width and height of the image
$width=200;
$height=200;

$simulate_old_gd=true; // do not use imagefilledarc although available?

// the pieces of the pie (in degree)
$pieces=array(180,90,45,25,15,5);

$diagram=imagecreate($width,$height);

// background color
$white=imagecolorallocate($diagram, 255, 255, 255);
imagefilledrectangle($diagram,0,0,$width,$height,$white);

// the circle is 2px smaller than the image
$width-=2;
$height-=2;

// we need a border color
$black=imagecolorallocate($diagram, 0, 0, 0);

// draw the border of the pie
imagearc($diagram, round($width/2), round($height/2),
    $width, $height, 0, 360, $black);

// position (in degrees) where to place the next piece
$position=270;
// we will use calculated gray colors for simple example
$gray=0;

foreach($pieces as $deg)
{
    // calculate the gray color
    $gray+=30;
    if($gray>255) $gray=0;
    $color=imagecolorallocate($diagram,$gray,$gray,$gray);

    // position must be kept < 360
    if($position>360) $position-=360;

    if(!$simulate_old_gd && is_callable('imagefilledarc'))
    {
        imagefilledarc($diagram, round($width/2),
            round($height/2), $width, $height, $position,
            $position+$deg, $color,IMG_ARC_EDGED);
    }
    else
    {
        // we use some maths to calculate the pixel on the circle
        $pix_x=round(floor(($width-2)/2)*cos($position/180*M_PI)
            +round($width/2));
        $pix_y=round(floor(($height-2)/2)*sin($position/180*M_PI)
            +round($height/2));
        // now we  draw a line from the mid of the circle to the
        // calculated pixel on the circle
        imageline($diagram, round($width/2), round($height/2),
            $pix_x, $pix_y, $black);
        // now we need a pixel for flood filling.
        //- We could use maths to calculate a pixel inside the
        // piece:
        //$fill_x=round(floor(($width-10)/2)*
        //        cos(($position+2)/180*M_PI)+round($width/2));
        //$fill_y=round(floor(($height-10)/2)*
        //        sin(($position+2)/180*M_PI)+round($height/2));
        //- or we could use an universal pixel with less maths ;)
        // (top mid):
        $fill_x=floor($width/2)-2;
        $fill_y=3;
        // now we flood fill the circle
        @imagefilltoborder ($diagram,$fill_x,$fill_y,$black,$color);
        /* (it does not matter here that we fill more than we need
            because the next pieces will fix this)
           IF YOU ONLY WANT ONE PIECE
           (simulate imagefilledarc) you'd have to draw
           both border lines and flood fill afterwards */
    }
    // the position of the next piece is $deg degrees further
    $position+=$deg;
}

// output the image
header('Content-type: image/png');
imagepng($diagram);
imagedestroy($digram);
?>

