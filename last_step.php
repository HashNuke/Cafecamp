<?php 

require 'functions.php';

$scripts = '	<script src="lib/prototype.js" type="text/javascript"></script>
	<script src="lib/show_rotated.js" type="text/javascript"></script>';
	
$styles = '<link type="text/css" rel="stylesheet" href="css/imig.css" media="screen, projection" />';

include 'header.php';

if(isset($_POST['imageFileName'])) { 

	// DEFINE VARIABLES
	$imageFileName	 = $_POST['imageFileName'];
	$scale					 = $_POST['resizeScale'];
	$sourceFile			 = "working/cropped/". $imageFileName;
	$destinationFile = "working/finished/" . $imageFileName;
	list($width, $height) = getimagesize($sourceFile);
	$imageWidth      = $width;
	$imageHeight     = $height;
	$resizeWidth		 = floor($imageWidth * $scale);
	$resizeHeight		 = floor($imageHeight * $scale);
	
	if(file_exists($destinationFile)) { chmod($destinationFile, 0777); unlink($destinationFile); }	// delete if existing

	// CHECK TO SEE IF WE NEED TO CROP
	if($imageWidth != $resizeWidth) {
		$newImage = imagecreatetruecolor($resizeWidth,$resizeHeight);
		$source = imagecreatefromjpeg($sourceFile);
		imagecopyresampled($newImage,$source,0,0,0,0,$resizeWidth,$resizeHeight,$imageWidth,$imageHeight);
		imagejpeg($newImage,$destinationFile,90);
		chmod($destinationFile, 0777);

	} else { // RESIZE WAS SKIPPED
		copy($sourceFile,$destinationFile);
		chmod($destinationFile, 0777);
	}

	$fileName = explode(".",$imageFileName);
	$fileName = $fileName[0];

	// ROTATE IMAGE 90 degrees
	$rotatedFile90 = "working/finished/" . $fileName . "_90" . ".jpg";
	rotateImage($destinationFile,$rotatedFile90,90);
	
	// ROTATE IMAGE 180 degrees
	$rotatedFile180 = "working/finished/" . $fileName . "_180" . ".jpg";
	rotateImage($destinationFile,$rotatedFile180,180);
	
	// ROTATE IMAGE 270 degrees
	$rotatedFile270 = "working/finished/" . $fileName . "_270" . ".jpg";
	rotateImage($destinationFile,$rotatedFile270,270);
	
?>

	<div class="info">
		<h1>All Done</h1>
		<p>Your image has been cropped and resized as you'd like.	 The image below can be used as you see fit.</p>
	</div>


<div id="completedImage">
	<?php
	echo "<img src=\"" . $destinationFile . "\" id=\"theImage\" alt=\"Final Image\" />";
	?>
</div> <!-- completedImage -->

<div id="rotatedImages">
	<h2>Rotated 90 degrees</h2>
	<img src="<?php echo $rotatedFile90; ?>" id="theImage90" alt="Final image rotated 90 degrees" />
	<h2>Rotated 180 degrees</h2>
	<img src="<?php echo $rotatedFile180; ?>" id="theImage180" alt="Final image rotated 180 degrees" />
	<h2>Rotated 270 degrees</h2>
	<img src="<?php echo $rotatedFile270; ?>" id="theImage270" alt="Final image rotated 280 degrees" />
</div>

<?php } else { ?> 

	<div class="info">
		<h1>Error</h1>
		<p>There was an error.</p> 
	</div>

<?php } include 'footer.php' ?>