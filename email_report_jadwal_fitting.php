<html>
<head>
<link rel="stylesheet" href="./src/lib/jquery-ui-1.11.1/jquery-ui.css">	
<script src="./src/lib/jquery-1.9.1.js" type="text/javascript"></script>
<script src="./src/lib/jquery-ui-1.11.1/jquery-ui.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="src/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="src/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="src/css/steel/steel.css" />
<title>PHPMailer - Sendmail basic test</title>
</head>


<?php
include_once("include.php");
include_once("p_bulan.php");
require_once('class.phpmailer.php');

$runSQL = "select a.id_client, a.nama_cpw, ifnull(a.tlp_mobile_cpw,'belum-diinput')tlp_mobile_cpw, ifnull(a.nama_cpp,'belum-diinput')nama_cpp, ifnull(a.tlp_mobile_cpp,'belum-diinput')tlp_mobile_cpp, a.tgl_rencana, b.tgl_janjiawal, b.tgl_janjiakhir, b.barang, b.keterangan, ifnull(c.nama,'-')nama
 from client a 
 left join jadwal_fitting_new b on a.id_client=b.id_client 
 left join pegawai c on a.id_pegawai=c.id_pegawai
 where a.id_client=b.id_client and b.tgl_janjiakhir BETWEEN '$tanggal' AND '$tanggal2'
order by id_client desc";

$mail  = new PHPMailer(); // defaults to using php "mail()"

$mail->IsSendmail(); // telling the class to use SendMail transport

$body  = "<table> 
		  <tr bgcolor='#A7A7A7' height='25'>
			<td width='4%' align='center'>NO</td>
			<td width='12%' align='center'>NAMA CPW</td>
			<td width='12%' align='center'>HP CPW</td>
			<td width='8%' align='center'>Nama CPP</td>
			<td width='12%' align='center'>HP CPP</td>
			<td width='10%' align='center'>TGL RENCANA</td>
			<td width='10%' align='center'>JANJI AWAL</td>
			<td width='10%' align='center'>JANJI AKHIR</td>
			<td width='10%' align='center'>BARANG</td>
			<td width='10%' align='center'>KETERANGAN</td>
            <td width='10%' align='center'>PETUGAS CS</td>
</tr>".

$res=mysql_query($runSQL);
//echo $runSQL;
while($rec=mysql_fetch_array($res))
{
	

	$ccc++;
	if ($ccc%2 > 0){ $color='#EBEFFA'; }else{ $color='#D7E0F4'; };
echo "<tr bgcolor=$color onmouseover=bgColor=\'#FDD0D8\' onmouseout=bgColor=\'$color\' valign=top>
    <td align='center'>".($ccc)."</td>

	
		  <td align=center> $rec[nama_cpw] </td>
		  <td align=center> $rec[tlp_mobile_cpw]</td>
		  <td align=center> $rec[nama_cpp] </td>
		  <td align=center> $rec[tlp_mobile_cpp] </td>
		  <td align=center> $rec[tgl_rencana] </td>
		  <td align=center> $rec[tgl_janjiawal] </td>
		  <td align=center> $rec[tgl_janjiakhir] </td>
		  <td> $rec[barang] </td>
		  <td> $rec[keterangan] </td> 
		  <td> $rec[nama]</td>

</tr>";
}
echo "<tr bgcolor=$color onmouseover=bgColor=\'#FDD0D8\' onmouseout=bgColor=\'$color\' valign=top>

</tr>
</table>
</font>
</table></br>

<table align='center' width='1002' height='79' border='0'>
  <tr align='center' >
    <td height='23'>Dibuat oleh,</td>
    <td>Diperikasa oleh,</td>
  </tr>
  <tr>
    <td height='23'>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr align='center'>
    <td height='23'>(Admin Fitting)</td>
    <td>(KaBag. Gudang)</td>
  </tr>
</table>";



  $mail->AddReplyTo('admin@alfin.com', 'admin');
  $mail->AddAddress('zalfinm@gmail.com', 'zalfinm');
  $mail->SetFrom('admin@alfin.com', 'admin');
  $mail->AddReplyTo('admin@alfin.com', 'admin');
  $mail->Subject = 'test';
  $mail->AltBody = 'ini isi email'; // optional - MsgHTML will create an alternate automatically
  $mail->MsgHTML($body);


if(!$mail->Send()) {
  echo "Mailer Error: " . $mail->ErrorInfo;
} else {
  echo "Message sent!";
}

?>

</body>
</html>
