<?php 

$styles = '<link type="text/css" rel="stylesheet" href="css/imig.css" media="screen, projection" />';

$scripts = '';

include 'header.php';

if(isset($_POST['imageFileName'])) { 
echo("<h1>".$_FILE['']['type']."</h1>");
	// DEFINE VARIABLES
	$imageWidth			 = $_POST['imageWidth'];
	$imageHeight		 = $_POST['imageHeight'];
	$imageFileName		 = $_POST['imageFileName'];
	$cropX				 = $_POST['cropX'];
	$cropY				 = $_POST['cropY'];
	$cropWidth			 = $_POST['cropWidth'];
	$cropHeight			 = $_POST['cropHeight'];
	$i_type 			 = $_POST['ftype'];
	
	if($cropWidth == 0) { $cropWidth = $imageWidth; }
	if($cropHeight == 0) { $cropHeight = $imageHeight; }

	$sourceFile			 = "working/uploads/". $imageFileName;
	$destinationFile = "working/cropped/" . $imageFileName;

	if(file_exists($destinationFile)) { chmod($destinationFile, 0777); unlink($destinationFile); }

	// CHECK TO SEE IF WE NEED TO CROP
	if($imageWidth != $cropWidth || $imageHeight != $cropHeight) {
		$canvas = imagecreatetruecolor($cropWidth,$cropHeight);
		
		if($i_type=="image/jpeg" || $i_type=="image/pjpeg")
		{
			$piece = imagecreatefromjpeg($sourceFile);
		}
		else if($i_type=="image/png")
		{
			$piece = imagecreatefrompng($sourceFile);
		}
		else
		{
			/* we assume its GIF */
			$piece = imagecreatefromgif($sourceFile);
		}
		
		imagecopy($canvas,$piece,0,0,$cropX,$cropY,$cropWidth,$cropHeight);
		
		if($i_type=="image/jpeg" || $i_type=="image/pjpeg")
		{
			imagejpeg($canvas,$destinationFile,90);
		}
		else if($i_type=="image/png")
		{
			imagepng($canvas,$destinationFile);
		}
		else
		{
			/* we assume its GIF */
			imagegif($canvas,$destinationFile,90);
		}
		
		imagedestroy($canvas);
		imagedestroy($piece);
		chmod($destinationFile, 0777);
		
		$canvas2 = imagecreatetruecolor("50","50");
		$sourceFile2			 = "working/cropped/" . $imageFileName;
		$destinationFile2 = "working/images-small/" . $imageFileName;
		
		if($i_type=="image/jpeg" || $i_type=="image/pjpeg")
		{
			$piece2 = imagecreatefromjpeg($sourceFile2);
		}
		else if($i_type=="image/png")
		{
			$piece2 = imagecreatefrompng($sourceFile2);
		}
		else
		{
			/* we assume its GIF */
			$piece2 = imagecreatefromgif($sourceFile2);
		}
		
		imagecopyresampled($canvas2,$piece2,0,0,0,0,50,50,100,100);
		
		if($i_type=="image/jpeg" || $i_type=="image/pjpeg")
		{
			imagejpeg($canvas2,$destinationFile2,90);
		}
		else if($i_type=="image/png")
		{
			imagepng($canvas2,$destinationFile2);
		}
		else
		{
			/* we assume its GIF */
			imagegif($canvas2,$destinationFile2,90);
		}
		
		imagedestroy($canvas2);
		imagedestroy($piece2);
		chmod($destinationFile2, 0777);		
		
		
	
	} else {
		// CROP WAS SKIPPED -- MOVE TO CROPPED FOLDER ANYWAY	
		copy($sourceFile,$destinationFile);
		chmod($destinationFile, 0777);
	}

?>




	<!-- The Image to Resize -->
	<div id="resizeImage">
		<?php echo "	<img src=\"" . $destinationFile . "\" id=\"theImage\" alt=\"Image to Resize\" />"; ?>
	</div> <!-- resizeImage -->

<?php } else { ?> 

	<div class="info">
		<h1>Error</h1>
		<p>There was an error.</p> 
	</div>

<?php } include 'footer.php' ?>