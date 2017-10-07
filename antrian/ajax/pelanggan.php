<?php
$like= $_REQUEST['term'];

include_once '../lib/conection.php';
$sql = "select * from client where nama_cpw like '$like%' or nama_cpp like '$like%' limit 10";
$data = mysql_query($sql);
$html = "[";
while ($row = mysql_fetch_array($data)) {
    $lis.='{"value":"' . $row['nama_cpw'] . '","id":"' . $row['id_client'] . '"},';
}
$html.= substr($lis, 0, strlen($lis) - 1);

$html.="]";
echo $html;
?>