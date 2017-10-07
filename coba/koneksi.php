<?php

$db_host = "localhost";
$db_user = "h67649_liza642";
$db_pass = "telkom135";
$db_name = "h67649_liza642";

$koneksi = mysql_connect($db_host, $db_user, $db_pass, $db_name) or die ("GAGAL KONEK DATABASE CALL MARVIN");



$tanggal_hari_ini = date("d");
$jarak_reminder	  = 2;
$tanggal_reminder = $tanggal_hari_ini - $jarak_reminder;


$today = date("m-$tanggal_reminder");

$query  = "SELECT * FROM jadwal_fitting_new WHERE tgl_janji_akhir LIKE '%$today%' ";

$result = mysql_query($koneksi, $query);

$row = mysql_fetch_array($result);

$cek = mysql_num_rows($result);

?>