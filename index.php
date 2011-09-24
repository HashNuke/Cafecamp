<?php

$x=0;
function verify()
{

	// check to see if they're already logged in

	if (isset($_SESSION['user']) && isset($_COOKIE['userid']))
	return true;

	
	// check to see if visitor has just tried to log on

   if(isset($_POST['u_name'])&&(isset($_POST['u_password'])))
    {
      $u_name=$_POST['u_name'];
      $u_password=md5($_POST['u_password']);

      // validate username and password

     include('../ccconfig.php');
     include('../dbal.php');

	$conn=openconn();

	selectdb();

     $sql="Select * from useraccounts where email=\"$u_name\" and password=\"$u_password\" ";
     $qry=mysql_query($sql,$conn);
     $fetchqry=mysql_fetch_array($qry);
     
   
     if($u_password==$fetchqry['password'])
      {
      $user_ID = $fetchqry['user_id'];
      $_SESSION['user']=$fetchqry['email']."::".$fetchqry['user_id'];
      setcookie("userid", $user_ID, time()+(3600*24*365), "/", ".cafecamp.com", 0);
      return true;
      }
      else
      {
      /*****************************************/
      /********  BAD PASSWORD ERROR PAGE  ******/
      /*****************************************/
      
      ?> 

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html lang="en">
<head>
    <title>Caf&eacute;camp &raquo; Welcome</title>
    <link href="pagestyle.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="images/favicon.gif" type="image/x-icon">
<script type="text/javascript" src="js/timezone.js"></script>
    
</head>


<body>
    
    <table class="pagepack" align="center">
        <tr><td> 
            <div id="packheader">
                <table class="pageheader" width="100%" cellspacing="0">
                    <tr>
                        <td colspan="3" id="userpanel">
                            <br>
                        </td>
                    </tr>
                    <tr>
                        <td width="120px">
                            <a href="<?php echo(BASE_SITEURL); ?>"><img src="../images/cafecamp-logo.gif" alt="Cafecamp" id="cafecamp_logo" border="0"></a>
                        </td>
                        <td id="navlist">
                            <p align="center" style="font-family:serif;"></p>
                        </td>
                        <td width="200px">
                            
                        </td>
                    </tr>
                </table>
            </div>
            <br>
            
            <table width="100%" id="contentbox">
				<tr valign="top">
					<td width="80%">
						
							<table width="100%">
                                                            <tr valign="center">
                                                                    <td>
                                                                            
                                                                            <div id="greenbox" style="padding:10px 10px 10px 10px;">
                                                                                    <p style="font-size:15px;font-weight:bold;">launching soon...</p>
                                                                                    <p align="center" style="font-size:25px;font-weight:bold;color:#87ADDA;">Just askin'&nbsp;<span style="font-size:50px;font-weight:bold;">Howdy?</span></p>
                                                                                    <br>
                                                                                    
                                                                            </div>
                                                                            
                                                                    </td>
                                                            </tr>
                                                    </table>
					</td>
					<td>
						<form method="post" action="index.php">
							<div id="packbox">
								<div class="box" style="padding:5px;">
									<div id="loginlabel"><img src="../images/login.gif">&nbsp;Login</div>
									<div id="wrongpass">Oops!<br> Verify your username and password</div>
									<p><label>Email<br><input type="text" name="u_name" id="bigtext"></label></p>
									<p><label>Password<br><input type="password" name="u_password" id="bigtext"></label></p>
									<p class="submit" align="center"><input type="submit" id="submit" name="submit" value="Get me in!"></p>
									<p align="center"><a href="forgotpassword.php">Forgot Password?</a></p>
								</div>
							</div>
						</form>
					
					</td>
				</tr>
            </table>
            <br>
            
                <div id="packbox">
                            <div class="box" style="padding:5px 5px 5px 5px;">
                                <p align="right" style="color:#555555;"><a href="signup.php">Signup</a>&nbsp; &nbsp; <b>Caf&eacute;camp&nbsp;&copy;&nbsp;2008</b></p>
                            </div>
                </div>
      
      </td></tr>
      </table>
      
</body>
</html>

 
<?php 
 
	  /************************************************/
      /********  END OF BAD PASSWORD ERROR PAGE  ******/
      /************************************************/
exit(); 
      }
     }
     
}

session_start();

if(isset($_GET['logout']))
if ($_GET['logout'])
{

session_unregister( "user" );
session_destroy();
setcookie("userid", $user_ID, time()-3600, "/", ".cafecamp.com", 0);

}


if(!verify())
{
$x=0;
include("../tpls/loginpage.php");
exit();
}
else{
$x=1;
$x_login=1;
include("../tpls/dashboard.php");
exit();
}

?>