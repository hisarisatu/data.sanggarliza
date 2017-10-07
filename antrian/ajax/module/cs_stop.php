<?php

include_once '../../lib/conection.php';
$jam = date('Gis');

$sql = "update cs set jam_finish=$jam , status =2 "
        . " where id_client=" . $_REQUEST['id'];
$data = mysql_query($sql);



$sql = "select * from cs where id_client=" . $_REQUEST['id'];
$data = mysql_query($sql);
$row = mysql_fetch_array($data);
$SqlInsertNofif="insert into notif values (".$row['id_pegawai'].",".date('YmdH').",2,'cs')";
mysql_query($SqlInsertNofif);


?>
        