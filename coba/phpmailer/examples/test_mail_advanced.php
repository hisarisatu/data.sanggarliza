<html>
<head>
<title>PHPMailer - Mail() advanced test</title>
</head>
<body>

<?php
date_default_timezone_set('Asia/Jakarta');
require_once '../class.phpmailer.php';

$mail = new PHPMailer(true); //defaults to using php "mail()"; the true param means it will throw exceptions on errors, which we need to catch

try {
  $mail->AddReplyTo('admin@sanggarliza.com', 'admin');
  $mail->AddAddress('zalfinm@gmail.com', 'zalfinm');
  $mail->SetFrom('admin@sanggarliza.com', 'admin');
  $mail->AddReplyTo('admin@sanggarliza.com', 'admin');
  $mail->Subject = 'test';
  $mail->AltBody = 'ini isi email'; // optional - MsgHTML will create an alternate automatically
  $mail->MsgHTML(file_get_contents('http://data.sanggarliza.com/coba/phpmailer/examples/content.php'));
  $mail->AddAttachment('images/phpmailer.gif');      // attachment
  $mail->AddAttachment('images/phpmailer_mini.gif'); // attachment
  $mail->Send();
  echo "Message Sent OK</p>\n";
} catch (phpmailerException $e) {
  echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
  echo $e->getMessage(); //Boring error messages from anything else!
}
?>
</body>
</html>
