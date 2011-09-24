<?php
setcookie("userid", "akash", time()+(3600*24), "/", "", 0);
setcookie("appowner", "akash", time()+(3600*24), "/", "", 0);
$app_config['userid']=$_COOKIE['userid'];

echo("Viewer :".$_COOKIE['userid'].", Owner: ".$_COOKIE['appownerid']);

?>

<h1>OpenSocial Compliance testing</h1>

<iframe style="padding:0px 0px 0px 0px;" src="http://127.0.0.1/workcamp/opensocial/wired/apprender.php?url=http://127.0.0.1/workcamp/opensocial/wired/gadgets/helloworld.xml">
</iframe>