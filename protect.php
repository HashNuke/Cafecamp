<?php
header("Cache-Control: no-cache, must-revalidate");
$x=0;
function verify()
{

	// check to see if they're already logged in
	session_start();
	if (isset($_SESSION['user']))
	return true;
	
	
	// check to see if visitor has just tried to log on

   if(isset($_POST['u_name'])&&(isset($_POST['u_password'])))
    {
      $u_name=$_POST['u_name'];
      $u_password=md5($_POST['u_password']);

      // validate username and password

     include('ccconfig.php');
     include('dbal.php');

	$conn=openconn();

	selectdb();

     $sql="Select * from users where email=\"$u_name\" and password=\"$u_password\" ";
     $qry=mysql_query($sql,$conn);
     $fetchqry=mysql_fetch_array($qry);
     
   
     if($u_password==$fetchqry['password'])
      {
      $_SESSION['user']=$fetchqry['email'];
      return true;
      }
      else
      {
        header("location:index.php");
      }
     }
     
}

session_start();

if(isset($_POST['log_out']))
if ($_POST['log_out'])
{
unset($_SESSION['user']);
session_unset();
session_destroy();
}

if(!verify())
{
$x=0;
}
else{
$x=1;
}

$x_login=$x;

?>