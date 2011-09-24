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
    <title>Caf&eacute;camp &raquo; Developers</title>
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
                    <tr><td colspan="3"><div id="pagetitle">Developers</div></td></tr>
                </table>
            </div>
            
            <table width="100%">
                <tr valign="top">
                    <td><br>
						<div id="packbox">
						<div class="box">
						<br>
							
							<div id="docboxtitle"><a name="top"></a>Contents</div>	
								
								<ul id="contentsindex">
									<li><a href="#intro">Introduction to Caf&eacute;camp Application Platform (CAP)</a></li>
									<li><a href="#types">Types of Applications</a></li>
									<li><a href="#genapps">General Applications</a>
										<ul>
										<li><a href="#genappintro">Introduction</li>
										<li><a href="#genappsurfaces">Surface Details</li>
										<li><a href="#genappdata">User-data available to applications</li>
										<li><a href="#genappdiff">Caf&eacute;camp-only features</li>
										<li><a href="#genappnotes">A few handy notes</li>
										<li><a href="#genappusage">Terms of service</li>
										</ul>
									</li>
									<li><a href="#campapps">Camp Applications</a>
										<ul>
										<li><a href="#campappintro">Introduction</li>
										<li><a href="#campappsurfaces">Surface Details</li>
										<li><a href="#campappdata">Camp-data available to applications</li>
										<li><a href="#campappnotes">A few handy notes</li>
										<li><a href="#campappusage">Terms of service</li>
										</ul>
									</li>
									<li><a href="#caching">Caching</a></li>
									<li><a href="#apppromo">Promoting your application</a></li>
									<li><a href="#appmone">Monetizing your application</a></li>
									<li><a href="#help">Need help or more info?</a></li>
								</ul>
							
							<br>
							<div id="docboxtitle"><a name="intro"></a>Introduction to the Caf&eacute;camp Application Platform (CAP) <span id="toplink">[<a href="#top">TOP</a>]</span></div>	
							<p>Caf&eacute;camp is an OpenSocial container. So you, developers, can create OpenSocial applications that run on the Caf&eacute;camp Platform.
							 To be able to understand this guide fully, we recommend that you have basic knowledge of developing OpenSocial applications (<a href="http://code.google.com/apis/opensocial">http://code.google.com/apis/opensocial</a>).
							</p>
							<br>
							<div id="docboxtitle"><a name="types"></a>Types of Applications <span id="toplink">[<a href="#top">TOP</a>]</span></div>	
							<p>Applications for the Caf&eacute;camp Platform are of two kinds: General Applications and Camp Applications.
							</p>
							<br>
							<div id="docboxtitle"><a name="caching"></a>Gadget Cache <span id="toplink">[<a href="#top">TOP</a>]</span></div>	
							<p>The gadget XML file is cached for 24 hours on Caf&eacute;camp the servers This is done to reduce the load on the application server However, this cached can be by-passed by passing parameter to the application platform. Pass the variable 'no_cache' with the value 1 and your gadget will automatically be allowed to by-pass the 24-hour cache rule.
							</p>
							<br>
							<div id="docboxtitle"><a name="apppromo"></a>Promoting your application <span id="toplink">[<a href="#top">TOP</a>]</span></div>	
							<p>Currently there are two ways of promoting your application on Caf&eacute;camp.
								<ul>
								<li><u>Application Directory:</u> Add it to the application directory. There's an option to add an application right below the navigation, on the top of the page, in the application directory.</li>
								<li><u>Through the SocialGraph:</u> You can rely more on this method. When one user views his/her friend's profile page, the applications the friend is using is listed. The viewer can then add an application he/she wants in a couple of clicks</li>
								<li><u>We tell people:</u> When a application's introduction page is viewed, the user is given a glimpse of what other applications are related to this. This only works if you have added your application to the application directory.</li>
								</ul>
							</p>
							<br>
							<div id="docboxtitle"><a name="appmone"></a>Monetizing your application <span id="toplink">[<a href="#top">TOP</a>]</span></div>	
							<p>You create your application, so you have the right to profit from the it. Advertising in applications is allowed, but don't over-do it, because for users 'too much is too bad'.</p>
							<br>
							<div id="docboxtitle"><a name="help"></a>Need help or more info? <span id="toplink">[<a href="#top">TOP</a>]</span></div>	
							<p>Sure! Apart from the few of us there's also a camp dedicated to OpenSocial developers at <a href="http://opensocial.cafecamp.com">opensocial.cafecamp.com</a>. We address all queries related to Caf&eacute;camp Application Platform there. You can also catchup with us at <a href="http://www.maincamp.cafecamp.com">maincamp.cafecamp.com</a>
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