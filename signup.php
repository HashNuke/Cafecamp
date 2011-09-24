<?php

include("../common_process.php");
if($x_login==1)
    {
        echo("<META HTTP-EQUIV=\"Refresh\" CONTENT=\"0; URL=profile.php\">");
        exit();
    }
    
require('../imp_scripts/php-captcha.inc.php');

   
    function write_signup_form($msg)
    {
        ?>
        <div>Just fill in the form below. You will receive a mail at the email address you enter below. Click the link in the email to validate the email address and you are done!</div>
        <hr color="#eeeeee">
        <?php
        if(!empty($msg))
        {
        ?>
        <div id="wrongpass"><?php echo($msg); ?></div>
        <?php
        }
        ?>
        <form method="post" action="signup.php">
        <br><br>
        <div id="boxtitle" style="border-bottom:1px dashed #cccccc;">Account Details</div>    
        <p><label>Email<span style="color:#ff0000;">*</span><br><input type="text" name="email" id="bigtext"> <span id="gsnippet">ex: kevin@somewhere.com</span></p>
        <p><label>Password<span style="color:#ff0000;">*</span><br><input type="password" name="pword" id="bigtext"> <span id="gsnippet">minimum of 8 characters</span></p>
        <p><label>Re-type your password<br><input type="password" name="rpword" id="bigtext"> <span id="gsnippet"></span></p>
        <br>
        <div id="boxtitle" style="border-bottom:1px dashed #cccccc;">Fillup the below fields for your profile. You can fillup the rest after you login</div>     
        <p><label>First name<span style="color:#ff0000;">*</span><br><input type="text" name="fname" id="bigtext"></label></p>
                        <p><label>Last name<br><input type="text" name="lname" id="bigtext"></label></p>
                        <p><label>City<br><input type="text" name="city" id="bigtext"></label></p>
                        <p>
                            <label>
                            Country<span style="color:#ff0000;">*</span><br>
                            <select name="country">
                                <option value="default">--Select--</option>
                                <?php
                                include('../ccconfig.php');
                                                                
                                $dbconn=openconn();
                                selectdb();
                                $qry="select * from countries ORDER BY id";
                                $do_qry = exe_qry($qry,$dbconn);
                                
                                $countries=get_qry_array($qry,$dbconn);
                                var_dump($countries);
                                foreach ($countries as $country)	
                                  {
                                      echo("<option>".$country['value']."</option>");
                                  }
                                ?>
                            </select>
                            </label>
                        </p>
                        <p><label>Gender<span style="color:#ff0000;">*</span><br><select name="gender"><option>male</option><option>female</option></select></label></p> 
				
						<p>
                            Date of Birth<span style="color:#ff0000;">*</span><br>
    							<select name="year">
									<option value="default">--Year--</option>
									<option>1997</option> 
									<option>1996</option> 
									<option>1995</option> 
									<option>1994</option> 
									<option>1993</option> 
									<option>1992</option> 
									<option>1991</option> 
									<option>1990</option> 
									<option>1989</option> 
									<option>1988</option> 
									<option>1987</option> 
									<option>1986</option> 
									<option>1985</option> 
									<option>1984</option> 
									<option>1983</option> 
									<option>1982</option> 
									<option>1981</option> 
									<option>1980</option> 
									<option>1979</option> 
									<option>1978</option> 
									<option>1977</option> 
									<option>1976</option> 
									<option>1975</option> 
									<option>1974</option> 
									<option>1973</option> 
									<option>1972</option> 
									<option>1971</option> 
									<option>1970</option> 
									<option>1969</option> 
									<option>1968</option> 
									<option>1967</option> 
									<option>1966</option> 
									<option>1965</option> 
									<option>1964</option> 
									<option>1963</option> 
									<option>1962</option> 
									<option>1961</option> 
									<option>1960</option> 
									<option>1959</option> 
									<option>1958</option> 
									<option>1957</option> 
									<option>1956</option> 
									<option>1955</option> 
									<option>1954</option> 
									<option>1953</option> 
									<option>1952</option> 
									<option>1951</option> 
									<option>1950</option> 
									<option>1949</option> 
									<option>1948</option> 
									<option>1947</option> 
									<option>1946</option> 
									<option>1945</option> 
									<option>1944</option> 
									<option>1943</option> 
									<option>1942</option> 
									<option>1941</option> 
									<option>1940</option> 
									<option>1939</option> 
									<option>1938</option> 
									<option>1937</option> 
									<option>1936</option> 
									<option>1935</option> 
									<option>1934</option> 
									<option>1933</option> 
									<option>1932</option> 
									<option>1931</option> 
									<option>1930</option> 
									<option>1929</option> 
									<option>1928</option> 
									<option>1927</option> 
									<option>1926</option> 
									<option>1925</option>
								</select>
								&nbsp;&nbsp;
								<select name="day">
									<option value="default">--Day--</option>
									<option>1</option>
									<option>2</option>
									<option>3</option>
									<option>4</option>
									<option>5</option>
									<option>6</option>
									<option>7</option>
									<option>8</option>
									<option>9</option>
									<option>10</option>
									<option>11</option>
									<option>12</option>
									<option>13</option>
									<option>14</option>
									<option>15</option>
									<option>16</option>
									<option>17</option>
									<option>18</option>
									<option>19</option>
									<option>20</option>
									<option>21</option>
									<option>22</option>
									<option>23</option>
									<option>24</option>
									<option>25</option>
									<option>26</option>
									<option>27</option>
									<option>28</option>
									<option>29</option>
									<option>30</option>
									<option>31</option>
								</select>
								&nbsp;&nbsp;
								<select name="month">
									<option value="default">--Month--</option>
									<option>January</option>
									<option>February</option>
									<option>March</option>
									<option>April</option>
									<option>May</option>
									<option>June</option>
									<option>July</option>
									<option>August</option>
									<option>September</option>
									<option>October</option>
									<option>November</option>
									<option>December</option>
								</select>
                            </p>
        <br>
        <p align="center">Enter the text as shown in the image. <span id="gsnippet">not case sensitive</span><br>
        <img src="visual-captcha.php" width="200" height="60" alt="Human Test image">
        <br><br><input type="text" name="humantest" id="bigtext">
        </p>
        
        <p class="submit" align="center"><input type="submit" id="submit" name="submit" value="Join Caf&eacute;camp"></p>
        
        </form>
        
        <?php
    }
   
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html lang="en">
<head>
    <title>Caf&eacute;camp &raquo; Signup</title>
    <link href="pagestyle.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="images/favicon.gif" type="image/x-icon">
	<style type="text/css">
        @import "http://o.aolcdn.com/dojo/1.0.0/dijit/themes/tundra/tundra.css";
        @import "http://o.aolcdn.com/dojo/1.0.0/dojo/resources/dojo.css"
    </style>
	  <script type="text/javascript" src="http://o.aolcdn.com/dojo/1.0.0/dojo/dojo.xd.js"
        djConfig="parseOnLoad: true"></script>
        <script type="text/javascript">
       dojo.require("dojo.parser");
       dojo.require("dijit.Tooltip");
     </script>

