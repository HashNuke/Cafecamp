<?php 

require 'functions.php';

if($_FILES['image']['type']=="image/jpeg"||$_FILES['image']['type']=="image/pjpeg"||$_FILES['image']['type']=="image/png"||$_FILES['image']['type']=="image/gif") {

	$uploadedFile = $_FILES['image']['tmp_name'];
	$croptype = "fixed";
	$i_type = $_FILES['image']['type'];
	
	$styles = '	 <link type="text/css" rel="stylesheet" href="css/debug.css" media="screen, projection" />
		<link type="text/css" rel="stylesheet" href="css/cropper.css" media="screen, projection" />
		<link type="text/css" rel="stylesheet" href="css/imig.css" media="screen, projection" />
		<!--[if IE 6]><link type="text/css" rel="stylesheet" href="css/cropper_ie6.css" media="screen, projection" /><![endif]-->
		<!--[if lte IE 5]><link type="text/css" rel="stylesheet" href="css/cropper_ie5.css" media="screen, projection" /><![endif]-->';

	$scripts = '	<script src="lib/prototype.js" type="text/javascript"></script> 
		<script src="lib/scriptaculous.js?load=builder,dragdrop" type="text/javascript"></script>
		<script src="lib/cropper.js" type="text/javascript"></script>';

	$scripts .= '<script src="lib/init_cropper/fixed.js" type="text/javascript"></script>';
	

include 'header.php';

	// SETUP DIRECTORY STRUCTURE WITH GOOD PERMS
	if(!is_dir("working")) { mkdir("working", 0777); chmod("working", 0777); }
	if(!is_dir("working/uploads")) { mkdir("working/uploads"); chmod("working/uploads", 0777); }
	if(!is_dir("working/cropped")) { mkdir("working/cropped"); chmod("working/cropped", 0777); }
	if(!is_dir("working/finished")) { mkdir("working/finished"); chmod("working/finished", 0777); }

	// DEFINE VARIABLES
	$maxWidth = 2000;
	$maxHeight = 2000;
	$minWidth = 320;
	$minHeight = 240;
	$imageFileName = basename($_FILES['image']['name']);
	
	$imageFileName = str_replace(" ","",$imageFileName);
	$imageFileName = str_replace("'","",$imageFileName);
	$target_path = "working/uploads/";
	$target_path = $target_path . $imageFileName;
	$imageLocation = $target_path;
	$fileTypeError = false;


	// DELETE FILE IF EXISTING
	if(file_exists($imageLocation)) { chmod($imageLocation, 0777); unlink($imageLocation); }

	// CHECK FOR IMAGE UPLOAD
	if(move_uploaded_file($uploadedFile, $imageLocation)) {
		chmod($imageLocation, 0777);

		// GET UPLOADED IMAGE DIMENSIONS
		$dimensions['width'] = getWidth($imageLocation);
		$dimensions['height'] = getHeight($imageLocation);
			
		// RESIZE IF WIDTH IS TOO WIDE
		if(($dimensions['width']>$maxWidth)){
			$scale = $maxWidth/$dimensions['width'];
			$imageLocation = scaleImage($imageLocation,$dimensions['width'],$dimensions['height'],$scale,$i_type);
			$dimensions['width'] = getWidth($imageLocation);
			$dimensions['height'] = getHeight($imageLocation);
		}

		// RESIZE IF WIDTH IS TOO TALL
		if(($dimensions['height']>$maxHeight)){
			$scale = $maxHeight/$dimensions['height'];
			$imageLocation = scaleImage($imageLocation,$dimensions['width'],$dimensions['height'],$scale,$i_type);
			$dimensions['width'] = getWidth($imageLocation);
			$dimensions['height'] = getHeight($imageLocation);
		}
	
		// RESIZE IF WIDTH IS TOO NARROW
		if(($dimensions['width']<$minWidth)){
			$scale = $minWidth/$dimensions['width'];
			$imageLocation = scaleImage($imageLocation,$dimensions['width'],$dimensions['height'],$scale,$i_type);
			$dimensions['width'] = getWidth($imageLocation);
			$dimensions['height'] = getHeight($imageLocation);
		}

		// RESIZE IF HEIGHT IS TOO SHORT
		if(($dimensions['height']<$minHeight)){
			$scale = $minHeight/$dimensions['height'];
			$imageLocation = scaleImage($imageLocation,$dimensions['width'],$dimensions['height'],$scale,$i_type);
			$dimensions['width'] = getWidth($imageLocation);
			$dimensions['height'] = getHeight($imageLocation);
		}
?>

<div class="info">
	<h1>Step 1: Crop Your Image</h1>
	<p>You may click and drag an area within the image to crop.	 Once complete you will be able to scale/resize your image before saving.</p>
</div> <!-- /info -->

<div id="cropContainer">
	<h2>Fixed Dimensions (200x200)</h2>';

	<div id="crop">
		<div id="cropWrap">
			<img src="<?php echo $imageLocation ?>" alt="Image to crop" id="cropImage" />
		</div> <!-- /cropWrap -->
	</div> <!-- /crop -->
	<div id="crop_save">
		<form action="createphoto.php" method="post" class="frmCrop">
			<fieldset>
				<legend>Continue</legend>
				<input type="hidden" class="hidden" name="imageWidth" id="imageWidth" value="<?php echo $dimensions['width'] ?>" />
				<input type="hidden" class="hidden" name="imageHeight" id="imageHeight" value="<?php echo $dimensions['height'] ?>" />
				<input type="hidden" class="hidden" name="imageFileName" id="imageFileName" value="<?php echo $imageFileName ?>" />
				<input type="hidden" class="hidden" name="cropX" id="cropX" value="0" />
				<input type="hidden" class="hidden" name="cropY" id="cropY" value="0" />
				<input type="hidden" class="hidden" name="ftype" id="ftype" value="<?php echo($i_type); ?>" />
				<input type="hidden" class="hidden" name="cropWidth" id="cropWidth" value="<?php echo $dimensions['width'] ?>" />
				<input type="hidden" class="hidden" name="cropHeight" id="cropHeight" value="<?php echo $dimensions['height'] ?>" />
				<div id="submit">
					<input type="submit" value="Save" name="save" id="save" />
				</div>
			</fieldset>
		</form>
	</div> <!-- /crop_save -->
</div> <!-- /cropContainer -->

<?php } } else { 
		
	if($_FILES['image'] ['error']) {
		switch ($_FILES['image'] ['error']) {
			case 1:
				$error = 'The file is bigger than this PHP installation allows.';
				break;
			case 2:
				$error = 'The file is bigger than 50k.';
				break;
			case 3:
				$error = 'Only part of the file was uploaded.';
				break;
			case 4:
				$error = 'No file was uploaded.';
				break;
		}
	} else {
		$error = 'File is not of type .jpg';
	}
	
	 include 'header.php';

?> 

	<div class="info">
		<h1>File Upload Error</h1>
		<p>There was an error uploading the file.	 <?php echo $error; ?></p>
	</div>

<?php }

include 'footer.php' ?>