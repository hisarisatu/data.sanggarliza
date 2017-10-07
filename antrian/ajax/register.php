<?php
include_once '../lib/conection.php';
$sql = "select a.*,b.status from (
select distinct a.id_pegawai ,a.nama 
  from pegawai a ,pegawai_pekerjaan b  where a.id_pegawai=b.id_pegawai  and b.id_pekerjaan=33 
  )a left join pendaftaran_petugas b on a.id_pegawai=b.id_pegawai 
    and tgl=".date('Y'-'m'-'d'). " 
    and status='cs' order by nama asc";
$data = mysql_query($sql);


while ($row = mysql_fetch_array($data)) {
    $data_arr[] = array(
        'id_pegawai' => $row['id_pegawai']
        , 'nama' => $row['nama']
    );
}
#echo "<pre>".print_r($data_arr,true)."</pre>";
?>
<script src="js/bootstrap-timepicker.min.js"></script>
 <link href="css/bootstrap-timepicker.min.css" rel="stylesheet" />
 <script type="text/javascript">
    $('#datepickersss').datepicker({dateFormat:'yy-mm-dd'});
</script>  
<div class="contentpanel contentpanel-wizard">

    <div class="row">

        <div class="col-md-9">
            <h5 class="lg-title">Form Register</h5>
            <!--<p class="mb20">Same with basic wizard setup but with form validation</p>-->
            <p class="mb20"> </p>

            <!-- BASIC WIZARD -->
            <form method="post" id="valWizard" class="panel-wizard">
                <ul class="nav nav-justified nav-wizard nav-disabled-click">
                    <li><a href="#tab1-4" data-toggle="tab"><strong>Step 1:&nbsp;</strong>Calon Pengantin Wanita</a></li>
                    <li><a href="#tab2-4" data-toggle="tab"><strong>Step 2:&nbsp;</strong>Calon Pengantin Pria</a></li>
                    <li><a href="#tab3-4" data-toggle="tab"><strong>Step 3:&nbsp;</strong>Catatan Tambahan</a></li>
                    <!-- -->

                </ul>

                <div class="tab-content">
                    <div class="tab-pane" id="tab1-4">

                        <div class="form-group">
                            <label class="col-sm-4">Nama Lengkap</label>
                            <div class="col-sm-8">
                                <input type="text" id="Ncpw" name="Ncpw" class="form-control" required />
                            </div>
                        </div><!-- form-group -->

                        <div class="form-group">
                            <label class="col-sm-4">Nama Orang Tua</label>
                            <div class="col-sm-8">
                                <input type="text" id="rtu_cpw" name="rtu_cpw" class="form-control"  />
                            </div>
                        </div><!-- form-group -->

                        <div class="row">
                            <label class="col-sm-4" style="padding-left: 19px;">Contact Person</label>
                            <div class="form-group col-md-4">Telepon Rumah
                                <input type="text" class="form-control" placeholder="Tlp Rumah" name="tlp_cpw" id="tlp_cpw">
                            </div>
                            <div class="form-group col-md-3">Nomor HP
                                <input type="text" class="form-control" placeholder="hp" name="hp_cpw" id="hp_cpw">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4">Alamat</label>
                            <div class="col-sm-8">
                                <textarea rows="5" id="alamat_cpw" name="alamat_cpw" class="form-control" id="autoResizeTA" style="height: 106px;"></textarea>
                            </div>
                        </div><!-- form-group -->



                    </div><!-- tab-pane -->

                    <div class="tab-pane" id="tab2-4">

                        <div class="form-group">
                            <label class="col-sm-4">Nama Lengkap</label>
                            <div class="col-sm-8">
                                <input type="text" name="Ncpp" id="Ncpp" class="form-control" required />
                            </div>
                        </div><!-- form-group -->

                        <div class="form-group">
                            <label class="col-sm-4">Nama Orang Tua</label>
                            <div class="col-sm-8">
                                <input type="text" name="ortu_cpp" id="ortu_cpp" class="form-control"  />
                            </div>
                        </div><!-- form-group -->

                        <div class="row">
                            <label class="col-sm-4" style="padding-left: 19px;">Contact Person</label>
                            <div class="form-group col-md-4">Telepon Rumah
                                <input type="text" class="form-control" placeholder="Tlp Rumah" name="tlp_cpp" id="tlp_cpp">
                            </div>
                            <div class="form-group col-md-3">Nomor HP
                                <input type="text" class="form-control" placeholder="hp" name="hp_cpp" id="hp_cpp">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4">Alamat</label>
                            <div class="col-sm-8">
                                <textarea rows="5" name="alamat_cpp" id="alamat_cpp" class="form-control" id="autoResizeTA" style="height: 106px;"></textarea>
                            </div>
                        </div><!-- form-group -->
                        <div class="form-group">
                            <label class="col-sm-4">Tanggal</label>
                            <div class="col-sm-8">
                                <input type="text" required class="form-control" placeholder="yyyy/mm/dd" name="datepickersss" id="datepickersss">
                                
                            </div>               
                        </div>

                    </div><!-- tab-pane -->

                    <div class="tab-pane" id="tab3-4">

                        <div class="row">
                            <label class="col-sm-4" style="padding-left: 19px;">Contact Lainnya</label>
                            <div class="form-group col-md-3">Email
                                <input type="email" class="form-control" placeholder="Email" name="email" id="email">
                            </div>
                            <div class="form-group col-md-3">Facebook
                                <input type="text" class="form-control" placeholder="hp" name="facebook" id="facebook">
                            </div>
                            <div class="form-group col-md-2">Twitter
                                <input type="text" class="form-control" placeholder="hp" name="twitter" id="twitter">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4">Catatan</label>
                            <div class="col-sm-8">
                                <textarea rows="5" name="catatan" id="catatan" class="form-control" id="autoResizeTA" style="height: 106px;"></textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4">Petugas CS</label>
                            <div class="col-sm-4">
                                <select class="width100p" data-placeholder="Petugas CS" id="petugas" name="petugas" required>
                                    <option value="">Choose One</option>
                                    <?php foreach ($data_arr as $row) { ?> 
                                        <option value="<?= $row['id_pegawai'] ?>"><?= $row['nama'] ?></option>
                                    <?php } ?>  


                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4">Status Aktif</label>
                            <div class="col-sm-4">
                                <select class="width100p" data-placeholder="Status Aktif" id="sts_aktif" name="sts_aktif"  required>
                                    <option value="">Choose One</option>
                                    <option value="1">aktif</option>
                                    <option value="0">non aktif</option>


                                </select>
                            </div>
                        </div>


                    </div><!-- tab-pane -->

                    <div class="tab-pane" id="tabinfo">

                    </div>

                </div><!-- tab-content -->

                <ul class="list-unstyled wizard">
                    <li class="pull-left previous"><button type="button" class="btn btn-default">Previous</button></li>
                    <li class="pull-right next"><button type="button" class="btn btn-primary">Next</button></li>
                    <li class="pull-right finish hide"><button type="submit" class="btn btn-primary">Finish</button></li>
                </ul>

            </form><!-- panel-wizard -->

        </div><!-- col-md-6 -->
    </div><!-- row -->

</div><!-- contentpanel -->
<script src="./js/module/register.js"></script>