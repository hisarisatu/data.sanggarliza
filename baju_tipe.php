<?php

include_once("include.php");
$keterangan = $_REQUEST['term'];
$id_tipe_baju = $_REQUEST['id_baju'];
switch ($_REQUEST['type']) {
    case 'baju_type' :type_baju($keterangan);
        break;
    case 'id_baju' :id_baju_($id_tipe_baju, $keterangan);
        break;
}

function type_baju($keterangan) {
#$sql = "select id_tipe_baju,keterangan from p_baju_tipe where upper(keterangan) not like '%KAIN%' OR upper(keterangan) like '$keterangan%' order by keterangan asc";
    $sql = "select id_tipe_baju,keterangan from p_baju_tipe where  upper(keterangan) like '$keterangan%' order by keterangan asc";
    $rs = mysql_query($sql);
    while ($row = mysql_fetch_array($rs)) {
        $dr[] = array('id' => $row['id_tipe_baju'], 'label' => $row['keterangan'], 'value' => $row['keterangan']);
    }
    echo json_encode($dr);
}

function id_baju_($id_tipe_baju, $keterangan) {
    $sql = "select id_layanan,layanan from p_baju where id_tipe_baju='$id_tipe_baju' AND layanan  like '$keterangan%' order by layanan asc";
    #exit($sql); 
    $rs = mysql_query($sql);
    while ($row = mysql_fetch_array($rs)) {
        $dr[] = array('id' => $row['id_layanan'], 'label' => $row['layanan'], 'value' => $row['layanan']);
    }
    echo json_encode($dr);
}
?>
 