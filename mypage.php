<?php
include("../protect.php");
include("../ccconfig.php");


$prf_user_id = $_GET['id'];

if($x_login==1)
{
    
    list($user_email, $user_id) =  split("::", $_SESSION['user'], 2);

include("../dbal.php");
$dbconn=openconn();
selectdb();    
$sql = "select * from userprofiles where user_id = '$prf_user_id' ";
$qry = exe_qry($sql, $dbconn);
while($prf=mysql_fetch_array($qry))
		{
			$f = stripslashes($prf['fname']);
			$about = stripslashes($prf['about']);
		}
?>
<div id="aboutme">
<label>About me</label><br>
<div id="abouttext">
<?php echo($about); ?>
</div>
</div>
<?php
$sql_pro = "select * from myapps where user_id = '$prf_user_id' ";
$qry_pro = exe_qry($sql, $dbconn);
if(mysql_num_rows($qry_pro)!=0)
{
echo("<ul id=\"appcol\">");
$apps_list = get_qry_array($sql_pro,$dbconn);
foreach($apps_list as $per_app)
{
$app_id = $per_app['app_id'];
$sql_pro2 = "select * from appdirectory where app_id = '$app_id' ";
$qry_pro2 = exe_qry($sql, $dbconn);
$app_info = get_qry_array($sql_pro2,$dbconn);
foreach($app_info as $app_d)
{
	$app_url = stripslashes($app_d['app_url']);
}

?>
<li>
<iframe class="perapp" id="<?php echo($user_id."_".$app_id); ?>" frameborder="0" src="http://sleeky.info/apps/apprender.php?&u=<?php echo($user_id); ?>&v=<?php echo($prf_user_id); ?>&url=<?php echo($app_url); ?>">
</iframe>
</li>
<?php

}
echo("</ul>");
}

}
?>