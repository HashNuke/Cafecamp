                                            
<?php
echo("<table width=\"100%\">");

$sql_apps_list="select * from myapps where user_id='$prf_user_id' ";
$qry_apps_list=mysql_query($sql_apps_list,$dbconn);
$num_apps=mysql_num_rows($qry_apps_list);

echo("<table width=\"100%\">");
if($num_apps==0)
{
?>

<tr valign="top">
<td><p><?php echo($fname); ?> has not added any apps</p></td>
</tr>

<?php	
}
else
{
	$app_list=get_qry_array($sql_apps_list,$dbconn);

  foreach($app_list as $per_app)
  {
    $app_id = $per_app['app_id'];
    
    $sql_app="select * from appdirectory where app_id='$app_id' ";
    $qry_app = exe_qry($sql_app,$dbconn);
    
    $app_info = get_qry_array($sql_app,$dbconn);
    
        foreach($app_info as $per_app_info)
        {
          $app_name = $per_app_info['app_name'];
          $app_added_by = $per_app_info['added_by'];
          $app_url = "app.php?id=".$app_id."&uid=".$prf_user_id;
        }
        
        if($user_id==$prf_user_id)
        {
        ?>
          <tr valign="top">
              <td width="20px"><img src="images/apps.gif"></td>
              <td><a href="<?php echo($app_url); ?>"><?php echo($app_name); ?></a></td>
          </tr>
        <?php
        }
        else
        {
        ?>
          <tr valign="top">
              <td width="20px"><img src="images/apps.gif"></td>
              <td><a href="<?php echo($app_url); ?>"><?php echo($app_name); ?></a>&nbsp;&nbsp;<a href="appintro.php?id=<?php echo($app_id); ?>" style="font-size:90%;">(add)</a></td>
          </tr>
        <?php
        }
  }
	
}
echo("</table>");
?>
                                            