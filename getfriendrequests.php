<?php

$sql_gfr = "select * from friendrequests where user_id_to='$user_id' ";
$qry_gfr = exe_qry($sql_gfr,$dbconn);

$fr_num = mysql_num_rows($qry_gfr);

if($fr_num==0)
{
  echo("<p align=\"center\">You have no friend requests</p>");
}
else
{
  $friendreqs = get_qry_array($sql_gfr,$dbconn);
  
  foreach($friendreqs as $friend_req)
    {
      $person_id = $friend_req['user_id_frm'];
      
        $sql_per = "select * from userprofiles where user_id='$person_id' ";
        $qry_per = exe_qry($sql_per,$dbconn);

        $person_ds = get_qry_array($sql_per,$dbconn);

        foreach($person_ds as $person_d)
        {
          $person_name = $person_d['fullname'];
          $person_pic = $person_d['pic'];
        }

        if(($person_pic==NULL) || ($person_pic==""))
        {
          $img_url="images/defaultpic_small.gif";
        }
        else
        {
          $img_url="photos/images-small/".$person_pic;
        }
      ?>
        <div id="frbox_<?php echo($person_id); ?>">
        <table width="100%" id="frbox">
            <tr valign="top">
                <td width="60px">
                    <img src="<?php echo($img_url); ?>" border="0">
                </td>
                <td>        
                    <p>Is <a href="profile.php?id=<?php echo($person_id); ?>"><?php echo($person_name); ?></a> your friend?</p>
                    <p align="center"><a href="javascript:approvefriend(<?php echo($person_id); ?>);" id="boxedlink"><img src="images/thumb_up.gif" border="0">&nbsp;Yes</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:rejectfriend(<?php echo($person_id); ?>);" id="boxedlink"><img src="images/thumb_down.gif" border="0">&nbsp;No</a></p>
                </td>
            </tr>
        </table>
        </div>
      <?php
      
    }
    
    
}

?>