<?php
/*

We get the following values by default from EditInPlace:

id - The DOM id
form_type - The edit field type (text, textarea, select)
old_content - The pre-edited content
new_content - The edited content

If the form_type was select then we'll also get

old_option - The pre-edited option
new_option - The edited option
old_option_text - The pre-edited display option
new_option_text - The edited display option

If any additional data was specified via the xhr_data option
then it will also be provided.

 */

// Add a little delay so that the user has a chance
// to actually see the saving message.
include("../protect.php");

if($x_login==1)
{

	sleep(1);
	
	$id				= $_POST["id"];
	
	$form_type		= $_POST["form_type"];
	$old_content	= rawurldecode($_POST["old_content"]);
	$new_content	= rawurldecode($_POST["new_content"]);
		
	if($old_content == $new_content)
	{
		print(rawurldecode($old_content));
	}
	else
	{
		if($id=="flickr_name")
		{

		require_once("phpFlickr/phpFlickr.php");
		$current_id = $_COOKIE['userid'];
		$flickrname = $new_content;
		$apiKey = "3cd89929c55171eba5c13786abc4d2ae";
		$apiSecret ="08649ea49828fe90";
		
		$f = new phpFlickr($apiKey, $apiSecret);
		$nsid = $f->people_findByUsername($flickrname);
		
		if($nsid==(bool)false)
		{
			print(rawurldecode("Invalid username!"));
		}
		else{
			addslashes($flickrname);
			include("../ccconfig.php");
			$dbconn = mysql_connect(THEDBHOST,THEDBUSER,THEDBPASS);
			mysql_select_db(THEDB);
			$sql = "update userprofiles SET flickr_username='$flickrname' where user_id='$current_id' ";
			$qry = mysql_query($sql,$dbconn);
			if($qry){print(rawurldecode($flickrname));}else{print("Save failed!");}
			
		}

		}
		
		if($id=="webpage_url")
		{
		
		$current_id = $_COOKIE['userid'];
		$webpage_url = $new_content;
		
			addslashes($webpage_url);
			include("../ccconfig.php");
			$dbconn = mysql_connect(THEDBHOST,THEDBUSER,THEDBPASS);
			mysql_select_db(THEDB);
			$sql = "update userprofiles SET webpage='$webpage_url' where user_id='$current_id' ";
			$qry = mysql_query($sql,$dbconn);
			if($qry){print(rawurldecode($webpage_url));}else{print("Save failed!");}
		
			
		}
	}

}
else
{

print("logged out!");
}


?>
