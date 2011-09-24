<?php
    
    include("../protect.php");
  
    if($x_login==1)
    {
        list($user_email, $user_id) =  split("::", $_SESSION['user'], 2);
    }
	    
    include("../ccconfig.php");
    include("../dbal.php");
$error_flag = "0";

if(isset($_GET['id']))
{

$profile_id = $_GET['id'];


$dbconn = openconn();
selectdb();

$sql = "select * from userprofiles where user_id = '$profile_id' ";
$qry = exe_qry($sql, $dbconn);
	
	if(mysql_num_rows($qry)==1)
	{
		while($prf=mysql_fetch_array($qry))
		{
			$fullname = stripslashes($prf['fullname']);
			$fname = stripslashes($prf['fname']);
			$city = stripslashes($prf['city']);
			$about = stripslashes($prf['about']);
			$profile_privacy = $prf['profile_privacy'];
			$gender = $prf['gender'];
			$pic = $prf['pic'];
			$country = $prf['country'];
			$dob_m = $prf['dobmonth'];
			$dob_r = $prf['dobyear'];
			$dob_d = $prf['dobday'];
			$status_msg = $prf['status_msg'];
			list($profile_set, $scribble_set, $photos_set) =  split("::", $profile_privacy, 3);
			$prf_user_id = $prf['user_id'];
		}
		
	}
	else
	{
	$error_flag = "2";
	}

}
else
{

	if(isset($_SESSION['user']))
	{
		//show own profile
		$error_flag = "1";
		
		$dbconn = openconn();
		selectdb();
		
		$sql = "select * from userprofiles where user_id = $user_id ";
		$qry = exe_qry($sql, $dbconn);

		while($prf=mysql_fetch_array($qry))
		{
			$fullname = stripslashes($prf['fullname']);
			$fname = stripslashes($prf['fname']);
			$city = stripslashes($prf['city']);
			$about = stripslashes($prf['about']);
			$profile_privacy = $prf['profile_privacy'];
			$gender = $prf['gender'];
			$pic = $prf['pic'];
			$country = $prf['country'];
			$dob_m = $prf['dobmonth'];
			$dob_r = $prf['dobyear'];
			$dob_d = $prf['dobday'];
			$status_msg = $prf['status_msg'];
			list($profile_set, $scribble_set, $photos_set) =  split("::", $profile_privacy, 3);
			$prf_user_id = $prf['user_id'];
		}
	
	}
	else
	{
	//show error
	$error_flag = "2";
	}

}

if(error_flag=="0")
{
	$sql = "select * from friends where user_id_me='$user_id' and user_id_you='$prf_user_id' ";
	$qry = exe_qry($sql,$dbconn);
	$is_friend = mysql_num_rows($qry);
}
$profile_page = $_GET['p'];

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html lang="en">
<head>
<?php
if($error_flag==2 || ($x_login!="1" && $profile_set=="2"))
{
?>
    <title>Cafecamp &raquo; Page not found</title>
    <link href="profile.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="images/favicon.gif" type="image/x-icon">
<?php
}
else
{
?>
<title><?php echo($fullname); ?> &raquo; Cafecamp</title>
<link rel="shortcut icon" href="images/favicon.gif" type="image/x-icon">
<script src="js/jquery/jquery.js"></script>
<script src="js/customjax.js"></script>
<?php
	if($prf_user_id==$user_id)
	{
	?>
<script src="js/jquery/jquery.dimensions.js"></script>
<script src="js/jquery/ui.mouse.js"></script>
<script src="js/jquery/ui.draggable.js"></script>
<script src="js/jquery/ui.droppable.js"></script>
<script src="js/jquery/ui.sortable.js"></script>

<?php
}
?>
    <!-- Dependencies -->
    <!-- Sam Skin CSS for TabView -->
    <script language="javascript" src="js/fat.js"></script>
    <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.4.1/build/tabview/assets/skins/sam/tabview.css">
    <link href="profile.css" rel="stylesheet" type="text/css">
    
    <script type="text/javascript" src="js/customjax.js"></script>
    <script type="text/javascript" src="server.php?client=all"></script>
    <!-- JavaScript Dependencies for Tabview: -->
    <script type="text/javascript" src="http://yui.yahooapis.com/2.4.1/build/yahoo-dom-event/yahoo-dom-event.js"></script>
    <script type="text/javascript" src="http://yui.yahooapis.com/2.4.1/build/element/element-beta-min.js"></script>
       

    <!-- Source file for TabView -->
    <script type="text/javascript" src="http://yui.yahooapis.com/2.4.1/build/tabview/tabview-min.js"></script>
    <script type="text/javascript">
        var myTabs = new YAHOO.widget.TabView("profile_tabs");
        function togglerspace(objID)
        {
          $(objID).toggle();
        }
    </script>
<?php
}
?>
</head>


