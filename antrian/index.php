<?php
include_once './lib/conection.php';
require_once './template/header.php'; ?>
<?php require_once './template/header_m.php'; ?>
<?php require_once './template/footer_js.php'; ?>
<?php
#echo md5('admin2016');exit;


if($_REQUEST['proses_status']=='clear'){    
    $sql_update="update ".$_REQUEST['table']." set status=3 where id_antrian=".$_REQUEST['id_antrian'];
    #echo $sql_update;
    mysql_query($sql_update);
}


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
/*
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


$sqlCeknotif = "select * from ";
 * 
 */
?>

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
                        <i class="fa fa-th-list"></i>
                    </div>
                    <div class="media-body">
                        <ul class="breadcrumb">
                            <li><a href="#"><i class=""></i></a></li>

                        </ul>
                        <h4>Monitoring Antrian CS & Fitting</h4>
                    </div>
                </div>
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
                                        <?php
                                        $x = 1;
                                        foreach ($arr_p_cs as $row) {
                                            if ($row['status'] == 'cs') {
                                                ?>  
                                                <tr>
                                                    <td><?= $x ?></td>
                                                    <td><?= $row['nama'] ?></td>
                                                    <?php $kow = lis_cs($row['id_pegawai']); ?>
                                                    <td>
                                                        <table style="width: 100%;">

                                                            <?php
                                                            $y = 1;
                                                            foreach ($kow as $rw) {
                                                                if ($rw['status'] == 1) {
                                                                    $scolor = "green";
                                                                } else if ($rw['status'] == 0) {
                                                                    $scolor = "red";
                                                                }
                                                                ?>
                                                                <tr>
                                                                    <td><?= $y ?>.&nbsp;</td>
                                                                    <td style="width: 77%;"><?= $rw['nama_cpw'] ?>/<?= $rw['nama_cpp'] ?></td>
                                                                    <td style="width: 50%;">
                                                                        <?php
                                                                        echo label_timer($x . $y, $rw['status'],$rw['id_client'],'cs',$rw['id_antrian']);
                                                                        echo timers($x . $y, $rw['jam_approve'], $rw['status'], $rw['jam_finish']);
                                                                        ?>

                                                                    </td>
                                                                    <td>
                                                                    <?php if($rw['status']< 2){?>    
                                                                        <img style="width: 25px;height:25px; " src="images/<?= $scolor ?>.png"/>
                                                                    <?php }?>    
                                                                    </td>
                                                                </tr>
                                                                <?php $y++;
                                                            } ?>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <?php
                                                $x++;
                                            }
                                        }
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
                                        <?php
                                        $x = 200;
                                        $no = 1;
                                        foreach ($arr_p_cs as $row) {
                                            if ($row['status'] == 'fitting') {
                                                ?>  
                                                <tr>
                                                    <td><?= $no ?></td>
                                                    <td><?= $row['nama'] ?></td>
                                                            <?php $kow = lis_fitting($row['id_pegawai']); ?>
                                                    <td>
                                                        <table style="width: 100%;">                                                        
                                                            <?php
                                                            $nox = 1;
                                                            $y = 100;
                                                            foreach ($kow as $rw) {
                                                                if ($rw['status'] == 1) {
                                                                    $scolor = "green";
                                                                } else if ($rw['status'] == 0) {
                                                                    $scolor = "red";
                                                                }
                                                                ?>

                                                            <tr style="">
                                                                    <td><?= $nox ?>.&nbsp;</td>
                                                                    <td style="width: 77%;"><?= $rw['nama_cpw'] ?>/<?= $rw['nama_cpp'] ?></td>
                                                                    <td style="width: 50%; padding-bottom: 5px;">
                                                                    <?php
                                                                    echo label_timer($x . $y, $rw['status'],$rw['id_client'],'fitting',$rw['id_antrian']);
                                                                    echo timers($x . $y, $rw['jam_approve'], $rw['status'], $rw['jam_finish']);
                                                                    ?>
                                                                    </td>
                                                                    <td>
                                                                    <?php if($rw['status']< 2){?>     
                                                                        <img style="width: 25px;height:25px; " src="images/<?= $scolor ?>.png"/></td>
                                                                    <?php } ?>
                                                                </tr>
                                                                <?php $y++;
                                                                $nox++;
                                                            } ?>
                                                        </table>
                                                    </td>
                                                </tr>
                                                    <?php
                                                    $x++;
                                                    $no++;
                                                }
                                            }
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
<div id="sound">  
    <audio id="xyz" src="sound.mp3" preload="auto">
    </audio>
</div>
  

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
    ,b.jam_finish
    ,b.id_pegawai
    ,a.id_client
    ,b.id_antrian
    FROM client a
    LEFT JOIN cs b ON a.id_client = b.id_client
    WHERE b.status IN ( 0, 1 ,2)
    and b.id_pegawai=$id_petugas
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
            , 'jam_finish' => $row['jam_finish']
            , 'id_antrian'=>$row['id_antrian']    
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
    ,b.jam_finish
    ,b.id_pegawai
    ,a.id_client
    ,b.id_antrian
    FROM client a
    INNER JOIN fitting b ON a.id_client = b.id_client
    WHERE b.status IN ( 0, 1 ,2)
    and b.id_pegawai=$id_petugas
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
            , 'jam_finish' => $row['jam_finish']
            , 'status_label' => $row['status_label']
            , 'id_antrian'=>$row['id_antrian']
        );
    }
    return $arr_cs;
    #echo "<pre>" . print_r($arr_cs, true) . "</pre>";
}
?>
<script type="text/javascript">

    $(document).ready(function () {
        (function worker() {
            $.get('ajax/module/cek_notif.php', function (data) {
                if (data != '') {
                    playSound();
                }
                setTimeout(worker, 10000);
            });
        })();

    });

    function playSound() {
        document.getElementById('xyz').play();
        $.ajax({
            url: "ajax/module/notif_remove.php"
            , type: 'POST'
            , data: {id: 0}
            , success: function (result) {

                setTimeout(function () {
                    location.reload(1);
                }, 7000);
            }
        });
    }
</script>   