<?php

include("../protect.php");
include("../ccconfig.php");

$fname=addslashes(strip_tags($_POST['fname']));
$lname=addslashes(strip_tags($_POST['lname']));
$gender=$_POST['gender'];
if($gender=="male" || $gender=="female")
{}
else{exit();}
$country=addslashes(strip_tags($_POST['country']));
$year=addslashes(strip_tags($_POST['y']));
$month=addslashes(strip_tags($_POST['m']));
$day=addslashes(strip_tags($_POST['d']));
$city=addslashes(strip_tags($_POST['city']));
$about = nl2br(addslashes(strip_tags($_POST['a'])));

if($x_login==1)
{
    
    list($user_email, $user_id) =  split("::", $_SESSION['user'], 2);
    
    include("../dbal.php");
    $dbconn = openconn();
    selectdb();
    
    $now=date("YmdHis");
    $sql = "update userprofiles set fname='$fname',lname='$lname',gender='$gender',dobyear='$year',dobmonth='$month',dobday='$day',about='$about',country='$country',city='$city' where user_id='$user_id' ";
    $qry = mysql_query($sql,$dbconn);
}

?>