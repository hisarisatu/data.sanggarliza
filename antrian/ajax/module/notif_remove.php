<?php

include_once '../../lib/conection.php';
$jam = date('Gis');
$sql="delete from notif where status <>0";
$data = mysql_query($sql);

?>