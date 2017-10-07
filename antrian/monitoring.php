<?php 
#echo md5("sanggar2016");
#exit;
  
require_once './template/header.php'; ?>
<?php require_once './template/header_m.php'; ?>

<?php
include_once './lib/conection.php';

 
$sql_petugas_cs = "select a.*,b.nama from pendaftaran_petugas a
  inner join pegawai b on a.id_pegawai=b.id_pegawai
  -- where a.status='cs' 
  and a.tgl=" . date('Ymd') . "";
$data_petugas_cs = mysql_query($sql_petugas_cs);

while ($row = mysql_fetch_array($data_petugas_cs)) {
    $arr_p_cs[] = array(
        'id_pegawai' => $row['id_pegawai']
        , 'nama' => $row['nama']
        , 'status' => $row['status']
    );
}



$sql_cs = "SELECT a . * ,
    CASE WHEN b.status =1 THEN 'Sedang Berjalan'
        WHEN b.status =0 THEN 'Dalam Antrian'
        WHEN b.status =2 THEN 'Selesai'
    END status_label, b.status, b.tgl, b.no_antrian, b.jam_approve
    FROM client a
    INNER JOIN cs b ON a.id_client = b.id_client
    WHERE b.status IN ( 0, 1 )
    AND tgl =" . date('Ymd') . "
ORDER BY no_antrian ASC";

$data_cs = mysql_query($sql_cs);

while ($row = mysql_fetch_array($data_cs)) {
    $arr_cs[] = array(
        'nama_cpw' => $row['nama_cpw']
        , 'nama_cpp' => $row['nama_cpp']
        , 'no_antrian' => $row['no_antrian']
        , 'tgl_rencana' => $row['tgl_rencana']
        , 'status' => $row['status']
        , 'id_client' => $row['id_client']
        , 'jam_approve' => $row['jam_approve']
        , 'status_label' => $row['status_label']
    );
}


$sql_fitting = "SELECT a . * ,
    CASE WHEN b.status =1 THEN 'Sedang Berjalan'
        WHEN b.status =0 THEN 'Dalam Antrian'
        WHEN b.status =2 THEN 'Selesai'
    END status_label, b.status, b.tgl, b.no_antrian, b.jam_approve
    FROM client a
    INNER JOIN fitting b ON a.id_client = b.id_client
    WHERE b.status IN ( 0, 1 )
    AND tgl =" . date('Ymd') . "
ORDER BY no_antrian ASC";

$data_fitting = mysql_query($sql_fitting);
while ($row = mysql_fetch_array($data_fitting)) {
    $arr_fitting[] = array(
        'nama_cpw' => $row['nama_cpw']
        , 'nama_cpp' => $row['nama_cpp']
        , 'no_antrian' => $row['no_antrian']
        , 'tgl_rencana' => $row['tgl_rencana']
        , 'status' => $row['status']
        , 'id_client' => $row['id_client']
        , 'jam_approve' => $row['jam_approve']
        , 'status_label' => $row['status_label']   
    );  
}
 

?>
<?php require_once './template/footer_js.php'; ?>
<script src="./js/lib/jquery.stopwatch.js"></script>



<style>
    .ui-autocomplete-loading {
        background: white url("images/ui-anim_basic_16x16.gif") right center no-repeat;
    }
