<?php
include("../ccconfig.php");
include("../dbal.php");
$dbconn=openconn();
selectdb();

$sql = "select * from userprofiles";
$qry=exe_qry($sql,$dbconn);
$num_users = mysql_num_rows($qry);
echo($num_users." users");
echo("<br>");
$sql = "select * from camps";
$qry=exe_qry($sql,$dbconn);
$num_camps = mysql_num_rows($qry);
echo($num_camps." camps");
?>