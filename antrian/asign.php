<?php
include_once './lib/conection.php';
$pelanggan = $_POST['idpegawai'];

if ($_POST) {   

    $sql_delete = "delete from pendaftaran_petugas where status='" . $_POST['type-pegawai'] . "' and tgl= " . date('Ymd') . "";
    mysql_query($sql_delete);

    for ($x = 0; $x < count($pelanggan); $x++) {
        $sql = "insert into pendaftaran_petugas (tgl,id_pegawai,status) value (" . date('Ymd') . "," . $_POST['idpegawai'][$x] . ",'" . $_POST['type-pegawai'] . "')";
        mysql_query($sql);
    }
}



$sql = "select a.*,b.status from (
select distinct a.id_pegawai ,a.nama 
  from pegawai a ,pegawai_pekerjaan b  where a.id_pegawai=b.id_pegawai  and b.id_pekerjaan=33 
  )a left join pendaftaran_petugas b on a.id_pegawai=b.id_pegawai 
    and tgl=".date('Ymd'). " 
    and status='cs' order by nama asc";

$sql_fitting = "select a.*,b.status from (
select distinct a.id_pegawai ,a.nama 
  from pegawai a ,pegawai_pekerjaan b  where a.id_pegawai=b.id_pegawai  and b.id_pekerjaan=27 
  )a left join pendaftaran_petugas b on a.id_pegawai=b.id_pegawai 
    and tgl=".date('Ymd'). " 
    and status='fitting' order by nama asc";

 
$data_cs = mysql_query($sql);
$data_fitting = mysql_query($sql_fitting);

while ($row = mysql_fetch_array($data_cs)) {
    $data_arr[] = array(
        'id_pegawai' => $row['id_pegawai']
        , 'nama' => $row['nama']
        , 'status' => $row['status']      
    );
}

while ($row = mysql_fetch_array($data_fitting)) {
    $data_arr_fitting[] = array(
        'id_pegawai' => $row['id_pegawai']
        , 'nama' => $row['nama']
        , 'status' => $row['status']    
    );
}


require_once './template/header.php';
require_once './template/header_m.php';
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
                        <h4>Assign Petugas CS & Fitting</h4>
                    </div>
                </div>
            </div><!-- pageheader -->

            <div id="ajax-form">
                <div class="contentpanel">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="lg-title mb5">Petugas CS</h5>
                            <div class="table-responsive">
                                <form action="asign.php" method="post">
                                    <table class="table table-primary mb30">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Id Petugas</th>
                                                <th>Nama Petugas</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        $x = 1;
                                        foreach ($data_arr as $row) {
                                            $checked=$row['status']!='' ? 'checked' : '';
                                            ?>  
                                                <tr>
                                                    <td><?= $x ?></td>
                                                    <td><?= $row['id_pegawai'] ?></td>
                                                    <td><?= $row['nama'] ?></td>
                                                    <td>
                                                        <input type="checkbox" <?=$checked?> value="<?= $row['id_pegawai'] ?>" name="idpegawai[]"  >
                                                    </td>
                                                </tr>
                                            <?php
                                            $x++;
                                        }
                                        ?>
                                        </tbody>
                                    </table>
                                    <button value="cs" name="type-pegawai" type="submit" class="btn btn-danger">Register</button>
                                </form>
                            </div>

                        </div>

                        <div class="col-md-6">
                            <h5 class="lg-title mb5">Petugas Fitting</h5>
                            <div class="table-responsive">
                                <form action="asign.php" method="post">
                                    <table class="table table-primary mb30">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Id Petugas</th>
                                                <th>Nama Petugas</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $x = 1;
                                            foreach ($data_arr_fitting as $row) {
                                                $checked=$row['status']!='' ? 'checked' : '';
                                                ?>  
                                                <tr>
                                                    <td><?= $x ?></td>
                                                    <td><?= $row['id_pegawai'] ?></td>
                                                    <td><?= $row['nama'] ?></td>
                                                    <td>
                                                        <input type="checkbox" type="checkbox" <?=$checked?>  value="<?= $row['id_pegawai'] ?>" name="idpegawai[]"  >
                                                    </td>
                                                </tr>
                                                <?php
                                                $x++;
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                    <button value="fitting" name="type-pegawai" type="submit" class="btn btn-danger">Register</button>
                                </form>
                            </div>

                        </div>

                        <div class="col-md-6">

                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div><!-- mainpanel -->
</div><!-- mainwrapper -->




</section>
<script type="text/javascript">


    });



</script>    


<?php
# require_once './template/footer.php'; ?>