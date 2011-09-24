<?php

$nvar=$_POST['nvar'];
$mvar=$_POST['mvar'];

include("../../ccconfig.php");
include("../../dbal.php");

$conn = openconn();
selectdb();

$sql = "insert into moblog(phno,msg) values(\"$nvar\",\"$mvar\")";
$qry = mysql_query($sql,$conn);

?>