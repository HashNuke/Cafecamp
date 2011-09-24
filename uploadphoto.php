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
$styles = '<link type="text/css" rel="stylesheet" href="css/imig.css" media="screen, projection" />';
$scripts = '	<script type="text/javascript" src="lib/prototype.js"></script>
	<script type="text/javascript" src="lib/scriptaculous.js"></script>
	<script type="text/javascript" src="lib/init_wait.js"></script>';


include('header.php');



  $dbconn=openconn();
  selectdb();
  $sql = "select * from userprofiles where user_id='$user_id' ";
  $qry = exe_qry($sql,$dbconn);

  $udetails = get_qry_array($sql,$dbconn);

  foreach($udetails as $udetail)
  {
    $my_pic = $udetail['pic'];   
  }



 ?>

	<div class="info">

<table width="100%">
<tr valign="top">
<td>

    <p>Upload a picture to crop and set it as your photo</p>

		<p>Filesize limit is <strong>500kb</strong></p>

		<form action="crop_image.php" method="post" name="imageUpload" id="imageUpload" enctype="multipart/form-data">
		<fieldset>
			<input type="hidden" class="hidden" name="max_file_size" value="1000000">
			<div class="file">
				<label for="image">Select a file to upload</label>
				<input type="file" name="image" id="image">
			</div>
			
      <br>
      <br>
			<p class="submit" align="center" id="submit"><input type="submit" id="Upload" name="submit" value="Upload"></p>
			<div class="hidden" id="wait">
				<img src="images/wait.gif" alt="Please wait...">
			</div>
		</fieldset>
		</form>
</td>
<td style="border-left:1px dashed #cccccc;">
<div id="rtitle"><span id="tpointer">&nbsp;&raquo;</span> your current photo</div><br>
<div style="padding:10px 0px 10px 10px;">
<?php if(($my_pic==NULL) || ($my_pic=="")){echo("<img src=\"images/defaultpic.gif\" alt=\"my current photo\">");}else{echo("<img src=\"photos/cropped/$my_pic\" alt=\"my current photo\">");} ?>
</div>
</td>
</tr>
</table>
	</div>

<?php include 'footer.php' ?>
