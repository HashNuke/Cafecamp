<?PHP
include 'flickr.php';
$a = new flickr('3cd89929c55171eba5c13786abc4d2ae');
echo '<a href="'.$a->createAuthLink('SECRET HERE').'">Click here to get a frob</a>';
IF(isset($_GET['frob']))
	{
	echo '<BR>Token: '.$a->getToken($_GET['frob'] ,'08649ea49828fe90').'';
	}
?>