<?php
// test.php -- Test Yahoo! Browser-Based Authentication
// A simple auth exmaple.
// Author: Jason Levitt
// Date: November 20th, 2006
// Version 1.0
//

// Edit these. Change the values to your Application ID and Secret
define("APPID", 'GHBie4rIkY59BJVg5QODsGFMgv7s1w2uUaOB');
define("SECRET", '8920f08b57d0937912fed72dbbcab280');

// Include the proper class file

session_start();

$v = phpversion();
if ($v[0] == '4') {
	include("ybrowserauth.class.php4");
} elseif ($v[0] == '5') {
	include("ybrowserauth.class.php5");
} else {
	die('Error: could not find the bbauth PHP class file.');
}

function CreateContent() {

	$authObj = new YBrowserAuth(APPID, SECRET);

	// If Yahoo! isn't sending the token, then we aren't coming back from an
	// authentication attempt
	if (empty($_GET["token"])) {
		// You can send some data along with the authentication request
		// In this case, the data is the string 'some_application_data'
		echo 'You have not signed on using BBauth yet<br /><br />';
		echo '<a href="'.$authObj->getAuthURL('some_application_data', true).'">Click here to authorize</a>';
		return;
	}

	// Validate the sig
	if ($authObj->validate_sig()) {
	echo("The user hash: ".$authObj->userhash."<br>");
	$thehash=$authObj->userhash;
	$_SESSION['myuser']="y:".$thehash;
	echo("<br><a href=\"test2.php\">Go to another page</a>");
	/** 
		echo '<h2>BBauth authentication Successful</h2>';
		echo '<h3>The user hash is: '.$authObj->userhash.'</h3>';
        echo '<b>appdata value is:</b> '. $authObj->appdata . '<br />'; **/
	} else {
		die('<h1>BBauth authentication Failed</h1> Possible error msg is in $sig_validation_error:<br />'. $authObj->sig_validation_error);
	}

	return;
}

CreateContent();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<div id="look">
<h2>Test BBauth </h2>
  <div>
  
  </div>
  <div id="content">
  </div>
</div>
</body>
</html>