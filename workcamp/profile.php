<?php
    
    include("../protect.php");
  
    if($x_login==1)
    {
        list($user_email, $user_id, $profile_created) =  split("::", $_SESSION['user'], 3);
    }
    
    include("../ccconfig.php");
    include("../dbal.php");

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
			$fullname = $prf['fullname'];
			$about = $prf['about'];
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
			$fullname = $prf['fullname'];
			$about = $prf['about'];
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
	echo("proflem kid!");
	}

}


?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html lang="en">
<head>
<?php
if($error_flag==2 || ($x_login!="1" && $profile_set=="2"))
{
?>
    <title>Cafecamp.com &raquo; Page not found</title>
    <link href="profile.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="images/favicon.gif" type="image/x-icon">
<?php
}
else
{
?>
<title><?php echo($fullname); ?> &raquo; Cafecamp.com</title>
<link rel="shortcut icon" href="images/favicon.gif" type="image/x-icon">
<?php
	if($prf_user_id==$user_id)
	{
	?>
<script src="js/jquery/jquery.js"></script>    
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
    <link rel="stylesheet" type="text/css" href="http://yui.yahooapis.com/2.4.1/build/tabview/assets/skins/sam/tabview.css">
    <link href="profile.css" rel="stylesheet" type="text/css">
    
    
    <!-- JavaScript Dependencies for Tabview: -->
    <script type="text/javascript" src="http://yui.yahooapis.com/2.4.1/build/yahoo-dom-event/yahoo-dom-event.js"></script>
    <script type="text/javascript" src="http://yui.yahooapis.com/2.4.1/build/element/element-beta-min.js"></script>
	

    <!-- Source file for TabView -->
    <script type="text/javascript" src="http://yui.yahooapis.com/2.4.1/build/tabview/tabview-min.js"></script>

    <script type="text/javascript">
        var myTabs = new YAHOO.widget.TabView("profile_tabs");
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
                    <tr><td colspan="3"><div id="pagetitle"><?php if($error_flag==2){echo("Page not found!");}else if($x_login=="0" && $profile_set=="2"){echo("Page not found!");} else{echo($fullname);} ?><br>
                     
                    </div>
                    </td></tr>
                </table>
            </div>
            <br>
            <?php if($error_flag==2){}else{ ?> <div id="prfnav"><a href="about.php?id=<?php echo($prf_user_id); ?>"><img src="images/page_user.gif" border="0">&nbsp;&nbsp;About</a>&nbsp;&nbsp;<a href="scribblebook.php?id=<?php echo($prf_user_id); ?>"><img src="images/scribblebook.gif" border="0">&nbsp;&nbsp;ScribbleBook</a></div><?php } ?>
            <?php
            if($error_flag==2)
            {
				 echo("<div id=\"wrongpass\"><p>Ouch! The page you are trying to access doesn't exist.</p></div>");
				 
            }
            else if($x_login=="0" && $profile_set=="2")
					{echo("<div id=\"wrongpass\"><p>Ouch! The page you are trying to access doesn't exist.</p></div>");}
            else
            {
            ?>
            <br>
            <table width="100%">
                 <tr valign="top">
                    <td width="28%">
                        <div id="packbox">
                            <div class="box">
                                <table width="100%">
                                    <tr valign="center">
                                        <td width="105px">
                                            <?php
                                            if($pic=="null" || $pic=="")
                                            { ?>
												<div id="theimg"><a href=profile.php?id=<?php echo($prf_user_id); ?>><img height="100px" width="100px" src="images/defaultpic.gif" border="0"></a></div>
											  <?php
											}
											else
											{ ?>
												<a href=profile.php?id=<?php echo($prf_user_id); ?>><img height="100px" width="100px" src="userphotos/big/<?php echo($pic); ?>" border="0"></a>
											<?php
											}
											?>
                                        </td>
                                        <td>
											<div style="width:100px;height:100px;overflow-x:hidden;overflow-y:hidden;">
												
														<?php
														if($x_login)
														{
														?>
															<img src="images/star.gif">
														<?php } ?>
											</div>
                                        </td>
                                        </tr>
                                        <tr>
                                        <td id="briefinfo" colspan="2">
                                            <table width="100%">
												<tr valign="top"><td><span id="fltitle">Name: </span></td><td><?php echo($fullname) ?></td></tr>
												<tr valign="top"><td><span id="fltitle">Gender: </span></td><td><?php echo($gender) ?></td></tr>
												<tr valign="top"><td><span id="fltitle">City: </span></td><td><?php echo($city) ?></td></tr>
												<tr valign="top"><td><span id="fltitle">Country: </span></td><td><?php echo($country) ?></td></tr>
											</table>
                                        </td>
                                    </tr>
                                </table>
                                
                            </div>
                        </div>
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
                                                <tr valign="top">
                                                    <td width="33%"><img src="images/defaultpic_small.gif"><br><a href="#">Benson</a></td>
                                                    <td width="33%"><img src="images/defaultpic_small.gif"><br><a href="#">Joseph</a></td>
                                                    <td width="33%"><img src="images/defaultpic_small.gif"><br><a href="#">Vishnu</a></td>
                                                </tr>
                                                <tr valign="top">
                                                    <td width="33%"><img src="images/defaultpic_small.gif"><br><a href="#">Kumar</a></td>
                                                    <td width="33%"><img src="images/defaultpic_small.gif"><br><a href="#">Ramjee</a></td>
                                                    <td width="33%"><img src="images/defaultpic_small.gif"><br><a href="#">Atul</a></td>
                                                </tr>
                                                <tr valign="top">
                                                    <td width="33%"><img src="images/defaultpic_small.gif"><br><a href="#">Prabhu</a></td>
                                                    <td width="33%"><img src="images/defaultpic_small.gif"><br><a href="#">Ram</a></td>
                                                    <td width="33%"><img src="images/defaultpic_small.gif"><br><a href="#">Sai</a></td>
                                                </tr>
                                             </table>
                                             <p align="right"><a href="#">more &raquo;</a></p>
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
                                            <table width="100%">
                                                <tr valign="top">
                                                    <td><img src="images/campicon_mini.gif"></td>
                                                    <td><a href="#">Tetris Game</a></td>
                                                </tr>
                                                <tr valign="top">
                                                    <td><img src="images/campicon_mini.gif"></td>
                                                    <td><a href="#">Photos</a></td>
                                                </tr>
                                                <tr valign="top">
                                                    <td><img src="images/campicon_mini.gif"></td>
                                                    <td><a href="#">Videos</a></td>
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
                                   </div>
                                </div>
                            </div>
							
					</td>
                    <td>
						                      
                        
          <ul id="appcol">
              <?php if($prf_user_id==$user_id){ ?><li><div id="appout"><div id="ddhelp">Drag n drop apps above or below this box</div></div></li><?php } ?>
							<li>
								<div id="appout">
								<div id="appdiv">
								<table width="100%" id="apptitle">
									<tr valign="top">
										<td width="95%">
											<div>About</div>
										</td>
										<td>
											<?php
												if($prf_user_id==$user_id)
												{
												?>
												<div id="appsettings"><img src="images/settings.gif" alt="settings" border="0"></div>
												<?php
												}
												else
												{
												?>
												<a href="#"><img src="images/addapp.gif" alt="add app" border="0"></a><?php } ?>
										</td>
									</tr>
									<?php
												if($prf_user_id==$user_id)
												{ ?><tr><td colspan="2"><div id="appsetdock">User Preferences: <input type="text"><br><div style="text-align: center;"></div></div></td></tr> <?php } ?>
								</table>
								<div id="appct">Hi everyone!<br>'Mr.Programming Freak'... thats a quick one-phrase summary of me. I love programming. Learning new languages. And also like to work on User Interface Design. Hmmm... just waiting for the next Google Summer of Code 2008 registrations to openup. I Going In :)
								I love talking to my friends(I probably might not need any food when I do so).....<br> If you just dropped in here then dont miss scrapping me.....I love reading them.
								</div>
									<div style="text-align:right;"><a href="<?php echo(BASE_SITEURL); ?>profile.php?id=<?php echo($prf_user_id);?>&show=about" id="morelink">more&nbsp;&raquo;</a></div>
								</div>
								</div>
							</li>
							<li>
								<div id="appout">
								<div id="appdiv">
								<table width="100%" id="apptitle"><tr valign="top"><td width="95%"><div>App2</div></td><td><?php if($prf_user_id==$user_id){ ?><a href="#"><img src="images/settings.gif" alt="settings" border="0"></a><?php }else{ ?><a href="#"><img src="images/addapp.gif" alt="add app" border="0"></a><?php } ?></td></tr></table>
								<div id="appct">
									so here goes app1 content
							
								</div>
									<div style="text-align:right;"><a href="<?php echo(BASE_SITEURL); ?>profile.php?id=<?php echo($profile_id);?>&show=about" id="morelink">more&nbsp;&raquo;</a></div>
								</div>
								</div>
							</li>
					</ul>
                        
 

<?php
if($prf_user_id==$user_id)
{
?>                        
<script language="javascript">
$("#appcol").sortable({ revert: true, handle: '#apptitle', containment: 'document', placeholder: 'appholder' });


$(document).ready(function(){

$("#appsettings").click(function () {
  $("#appsetdock").slideToggle("fast");
});

});
$("#appsetdock").slideToggle("fast");
</script>

<?php
}
?>                        
		
                    </td>
                </tr>
            </table>
           <?php } include("../tpls/footer.php"); ?> 
        </td></tr>
    </table>
    
</body>
</html>
