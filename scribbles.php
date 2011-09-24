<?php

	include("../protect.php");
  echo("<div id=\"scribble_box\">");

	if($x_login=="1")
	{
	/** start of ajax page **/
	include("Date.php");
      function format_tstamp($tstamp)
        {
         
        $tzone=$_COOKIE['tzoffset'];
        $year=substr($tstamp,0,4);
        $mon=substr($tstamp,4,2);
        $day=substr($tstamp,6,2);
        $hour=substr($tstamp,8,2);
        $min=substr($tstamp,10,2);
        $sec=substr($tstamp,12,2);
        
	$d = new Date($year."-".$mon."-".$day." ".$hour.":".$min.":".$sec);	
	$d->setTZByID("America/Anguilla");
	$d->convertTZByID($tzone);

	$tstamp = $d->format("%A, %d %B %Y %r");
        /** $tstamp=date("l F dS, Y h:i:s A",mktime($hour,$min,$sec,$mon,$day,$year)); **/
                
        return $tstamp;
        
        }
	
    list($user_email, $user_id) =  split("::", $_SESSION['user'], 2);
    include("../ccconfig.php");
    
    require_once 'Pager.php';
    require_once 'mdb2/MDB2.php';
    
    $prf_user_id = $_GET['id'];
    
?>

    

<div style="text-align:center;"><textarea id="rbox" cols="40" rows="5"></textarea></div>
<div id="scribblelink"><a href="javascript:sendscribbledirect(<?php echo($prf_user_id); ?>, '#rbox');">Scribble!</a></div><br>
<div style="border-bottom:1px dashed #cccccc;"></div>

<?php    
  $sr_qry_num = "SELECT COUNT(*) FROM scribblebook WHERE user_id='$prf_user_id' ";

  $sr_qry = "SELECT * FROM scribblebook WHERE user_id='$prf_user_id' ORDER BY scribble_date DESC ";

  $dsn = "mysql://".THEDBUSER.":".THEDBPASS."@".THEDBHOST."/".THEDB;
  $options = array(
    'debug' => 2,
    'result_buffering' => false,
  );

$db =& MDB2::factory($dsn, $options);


$num_products = $db->queryOne($sr_qry_num);
$scrib_num = $num_products;
$thefileurl = "javascript:HTML_AJAX.replace('rcontent','scribbles.php?id=".$prf_user_id."&pageID=%d');";
$pager_options = array(
'mode'     => 'Sliding',
    'append'   => false,  //don't append the GET parameters to the url
    'path'     => '',
    'fileName' => $thefileurl,  //Pager replaces "%d" with the page number...
    'perPage'  => 10, //show 10 items per page
    'delta'    => 1,
    'totalItems'=> $num_products,
);

	
$pager = Pager::factory($pager_options);

//then we fetch the relevant records for the current page
list($from, $to) = $pager->getOffsetByPageId();

$db->setLimit($pager_options['perPage'], $from - 1);
$sr_results = $db->queryAll($sr_qry, null, MDB2_FETCHMODE_ASSOC);

?>
<div style="text-align:right;">
<b><?php echo($scrib_num); ?> scribbles</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo ($pager->links); ?>
</div><br>
<?php
        
foreach ($sr_results as $sr_result)
      {

        $scribble_id = $sr_result['scribble_id'];
        $scribble_by = $sr_result['scribble_by'];
        $scribble_date = $sr_result['scribble_date'];
        $scribble_text = stripslashes($sr_result['scribble_text']);
        
        $dbconn = mysql_connect(THEDBHOST, THEDBUSER, THEDBPASS);
        mysql_select_db(THEDB);
        $cs_sql="select * from userprofiles where user_id='$scribble_by' ";
        $cs_qry = mysql_query($cs_sql,$dbconn) or die(mysql_error());
        
        while($row = mysql_fetch_array($cs_qry)) 
               {
                  $scribble_by_pic = $row['pic'];
                  $scribble_by_name = stripslashes($row['fname']);
               }
        
        if($scribble_by_pic=="null" || $scribble_by_pic=="")
          {
            $scribble_by_pic="images/defaultpic_small.gif";
          }
          else
          {
            $scribble_by_pic="photos/images-small/".$scribble_by_pic;
          }
        
        ?>
          <div id="scribblebox_<?php echo($scribble_id); ?>">
          <table width="100%" id="scribblebox" cellpadding="0">
          <tr valign="top">
          <td id="scribbleinfo" width="15%">
          <img src="<?php echo($scribble_by_pic); ?>" id="scribblepic"><br><a href="profile.php?id=<?php echo($scribble_by); ?>"><?php echo($scribble_by_name); ?></a>
          </td>
          <td id="scribblecontent"><div id="scribbletime"><?php echo(format_tstamp($scribble_date)); ?> &nbsp;&nbsp;<?php
          if($prf_user_id==$user_id){
          ?><a href="javascript:deletescribble(<?php echo($scribble_id); ?>);">Delete</a><?php } ?> </div>
          <div id="scribbletext"><?php echo($scribble_text); ?></div>
          <?php
          if($prf_user_id==$user_id){
          ?>
          <div id="replyspace"><a href="javascript:togglerspace('#replyarea_<?php echo($scribble_id); ?>');">[+] Reply</a>
          <div id="sc_msg_<?php echo($scribble_id); ?>"></div>
          <div id="replyarea_<?php echo($scribble_id); ?>">
          
          <div style="text-align:center;"><textarea id="rbox_<?php echo($scribble_id); ?>" cols="40" rows="5"></textarea></div>
          <script type="text/javascript">togglerspace('#replyarea_<?php echo($scribble_id); ?>');</script>
          <br><div id="scribblelink"><a href="javascript:sendscribble(<?php echo($scribble_by); ?>, '#rbox_<?php echo($scribble_id); ?>', '#replyarea_<?php echo($scribble_id); ?>','sc_msg_<?php echo($scribble_id); ?>');">Scribble!</a></div>
          </div>
          </div>
          <?php } ?>
          </td>
          </tr>
          </table>
          </div>
          <br>
        <?php       
        
      }
echo("</div>");
?>
<p align="center"><?php echo ($pager->links); ?></p>
    
 
<?php    
   /** end of ajax **/
}
?>
