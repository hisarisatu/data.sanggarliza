<?php require_once './template/header.php'; ?>
<?php require_once './template/header_m.php'; ?>
<?php
include_once './lib/conection.php';
$sql = "select a.*,b.status,b.tgl,b.no_antrian,b.jam_approve,c.nama 
        ,case 
            when keperluan =1 then 'Pilih-pilih baju'    
            when keperluan =2 then 'Fitting Ortu / Keluarga'
            when keperluan =3 then 'Fitting Lanjut'
            when keperluan =4 then 'Fitting Akhir'
        end keperluan
        from client a 
              inner join fitting b on a.id_client=b.id_client 
              left join pegawai c on b.id_pegawai=c.id_pegawai
              where b.status in (0,1) and tgl=".date('Ymd')."
              order by no_antrian asc"; 
$data = mysql_query($sql);
while ($row = mysql_fetch_array($data)) {
    $data_arr[] = array(
        'nama_cpw' => $row['nama_cpw']
        , 'nama_cpp' => $row['nama_cpp']
        , 'no_antrian' => $row['no_antrian']
        , 'tgl_rencana' => $row['tgl_rencana']
        , 'status' => $row['status']
        , 'id_client' => $row['id_client']
        , 'jam_approve'=>$row['jam_approve']    
        , 'nama' =>$row['nama']     
        , 'keperluan' =>$row['keperluan']         
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
                        <i class="fa fa-th-list"></i>
                    </div>
                    <div class="media-body">
                        <ul class="breadcrumb">
                            <li><a href="#"><i class=""></i></a></li>

                        </ul>
                        <h4>Antrian Fitting</h4>
                    </div>
                </div>
            </div><!-- pageheader -->

            <div class="contentpanel">
                <div class="row">

                    <div class="col-md-11">
                        <div class="table-responsive">
                            <table class="table table-danger mb30">
                                <thead>
                                    <tr>

                                        <th>Antrian</th>
                                        <th>Nama Pasangan</th>
                                        <th>Petugas</th>
                                        <th>Tgl Acara</th>
                                        <th>Keperluan</th>
                                        <th>status</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $x = 1;
                                    foreach ($data_arr as $row) {
                                        ?>     
                                        <tr>                                        
                                            <td>Antrian ke - <?= $x ?></td>
                                            <td><?= $row['nama_cpw'] ?>/<?= $row['nama_cpp'] ?></td>
                                            <td><?= $row['nama'] ?></td>
                                            <td><?= $row['tgl_rencana'] ?></td>
                                            <td><?= $row['keperluan'] ?></td>
                                            <td>
                                               <?php echo button_exec($x, $row['id_client'], $row['status'])?>
                                               <?php echo timers($x, $row['jam_approve'],$row['status']); ?>
                                            </td>                                        
                                        </tr>
                                        <?php $x++;
                                    }
                                    ?>    
                                </tbody>  
                            </table>  
                        </div><!-- table-responsive -->
                    </div>
                </div>

            </div><!-- mainpanel -->
        </div><!-- mainwrapper -->
</section>
<div id="sound">
    <!--
    <audio autoplay="autoplay">
        <source src="sound.mp3" type="audio/mpeg" />
        <source src="sound.ogg" type="audio/ogg" />
        <embed hidden="true" autostart="true" loop="false" src="sound.mp3" />
    </audio>-->
    
    <audio id="xyz" src="sound.mp3" preload="auto">
        
    </audio>
    
</div>


<script type="text/javascript">

    function cs_start(x, id) {
        $('#cs-stop' + x).show();
        $('#cs-start' + x).hide();
        $.ajax({
            url: "ajax/module/fitting_antrian.php"
            , type: 'POST'
            , data: {id: id}
            , success: function (result) {
                $('#waktu' + x).show();
                var waktu = parseInt(result);
                waktu = waktu * 1000;
                $('#waktu' + x).stopwatch({startTime: waktu}).stopwatch('start');
            }
        });

    }

    function cs_stop(x, id) {
        $('#cs-finish' + x).show();
        $('#cs-stop' + x).hide();

        $.ajax({
            url: "ajax/module/fitting_stop.php"
            , type: 'POST'
            , data: {id: id}
            , success: function (result) {
                $('#waktu' + x).stopwatch().stopwatch('stop');

            }
        });

    }
    function cs_finish() {
        alert('-');
    }

</script>    

<script type="text/javascript">
    
    $(document).ready(function(){
     (function worker() {
    $.get('ajax/module/cek_notif_petugas.php', function(data) {
    
   if(data!=''){
        playSound();
    }
    setTimeout(worker, 10000);
    });
    })();
     
    });

function playSound(){   
              document.getElementById('xyz').play();
           $.ajax({
            url: "ajax/module/notif_remove_petugas.php"
            , type: 'POST'
            , data: {id: 0}
            , success: function (result) {
                
                setTimeout(function(){
        location.reload(1);
    }, 7000); 
                
                
            }
             });
            }
            
     
</script>   