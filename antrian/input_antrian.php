<?php 
#echo md5("sanggar2016");
#exit;
  
require_once './template/header.php'; ?>
<?php require_once './template/header_m.php'; ?>

<?php
include_once './lib/conection.php';

  

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
    $sql_fitting = "SELECT a.nama_cpp,a.nama_cpw
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

    $data_fitting = mysql_query($sql_fitting);

    while ($row2 = mysql_fetch_array($data_fitting)) {
         $arr_fitting[] = array(
            'nama_cpw' => $row2['nama_cpw']
            , 'nama_cpp' => $row2['nama_cpp']
            , 'no_antrian' => $row2['no_antrian']
            , 'tgl_rencana' => $row2['tgl_rencana']
            , 'status' => $row2['status']  
            , 'id_client' => $row2['id_client']
            , 'jam_approve' => $row2['jam_approve']
            , 'status_label' => $row2['status_label']
        );
    }
    return $arr_fitting;
    #echo "<pre>" . print_r($arr_cs, true) . "</pre>";
}



?>