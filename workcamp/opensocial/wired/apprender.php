<?php

require_once("apprenderset.php");

if(isset($_GET['url']) && $_GET['url'])
{
	$theurl = $_GET['url'];
	
	$ch = curl_init();
	
	curl_setopt($ch, CURLOPT_URL, $theurl);
	curl_setopt($ch , CURLOPT_RETURNTRANSFER , 1 );
	$thexmldata = curl_exec($ch);
	curl_close($ch);
	include ("gadgetparser.php");
	
}
else
{
	$error_flag = "1";
}
?>