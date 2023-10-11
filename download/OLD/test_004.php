<?php

function myimagefilledarc($image, $cx, $cy, $width, $height, $start, $end, $color, $style = IMG_ARC_PIE){

    $delta = 0.1;
    $twoPi = 2*pi();

    $w = $width/2;
    $h = $height/2;

    if($h<=$w){
        $kx=$w;
        $ky=$w*$h/$w;
    }else{
        $kx=$h*$w/$h;
        $ky=$h;
    }

    $StartRad = deg2rad($start);
    $EndRad   = deg2rad($end);

    $array_points[] = $cx;
    $array_points[] = $cy;

    $a = $StartRad;

    if($style==IMG_ARC_PIE
     or $style==IMG_ARC_EDGED
     or $style==(IMG_ARC_PIE|IMG_ARC_NOFILL)
     or $style==(IMG_ARC_EDGED|IMG_ARC_NOFILL)){

        if($StartRad>=$EndRad){

            $b[] = $twoPi;
            $b[] = $EndRad;

        }else $b[] = $EndRad;

    }else $b[] = 0;

    foreach($b as $vb){
        do {
            $array_points[] = $cx + $kx*cos($a);
            $array_points[] = $cy + $ky*sin($a);
            $a += $delta;
        } while ($a<$vb);
        $a = 0;
    }

    $array_points[] = $cx + $kx*cos($EndRad);
    $array_points[] = $cy + $ky*sin($EndRad);

    $count_array_points    = count($array_points);
    $num_points = $count_array_points/2;

    if($style==IMG_ARC_PIE or $style==IMG_ARC_EDGED or $style==IMG_ARC_CHORD){
        imagefilledpolygon($image, $array_points, $num_points, $color);
    }elseif($style==(IMG_ARC_PIE|IMG_ARC_NOFILL)){

        $i = 1;
        $c = $count_array_points - 1;

        $x1 = $array_points[++$i];
        $y1 = $array_points[++$i];

        do {
            $x2 = $array_points[++$i];
            $y2 = $array_points[++$i];
            imageline($image, $x1, $y1, $x2, $y2, $color);
            $x1 = $x2;
            $y1 = $y2;
        } while ($i<$c);

    }elseif($style==(IMG_ARC_CHORD|IMG_ARC_NOFILL) or $style==(IMG_ARC_PIE|IMG_ARC_NOFILL)){
        imageline($image, $array_points[2], $array_points[3], $array_points[4], $array_points[5], $color);
    }else{
        imagepolygon($image, $array_points, $num_points, $color);
    }

}

$image = imagecreatetruecolor(900, 1250);

$white        = imagecolorallocate($image, 0xFF, 0xFF, 0xFF);
$gray[]     = imagecolorallocate($image, 0xC0, 0xC0, 0xC0);
$gray[]     = imagecolorallocate($image, 0x90, 0x90, 0x90);
$navy[]     = imagecolorallocate($image, 0x00, 0x00, 0x80);
$navy[]     = imagecolorallocate($image, 0x00, 0x00, 0x50);
$red[]      = imagecolorallocate($image, 0xFF, 0x00, 0x00);
$red[]      = imagecolorallocate($image, 0x90, 0x00, 0x00);
$yellow[]    = imagecolorallocate($image, 0xFF, 0xFF, 0x00);
$yellow[]    = imagecolorallocate($image, 0x90, 0x90, 0x00);

$Cx = 200;
$Cy = 100;

$W = 300;
$H = 100;

$Dx = 500;
$Dy = 0;
$Dy_3d = 40;

$Angles['yellow']    = array(180,0);
$Angles['gray']        = array(0,88);
$Angles['navy']        = array(88,92);
$Angles['red']        = array(92,180);

$styles['IMG_ARC_PIE'] = IMG_ARC_PIE;

$styles['IMG_ARC_CHORD'] = IMG_ARC_CHORD;

$styles['IMG_ARC_PIE|IMG_ARC_NOFILL'] = IMG_ARC_PIE|IMG_ARC_NOFILL;

$styles['IMG_ARC_CHORD|IMG_ARC_NOFILL'] = IMG_ARC_CHORD|IMG_ARC_NOFILL;

$styles['IMG_ARC_PIE|IMG_ARC_EDGED|IMG_ARC_NOFILL'] = IMG_ARC_PIE|IMG_ARC_EDGED|IMG_ARC_NOFILL;

$styles['IMG_ARC_CHORD|IMG_ARC_EDGED|IMG_ARC_NOFILL'] = IMG_ARC_CHORD|IMG_ARC_EDGED|IMG_ARC_NOFILL;

imagestring($image, 5, 130, 15, 'imagefilledarc', $white);

imagestring($image, 5, 130 + $Dx, 15, 'myimagefilledarc', $white);

foreach($styles as $name_style => $style){


    for ($i = $Cy+$Dy_3d; $i > $Cy; $i--) {
        foreach($Angles as $colors=>$angle){
            imagefilledarc($image, $Cx, $i+$Dy, $W, $H, $angle[0], $angle[1],$$colors[1], $style);
        }
    }

    foreach($Angles as $colors=>$angle){
        imagefilledarc($image, $Cx, $Cy+$Dy, $W, $H, $angle[0], $angle[1],$$colors[0], $style);
    }


    for ($i = $Cy+$Dy_3d; $i > $Cy; $i--) {
        foreach($Angles as $colors=>$angle){
            myimagefilledarc($image, $Cx+$Dx, $i+$Dy, $W, $H, $angle[0], $angle[1],$$colors[1], $style);
        }
    }

    foreach($Angles as $colors=>$angle){
        myimagefilledarc($image, $Cx+$Dx, $Cy+$Dy, $W, $H, $angle[0], $angle[1],$$colors[0], $style);
    }

    imagestring($image, 5, 450-strlen($name_style)*8/2, $Cy+$Dy+$H-10, $name_style, $yellow[0]);

    $Dy+=200;
}


header('Content-type: image/png');
imagepng($image);
imagedestroy($image);

?>