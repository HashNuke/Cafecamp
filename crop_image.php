<?php 
	include("../protect.php");
  
    if($x_login==1)
    {
        list($user_email, $user_id) =  split("::", $_SESSION['user'], 2);
    }
    else
    {
        header("location:index.php");
        exit();
    }
    
    include("../ccconfig.php");
    include("../dbal.php");

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
	

include('header.php');

	// SETUP DIRECTORY STRUCTURE WITH GOOD PERMS
	if(!is_dir("photos")) { mkdir("photos", 0777); chmod("photos", 0777); }
	if(!is_dir("photos/uploads")) { mkdir("photos/uploads"); chmod("photos/uploads", 0777); }
	if(!is_dir("photos/cropped")) { mkdir("photos/cropped"); chmod("photos/cropped", 0777); }
	if(!is_dir("photos/finished")) { mkdir("photos/finished"); chmod("photos/finished", 0777); }

	// DEFINE VARIABLES
	$maxWidth = 1000;
	$maxHeight = 1000;
	$minWidth = 125;
	$minHeight = 125;
	$imageFileName = $user_id.'_'.basename($_FILES['image']['name']);
	
	$imageFileName = str_replace(" ","",$imageFileName);
	$imageFileName = str_replace("'","",$imageFileName);
	$target_path = "photos/uploads/";
	$target_path = $target_path.$imageFileName;
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
	<h1>Crop Your Image</h1>
	<p>You may click and drag an area within the image to crop. Once complete you will be able to scale/resize your image before saving.</p>
<!-- /info -->

<div id="cropContainer">
	<div id="crop">
		<div id="cropWrap">
			<img src="<?php echo $imageLocation ?>" alt="Image to crop" id="cropImage" />
		</div> <!-- /cropWrap -->
	</div> <!-- /crop -->
	<div id="crop_save">
		<form action="resize_image.php" method="post" class="frmCrop">
		
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
				<p class="submit" align="center"><input type="submit" id="submit" name="submit" value="Crop picture"></p>
			</fieldset>
		</form>
	</div> <!-- /crop_save -->
</div> <!-- /cropContainer -->
</div> 

<?php } } else { 
		
	if($_FILES['image'] ['error']) {
		switch ($_FILES['image'] ['error']) {
			case 1:
				$error = 'The file is bigger than this PHP installation allows.';
				break;
			case 2:
				$error = 'The file is bigger than 500kb';
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