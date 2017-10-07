<?php

session_start();
#echo "<pre>".print_r($_SESSION,true)."</pre>";

#$login_Id=$_SESSION['groupId']==1 ? null : " and b.id_pegawai=".$_SESSION['id_pegawai']."";
include_once '../../lib/conection.php';
$jam = date('Gis');
$sql="select * from notif where status=0 and id_pegawai=".$_SESSION['id_pegawai'];
$data = mysql_query($sql);
$row  = mysql_fetch_array($data);
echo $row['id_pegawai'];

?>