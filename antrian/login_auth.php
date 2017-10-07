<?php
session_start();
include_once './lib/conection.php';
#echo "<pre>".print_r($_POST,true)."</pre>";exit;

$username = strtolower($_POST['user']);
$password = md5($_POST['password']);  



$runSQL = "select a.*,case when b.status='cs' then 3 "
        . " when b.status='fitting' then 7"
        . " else 1 end gi"
        . "  from sys_user_antrian a left join pendaftaran_petugas b on a.id_pegawai=b.id_pegawai where a.username in ('$username') and a.password in ('$password') ";
#echo "<pre>".print_r($runSQL,true)."</pre>";exit;
$data = mysql_query($runSQL);  
if ($row = mysql_fetch_array($data)) {
    
   
    mysql_close();
    
    $_SESSION['userlogin']='loginTrue';
    $_SESSION['userlogin-name']=$row['username'];
    $_SESSION['username']=$row['username'];
    $_SESSION['id_pegawai']=$row['id_pegawai'];
    $_SESSION['groupId']=$row['gi'];
    
    
    if($row['gi']==1){
        header("Location:index.php");
    }else if($row['gi']==3 || $row['gi']==6){
        header("Location:cs.php");
    }else if($row['gi']==7 || $row['gi']==8){
        header("Location:fitting.php");
    }
 
}else{
    header("Location:login.php");
}
?>
 