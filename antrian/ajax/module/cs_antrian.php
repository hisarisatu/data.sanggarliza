<?php

include_once '../../lib/conection.php';
$jam = date('Gis');

$sql = "update cs set jam_approve=$jam , status =1"
        . " where id_client=" . $_REQUEST['id'];
$data = mysql_query($sql);





$sql = "select * from cs where id_client=" . $_REQUEST['id'];
$data = mysql_query($sql);
$row = mysql_fetch_array($data);

$SqlInsertNofif="insert into notif values (".$row['id_pegawai'].",".date('YmdH').",1,'cs')";
mysql_query($SqlInsertNofif);

$x = selisih($row['jam_approve']);
echo $x['detik'];
?>
        