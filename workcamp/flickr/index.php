<!--photos-->
<?php 
require_once("phpFlickr/phpFlickr.php");
include_once('header.php'); 


$username = "soyburger";
$apiKey = "FLICKR_API_KEY";
$apiSecret = "FLICKR_SECRET";


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
	
	function returnPhotos($f,$setid,$username) {
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
        	$html .= "<a href='#' title='".$photo['title']."' onclick='SwapImage(".$photo['id'].",".$photos['id'].",\"$username\");return false;' ><img border='0' alt='$photo[description]' src='".$f->buildPhotoURL($photo, "Square")."'id='photo_".$photo['id']."'></a>";
           
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
  	
	function SwapImage(pid,setid,prid)
	{
		document.getElementById('mainphoto').src = 'images/loading.gif';
		document.getElementById('mainphoto').align = 'absmidddle';
    	//document.getElementById('mainphotodiv').innerHTML = 'Loading...';
    	new Ajax.Updater('mainphotodiv','ajaxPhoto.php?pid='+pid+'&setid='+setid+'&prid='+prid+'', { method:'get', asynchronous:true,  onSuccess:handlerSwapImage });
   	 	
	}
	
</script>
	
<div id="content">

<?php 
	$action = rawurlencode($_GET['action']);
	$setid =  rawurlencode($_GET['setid']);
	$pid =  rawurlencode($_GET['pid']);	

	
	switch($action) {
		case 'photoset':
			
			returnPhotos($f,$setid,$username);
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



</div>
<div id="subcontent">
<div class="small box">
<?php returnPhotoThumbs($f,$nsid['id']); ?>
</div>

</div>

<?php include_once('footer.php'); ?>
