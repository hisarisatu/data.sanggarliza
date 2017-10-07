<?php
include_once '../lib/conection.php';
#$sql = "select * from client where id_client='" . $_REQUEST['idPlg'] . "'";

$sql="select nama_cs ,nama_fitting,a.* from( 
select b.id_cs ,c.id_fitting,a.*  from client a
left join (select id_client,id_pegawai as id_cs ,max(id_antrian)tgl from  cs where id_client='" . $_REQUEST['idPlg'] . "' ) b on  a.id_client=b.id_client
left join (select id_client,id_pegawai as id_fitting,max(id_antrian)tgl from  fitting where id_client='" . $_REQUEST['idPlg'] . "' ) c on  a.id_client=c.id_client
where a.id_client='" . $_REQUEST['idPlg'] . "'
)a left join (select id_pegawai,nama nama_cs from pegawai) b on a.id_cs=b.id_pegawai
   left join (select id_pegawai,nama nama_fitting from pegawai) c on a.id_fitting=c.id_pegawai";


$data = mysql_query($sql);
$row = mysql_fetch_array($data);

$sql_cs="   select * from cs where id_client=".$_REQUEST['idPlg']." and tgl=".date('Ymd');
$data_cs = mysql_query($sql_cs);
$row_cs = mysql_fetch_array($data_cs);

$sql_fitting="   select * from fitting where id_client=".$_REQUEST['idPlg']." and tgl=".date('Ymd');
$data_fitting = mysql_query($sql_fitting);
$row_fitting = mysql_fetch_array($data_fitting);

#echo "<pre>".print_r($row_fitting,true)."</pre>";

?>
<!--<script src="./js/lib/jquery.stopwatch.js"></script>-->
<div class="contentpanel">
    <div class="row">
        <div class="col-md-20">
            <h5 class="lg-title mb5">Profile</h5>
            <p class="mb20"></p>
            <div class="table-responsive">
                <table class="table mb30">
                    <thead>
                        <tr>
                            <th>Nama Pengantin Pria</th>
                            <th>Nama Pengantin wanita</th>
                            <th>Cs</th>
                            <th>Fitting</th>
                            <th>Tgl Acara</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($row['nama_cpw'] != '') { ?>
                            <tr>
                                <td><?= $row['nama_cpp'] ?></td>
                                <td><?= $row['nama_cpw'] ?></td>
                                <td><?= $row['nama_cs'] ?></td>
                                 <td><?= $row['nama_fitting'] ?></td>
                                <td><?= $row['tgl_rencana'] ?></td>
                            </tr>
                            <tr>
                                <td colspan="5">                                    
                                          
                                         <?php if($row_cs['id_client']=='' || $row_cs['status']==3 || $row_cs['status']==2) { echo register_cs($row['id_client'])?>
                                         <?php }else{ ?>
                                         <p style="float:left; padding-right: 20px;font-weight: bold;">Anda Sudah Masuk Dalam Antrian CS ke - <?=$row_cs['no_antrian']?></p>
                                         <?php } ?>
                                    &nbsp;
                                     
                                     <?php if($row_fitting['status']==2 || $row_fitting['status']==3 || $row_fitting['id_client']=='' ){ echo register_fitting($row['id_client'])?>
                                         <?php }else{ ?>
                                         <p style="float:left; padding-right: 20px;font-weight: bold;">Anda Sudah Masuk Dalam Antrian FITTING ke - <?=$row_fitting['no_antrian']?></p> 
                                         <?php  } ?>
                                     <?= $row['nama_fitting'] ?> 
                                    
                                    <div style="clear: both;"></div>
                                </td>
                            </tr>
                        <?php } else { ?>
                            <tr>
                                <td colspan="3">Data tidak ada &nbsp;
                                    <button onclick="form_register()" class="btn btn-success btn-bordered">Input data baru</button>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div> 
        </div>
    </div>
</div>
<script type="text/javascript">
    //$('#demo1').stopwatch().stopwatch('start');
</script>    


<?php
function register_cs($id_client){    
    
$sql_ = "select a.*,b.status,sum(
CASE WHEN c.id_pegawai IS NOT NULL
THEN 1
ELSE 0
END ) jml from (
select distinct a.id_pegawai ,a.nama 
  from pegawai a ,pegawai_pekerjaan b  where a.id_pegawai=b.id_pegawai  and b.id_pekerjaan=23 
  )a inner join pendaftaran_petugas b on a.id_pegawai=b.id_pegawai and b.tgl=".date('Ymd'). "  and b.status='cs'
  left join cs c on b.id_pegawai=c.id_pegawai and c.tgl =".date('Ymd')." and c.status IN ( 0, 1 )
       
      group by a.id_pegawai
    ";

#echo "<pre>".print_r($sql_,true)."</pre>";
$data_ = mysql_query($sql_);
#$row = mysql_fetch_array($data_cs);
while ($row = mysql_fetch_array($data_)) {
    $data_arr[] = array(
        'id_pegawai' => $row['id_pegawai']
        , 'nama' => $row['nama']
        , 'status' => $row['status']
        , 'jml' => $row['jml']    
            
    );
}

  
$html='<div class="col-md-5">
    <table class="table mb5">
          <thead>
              <tr>
                  <th>Petugas CS</th>
                  <th>Jml antrian</th>
                  <th>Keperluan</th>
                  <th>Asign</th>
              </tr>
          </thead>
          <tbody> '; 
foreach($data_arr as $row){
    $html.="<tr>";
    $html.="<td>";
        $html.=$row['nama'];
    $html.="</td>";
    $html.="<td>";
        $html.=$row['jml'];
    $html.="</td>";
    $html.="<td>".keperluan_cs($id_client,'cs')."</td>";
    
    $html.="<td>";
        $html.="<button  style=\"float:left;\" onclick=\"antri_cs($id_client,'".$row['id_pegawai']."')\" class=\"btn btn-success btn-bordered\">Asign</button>";
    $html.="</td>";
    
    $html.="</tr>";  
}
 $html.='</tbody>
    </table>      
</div>' ;
    
    
    
    return $html;


 

}

