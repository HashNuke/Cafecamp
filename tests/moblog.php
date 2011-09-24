<?php

include("../../ccconfig.php");
include("../../dbal.php");

$conn = openconn();
selectdb();

$sql = "select * from moblog";
$qry = mysql_query($sql,$conn);
?>

Displaying posts below:<br><br>

<?php
while($row = mysql_fetch_array($qry))
{
    echo("<p>Msg_id: ".$row['msg_id']."<br><b>N</b>".$row['phno']."<br><b>M</b>".$row['msg']."</p>");
}

?>