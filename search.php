<?php
  
	include("../protect.php");
  
    if($x_login==1)
    {
        list($user_email, $user_id) =  split("::", $_SESSION['user'],2);
    }
    else
    {
        header("location:index.php");
        exit();
    }
    
    include("../ccconfig.php");

require_once 'Pager.php';
require_once 'mdb2/MDB2.php';

if(isset($_GET['q']))
{
$myword=$_GET['q'];
}

if(isset($_POST['q']))
{
$myword = $_POST['q'];
}

$sr_qry_num = "SELECT COUNT(*) FROM userprofiles WHERE fullname LIKE '%$myword%' OR city LIKE '%$myword%' OR country LIKE '%$myword%'  OR country LIKE '%$myword%' ";

$sr_qry = "SELECT * FROM userprofiles WHERE fullname LIKE '%$myword%' OR city LIKE '%$myword%' OR country LIKE '%$myword%'  OR country LIKE '%$myword%' OR about LIKE '%$myword%' ";

$dsn = "mysql://".THEDBUSER.":".THEDBPASS."@".THEDBHOST."/".THEDB;
$options = array(
    'debug' => 2,
    'result_buffering' => false,
);

$db =& MDB2::factory($dsn, $options);


$num_products = $db->queryOne($sr_qry_num);
$pager_options = array(
    'mode'       => 'Sliding',
    'perPage'    => 10,
    'delta'      => 2,
    'totalItems' => $num_products,
);

$pager = Pager::factory($pager_options);

//then we fetch the relevant records for the current page
list($from, $to) = $pager->getOffsetByPageId();

$db->setLimit($pager_options['perPage'], $from - 1);
$sr_results = $db->queryAll($sr_qry, null, MDB2_FETCHMODE_ASSOC);

?>


<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html lang="en">
<head>
    <title>Search &raquo; Caf&eacute;camp</title>
    <link href="pagestyle.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="images/favicon.gif" type="image/x-icon">
    <script language="javascript" type="text/javascript" src="js/tiny_mce/tiny_mce.js"></script>
</head>


<body>
    
    <table class="pagepack" align="center" cellspacing="0">
        <tr><td> 
            <div id="packheader">
                <table class="pageheader" width="100%" cellspacing="0" cellpadding="0">
                    <tr>
                        <td colspan="3" id="userpanel">
                            <?php include("../tpls/userpanel.php");  ?>
                        </td>
                    </tr>
                    <tr>
                        <td width="120px">
                            <a href="<?php echo(BASE_SITEURL); ?>index.php"><img src="images/logo.gif" alt="Cafecamp" id="cafecamp_logo" border="0"></a>
                        </td>
                        <td id="navlist">
                            <?php include("../tpls/navlist.php");  ?>
                        </td>
                        <td width="200px">
                            <?php include("../tpls/searchbox.php"); ?>
                        </td>
                    </tr>
                    <tr><td colspan="3"><div id="pagetitle">Search</div></td></tr>
                </table>
            </div>
            
            <table width="100%">
                <tr valign="top">
                    <td>
						<div id="packbox">
						<div class="box">
                    
						<p align="right"></p>
						
							<?php
							
								foreach ($sr_results as $sr_result)
								 {
								 
									$p_user_id = $sr_result['user_id'];
									$fullname = $sr_result['fullname'];
									$city =  $sr_result['city'];
									$country =  $sr_result['country'];
									$pic =  $sr_result['pic'];
									$gender =  $sr_result['gender'];
									$about = strip_tags($sr_result['about']);
									
									$fullname = str_ireplace($myword, '<b>'. $myword .'</b>', $fullname);
									$city = str_ireplace($myword, '<b>'. $myword .'</b>', $city);
									$country = str_ireplace($myword, '<b>'. $myword .'</b>', $country);
									$about_num = strpos($about, $myword);
									
									$mycity=$city;
									if(trim($mycity)=="")
									{}
									else
									{$city=$city.",";}
									
									if($pic=="null" || $pic=="")
									{
									$pic="images/defaultpic_small.gif";
									}
									else
									{
									$pic="photos/images-small/".$pic;
									}
									?>
									<table width="100%">
										<tr valign="top">
										<td style="width:60px">
										<img src="<?php echo($pic); ?>">
										</td>
										<td>
								   <a href="profile.php?id=<?php echo($p_user_id); ?>"><?php echo($fullname); ?></a>,&nbsp;
										<span id="gsnippet"><?php echo($city); ?>&nbsp;<?php echo($country); ?></span><br><br>
										<?php
										echo("Matches: ");
										if(strpos($fullname, $myword)!=false){ echo("<span id=\"searchmatch\"> <i>Name</i> </span>"); }
										if(strpos($gender, $myword)!=false){ echo("<span id=\"searchmatch\"> <i>Gender</i> </span>"); }
										if(strpos($city, $myword)!=false){ echo("<span id=\"searchmatch\"> <i>City</i> </span>"); }
										if(strpos($country, $myword)!=false){ echo("<span id=\"searchmatch\"> <i>Country</i> </span>"); }
										if(strpos($about, $myword)!=false){ echo("<span id=\"searchmatch\"> <i>About</i> </span>"); }
										?>
										</td>
										</tr>
									</table>
									<br>
									<br>
									
									<?php
									
								}
								?>
													
								<p align="center"><?php echo ($pager->links); ?></p>
							
							
							</div>
							</div>
                    </td>
                 </tr>
            </table>
            <?php
               include("../tpls/footer.php");
            ?>
            
        </td></tr>
    </table>
</body>
</html>