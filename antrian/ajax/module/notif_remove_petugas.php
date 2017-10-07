<?php
session_start();

include_once '../../lib/conection.php';
$jam = date('Gis');
$sql="delete from notif where status=0 and id_pegawai=".$_SESSION['id_pegawai'];
$data = mysql_query($sql);

?>