<?php

$sendto="akashxavier@gmail.com";
$thepass="EMAIL_PASS";

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

require("../../imp_scripts/phpmailer/class.phpmailer.php");

$mail = new PHPMailer();

$mail->IsSMTP();                                      // set mailer to use SMTP
$mail->Host = "cafecamp.com;mail@cafecamp.com";  // specify main and backup server
$mail->SMTPAuth = true;     // turn on SMTP authentication
$mail->Username = "jcafecam";  // SMTP username
$mail->Password = "SMTP_PASSWORD"; // SMTP password

$mail->From = "accounts@cafecamp.com";
$mail->FromName = "Cafecamp.com";
$mail->AddAddress($sendto);
$mail->AddReplyTo("noreply@cafecamp.com", "No Reply");

$mail->WordWrap = '50';                                 // set word wrap to 50 characters
$mail->IsHTML('true');                                  // set email format to HTML

$mail->Subject = "Cafecamp.com Email Verification";

$mail->Body    = "
<p>Dear user,</p>
<p>Welcopme to Caf&eacute;camp.com. Below is a link by which your email address is to be verified. Click on it to proceed to the verification page.</p>
<br>
<p align=\"center\" style=\"padding:5px 5px 5px 5px;background:#eeeeee;border:1px solid #cccccc;\"><a href=\"$theverifylink\">".$theverifylink."</a>
</p>

<p>
Your username/email: <b>".$sendto."<b><br>your password: <b>".$thepass."</b>
</p>

<p>
--<br>
Have a nice camping season<br>
Cafecamp.com Team
</p>
";

$mail->AltBody = "
Dear user, Thanks for joining Cafecamp. Copy the link and paste it in your web browser's address bar to verify your email address. ".$theverifylink;

if(!$mail->Send())
{
   echo "There was an error sending the message";
   exit;
}
else
{
    echo("mail sent");
}
