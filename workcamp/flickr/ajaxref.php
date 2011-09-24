<!--photos-->
<?php 
require_once("phpFlickr/phpFlickr.php");

$username = $_GET['flid'];
$apiKey = "eb5b451bf939352b0c4c4c1aa382299f";
$apiSecret ="4488250323731dec";


	// Create new phpFlickr object
	
	$f = new phpFlickr($apiKey, $apiSecret);
	
	$f->enableCache("db","mysql://jcafecam_main:some_password@localhost/jcafecam_workcamp");
	//$flickr->enableCache("fs", "/var/www/phpFlickrCache");

	// Find the NSID of the username inputted via the form
    $nsid = $f->people_findByUsername($username);
   
	function returnPhotoThumbs($f,$user_id){
		
		$photosets = $f->photosets_getList($user_id);
		$html .= "<h2>Flickr Photos</h2>";
		if(!empty($photosets)){
			
			$html .= "<ul style='list-style-type:none;'>";
			$i =0;
			foreach ($photosets['photoset'] as $set) {				
				$html .= "<li style='list-style-type:none;'><strong>".$set['title']."</strong><br>";
				$html .= "<a href='index.php?action=photoset&setid=$set[id]' title='$set[title]'>";
				$html .= "<img alt='$set[title]' src='http://static.flickr.com/$set[server]/$set[primary]_$set[secret]_s.jpg' />";
				$html .= "</a>";
				$html .= "</li>";				       					
			} 
			$html .= "</ul>";		
		}		
		echo $html;		
	}
	
	function returnPhotos($f,$setid) {
		$photosSetInfo = $f->photosets_getInfo($setid);
		$heading = "Photos: ".$photosSetInfo['title'];
		$photos = $f->photosets_getPhotos($setid, NULL, NULL);
						
		$html = "<h2>".$heading."</h2><p>";				
		$html .= "<div id='mainphotodiv' class='splitcontentleftImg'>";	
			
		foreach ($photos['photo'] as $photo) {
        	if($photo['isprimary'] == 1) {        		
        		
        		$html .=  "<a href='".$f->buildPhotoURL($photo, "medium")."' rel='lightbox[".$photos['id']."]' title='".$photo['title']."' id='mainphotoHREF'> ";
        		$html .= "<img border='0' alt='$photo[title]' "."src=" . $f->buildPhotoURL($photo, "medium") . "  id='mainphoto'>";
        		$html .= "</a>";
        		$html .= "<p id='photoTools'><a href='index.php?action=detailview&setid=".$photos['id']."'>Detail View</a></p>";
        		$html .= "<p id='mainphotoDesc'>".$photosSetInfo['description']."</p>";
        		break;
        	} 
    	}	
    	$html .="</div>";
        
		$html .= "<div id='photos' class='splitcontentrightImg'>";		
		foreach ($photos['photo'] as $photo) {        	
        	
        	$html .=  "<a href='".$f->buildPhotoURL($photo, "medium")."' rel='lightbox[".$photos['id']."]'  title='".$photo['title']."'  >";
        	$html .= "</a>";
        	$html .= "<a href='#' title='".$photo['title']."' onclick='SwapImage(".$photo['id'].",".$photos['id'].");return false;' ><img border='0' alt='$photo[description]' src='".$f->buildPhotoURL($photo, "Square")."'id='photo_".$photo['id']."'></a>";
           
    	}	
    	$html .="</div></p>";
    	echo $html;		
	}
	
	function returnPhotosDetailView($f,$setid) {
		
		$photosSetInfo = $f->photosets_getInfo($setid);
		$heading = "Photos: ".$photosSetInfo['title'];
		$photos = $f->photosets_getPhotos($setid, NULL, NULL);						
        $i=0;
		$html .= "<table border='0' >";	
		$html .="<tr valign=top>";	
		foreach ($photos['photo'] as $photo) {        	
        	$html .="<td><table>";
        	$html .="<tr><td><strong>".$photo['title']."</strong></td></tr>";
        	
        	$html .="<tr><td>";
        	$html .=  "<a href='".$f->buildPhotoURL($photo, "medium")."' rel='lightbox[".$photos['id']."]'  title='".$photo['title']."'  >";
        	
        	$html .= "<img border='0' alt='$photo[title]' ".
            "src='".$f->buildPhotoURL($photo, "small")."' id='photo_".$photo['id']."'></a>";
            $html .="</td></tr>";
            $html .="<tr><td>".$photo['description']."</td></tr>";
            
            $html .= "</table></td>";
        	$i++;        	
        	if ($i % 3 == 0) {
         	   $html .= "</tr><tr valign=top>";
        	}        	
    	}	
    	
    	$html .="</table>";
    	
    	echo $html;		
	}
	
	function returnPhoto($f,$pid,$setid) {
		$photo = $f->photos_getInfo($pid,NULL);	
		$html .="<h2>".$photo['title']."</h2><div class='splitcontentleftImg'> ";		
		$html .= "<img src='".$f->buildPhotoURL($photo, "medium") ."' id='currentPhoto' class='box' >";
		$html .= "</div>";
		if($setid != '') {
			$photosSetInfo = $f->photosets_getInfo($setid);
			$heading = "Photos: ".$photosSetInfo['title'];
			$photos = $f->photosets_getPhotos($setid, NULL, NULL);
		}
		echo $html ;	
	}
	
	
?>
<script>
	
	var handlerSwapImage = function SwapImage_Callback(str) {   
			
   		document.getElementById('mainphotodiv').innerHTML = str.responseText;
   		
  	}
  	
	function SwapImage(pid,setid)
	{
		document.getElementById('mainphoto').src = 'images/loading.gif';
		document.getElementById('mainphoto').align = 'absmidddle';
    	//document.getElementById('mainphotodiv').innerHTML = 'Loading...';
    	new Ajax.Updater('mainphotodiv','ajaxPhoto.php?pid='+pid+'&setid='+setid+'', { method:'get', asynchronous:true,  onSuccess:handlerSwapImage });
   	 	
	}
	
</script>
	
<div id="content">

<?php 
	$action = rawurlencode($_GET['action']);
	$setid =  rawurlencode($_GET['setid']);
	$pid =  rawurlencode($_GET['pid']);	

	
	switch($action) {
		case 'photoset':
			
			returnPhotos($f,$setid);
		break;
		
		case 'view':
			returnPhoto($f,$pid,$setid);			
		break;
		
		case 'detailview':			
			returnPhotosDetailView($f,$setid);			
		break;
			
		
		default:
			returnPhotoThumbs($f,$nsid['id']);
		break;					
	}	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
<title>Intergrate Flickr Photos on Your Own Site</title>
<meta http-equiv="content-type" content="text/html; charset=iso-8859-1" />
<meta name="description" content="Your website description goes here" />
<meta name="keywords" content="your,keywords,goes,here" />
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen,projection" />


<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/scriptaculous.js?load=effects"></script>
<script type="text/javascript" src="js/lightbox.js"></script>
<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" />
</head>

<body>
<div id="container" >

<div id="header">
<h1>Flickr Site</h1>
<h2>Intergrate Flickr Photos on Your Own Site</h2>
</div>

<div id="navigation">
<ul>
<li class="selected"><a href="index.php">Home</a></li>
</ul>
</div>

</div>
<div id="subcontent">
<div class="small box">
<?php returnPhotoThumbs($f,$nsid['id']); ?>
</div>

</div>

<?php include_once('footer.php'); ?>
