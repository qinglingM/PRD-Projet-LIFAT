<?php // content="text/plain; charset=utf-8"

function DashedLine($x1,$y1,$x2,$y2,$dash_length=1,$dash_space=4) {
    $im  = imagecreatetruecolor(300, 300);
    $w   = imagecolorallocate($im, 255, 255, 255);

    $style = array_fill(0,$dash_length,$w);
    $style = array_pad($style,$dash_space,IMG_COLOR_TRANSPARENT);
    imagesetstyle($im, $style);
    imageline($im, $x1, $y1, $x2, $y2, IMG_COLOR_STYLED);

    imagejpeg($im);
    imagedestroy($im);
}

header("Content-type: image/jpeg");
DashedLine(30, 20, 100, 150, 5, 10);
?>
