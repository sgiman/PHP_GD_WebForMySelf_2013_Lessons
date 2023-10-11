<?php
$Randomized = rand(1,20);
for($i=0;$i<=$Randomized;$i++){$data[$i]=rand(2,20);};//full array with garbage.
$imgx='600';$imgy='400';//Set Image Size. ImageX,ImageY
$cx = '300';$cy ='150'; //Set Pie Postition. CenterX,CenterY
$sx = '600';$sy='300';$sz ='100';// Set Size-dimensions. SizeX,SizeY,SizeZ

$data_sum = array_sum($data);
//convert to angles.
for($i=0;$i<=$Randomized;$i++){
    $angle[$i] = (($data[$i] / $data_sum) * 360);
    $angle_sum[$i] = array_sum($angle);
};
$im  = imagecreate ($imgx,$imgy);
$background = imagecolorallocate($im, 255, 255, 255);
//Random colors.
for($i=0;$i<=$Randomized;$i++){
    $r=rand(100,255);$g=rand(100,255);$b=rand(100,255);
    $colors[$i] = imagecolorallocate($im,$r,$g,$b);
    $colord[$i] = imagecolorallocate($im,($r/1.5),($g/1.5),($b/1.5));
}
//3D effect.
for($z=1;$z<=$sz;$z++){
    // first slice
    imagefilledarc($im,$cx,($cy+$sz)-$z,$sx,$sy,0
        ,$angle_sum[0],$colord[0],IMG_ARC_EDGED);
    for($i=1;$i<=$Randomized;$i++){
        imagefilledarc($im,$cx,($cy+$sz)-$z,$sx,$sy,$angle_sum[$i-1]
            ,$angle_sum[$i],$colord[$i],IMG_ARC_NOFILL);
    };
};
//Top pie.
// first slice
imagefilledarc($im,$cx,$cy,$sx,$sy,0 ,$angle_sum[0], $colors[0], IMG_ARC_PIE);
for($i=1;$i<=$Randomized;$i++){
    imagefilledarc($im,$cx,$cy,$sx,$sy,$angle_sum[$i-1] ,$angle_sum[$i], $colors[$i], IMG_ARC_PIE);
};
//Output.
header('Content-type: image/png');
imagepng($im);
imagedestroy($im);
?>

