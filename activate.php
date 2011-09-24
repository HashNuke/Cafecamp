<?php
include("../common_process.php");

if($x_login==1)
{
header("location:index.php");
}

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html lang="en">
<head>
    <title>Caf&eacute;camp &raquo; Account Activation</title>
    <link href="pagestyle.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
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
                            <div id="pagetitle">Account Activation</div>
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
                                        
                                        if($_GET)
                                        {
                                            $key = $_GET['id'];
                                            $email = $_GET['email'];
                                            
                                            include_once("../dbal.php");
                                            
                                            $dbconn = openconn();
                                            selectdb();
                                            
                                            $qry="select * from signups where user_email='$email' and unique_key='$key' ";
                                            $do_qry=exe_qry($qry,$dbconn);
                                            
                                            if(get_rows($do_qry) == "1")
                                            {
                                                $now=date("YmdHis");
                                                $thedetails = get_qry_array($qry,$dbconn);
                                                
                                                foreach ($thedetails as $thedetail)
                                                {
                                                    $email=$thedetail['user_email'];
                                                    $password=$thedetail['user_password'];
                                                }
                                                
                                                $qry_t="select * from useraccounts where email='$email' ";
                                                $do_qry_t=exe_qry($qry_t,$dbconn);
                                                
                                                if(get_rows($do_qry_t) == "0")
                                                {
                                                
                                                    $qry2="insert into useraccounts(email,password,jdate) values('$email','$password','$now') ";
                                                    $do_qry2=exe_qry($qry2,$dbconn);
                                                
                                                    $qry3="delete from signups where user_email = '$email' ";
                                                    $do_qry3=exe_qry($qry3,$dbconn);
                                                
                                                    if($do_qry2)
                                                    {
                                                        echo("<div id=\"greenbox\"><h2>Yipee!</h2><br>Your account has been verified and activated. You can now <a href=\"index.php\">login here</a></div>");
                                                    }
                                                }
                                                else
                                                {
                                                    echo("<div id=\"wrongpass\">Ouch!<br>This email address is already in use or this account has already been activated.<br>If you feel anything was wrong, you can <a href=\"signup.php\">signup here</a>!</div>");    
                                                }
                                              
                                            }
                                            else
                                            {
                                                echo("<div id=\"wrongpass\">Ouch!<br>Please verify the link you clicked. <br>If you feel anything was wrong, you can <a href=\"signup.php\">signup here</a>!</div>");
                                            }
                                        }
                                        else
                                        {
                                            echo("<div id=\"wrongpass\">Ouch!<br>Please use a valid link to activate your account. The link is in the email sent to you after your signup.<br>If you feel anything was wrong, you can <a href=\"signup.php\">signup here</a>!</div>");
                                        }
                                        
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