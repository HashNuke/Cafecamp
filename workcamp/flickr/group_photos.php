<?php

require_once("phpFlickr/phpFlickr.php");
$f = new phpFlickr("3cd89929c55171eba5c13786abc4d2ae");
$f->enableCache(
    "db",
    "mysql://jcafecam_main:some_password@localhost/jcafecam_workcamp"
);

$username = "akashxavier";

    $person = $f->people_findByUsername($username);
    $groups = $f->people_getPublicGroups($person['id']);
    foreach ((array)$groups as $group) {
        echo "<h3><a href='http://www.flickr.com/groups/" . 
            $group['nsid'] . "/'>" . $group['name'] . "</a></h3>\n";
        $photos = $f->groups_pools_getPhotos($group['nsid'], NULL, NULL, NULL, 6);
        foreach ((array)$photos['photo'] as $photo) {
            echo "<a href=http://www.flickr.com/photos/" . $photo['owner'] . 
                "/" . $photo['id'] .">";
            echo "<img border='0' alt='$photo[title]' src=" . 
                $f->buildPhotoURL($photo, "Square") . ">";
            echo "</a>";
        }
    }


?>
