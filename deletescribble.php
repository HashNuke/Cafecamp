<?php

include("../protect.php");
include("../ccconfig.php");

$delete_id = addslashes($_POST['id']);
var_dump($_POST['id']);
if($x_login==1)
{
    echo("logged in");
    list($user_email, $user_id) =  split("::", $_SESSION['user'], 2);
    
    include("../dbal.php");
     
    $dbconn = openconn();
    selectdb();
    
    $sql="select * from scribblebook where scribble_id='$delete_id' ";
    $qry = mysql_query($sql,$dbconn);
    
    if(mysql_num_rows($qry)=="1")
    {
    
      $scribble_d = get_qry_array($sql,$dbconn);
    
      foreach($scribble_d as $scrib_d)
      {
        $s_user_id = $scrib_d['user_id'];
      }
        
    
      if($s_user_id == $user_id)
      {
      echo("yes yours");
      $sql = "DELETE FROM scribblebook where user_id='$user_id' and scribble_id='$delete_id' ";
      $qry = mysql_query($sql,$dbconn);
      }
    }
}

?>