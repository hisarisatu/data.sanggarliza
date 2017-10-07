<?php

// example on using PHPMailer with GMAIL

include("phpmailer/class.phpmailer.php");
include("phpmailer/class.smtp.php"); // note, this is optional - gets called from main class if not already loaded

$mail             = new PHPMailer();

$body             = "Test Email Saja";
$body             = eregi_replace("[\]",'',$body);

$mail->IsSMTP();
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
$mail->Port       = 465;                   // set the SMTP port

$mail->Username   = "zalfinm@gmail.com";  // GMAIL username
$mail->Password   = "Marvin2016";            // GMAIL password

$mail->From       = "zalfinm@gmail.com";
$mail->FromName   = "Alfin";
$mail->Subject    = "judul";
$mail->AltBody    = "test "; //Text Body
$mail->WordWrap   = 50; // set word wrap

$mail->MsgHTML($body);

$mail->AddReplyTo("zalfinm@gmail.com","alfin");

//$mail->AddAttachment("/path/to/file.zip");             // attachment
//$mail->AddAttachment("/path/to/image.jpg", "new.jpg"); // attachment

$mail->AddAddress("zalfinm@gmail","First Last");

$mail->IsHTML(true); // send as HTML

if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message has been sent";
}

?>
