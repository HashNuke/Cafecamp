<?php

$username = "some_username";
$password = "some_secure_pwd";

$title = "my image title";
$description = "Image Description";
$file_name = "img_7456.jpg";
$album_name = "Test Album";

// Don't edit below here

require_once(dirname(__FILE__) . "/classes/class_loader.inc");

$auth = new google_ClientLogin($username, $password);
$auth->login();
$picasa = new google_PicasaWeb($auth);

$gallery_xml = $picasa->getGalleryXml();

$album_id = FALSE;
foreach($gallery_xml->channel->item as $item) {
	if($album_name == (string) $item->title) {
		$album_id = $item->children("http://picasaweb.google.com/lh/picasaweb/")->id;
		echo "Album Exists\n";
	}
}

if(!$album_id) {
	$album_id = $picasa->createAlbum($album_name);
	echo "Album Created\n";
}

$image_data = file_get_contents($file_name);

echo $picasa->uploadImage($album_id, $title, $description, $file_name, $image_data);

echo "\nImage Uploaded\n";
