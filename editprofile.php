<?php
include("../protect.php");
  
    if($x_login==1)
    {
        list($user_email, $user_id) =  split("::", $_SESSION['user'], 2);
    }
    else
    {
        header("location:index.php");
        exit();
    }
    
    include("../ccconfig.php");
    include("../dbal.php");
    
$dbconn=openconn();
selectdb();
$sql="select * from userprofiles where user_id='$user_id' ";
$qry = exe_qry($sql,$dbconn);

$me=get_qry_array($sql,$dbconn);

foreach($me as $me_d)
{
  $firstname = $me_d['fname'];
  $lastname = $me_d['lname'];  
  $pic = $me_d['pic'];  
  $city = $me_d['city'];
  $my_country = $me_d['country'];
  $dobmonth = $me_d['dobmonth'];        
  $dobday = $me_d['dobday'];
  $dobyear = $me_d['dobyear'];
  $gender = $me_d['gender'];
  $about = stripslashes(strip_tags($me_d['about']));

}
                                      
$sql_qry="select * from countries ORDER BY id";
$do_qry = exe_qry($sql_qry,$dbconn);
$countries=get_qry_array($sql_qry,$dbconn);
  
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html lang="en">
<head>
    <title>Edit Profile &raquo; Caf&eacute;camp</title>
    <link href="pagestyle.css" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" href="images/favicon.gif" type="image/x-icon">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.2.3.min.js"></script>
    <script language="javascript" src="js/customjax.js"></script>
<script language="javascript" src="js/fat.js"></script>
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
                    <tr><td colspan="3"><div id="pagetitle">Edit Profile</div></td></tr>
                </table>
            </div>
            
            <table width="100%">
                <tr valign="top">
                    <td>
						<div id="packbox">
						<div class="box">
<div id="pagemsg"></div>
<table width="100%">
<tr valign="top">
<td width="80%">						
<div id="editprofile">
<p>
<label>First name<span style="color:#ff0000;">*</span><br>
<input type="text" class="bigtext" id="fname" name="fname" value="<?php echo($firstname); ?>">
</label>
</p>
<p>
<label>Last name<br>
<input type="text" class="bigtext" id="lname" name="lname" value="<?php echo($lastname); ?>">
</label>
</p>

<p><label>Gender<br><select name="gender" id="gender"><option<?php if($gender=="male")echo(" selected"); ?>>male</option><option<?php if($gender=="female")echo(" selected"); ?>>female</option></select></label></p> 

<p>
<label>City<br>
<input type="text" class="bigtext" id="city" name="city" value="<?php echo($city); ?>">
</label>
</p>


<p>
  <label>
  Country<br>
  <select name="country" id="country">
      <?php

      foreach ($countries as $country)
        {
          if($my_country==$country['value'])
          {
            echo("<option selected>".$country['value']."</option>");
          }
          else
          {
            echo("<option>".$country['value']."</option>");
          }
          
        }
      ?>
  </select>
  </label>
</p>

<p>
<label>Date of Birth</label><br>
  <select name="year" id="year">
