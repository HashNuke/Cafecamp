<?php

require('crop.php');

$file = $_GET[’file’];
$sx = $_GET[’sx’];
$sy = $_GET[’sy’];
$ex = $_GET[’ex’];
$ey = $_GET[’ey’];
$test = $_GET[’test’];

$fake = $_GET[’fake’];
echo("<h2>".$fake."</h2>");
$cc =& new CropCanvas();
$cc->loadImage($file);
$cc->cropToDimensions($sx, $sy, $ex, $ey);

$cc->saveImage($file);
$cc->flushImages(false);

echo ($file);

?>