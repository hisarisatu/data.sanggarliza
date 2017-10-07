<?php
include "koneksi.php";

    $date = date('Y-m-d');
	$query1="SELECT *,DATE_ADD(tgl_janji_akhir, INTERVAL -2 DAY) as deadline, DATEDIFF(DATE_ADD(tgl_janji_akhir, INTERVAL 0 DAY), CURDATE()) as selisih FROM jadwal_fitting_new WHERE DATEDIFF(DATE_ADD(tgl_janji_akhir, INTERVAL 0 DAY), CURDATE()) >= '1' AND DATEDIFF(DATE_ADD(tgl_janji_akhir, INTERVAL 0 DAY), CURDATE()) <= '2'";
    $daftar=mysql_query($koneksi, $query1) or die (mysql_error());
    
    $laporan="<h4><b>List Nama Pengantin yang akan Fitting 2 Hari Lagi 2 Hari Lagi</b></h4>";
    $laporan .="<br/>";
	$laporan .="<table width=\"100%\" border=\"1\" align=\"center\" cellpadding=\"3\" cellspacing=\"0\">";
	$laporan .="<tr style=\"color: blue;\">";
	$laporan .="<td>ID CLIENT</td><td>TGL JANJI AWAL</td><td>Tanggal Janji Akhir</td><td>Barang Yang Harus Disiapkan</td><td>Keterangan</td> ";
	$laporan .="</tr>";
	while($dataku=mysql_fetch_object($daftar))
	{
		$laporan .="<tr>";
		$laporan .="<td>$dataku->id_client</td><td>$dataku->tgl_janji_awal</td><td>$dataku->tgl_janji_akhir</td><td>$dataku->barang</td><td>$dataku->keterangan</td>";
		$laporan .="</tr>";
	}
	$laporan .="</table>";
    $laporan .="<h5><a href='#'><b>Untuk detail klik link ini, untuk login gunakan User dan Pass anda</b></a></h5>";
    
    require_once("phpmailer/class.phpmailer.php");
    require_once("phpmailer/class.smtp.php");
    
    $sendmail = new PHPMailer();
    $sendmail->setFrom('zalfinm@protonmail','alfin'); //email pengirim
    $sendmail->addReplyTo('zalfinm@protonmail','alfin'); //email replay
    $sendmail->addAddress('zalfinm@gmail.com','alfin'); //email tujuan
    $sendmail->AddBCC('zalfinm@protonmail.com');
    $sendmail->Subject = 'Daftar Jadwal Fitting  Pengantin deadline 2 hari lagi'; //subjek email
    $sendmail->Body=$laporan; //isi pesan dalam format laporan
    $sendmail->isHTML(true);
	if(!$sendmail->Send()) 
	{
		echo "Email gagal dikirim : " . $sendmail->ErrorInfo;  
	} 
	else 
	{ 
		echo "Email berhasil terkirim!";  
	}
?>