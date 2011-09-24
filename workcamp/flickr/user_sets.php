<?php
require_once("phpFlickr/phpFlickr.php");
// Create new phpFlickr object
$f = new phpFlickr("FLICKR_API_KEY");
$f->enableCache(
    "db",
    "mysql://jcafecam_main:some_password@localhost/jcafecam_workcamp"
);

$i = 0;
if (!empty($_POST['username'])) {
    // Find the NSID of the username inputted via the form
    $person = $f->people_findByUsername($_POST['username']);
    
    $photo_sets = $f->photosets_getList($person['id']);
	
	var_dump($photo_sets);

function returnphotosets_getList($f,$user_id){       
        $photosets = $f->photosets_getList($user_id);       
        if(!empty($photosets)){           
            $html .="<ul class='menublock'>";                       
            foreach ($photosets['photoset'] as $set) {
                $html .= "<li><a href='photos.php?action=photoset&setid=$set[id]' >";
                $html .= "<img alt='$set[title]'src='http://static.flickr.com/$set[server]/$set[primary]_$set[secret]_s.jpg'/>";
                $html .= "</a></li>";
            }
            $html .= "</ul>";
        }       
        echo $html;       
    }

returnphotosets_getList($f,$person['id']);
    
}
?>

<h3>Enter a username to search for</h3>
<form method='post'>
    <input name='username'><br>
    <input type='submit' value='Display Photos'>
</form>
