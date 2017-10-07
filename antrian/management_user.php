<?php
include_once './lib/conection.php';

if ($_REQUEST['prosesdel'] == 'delete') {

    $del = "delete from sys_user_antrian where id_pegawai=" . $_REQUEST['id_pegawai'] . "";
    $data = mysql_query($sql);
    echo "<script>window.location.href='management_user.php';</script>";
    exit;
}



require_once './template/footer_js.php';
$sql = " select id_pegawai,nama,telepon"
        . ", username"
		. ", password"
        . ", case when group_id=3 then 'CS' "
        . "  when group_id=2 then 'FITTING' "
        . "  when group_id=1 then 'ADMIN'"
        . "  when group_id=0 then 'RECEPTION'"
        . " END group_id from sys_user_antrian order by nama asc";
$data = mysql_query($sql);

while ($row = mysql_fetch_array($data)) {
    $arr_p_cs[] = array(
        'id_pegawai' => $row['id_pegawai']
        , 'username' => $row['username']
        , 'nama' => $row['nama']
        , 'telepon' => $row['telepon']
		, 'password' => $row['password']
        , 'group_id' => $row['group_id']
    );
}
#echo "<pre>".print_r($arr_p_cs,true)."</pre>";


switch ($_REQUEST['proses']) {
    case 1:$row_edit = edit_detail($_REQUEST['id_pegawai']);
        break;
    case 2:
        break;
}

if ($_POST['formSubmit'] == 1) {
    switch ($_POST['tProses']) {
        case 1:updateUser($_REQUEST);
            break;
        default :insertBaru($_REQUEST);
            break;
    }

    echo "<script>window.location.href='management_user.php';</script>";
    exit;
}

require_once './template/header.php';
require_once './template/header_m.php';
?>
<style>
    .ui-autocomplete-loading {
        background: white url("images/ui-anim_basic_16x16.gif") right center no-repeat;
    }
</style>
<section>
    <div class="mainwrapper">
        <?php require_once './template/left_bar_menu.php'; ?>
        <div class="mainpanel">


            <div class="pageheader">
                <div class="media">
                    <div class="pageicon pull-left">
                        <i class="fa fa fa-male"></i>
                    </div>
                    <div class="media-body">
                        <ul class="breadcrumb">
                            <li><a href="#"><i class=""></i></a></li>

                        </ul>
                        <h4>Management User</h4>
                    </div>
                </div>
            </div><!-- pageheader -->

            <div class="contentpanel">
                <div class="row">


                    <div class="col-md-6">
                        <form class="form-horizontal form-bordered" method="POST" action="management_user.php" id="form2">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">Form User</h4>

                                </div>
                                <div class="panel-body nopadding">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">UserName:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" value="<?= $row_edit['username'] ?>" name="username">
                                        </div>
                                    </div><!-- form-group -->

									
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Nama:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" value="<?= $row_edit['nama'] ?>" name="nama">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">Telepon:</label>
                                        <div class="col-sm-8">
                                            <input type="text" class="form-control" value="<?= $row_edit['telepon'] ?>" name="telepon">
                                        </div>
                                    </div>

									<div class="form-group">
                                        <label class="col-sm-4 control-label">password:</label>
                                        <div class="col-sm-8">
                                            <input type="password" class="form-control" value="<?= $row_edit['password'] ?>" name="password">
                                        </div>
                                    </div><!-- form-group -->

                                    <div class="form-group">
                                        <label class="col-sm-4 control-label">GroupId:</label>
                                        <div class="col-sm-4">
                                            <select class="width100p"  id="petugas" name="petugas" required>
                                                <option value="1">Admin</option>
                                                <option value="2">Fitting</option>  
                                                <option value="3">Cs</option>  
                                                <option value="0">Reception</option>  
                                            </select>
                                        </div>
                                    </div><!-- form-group -->
                                </div><!-- panel-body -->
                                <div class="panel-footer">
                                    <button class="btn btn-primary mr5">Submit</button>
                                    <button class="btn btn-default" type="reset">Reset</button>
                                </div><!-- panel-footer -->
                            </div><!-- panel -->
                            <input type="hidden" value="<?= $_REQUEST['proses'] ?>" name="tProses"/>
                            <input type="hidden" value="1" name="formSubmit"/>
                            <input type="hidden" value="<?= $row_edit['id_pegawai'] ?>" name="idPegawai"/>
                        </form>
                    </div>


                    <div class="table-responsive">
                        <table class="table mb30">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Id Pegawai</th>
                                    <th>Username</th>
									<th>Nama</th>
                                    <th>Telepon</th>
									<th>password</th>
                                    <th>Group ID</th>
                                    <th>Proses</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $x = 1;
                                foreach ($arr_p_cs as $row) {
                                    ?>     
                                    <tr>
                                        <td><?= $x ?></td>
                                        <td><?= $row['id_pegawai'] ?></td>
                                        <td><?= $row['username'] ?></td>
                                        <td><?= $row['nama'] ?></td>
                                        <td><?= $row['telepon'] ?></td>
										<td><?= $row['password'] ?></td>
                                        <td><?= $row['group_id'] ?></td>
                                        <td class="table-action">
                                            <a class="tooltips" title="" data-toggle="tooltip" href="management_user.php?proses=1&id_pegawai=<?= $row['id_pegawai'] ?>" data-original-title="Edit"><i class="fa fa-pencil"></i></a>
                                            <a class="delete-row tooltips" title="" onclick="deleteUser('<?= $row['id_pegawai'] ?>')" data-toggle="tooltip" href="#" data-original-title="Delete"><i class="fa fa-trash-o"></i></a>
                                        </td>
                                    </tr>
                                    <?php
                                    $x++;
                                }
                                ?>    
                            </tbody>
                        </table>
                    </div>


                </div>

            </div> 


        </div>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function () {
        $('#petugas').val('<?= $row_edit['group_id'] ?>');
    });
    function deleteUser(id_pegawai) {
        var strconfirm = confirm("Are you sure you want to delete?");
        if (strconfirm) {
            window.location.href = 'management_user.php?prosesdel=delete&id_pegawai='+id_pegawai;
        }
    }
</script>


<?php

function edit_detail($id_pegawai) {

    $sql = "select * from sys_user_antrian where id_pegawai=$id_pegawai";
    $data = mysql_query($sql);
    $row = mysql_fetch_array($data);
    return $row;
}

function updateUser($data) {

    $sqlUpdate = "update sys_user_antrian "
            . " set username='" . $data['username'] . "' "
            . ",nama='" . $data['nama'] . "'"
            . ",telepon='" . $data['telepon'] . "'"
			. " set password='" . md5($data['password']) . "' "
            . ",group_id='" . $data['petugas'] . "'"
            . " where id_pegawai='" . $data['idPegawai'] . "'";

    #echo "<pre>".print_r($sqlUpdate,true)."</pre>";exit;
    $data = mysql_query($sqlUpdate);
}

function insertBaru($data) {

    if ($data['username'] != '') {
        $sqlInsert = "insert into  sys_user_antrian  (username,nama,telepon,password,group_id)"
                . " values ('" . $data['username'] . "' "
				. ",'" . $data['nama'] . "'"
                . ",'" . $data['telepon'] . "'"
                . ",'" . md5($data['password']) . "'"
                . ",'" . $data['petugas'] . "'"
                . ")";


        $data = mysql_query($sqlInsert);
    }
}
?>