</head>


<body>
    
    <table class="pagepack" align="center" cellspacing="0">
        <tr><td> 
            <div id="packheader">
                <table class="pageheader" width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td colspan="3" id="userpanel">
                            &nbsp;
                        </td>
                    </tr>
                    <tr>
                        <td width="120px">
                            <a href="<?php echo(BASE_SITEURL); ?>index.php"><img src="images/logo.gif" alt="Cafecamp" id="cafecamp_logo" border="0"></a>
                        </td>
                        <td id="navlist">
                            <a href="<?php echo(BASE_SITEURL); ?>index.php">Login</a>
                        </td>
                        <td width="200px">
                            
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3">
                            <div id="pagetitle">Signup</div>
                        </td>
                    </tr>
                </table>
            </div>
            
            <table width="100%">
                <tr valign="top">
                    <td width="100%">
                        <div id="packbox">
                            <div class="box">
                                
                                <div style="padding:20px 20px 20px 20px;">
   
<?php

/***********************************************/
/**********  START OF FORM GENERATION  *********/
/***********************************************/

if($signupgate=="open")
{

if( ($_POST) && PhpCaptcha::Validate($_POST['humantest']) )
{
    
    include("../imp_scripts/email_validate.php");
    $post_email = $_POST['email'];
    
    $city_text = $_POST['city'];
	$city = addslashes($city_text);
	$fname_text = $_POST['fname'];
	$fname = addslashes($fname_text);
	$lname_text = $_POST['lname'];
	$lname = addslashes($lname_text);
	$gender = $_POST['gender'];
	$year = $_POST['year'];
	$day = $_POST['day'];
	$month = $_POST['month'];
	
	$isLeap = (bool)date( 'L', strtotime( 'January 1, '.$year ) );
	$errorf="0";
	$themsg="";

    if (!validEmail($post_email))
    {
        $thsmsg.= "Please enter a valid email address<br>";
		$errorf=1;
    }
    
    if((empty($_POST['pword'])) || (empty($_POST['rpword'])) || ($_POST['pword']!=$_POST['rpword']))
    {
		$themsg.= "Your passwords didn't match!<br>";
        $errorf=1;
    }
						
                        
    if(trim($_POST['fname'])=="")
	{
		$errorf="1";
		$themsg.="You need a name to call yourself<br>";
	}
	
	if(($_POST['year']=="default") || ($_POST['date']=="default") || ($_POST['month']=="default") || (($isLeap==false) && ($month=="February") && ($day>28)))
	{
		$themsg.="Please select a valid date for your date of birth<br>";
		$errorf="1";
	}
	
	if($_POST['country']=="default")
	{
		$themsg.="Please select your country<br>";
		$errorf="1";
	}
	

	if($errorf=="0")
	{

            $dbconn = openconn();
            selectdb();
            $qry = "SELECT * FROM useraccounts WHERE email = '$post_email' ";
            $do_qry=mysql_query($qry,$dbconn);
            
            if(mysql_num_rows($do_qry) == "1")
                {
                    $themsg.= "The email address you entered is already related to an account. If it's yours you can login <a href=\"index.php\">here</a><br>";
					$errorf=1;
                }
                
		   $sendto=$post_email;
		   $thepass=$_POST['pword'];
    	   $thecryptopass=md5($thepass);
				 
			/* generate unique string */
			
			$CharPool=array('1','2','3','4','7','8','9','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
			$PoolLength = count($CharPool) - 1;
			$special_string="";
			
			for ($i = '0'; $i < '29'; $i++)
			 {
			  $special_string.= $CharPool[mt_rand('0', $PoolLength)];
			 }
			
			/* end of unique string generation */

			$theverifylink="http://www.cafecamp.com/activate.php?id=".$special_string."&amp;email=".$sendto;
			$qry = "insert into signups(user_email,user_password,unique_key,fname,lname,city,country,gender,day,month,year) values('$sendto','$thecryptopass','$special_string','$fname','$lname','$city','$country','$gender','$day','$month','$year')";
			$do_qry2=exe_qry($qry,$dbconn);
		
				/* PHP Mailer code*/
				require("../imp_scripts/phpmailer/class.phpmailer.php");

				$mail = new PHPMailer();
				
				$mail->IsSMTP();                                      // set mailer to use SMTP
				$mail->Host = "cafecamp.com;mail@cafecamp.com";  // specify main and backup server
				$mail->SMTPAuth = true;     // turn on SMTP authentication
				$mail->Username = "jcafecam";  // SMTP username
				$mail->Password = "some_password"; // SMTP password
				
				$mail->From = "accounts@cafecamp.com";
				$mail->FromName = "Cafecamp.com";
				$mail->AddAddress($sendto);
				$mail->AddReplyTo("noreply@cafecamp.com", "No Reply");
				
				$mail->WordWrap = '50';                                 // set word wrap to 50 characters
				$mail->IsHTML('true');                                  // set email format to HTML
				
				$mail->Subject = "Cafecamp.com verification email";
				
				$mail->Body    = "
				<p>Dear user,</p>
				<p>Welcome to Cafecamp.com. Click on the below link to proceed to the email verification page.</p>
				<br>
				<p align=\"center\" style=\"padding:5px 5px 5px 5px;background:#eeeeee;border:1px solid #cccccc;\"><a href=\"$theverifylink\">".$theverifylink."</a>
				</p>
				
				<p><br>
				Your username/email: <b>".$sendto."</b><br>Your password: <b>".$thepass."</b>
				</p>
				
				<p>
				--<br>
				Have a nice camping season<br>
				Cafecamp.com Team
				</p>
				";
				
				$mail->AltBody = "
				Dear user, Welcome to Cafecamp. Copy the link and paste it in your web browser's address bar to verify your email address. ".$theverifylink;
				
				/* END PHP MAILER CODE */
			
                    if((!$do_qry2) || (!$mail->Send()))
                    {
                        echo("<div id=\"wrongpass\">Oops!<br><p>The server has acted in an unexpected way. We will hopefully be back in a few moments. Please try again.</p></div>");
                    }
                    else
                    {
                        echo("<div id=\"greenbox\"><h2>Verification Email sent!</h2><p>An email was sent to ".$sendto." <br>Click the link in the email address to verify your email and you are done!</p></div>");
                    }
                
			}
			else
			{
				write_signup_form($themsg);
			}

}
else
{
write_signup_form("");    
}

}
else
{
?>
<div>
<h2>Sorry!</h2>
Site's not fully launched yet! So signups are currently closed. 

</div>
<?php    
}
/*********************************************/
/***********  END OF FORM PROCESSOR  *********/
/*********************************************/
?>
                                
                                </div>   
                            </div>
                        </div>
                        
                            
                    </td>
                    
                </tr>
            </table>
                        <?php include("../tpls/footer.php"); ?>
        </td></tr>
    </table>
</body>
</html>