function keperluan_cs($id,$tipe){
    $html="<select id=\"kep-$tipe-$id\" name=\"kep-$id\" class=\"kep-$id\">
    <option value=\"1\">Cari info</option>
    <option value=\"2\">Review Order</option>
    <option value=\"3\">Bayar DP</option>
    <option value=\"4\">Pelunasan</option>
</select>";
    return $html;
    
}

function keperluan_fitting($id,$tipe){
    $html="<select id=\"kep-$tipe-$id\" name=\"kep-$id\" class=\"kep-$id\">
    <option value=\"1\">Pilih2 Baju</option>
    <option value=\"2\">Fitting Ortu/Keluarga</option>
    <option value=\"3\">Fitting Kroscek</option>
    <option value=\"4\">Fitting Akhir</option>
</select>";
    return $html;
    
}


function register_fitting($id_client){    
    
$sql_ = "select a.*,b.status,sum(
CASE WHEN c.id_pegawai IS NOT NULL
THEN 1
ELSE 0
END ) jml from (
select distinct a.id_pegawai ,a.nama 
  from pegawai a ,pegawai_pekerjaan b  where a.id_pegawai=b.id_pegawai  and b.id_pekerjaan=23 
  )a inner join pendaftaran_petugas b on a.id_pegawai=b.id_pegawai and b.tgl=".date('Ymd'). "  and b.status='fitting'
  left join fitting c on b.id_pegawai=c.id_pegawai and c.tgl =".date('Ymd')." and c.status IN ( 0, 1 )
      group by a.id_pegawai
    ";

#echo "<pre>".print_r($sql_,true)."</pre>";
$data_ = mysql_query($sql_);

while ($row = mysql_fetch_array($data_)) {
    $data_arr[] = array(
        'id_pegawai' => $row['id_pegawai']
        , 'nama' => $row['nama']
        , 'status' => $row['status']
        , 'jml' => $row['jml']    
            
    );
}

  
$html='<div class="col-md-5">
    <table class="table mb5">
          <thead>
              <tr>
                  <th>Petugas Fitting</th>
                  <th>Jml antrian</th>
                  <th>Keperluan</th>
                  <th>Asign</th>
              </tr>
          </thead>
          <tbody> '; 
foreach($data_arr as $row){
    $html.="<tr>";
    $html.="<td>";
        $html.=$row['nama'];
    $html.="</td>";
    $html.="<td>";
        $html.=$row['jml'];
    $html.="</td>";
    $html.="<td>".keperluan_fitting($id_client,'fitting')."</td>";
    
    $html.="<td>";
        $html.="<button  style=\"float:left;\" onclick=\"antri_fiting($id_client,'".$row['id_pegawai']."')\" class=\"btn btn-success btn-bordered\">Asign</button>";
    $html.="</td>";
    
    $html.="</tr>";  
}
 $html.='</tbody>
    </table>      
</div>' ;
    
    
    
    return $html;


 

}

?>
