<?php

if($_POST)
{
$theurl = $_POST['theurl'];
// create a new curl resource
$ch = curl_init();

// set URL and other appropriate options
curl_setopt($ch, CURLOPT_URL, $theurl);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

// grab URL and pass it to the browser
curl_exec($ch);

// close curl resource, and free up system resources
curl_close($ch);

}
else
{
	?> <form method="post" action="index.php">Enter thr url of the page:<br>
	<input name="theurl" type="text"><input type="submit" value="Submit"></form>
<?php
}
?>