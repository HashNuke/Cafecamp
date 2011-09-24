<?php

include("../protect.php");
include("../ccconfig.php");

$to_id = $_POST['id'];
$msg = nl2br(addslashes(strip_tags($_POST['scrib'])));

if($x_login==1)
{
    
    list($user_email, $user_id) =  split("::", $_SESSION['user'], 2);
    
    include("../dbal.php");
     
    $dbconn = openconn();
    selectdb();
    
    $now=date("YmdHis");
    $sql = "insert into scribblebook(scribble_text,scribble_date,scribble_by,user_id) values('$msg','$now','$user_id','$to_id') ";
    $qry = exe_qry($sql,$dbconn);

    $sql = "select scribble_num from userprofiles where user_id='$to_id' ";
    $qry = exe_qry($sql,$dbconn);
	
$detl=get_qry_array($sql,$dbconn);
foreach($detl as $detl2)
{
	$snum=$detl2['scribble_num'];
}
$snum=$snum+1;
$sql = "update userprofiles set scribble_num='$snum' where user_id='$to_id' ";
$qry = exe_qry($sql,$dbconn);
	
}

?>