<body>
    
    <table class="pagepack" align="center" cellspacing="0">
        <tr><td> 
            <div id="packheader">
                <table class="pageheader" width="100%" cellspacing="0">
                    <tr>
                        <td colspan="3" id="userpanel">
                            <?php  include("../tpls/userpanel.php");  ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="120px">
                            <img src="images/logo.gif" alt="Cafecamp" id="cafecamp_logo">
                        </td>
                        <td id="navlist">
                            <?php  include("../tpls/navlist.php");  ?>
                        </td>
                        <td width="200px">
                            <?php  include("../tpls/searchbox.php");  ?>
                        </td>
                    </tr>
                    <tr><td colspan="3"><div id="pagetitle"><?php if($error_flag==2){echo("Page not found!");}else if($x_login=="0" && $profile_set=="2"){echo("Lon=hin!");} else{echo($fullname);} ?><br>
                     
                    </div>
                    </td></tr>
                </table>
            </div>
            <br>
            
            <?php
            if($error_flag==2)
            {
				 echo("<div id=\"wrongpass\"><p>Ouch! The page you are trying to access doesn't exist.</p></div>");
				 
            }
            else if($x_login=="0" && $profile_set=="2")
					{echo("<div id=\"wrongpass\"><p>Ouch! You need to be logged in to view this page.</p></div>");}
            else
            {
            ?>
            <br>
            <table width="100%">
                 <tr valign="top">
                    <td width="28%">
                        <div id="packbox">
                            
                                <table width="100%">
                                    <tr valign="top">
                                        <td style="text-align:center;">
                                            <?php
                                            
                                            if($pic=="null" || $pic=="")
                                            { ?>
												<div id="theimg"><a href="profile.php?id=<?php echo($prf_user_id); ?>"><img height="125px" width="125px" src="images/defaultpic.gif" border="0"></a></div>
											  <?php
											}
											else
											{ ?>
												<a href="profile.php?id=<?php echo($prf_user_id); ?>"><img height="125px" width="125px" src="photos/cropped/<?php echo($pic); ?>" border="0"></a>
											<?php
											}
											?>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td id="briefinfo">
                                            <table width="100%">
						<tr valign="top"><td><span id="fltitle">Name: </span></td><td><a href="profile.php?id=<?php echo($prf_user_id); ?>"><?php echo($fullname) ?></a></td></tr>
						<tr valign="top"><td><span id="fltitle">Gender: </span></td><td><?php echo($gender) ?></td></tr>
						<tr valign="top"><td><span id="fltitle">City: </span></td><td><?php echo($city) ?></td></tr>
						<tr valign="top"><td><span id="fltitle">Country: </span></td><td><?php echo($country) ?></td></tr>
					    </table>
                                        </td>
                                    </tr>
                                </table>
                                
                            </div>
                        
                  <br>

<table width="100%" id="myoptions" cellspacing="0">
				<?php

				if($prf_user_id==$user_id)
				{
					?>
<tr><td><a href="uploadphoto.php">&nbsp;<img src="images/photo.gif" border="0">&nbsp;Change photo</a></td></tr>
<tr><td><a href="editprofile.php">&nbsp;<img src="images/edit.gif" border="0">&nbsp;Edit profile</a></td></tr>								<?php
				}
				else
				{
				if($is_friend==0)
				{
        ?><tr><td id="addfriend_b"><a href="javascript:addfriend(<?php echo($prf_user_id); ?>);">&nbsp;<img src="images/add.gif" border="0">&nbsp;Add as a friend</a></td></tr><?php
				}
				?><tr><td><div style="padding:5px 0px 0px 0px;"><a href="javascript:ignoreperson(<?php echo($prf_user_id); ?>);">&nbsp;<img src="images/cancel.gif" border="0">&nbsp;Ignore this person</a></div></td></tr>
				<?php
				}
				?>
</table>

		  <br>

                            <div class="yui-skin-sam">
                                <div id="profile_tabs" class="yui-navset">
                                    <ul class="yui-nav">
                                        <li class="selected"><a href="#tab1"><em>Friends</em></a></li>
                                        <li><a href="#tab2"><em>Camps</em></a></li>
                                        <li><a href="#tab2"><em>Applications</em></a></li>
                                    </ul>
                                    <div class="yui-content">
                                       <div id="tabcontent">
                                            <table width="100%" id="friendsbox">

<?php

$sql_flist = "SELECT * FROM friends WHERE user_id_me='$prf_user_id' LIMIT 9 ";
$qry_flist = exe_qry($sql_flist,$dbconn);
$flist_num=mysql_num_rows($qry_flist);
if($flist_num!=0)
{$flist = get_qry_array($sql_flist,$dbconn);}

if($flist_num!=0)
{
$f_var=0;
foreach($flist as $per_friend)
	{
		
		$per_user_id = $per_friend['user_id_you'];
		$sql_pfd="select * from userprofiles where user_id='$per_user_id' ";
		$qry_pfd=exe_qry($sql_pfd,$dbconn);
		$pfd=get_qry_array($sql_pfd,$dbconn);
		foreach($pfd as $f_d)
		{
			$his_pic=$f_d['pic'];
			$thename=stripslashes($f_d['fname']);
			if($his_pic==NULL || $his_pic=="")
			{$his_pic="images/defaultpic_small.gif";}
			else
			{$his_pic="photos/images-small/".$his_pic;}
		}
		
		if($fvar==0 || $fvar==4 || $fvar==7)
		{
			echo("<tr valign=\"top\">");
		}
		?>
		<td width="33%"><img src="<?php echo($his_pic); ?>"><br><a href="profile.php?id=<?php echo($per_user_id); ?>"><?php echo($thename); ?></a></td>
		<?php
		
		if($flist_num<3)
		{
			for($i=0;$i<(3-$flist_num);$i++)
			{ ?>
				<td width="33%"></td>
			<?php }
		}
	
		if($flist_num<6)
		{
			for($i=0;$i<(6-$flist_num);$i++)
			{ ?>
				<td width="33%"></td>
			<?php }
		}

		if($flist_num<9)
		{
			for($i=0;$i<(9-$flist_num);$i++)
			{ ?>
				<td width="33%"></td>
			<?php }
		}

		if($fvar==0 || $fvar==4 || $fvar==7)
		{
			echo("</tr>");
		}
		$fvar++;
		
	}

}
else
{
?>
<tr valign="top">
<p><?php echo($fname); ?> has no friends</p>
</tr>
<?php
}
?>
</table>
 <?php if($flist_num!=0){ ?><p align="right"><a href="friends.php?id=<?php echo($prf_user_id); ?>">more &raquo;</a></p> <?php } ?>
</div>
                                       <div id="tabcontent">
                                            <table width="100%">
                                                <tr valign="top">
                                                    <td><img src="images/campicon_mini.gif"></td>
                                                    <td><a href="#">Web 2.0</a></td>
                                                </tr>
                                                <tr valign="top">
                                                    <td><img src="images/campicon_mini.gif"></td>
                                                    <td><a href="#">Clint Eastwood fanclub</a></td>
                                                </tr>
                                                <tr valign="top">
                                                    <td><img src="images/campicon_mini.gif"></td>
                                                    <td><a href="#">I love Google</a></td>
                                                </tr>
                                                <tr valign="top">
                                                    <td><img src="images/campicon_mini.gif"></td>
                                                    <td><a href="#">Josephites</a></td>
                                                </tr>
                                                <tr valign="top">
                                                    <td><img src="images/campicon_mini.gif"></td>
                                                    <td><a href="#">Bangalore</a></td>
                                                </tr>
                                            </table>
                                            <p align="right"><a href="#">more &raquo;</a></p>    
                                        </div>
                                        <div id="tabcontent">
                          <?php include("getapps.php"); ?>
                                        </div>
                                   </div>
                                </div>
                            </div>
							
					</td>
                    <td>

           <script type="text/javascript">
            function enable_sb()
            {
                HTML_AJAX.replace('rcontent', 'scribbles.php?id=<?php echo($prf_user_id); ?>');
                $('#scribble_link').css("font-weight","bold");
                $('#mypage_link').css("font-weight","normal");
                
            }
    
            function enable_mypage()
            {
                HTML_AJAX.replace('rcontent', 'mypage.php?id=<?php echo($prf_user_id); ?>');
                $('#mypage_link').css("font-weight","bold");
                $('#scribble_link').css("font-weight","normal");                
            }        
           </script>

							<div class="cccustom">
                                <div id="page_tabs" class="yui-navset">
                                <div id="subnav"><a id="mypage_link" href="javascript:enable_mypage();">My Page</a>&nbsp;&nbsp;&nbsp; <a id="scribble_link" href="javascript:enable_sb();">Scribblebook</a></div>   
                                
                                
                                <div id="rcontent"><div style="text-align:center;padding:25px;"><img src="loading-grey.gif"> Loading... </div>
                                </div>
              </div>            <?php if($profile_page=="sb"){ ?> <script type="text/javascript">enable_sb();</script> <?php }else{ ?><script type="text/javascript">enable_mypage();</script> <?php } ?>
                    </td>
                </tr>
            </table>
           <?php } include("../tpls/footer.php"); ?> 
         
         </td></tr>
    </table>
    
</body>
</html>