<option<?php if($dobyear=="1997")echo(" selected"); ?>>1997</option>
<option<?php if($dobyear=="1996")echo(" selected"); ?>>1996</option>
<option<?php if($dobyear=="1995")echo(" selected"); ?>>1995</option>
<option<?php if($dobyear=="1994")echo(" selected"); ?>>1994</option>
<option<?php if($dobyear=="1993")echo(" selected"); ?>>1993</option>
<option<?php if($dobyear=="1992")echo(" selected"); ?>>1992</option>
<option<?php if($dobyear=="1991")echo(" selected"); ?>>1991</option>
<option<?php if($dobyear=="1990")echo(" selected"); ?>>1990</option>
<option<?php if($dobyear=="1989")echo(" selected"); ?>>1989</option>
<option<?php if($dobyear=="1988")echo(" selected"); ?>>1988</option>
<option<?php if($dobyear=="1987")echo(" selected"); ?>>1987</option>
<option<?php if($dobyear=="1986")echo(" selected"); ?>>1986</option>
<option<?php if($dobyear=="1985")echo(" selected"); ?>>1985</option>
<option<?php if($dobyear=="1984")echo(" selected"); ?>>1984</option>
<option<?php if($dobyear=="1983")echo(" selected"); ?>>1983</option>
<option<?php if($dobyear=="1982")echo(" selected"); ?>>1982</option>
<option<?php if($dobyear=="1981")echo(" selected"); ?>>1981</option>
<option<?php if($dobyear=="1980")echo(" selected"); ?>>1980</option>
<option<?php if($dobyear=="1979")echo(" selected"); ?>>1979</option>
<option<?php if($dobyear=="1978")echo(" selected"); ?>>1978</option>
<option<?php if($dobyear=="1977")echo(" selected"); ?>>1977</option>
<option<?php if($dobyear=="1976")echo(" selected"); ?>>1976</option>
<option<?php if($dobyear=="1975")echo(" selected"); ?>>1975</option>
<option<?php if($dobyear=="1974")echo(" selected"); ?>>1974</option>
<option<?php if($dobyear=="1973")echo(" selected"); ?>>1973</option>
<option<?php if($dobyear=="1972")echo(" selected"); ?>>1972</option>
<option<?php if($dobyear=="1971")echo(" selected"); ?>>1971</option>
<option<?php if($dobyear=="1970")echo(" selected"); ?>>1970</option>
<option<?php if($dobyear=="1969")echo(" selected"); ?>>1969</option>
<option<?php if($dobyear=="1968")echo(" selected"); ?>>1968</option>
<option<?php if($dobyear=="1967")echo(" selected"); ?>>1967</option>
<option<?php if($dobyear=="1966")echo(" selected"); ?>>1966</option>
<option<?php if($dobyear=="1965")echo(" selected"); ?>>1965</option>
<option<?php if($dobyear=="1964")echo(" selected"); ?>>1964</option>
<option<?php if($dobyear=="1963")echo(" selected"); ?>>1963</option>
<option<?php if($dobyear=="1962")echo(" selected"); ?>>1962</option>
<option<?php if($dobyear=="1961")echo(" selected"); ?>>1961</option>
<option<?php if($dobyear=="1960")echo(" selected"); ?>>1960</option>
<option<?php if($dobyear=="1959")echo(" selected"); ?>>1959</option>
<option<?php if($dobyear=="1958")echo(" selected"); ?>>1958</option>
<option<?php if($dobyear=="1957")echo(" selected"); ?>>1957</option>
<option<?php if($dobyear=="1956")echo(" selected"); ?>>1956</option>
<option<?php if($dobyear=="1955")echo(" selected"); ?>>1955</option>
<option<?php if($dobyear=="1954")echo(" selected"); ?>>1954</option>
<option<?php if($dobyear=="1953")echo(" selected"); ?>>1953</option>
<option<?php if($dobyear=="1952")echo(" selected"); ?>>1952</option>
<option<?php if($dobyear=="1951")echo(" selected"); ?>>1951</option>
<option<?php if($dobyear=="1950")echo(" selected"); ?>>1950</option>
<option<?php if($dobyear=="1949")echo(" selected"); ?>>1949</option>
<option<?php if($dobyear=="1948")echo(" selected"); ?>>1948</option>
<option<?php if($dobyear=="1947")echo(" selected"); ?>>1947</option>
<option<?php if($dobyear=="1946")echo(" selected"); ?>>1946</option>
<option<?php if($dobyear=="1945")echo(" selected"); ?>>1945</option>
<option<?php if($dobyear=="1944")echo(" selected"); ?>>1944</option>
<option<?php if($dobyear=="1943")echo(" selected"); ?>>1943</option>
<option<?php if($dobyear=="1942")echo(" selected"); ?>>1942</option>
<option<?php if($dobyear=="1941")echo(" selected"); ?>>1941</option>
<option<?php if($dobyear=="1940")echo(" selected"); ?>>1940</option>
<option<?php if($dobyear=="1939")echo(" selected"); ?>>1939</option>
<option<?php if($dobyear=="1938")echo(" selected"); ?>>1938</option>
<option<?php if($dobyear=="1937")echo(" selected"); ?>>1937</option>
<option<?php if($dobyear=="1936")echo(" selected"); ?>>1936</option>
<option<?php if($dobyear=="1935")echo(" selected"); ?>>1935</option>
<option<?php if($dobyear=="1934")echo(" selected"); ?>>1934</option>
<option<?php if($dobyear=="1933")echo(" selected"); ?>>1933</option>
<option<?php if($dobyear=="1932")echo(" selected"); ?>>1932</option>
<option<?php if($dobyear=="1931")echo(" selected"); ?>>1931</option>
<option<?php if($dobyear=="1930")echo(" selected"); ?>>1930</option>
<option<?php if($dobyear=="1929")echo(" selected"); ?>>1929</option>
<option<?php if($dobyear=="1928")echo(" selected"); ?>>1928</option>
<option<?php if($dobyear=="1927")echo(" selected"); ?>>1927</option>
<option<?php if($dobyear=="1926")echo(" selected"); ?>>1926</option>
<option<?php if($dobyear=="1925")echo(" selected"); ?>>1925</option>
</select>
&nbsp;&nbsp;
<select name="day" id="day">
<option<?php if($dobday=="1")echo(" selected"); ?>>1</option>
<option<?php if($dobday=="2")echo(" selected"); ?>>2</option>
<option<?php if($dobday=="3")echo(" selected"); ?>>3</option>
<option<?php if($dobday=="4")echo(" selected"); ?>>4</option>
<option<?php if($dobday=="5")echo(" selected"); ?>>5</option>
<option<?php if($dobday=="6")echo(" selected"); ?>>6</option>
<option<?php if($dobday=="7")echo(" selected"); ?>>7</option>
<option<?php if($dobday=="8")echo(" selected"); ?>>8</option>
<option<?php if($dobday=="9")echo(" selected"); ?>>9</option>
<option<?php if($dobday=="10")echo(" selected"); ?>>10</option>
<option<?php if($dobday=="11")echo(" selected"); ?>>11</option>
<option<?php if($dobday=="12")echo(" selected"); ?>>12</option>
<option<?php if($dobday=="13")echo(" selected"); ?>>13</option>
<option<?php if($dobday=="14")echo(" selected"); ?>>14</option>
<option<?php if($dobday=="15")echo(" selected"); ?>>15</option>
<option<?php if($dobday=="16")echo(" selected"); ?>>16</option>
<option<?php if($dobday=="17")echo(" selected"); ?>>17</option>
<option<?php if($dobday=="18")echo(" selected"); ?>>18</option>
<option<?php if($dobday=="19")echo(" selected"); ?>>19</option>
<option<?php if($dobday=="20")echo(" selected"); ?>>20</option>
<option<?php if($dobday=="21")echo(" selected"); ?>>21</option>
<option<?php if($dobday=="22")echo(" selected"); ?>>22</option>
<option<?php if($dobday=="23")echo(" selected"); ?>>23</option>
<option<?php if($dobday=="24")echo(" selected"); ?>>24</option>
<option<?php if($dobday=="25")echo(" selected"); ?>>25</option>
<option<?php if($dobday=="26")echo(" selected"); ?>>26</option>
<option<?php if($dobday=="27")echo(" selected"); ?>>27</option>
<option<?php if($dobday=="28")echo(" selected"); ?>>28</option>
<option<?php if($dobday=="29")echo(" selected"); ?>>29</option>
<option<?php if($dobday=="30")echo(" selected"); ?>>30</option>
<option<?php if($dobday=="31")echo(" selected"); ?>>31</option>

