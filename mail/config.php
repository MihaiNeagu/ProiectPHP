<?php 
require_once ("mail/mail_const.php");
function get_email_object ()
{
$mail = new PHPMailer ();

$mail->IsSMTP();
$mail->Host = "smtp.gmail.com";
$mail->SMTPAuth = true;
$mail->SMTPKeepAlive = true;   
$mail->SMTPSecure = 'tls';
$mail->Port = 587;
$mail->Username = ID;	
$mail->Password = PWD;
//$mail->SetFrom("noreply@localsite.com","Site - Magazin Online");
$mail->IsHTML(true);
return $mail;
}
 ?>