<?php

include_once '../../lib/conection.php';
$jam = date('Gis');
$sql="select * from notif where status<>0";
$data = mysql_query($sql);
$row  = mysql_fetch_array($data);
echo $row['id_pegawai'];

?>