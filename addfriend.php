<?php
include("../protect.php");
include("../ccconfig.php");

$add_id = $_GET['id'];
$rel_text = nl2br(addslashes(strip_tags($_GET['text'])));


if($x_login=="1")
{

list($user_email, $user_id) =  split("::", $_SESSION['user'], 2);

if($add_id==$user_id)
{
print("You can always be your own friend");
exit();
}

include("../dbal.php");
$dbconn = openconn();
selectdb();

$sql1 = "select * from friends where user_id_you='$add_id' and user_id_me='$user_id' ";
$qry1 = exe_qry($sql1,$dbconn);

$sql2 = "select * from friendrequests where user_id_to='$add_id' and user_id_frm='$user_id' ";
$qry2 = exe_qry($sql2,$dbconn);

$sql3 = "select * from friendrequests where user_id_to='$user_id' and user_id_frm='$add_id' ";
$qry3 = exe_qry($sql3,$dbconn);

$sql_ig = "select * from ignored_users where ignored_id='$user_id' and user_id='$add_id' ";
$qry_ig = exe_qry($sql_ig,$dbconn);

$num1 = mysql_num_rows($qry1);
$num2 = mysql_num_rows($qry2);
$num3 = mysql_num_rows($qry3);
$num_ig = mysql_num_rows($qry_ig);

if($num_ig=="1")
{
print("You have been ignored by this person");
exit();
}

if($num1==0 && $num2==0)
{
/** send request **/

$sql_send = "insert into friendrequests(user_id_to,user_id_frm,text) values('$add_id','$user_id','$rel_text') ";
$qry_send = exe_qry($sql_send,$dbconn);
print("friend request sent!");

exit();
}

if($num1==1)
{
print("you are friends!");
exit();
}

if($num2==1)
{
print("Please wait for this person to approve your request!");
exit();
}

if($num3==1)
{
$sql_send = "insert into friendrequests(user_id_to,user_id_frm,text) values('$add_id','$add_id','$rel_text') ";
$qry_send = exe_qry($sql_send,$dbconn);

$sql_del = "delete from friendrequests where user_id_frm='$add_id' and user_id_to='$user_id' ";
$qry_del = exe_qry($sql_del,$dbconn);

echo("you are friends!");
exit();
}

}

?>