</select>
&nbsp;&nbsp;
<select name="month" id="month">
<option<?php if($dobmonth=="January")echo(" selected"); ?>>January</option>
<option<?php if($dobmonth=="February")echo(" selected"); ?>>February</option>
<option<?php if($dobmonth=="March")echo(" selected"); ?>>March</option>
<option<?php if($dobmonth=="April")echo(" selected"); ?>>April</option>
<option<?php if($dobmonth=="May")echo(" selected"); ?>>May</option>
<option<?php if($dobmonth=="June")echo(" selected"); ?>>June</option>
<option<?php if($dobmonth=="July")echo(" selected"); ?>>July</option>
<option<?php if($dobmonth=="August")echo(" selected"); ?>>August</option>
<option<?php if($dobmonth=="September")echo(" selected"); ?>>September</option>
<option<?php if($dobmonth=="October")echo(" selected"); ?>>October</option>
<option<?php if($dobmonth=="November")echo(" selected"); ?>>November</option>
<option<?php if($dobmonth=="December")echo(" selected"); ?>>December</option>
</select>
</p>

<p><label>About me<br>
<textarea cols="50" rows="7" name="about" id="about"><?php echo($about); ?></textarea></label>
</p>

<p class="submit" align="center"><input type="button" id="submit" name="submit" value="&nbsp;Save profile&nbsp;" onclick="javascript:saveprofile();"></p>
</td>
<td>
<?php
if($pic!=NULL || $pic!="")
{
$imgurl="photos/cropped/".$pic;
}
else
{$imgurl="photos/cropped/defaultpic.gif";}
echo("<div id=\"editpic\"><img src=\"$imgurl\"><br><p><a href=\"uploadphoto.php\"><img src=\"images/photo.gif\" border=\"0\">&nbsp;Change Photo</a></p></div>");
?>
</td>
</tr>
</table>
</div>
						
							
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