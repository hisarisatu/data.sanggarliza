<?php

include_once '../../lib/conection.php';


$sql = "select a.*,IFNULL(b.status,5)status,b.tgl,b.no_antrian,b.time from client a 
  left join fitting b on a.id_client=b.id_client 
   where a.id_client=" . $_REQUEST['id_client'].""
        . " order by id_antrian desc "
        . " limit 1"
        ;

$data = mysql_query($sql);
$row = mysql_fetch_array($data);
$not_allow=array(0,1);
#echo "<pre>".print_r($row,true)."</pre>";exit;

if ( in_array(intval($row['status']),$not_allow) && $row['tgl']==date('Ymd')) {
    echo "not";
} else {
    
       $SqlInsertNofif="insert into notif values (".$_REQUEST['id_pegawai'].",".date('YmdH').",0,'fitting')";
       mysql_query($SqlInsertNofif);

    $sql_antrian = "select IFNULL(max(no_antrian)+1,1)no_antrian from fitting where tgl=" . date('Ymd');
    $data_antrian = mysql_query($sql_antrian);
    $row_antrian = mysql_fetch_array($data_antrian);

     
    $sql_insert = "insert into fitting (id_client,time,id_pegawai,tgl,no_antrian,status,keperluan) "
            . "  values (" . $_REQUEST['id_client'] . "," . date("Gis") . "," . $_REQUEST['id_pegawai'] . "," . date('Ymd') . "," . $row_antrian['no_antrian'] . ",0,".$_REQUEST['keperluan'].")";
    #echo $sql_insert;
    $data = mysql_query($sql_insert);
    if ($data) {
        echo "1";
    } else {
        echo "0";
    }
}
