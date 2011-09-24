<?php
	
require_once("phpFlickr/phpFlickr.php");

$username = $_GET['prid'];
$apiKey = "3cd89929c55171eba5c13786abc4d2ae";
$apiSecret ="08649ea49828fe90";  //optional

	// Create new phpFlickr object
	
	$f = new phpFlickr($apiKey, $apiSecret);
	$f->setToken($authToken);
	$f->enableCache("db","mysql://jcafecam_main:some_password@localhost/jcafecam_workcamp");
	
	// Find the NSID of the username inputted via the form
    $nsid = $f->people_findByUsername($username);
     
	
$photo = $f->photos_getInfo($_GET['pid']);
	
$html .=  "<a href='index.php?action=slideshow&setid=".$_GET['setid']."' title='".$photo['title']."' id='mainphotoHREF'> ";
$html .= "<img border='0' alt='$photo[title]' src=" . $f->buildPhotoURL($photo, "medium") . "  id='mainphoto'>";
$html .= "</a>";
$html .= "<p id='photoTools'><a href='index.php?action=detailview&setid=".$_GET['setid']."'>Detail View</a></p>";
$html .= "<p id='mainphotoDesc'>".$photo['description']."</p>";

echo $html;

?>
