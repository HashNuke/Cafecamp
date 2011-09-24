<?php

include("../protect.php");
include("../ccconfig.php");

$add_fr_id = $_GET['id'];

if($x_login==1)
{    
    list($user_email, $user_id) =  split("::", $_SESSION['user'], 2);
    
    include("../dbal.php");
     
    $dbconn = openconn();
    selectdb();
    
    $sql3 = "select * from userprofiles where user_id='$add_fr_id' ";
    $qry3 = exe_qry($sql3,$dbconn);
    $num3 = mysql_num_rows($qry3);
    if($num3==0){exit();}
   
    $sql_cf = "select * from friends where user_id_me='$user_id' and user_id_you='$add_fr_id' ";
    $qry_cf = exe_qry($sql_cf,$dbconn);
    $num_cf = mysql_num_rows($qry_cf);
    if($num_cf!=0){exit();}
   
    $sql_cfr = "select * from friendrequests where user_id_to='$user_id' and user_id_frm='$add_fr_id' ";
    $qry_cfr = exe_qry($sql_cfr,$dbconn);
    $num_cfr = mysql_num_rows($qry_cfr);
    if($num_cfr==0){exit();}
 
    $person_ds=get_qry_array($sql3,$dbconn);
    foreach($person_ds as $person_d){ $person_name = $person_d['fullname']; }
    
    $sql_in = "INSERT INTO friends (`user_id_me` ,`user_id_you`) VALUES ('$user_id', '$add_fr_id'), ('$add_fr_id', '$user_id') ";
    $qry_in = mysql_query($sql_in,$dbconn);
    
    $sql_del = "delete from friendrequests where user_id_to='$user_id' and user_id_frm='$add_fr_id' ";
    $qry_del = mysql_query($sql_del,$dbconn);
    $theurl="profile.php?id=".$add_fr_id;
    echo("<a href=\"$theurl\">".$person_name."</a> is now your friend! Why not ask 'Howdy'? ");
}

?>