</style>
<section>
    <div class="mainwrapper">
        <!-- leftpanel -->
        <?php require_once './template/left_bar_menu.php'; ?>
        <div class="mainpanel">
            <div class="pageheader">
                <div class="media">
                    <div class="pageicon pull-left">
                        <i class="fa fa-search"></i>
                    </div>
                    <div class="media-body">
                       <!-- <input type="text" style="height: 51px; width: 30%" id="tags" class="form-control" placeholder="Nama Pelanggan"><button class="btn btn-default">Default</button>-->
                        <div class="input-group mb15">
                            <input style="" id="tags" type="text" class="form-control">
                            <span class="input-group-btn">
                                <button id="search-pelanggan" idPlg="" class="btn btn-default" type="button">Go!</button>
                            </span>
                        </div>
                    </div>
                </div><!-- media -->
            </div><!-- pageheader -->

            <div id="ajax-form">
                <div class="contentpanel">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="lg-title mb5">Monitoring CS</h5>
                            <div class="table-responsive">
                                <table class="table table-primary mb30">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Petugas</th>
                                            <th>Daftar Antrian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $x = 1;
                                        foreach ($arr_p_cs as $row) {                                             
                                            if($row['status']=='cs'){
                                            ?>  
                                            <tr>
                                                <td><?= $x ?></td>
                                                <td><?= $row['nama'] ?></td>
                                                    <?php $kow= lis_cs($row['id_pegawai']);?>
                                                <td>
                                                    <table style="width: 100%;">
                                                        
                                                      <?php $y=1; foreach($kow as $rw){ 
                                                          if($rw['status']==1){
                                                                    $scolor="green";
                                                                }else if($rw['status']==0){
                                                                    $scolor="red";
                                                                } 
                                                          ?>
                                                        <tr>
                                                            <td><?=$y?>.&nbsp;</td>
                                                            <td style="width: 77%;"><?=$rw['nama_cpw']?>/<?=$rw['nama_cpp']?></td>
                                                            <td style="width: 50%;">
                                                                <?php 
                                                                    echo label_timer($x.$y,$rw['status']);
                                                                    echo timers($x.$y, $rw['jam_approve'],$rw['status']);
                                                                ?>
                                                                 
                                                            </td>
                                                            <td><img style="width: 25px;height:25px; " src="images/<?=$scolor?>.png"/></td>
                                                        </tr>
                                                      <?php $y++; } ?>
                                                    </table>
                                                </td>
                                            </tr>
                                            <?php $x++;
                                            }}
                                        ?>
                                    </tbody>
                                </table>
                            </div><!-- table-responsive -->
                        </div>

                        <div class="col-md-6">
                            <h5 class="lg-title mb5">Monitoring Fitting</h5>
                            <div class="table-responsive">
                                
                                
                                <table class="table table-primary mb30">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Petugas</th>
                                            <th>Daftar Antrian</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $x = 200;
                                        $no=1;
                                        foreach ($arr_p_cs as $row) {                                             
                                            if($row['status']=='fitting'){
                                            ?>  
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><?= $row['nama'] ?></td>
                                                    <?php $kow= lis_fitting($row['id_pegawai']);?>
                                                <td>
                                                    <table style="width: 100%;">                                                        
                                                      <?php $nox=1; $y=100; foreach($kow as $rw){      
                                                            if($rw['status']==1){
                                                                    $scolor="green";
                                                                }else if($rw['status']==0){
                                                                    $scolor="red";
                                                                } 
                                                          ?>
                                                        
                                                        <tr>
                                                            <td><?=$nox?>.&nbsp;</td>
                                                            <td style="width: 77%;"><?=$rw['nama_cpw']?>/<?=$rw['nama_cpp']?></td>
                                                            <td style="width: 50%; padding-bottom: 5px;">
                                                                <?php 
                                                                    echo label_timer($x.$y,$rw['status']);
                                                                    echo timers($x.$y, $rw['jam_approve'],$rw['status']);
                                                                ?>
                                                            </td>
                                                            <td><img style="width: 25px;height:25px; " src="images/<?=$scolor?>.png"/></td>
                                                        </tr>
                                                      <?php $y++; $nox++;} ?>
                                                    </table>
                                                </td>
                                            </tr>
                                            <?php $x++;
                                            $no++;}}
                                        ?>
                                    </tbody>
                                </table>
                                
                            </div><!-- table-responsive -->
                        </div>


                    </div>
                </div>
            </div>




        </div>

    </div><!-- mainpanel -->
</div><!-- mainwrapper -->
</section>


<?php

function lis_cs($id_petugas) {
    $sql_cs = "SELECT a.nama_cpp,a.nama_cpw
    ,CASE WHEN b.status =1 THEN 'Sedang Berjalan'
        WHEN b.status =0 THEN 'Dalam Antrian'
        WHEN b.status =2 THEN 'Selesai'
    END status_label
    ,b.status   
    ,b.tgl
    ,b.no_antrian
    ,b.jam_approve
    ,b.id_pegawai
    FROM client a
    INNER JOIN cs b ON a.id_client = b.id_client
    WHERE b.status IN ( 0, 1 )
    and b.id_pegawai=$id_petugas
    AND tgl =".date('Ymd')."
ORDER BY no_antrian ASC";

    $data_cs = mysql_query($sql_cs);

    while ($row = mysql_fetch_array($data_cs)) {
        $arr_cs[] = array(
            'nama_cpw' => $row['nama_cpw']
            , 'nama_cpp' => $row['nama_cpp']
            , 'no_antrian' => $row['no_antrian']
            , 'tgl_rencana' => $row['tgl_rencana']
            , 'status' => $row['status']  
            , 'id_client' => $row['id_client']
            , 'jam_approve' => $row['jam_approve']
            , 'status_label' => $row['status_label']
        );
    }
    return $arr_cs;
    #echo "<pre>" . print_r($arr_cs, true) . "</pre>";
}

function lis_fitting($id_petugas) {
    $sql_cs = "SELECT a.nama_cpp,a.nama_cpw
    ,CASE WHEN b.status =1 THEN 'Sedang Berjalan'
        WHEN b.status =0 THEN 'Dalam Antrian'
        WHEN b.status =2 THEN 'Selesai'
    END status_label
    ,b.status   
    ,b.tgl
    ,b.no_antrian
    ,b.jam_approve
    ,b.id_pegawai
    FROM client a
    INNER JOIN fitting b ON a.id_client = b.id_client
    WHERE b.status IN ( 0, 1 )
    and b.id_pegawai=$id_petugas
    AND tgl =".date('Ymd')."
ORDER BY no_antrian ASC";

    $data_cs = mysql_query($sql_cs);

    while ($row = mysql_fetch_array($data_cs)) {
        $arr_cs[] = array(
            'nama_cpw' => $row['nama_cpw']
            , 'nama_cpp' => $row['nama_cpp']
            , 'no_antrian' => $row['no_antrian']
            , 'tgl_rencana' => $row['tgl_rencana']
            , 'status' => $row['status']  
            , 'id_client' => $row['id_client']
            , 'jam_approve' => $row['jam_approve']
            , 'status_label' => $row['status_label']
        );
    }
    return $arr_cs;
    #echo "<pre>" . print_r($arr_cs, true) . "</pre>";
}



?>