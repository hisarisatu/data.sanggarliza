<?php
include_once '../../lib/conection.php';
$sql_client_id ="select max(id_client)+1 id_client from client";
$data = mysql_query($sql_client_id);
$row = mysql_fetch_array($data); 

$sql="
insert into client    
select 
    ".$row['id_client']." id_client
    ,'".$_REQUEST['Ncpw']."' nama_cpw
    ,'".$_REQUEST['rtu_cpw']."' nama_ortu_cpw
    ,'".$_REQUEST['tlp_cpw']."' tlp_rumah_cpw
    ,'".$_REQUEST['hp_cpw']."' tlp_mobile_cpw
    ,'".$_REQUEST['alamat_cpw']."' alamat_cpw
    ,'".$_REQUEST['Ncpp']."' nama_cpp
    ,'".$_REQUEST['ortu_cpp']."' nama_ortu_cpp
    ,'".$_REQUEST['tlp_cpp']."' tlp_rumah_cpp
    ,'".$_REQUEST['hp_cpp']."' tlp_mobile_cpp
    ,'".$_REQUEST['alamat_cpp']."' alamat_cpp
    ,STR_TO_DATE('".$_REQUEST['datepickersss']."','%Y-%m-%d') tgl_rencana    
    ,'".$_REQUEST['catatan']."' catatan
    ,null id_user
    ,'".$_SERVER['REMOTE_ADDR']."' login_ip
    ,now() created
    ,null user_update
    ,null ip_update
    ,null last_update
    ,'".$_REQUEST['email']."' email
    ,'".$_REQUEST['facebook']."' facebook
    ,'".$_REQUEST['twitter']."' twiter
    ,'".$_REQUEST['petugas']."' id_pegawai
    ,'".$_REQUEST['sts_aktif']."' status    
from client limit 1
";
$data = mysql_query($sql);
if($data){
    echo "1";
}else{
    echo "0";
}


 ?>























