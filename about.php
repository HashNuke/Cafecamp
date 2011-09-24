<?php
  
	include("../protect.php");
  
    if($x_login==1)
    {
        list($user_email, $user_id, $profile_created) =  split("::", $_SESSION['user'], 3);
    }
        

include("../ccconfig.php");

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html lang="en">
<head>
    <title>Caf&eacute;camp &raquo; About</title>
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
                    <tr><td colspan="3"><div id="pagetitle">About Caf&eacute;camp</div></td></tr>
                </table>
            </div>
            
            <table width="100%">
                <tr valign="top">
                    <td>
						<div id="packbox">
						<div class="box">
                    
						<h2>How and Where?</h2><hr>	
						<p>
						Caf&eacute;camp is a social tool that enables you to <i>create, discover and share stuff</i> with people around you in simple way <i>as simple as bread and butter</i>.
						</p>	
													
						<h2>The story in its simplest form</h2><hr>	
						<p>
						All this started of as a hobby site on Akash Xavier's computer. It took time and as time passed, took shape. Thats what you see today - Caf&eacute;camp.
					  </p>	
								
						<h2>What's different?</h2><hr>	
						<p>
						The site's concept and design is based on <a href="http://en.wikipedia.org/wiki/Maslows_hierarchy_of_needs">Maslow's Hierarchy of Needs</a>. The concept and design is also based on a lot of research data from various sources like the Google-sponsored <a href="http://hcii.cmu.edu/M-HCI/2006/SocialstreamProject/index.php">SocialStream project</a>, user feedback, etc.
						These data were mashed up to create the fundamental values for Caf&eacute;camp:
						<ul>
              <li><u>Socialised content sharing:</u> People want to be able share content. Not just content created in one place, but also content that reside in other places (ex: a Flickr album, a WordPress blog, Tags from Del.icio.us).</li>
              <li><u>Less cluttered data:</u> People also want to read data added by others, but want the social data to be presented to them in such a way, that a quick-look would be enough.</li>
              <li><u>Present only selected data:</u> People want to control the content they view or socialise.</li>
              <li><u>Ease of use:</u> And be able to perform the above actions with ease. No one likes an interface that makes the to 'search and peck' at a link.</li>
						</ul>
					  </p>	
						
						<h2>What are we upto next?</h2><hr>	
						<p>
						There's a lot of things we like to do here at Caf&eacute;camp, but for a while we would just like to enjoy camping here before we get back to work. We plan to push the button on a new feature every now and then. For updates on what we are currently upto, visit the MainCamp.
					  </p>	
							
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