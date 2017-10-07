<?php
 
// Sisten Informasi Sanggar LIZA
// Written by iyok642@yahoo.com; 031-70920002
// 23 Agustus 2010, lastupdate 23 Agustus 2010

include_once("include.php");

function js_submit()
{
        echo "<script language=javascript>\n";
        echo "function submit_form() {\n";
        echo "  document.forms[0].submit();\n";
        echo "}\n";
        echo "</script>\n";

}
function generate_select_event($name,$sql,$default,$onchange)
{
		$result = mysql_query($sql);
        $nrows=0;
        while ($row = mysql_fetch_array ($result))
        {
                $nrows++;
                $key = $row[0];
                $value = $row[1];
                $arr["$key"] = $value;
        }
        echo "<select name=$name onchange=\"$onchange;\">\n";
        if (!$default) {
                echo "<option value=0>-- Pilih --</option>\n";
        }
        while (list($key,$val) = each($arr))
        {
                if ($default==$key) {
                        echo "<option value=$key selected>$val</option>\n";
                } else {
                        echo "<option value=$key>$val</option>\n";
                }
        }
        echo "</select>";
}

function generate_select($name,$sql,$default)
{

		$result = mysql_query($sql);
        $nrows=0;
        while ($row = mysql_fetch_array ($result))
        {
                $nrows++;
                $key = $row[0];
                $value = $row[1];
                $arr["$key"] = $value;
        }

        echo "<select name=$name>\n";
        while (list($key,$val) = each($arr))
        {
                if ($default==$key) {
                        echo "<option value=$key selected>$val</option>\n";
                } else {
                        echo "<option value=$key>$val</option>\n";
                }
        }
        echo "</select>";
}

function generate_select_program($name,$sql,$default)
{

		$result = mysql_query($sql);
        $nrows=0;
        while ($row = mysql_fetch_array ($result))
        {
                $nrows++;
                $key = $row[0];
                $value = $row[1];
                $arr["$key"] = $value;
        }

        echo "<select name=$name>\n";
        while (list($key,$val) = each($arr))
        {
                if ($default==$key) {
                        echo "<option value=$key selected>$val</option>\n";
                } else {
                        echo "<option value=$key>$val</option>\n";
                }
        }
        echo "</select>";
}

function generate_select_narasumber($name,$sql,$default)
{

		$result = mysql_query($sql);
        $nrows=0;
        while ($row = mysql_fetch_array ($result))
        {
                $nrows++;
                $key = $row[0];
                $value = $row[1];
                $arr["$key"] = $value;
        }

        echo "<select name=$name>\n";
        while (list($key,$val) = each($arr))
        {
                if ($default==$key) {
                        echo "<option value=$key selected>$val</option>\n";
                } else {
                        echo "<option value=$key>$val</option>\n";
                }
        }
        echo "</select>";
}

if (($SAH[id_group]==9) or ($SAH[id_group]==1))
{



if ((strlen($run) < 1) and ($id <> "")){ 
	$runSQL = "SELECT
  id_siswa,
  nama_siswa,
  no_telp,
  email,
  alamat,
  tgl_mulai,
  tgl_selesai,
  catatan,
  created,
  id_user,
  id_program,
  id_narasumber,
  login_ip,
  ip_update,
  user_update,
  last_update,
  id_pegawai,
  status
FROM tb_siswa
WHERE id_siswa = '$id'";
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id_siswa 			= $row[id_siswa];
		$nama_siswa 		= $row[nama_siswa];
		$email     		    = $row[email];
		$no_telp 			= $row[no_telp];
		$id_program 		= $row[id_program];
		$id_narasumber 		= $row[id_narasumber];
		$alamat 			= $row[alamat];
        $tgl_mulai	 		= $row[tgl_mulai];
		$tmp_tanggal 		= explode("-",$tgl_mulai);
        $new_tanggal 		= $tmp_tanggal[1]."/".$tmp_tanggal[2]."/".$tmp_tanggal[0];
        $tgl_selesai 		= $row[tgl_selesai];
		$tmp_tanggal2 		= explode("-",$tgl_selesai);
        $new_tanggal2 		= $tmp_tanggal2[1]."/".$tmp_tanggal2[2]."/".$tmp_tanggal2[0]; 
		$catatan 			= $row[catatan];
		$id_user 			= $row[id_user];
		$id_pegawai 		= $row[id_pegawai];
		$status 			= $row[status];
	};//if
};//if-id

if (strlen($run) > 1){ 

	
	$nama_siswa 	= ucwords($nama_siswa);
	$email 			= ucwords($email);
	$no_telp 		= ucwords($no_telp);
	$alamat 		= ucwords($alamat);
	$catatan 		= ucwords($catatan);
	$id_program 	= ucwords($id_program);
    $tmp_tanggal 	= explode("/",$tgl_mulai);
    $new_tanggal 	= $tmp_tanggal[2]."-".$tmp_tanggal[0]."-".$tmp_tanggal[1]; 
    $tmp_tanggal2 	= explode("/",$tgl_selesai);
    $new_tanggal2 	= $tmp_tanggal2[2]."-".$tmp_tanggal2[0]."-".$tmp_tanggal2[1]; 

	$ok = 1;
	if (strlen($nama_siswa) < 1){ $inama_siswa = "<br><font color='#FF0000' size='1'><i>* Nama CPW tidak valid"; $ok=0; }

if (strlen($id_pegawai) < 1){ $iid_pegawai = "<br><font color='#FF0000' size='1'><i>* Petugas CS tidak valid"; $ok=0; }

	if (($ok == 1) and ($id == "")){
		$registerInvalid = 1;
		$runSQL = "INSERT INTO tb_siswa
            (nama_siswa,
             alamat,
             no_telp,
             email,
             tgl_mulai,
             tgl_selesai,
             catatan,
             created, id_user, id_program, id_narasumber, login_ip, id_pegawai,
             status)
VALUES ('$nama_siswa',
        '$alamat',
        '$no_telp',
        '$email',
        '$new_tanggal',
        '$new_tanggal2',
        '$catatan',
         NOW(),
		'$SAH[id_user]',
		'$id_program',
		'$id_narasumber',
        '$REMOTE_ADDR',
        '$id_pegawai',
        '$status')";
		//echo $runSQL;
		$insert = mysql_query($runSQL, $connDB);
		$id = mysql_insert_id($connDB);
	} else if (($ok == 1) and ($id <> "")){
		$registerInvalid = 1;
		$runSQL = "UPDATE tb_siswa
SET nama_siswa = '$nama_siswa',
  alamat = '$alamat',
  no_telp = '$no_telp',
  email = '$email',
  tgl_mulai = '$new_tanggal',
  tgl_selesai = '$new_tanggal2',
  catatan = '$catatan',
  user_update = '$SAH[id_user]',
  id_program = '$id_program',
  id_narasumber = '$id_narasumber',
  ip_update = '$REMOTE_ADDR',
  last_update = NOW(),
  id_pegawai = '$id_pegawai',
  status = '$status'
WHERE id_siswa = '$id'";
		//echo $runSQL;
		$update = mysql_query($runSQL, $connDB);
	};//if
};//end-if-submit

if ($registerInvalid <> 1){
?>

<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Input/Edit Data Siswa</b></font>

	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
     <td valign="bottom">
		 </td>
     <td valign="bottom" align="right">
			 <img src="images/arrow2.gif" border="0">
			 <a href="<?="?menu=$menu&uid=$uid&page=program_belajar";?>"><b>Back Data Siswa</b></a>
		 </td>
	  </tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	 </table>
         <script language="JavaScript" src="calendar_us.js"></script>
	 <table border="0" cellpadding="5" cellspacing="0" width="650">
		<tr><td colspan="2" width="100%" align="center"> <br><b>Data isian Calon Siswa</b> </td></tr>
		
		<tr>
			<td width="35%" align="right">Nama Lengkap</td>
			<td width="65%"><input type="text" name="nama_siswa" size="40" value="<?=htmlentities(stripslashes($nama_siswa));?>"> <?=$inama_siswa;?></td>
		</tr>
		<tr>
			<td width="35%" align="right">Email</td>
			<td width="65%"><input type="text" name="email" size="40" value="<?=htmlentities(stripslashes($email));?>"></td>
		</tr>
		<tr>
			<td width="35%" align="right">Nomor HP</td>
			<td width="65%"><input type="text" name="no_telp" size="20" value="<?=htmlentities(stripslashes($no_telp));?>"></td>
		</tr>
		<tr>
			<td width="35%" align="right">Alamat</td>
			<td width="65%"><input type="text" name="alamat" size="55" value="<?=htmlentities(stripslashes($alamat));?>"></td>
		</tr>
		<tr>
			<td width="35%" align="right">Program Kelas</td>
			<td width="65%">
			<?
			$sqlprogram="select distinct id_program, nama_program from tb_program union select 0,'--Pilih Program Kelas--' from dual";
			generate_select_program("id_program",$sqlprogram,$id_program);
			?><font color="#FF0000"><b> *</b></font><?=$iid_program;?>
			</td>
		</tr>
		<tr>
			<td width="35%" align="right">Narasumber</td>
			<td width="65%">
			<?
			$sqlnarasumber="select distinct id_narasumber, nama_narasumber from tb_narasumber union select 0,'--Pilih Program Kelas--' from dual";
			generate_select_narasumber("id_narasumber",$sqlnarasumber,$id_narasumber);
			?><font color="#FF0000"><b> *</b></font><?=$iid_narasumber;?>
			</td>
		</tr>
		<tr>
			<td width="35%" align="right"> Tanggal Mulai</td><td> <input type='text' name='tgl_mulai' size='11' value='<?=$new_tanggal?>'>
			<script language='JavaScript'> new tcal ({'formname': 'form','controlname': 'tgl_mulai'}); </script>
			</td>
		</tr>
		<tr>
			<td width="35%" align="right"> Tanggal Selesai</td><td> <input type='text' name='tgl_selesai' size='11' value='<?=$new_tanggal2?>'>
			<script language='JavaScript'> new tcal ({'formname': 'form','controlname': 'tgl_selesai'}); </script>
			</td>
		</tr>
		<tr><td colspan="2" width="100%" align="center"> <br><b>Catatan Tambahan bila ada informasi khusus.</b> </td></tr>
		<tr>
			<td width="35%" align="right">Catatan</td>
			<td width="65%"><input type="text" name="catatan" size="55" value="<?=htmlentities(stripslashes($catatan));?>"></td>
		</tr>
		<tr>
			<td width="35%" align="right">Petugas CS</td>
			<td width="65%">
			<?
			$sqlpetugas="select distinct a.id_pegawai,a.nama from pegawai a,pegawai_pekerjaan b
			where a.id_pegawai=b.id_pegawai and b.id_pekerjaan=23 union select 0,'--Pilih Petugas CS--' from dual";
			generate_select("id_pegawai",$sqlpetugas,$id_pegawai);
			?><font color="#FF0000"><b> *</b></font><?=$iid_pegawai;?>
			</td>
		</tr>
		 <tr>
			<td width="35%" align="right">Status</td>
			<td width="65%"><select name="status" style="margin:0px;"><option value="aktif"<?php if($status=='Aktif'){echo ' selected';};?>>Aktif</option><option value="close"<?php if($surat=='Close'){echo ' selected';};?>>Close</option></select> </td>
		  </tr>
		<tr>
		<tr>
			<td width="35%" align="right">&nbsp;</td>
			<td width="65%">
			<input type="hidden" name="id" value="<?=$id;?>"><br>
			<input type="submit" value="Simpan" name="run" class="button">
      </td>
		</tr>
		<tr>
			<td width="100%" colspan="2" align="left">
			Keterangan : <br>
     		-PilihPastikan anda telah memasukan data isian dengan lengkap dan benar!<br>
			- Tanda <font color="#FF0000"><b>*</b></font> wajib diisi tidak boleh kosong.
		  </td>
		</tr>
	 </table>

   </td>
  </tr>
  </form>
</table>
<?

} else {
//registerInvalid

	$runSQL = "select id_siswa,  nama_siswa, email, alamat, no_telp, tgl_mulai, tgl_selesai, catatan, id_user, id_program, id_narasumber,login_ip, created, user_update, ip_update, last_update, id_pegawai,status from tb_siswa where id_siswa='$id'";
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id_siswa 		= $row[id_siswa];
		
		$nama_siswa 	= $row[nama_siswa];
		$alamat 		= $row[alamat];
		$no_telp 		= $row[no_telp];
		$email 			= $row[email];
		$tgl_mulai 		= $row[tgl_mulai];
		$tgl_selesai 	= $row[tgl_selesai];
		$catatan 		= $row[catatan];
		$created 		= $row[created];
		$id_user 		= $row[id_user];
		$id_program     = $row[id_program];
		$id_narasumber  = $row[id_narasumber];
		$login_ip 		= $row[login_ip];
        $ip_update 		= $row[ip_update];
		$user_update 	= $row[user_update];
		$last_update 	= $row[last_update];
		$id_pegawai 	= $row[id_pegawai];
		$status 		= $row[status];
		$id_pegawai 	= $row[id_pegawai];
		$id_user 		= $row[id_user];
		$login_ip 		= $row[login_ip];
		$created 		= $row[created];
		$user_update	= $row[user_update];
		$ip_update 		= $row[ip_update];
		$last_update 	= $row[last_update];
		$status 		= $row[status];
	};

	if ($id_user > 0){
		$runSQL2 = "select id_user, fullname from sys_username where id_user='$id_user'";
		$result2 = mysql_query($runSQL2, $connDB);
		$CRE = mysql_fetch_array ($result2);
		$inforecord = "Input: $CRE[fullname], $created";
	};

	if ($user_update > 0){
		$runSQL2 = "select id_user, fullname from sys_username where id_user='$user_update'";
		$result2 = mysql_query($runSQL2, $connDB);
		$UPD = mysql_fetch_array ($result2);
		$inforecord .= "<br>Update: $UPD[fullname], $last_update";
	};
?>

<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Input/Edit Data Siswa</b><br></font>
	 <font color="#FF0000"><b>-- Data telah berhasil disimpan --</b><br><br></font>

	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr><td colspan="2" align="right"><a href='<?="?menu=$menu&uid=$uid&page=siswa_input&id=$id";?>'><img border='0' src='images/edit.gif' title='Edit Data'></a> &nbsp; &nbsp; </td></tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	  <tr>
     <td width="50%" valign="top" align="center">
		 <table border="0" cellpadding="5" cellspacing="0" width="100%">
			<tr><td colspan="2" width="100%" align="center"> <b>Data Siswa Baru</b> </td></tr>
			
			<tr>
				<td width="35%" align="right">Nama Lengkap :</td>
				<td width="65%"><font class="datafield"><?=$nama_siswa;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Email :</td>
				<td width="65%"><font class="datafield"><?=$email;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">No Tetelpon :</td>
				<td width="65%"><font class="datafield"><?=$no_telp;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Alamat :</td>
				<td width="65%"><font class="datafield"><?=$alamat;?></font></td>
			</tr>
			<tr>
			<td width="35%" align="right">Program Kelas</td>
			<td width="65%">
			<?
			$sqlprogram="select distinct id_program, nama_program from tb_program union select 0,'--Pilih Program Kelas--' from dual";
			generate_select_program("id_program",$sqlprogram,$id_program);
			?>
			</td>
		</tr>
		<tr>
			<td width="35%" align="right">Narasumber</td>
			<td width="65%">
			<?
			$sqlnarasumber="select distinct id_narasumber, nama_narasumber from tb_narasumber union select 0,'--Pilih Program Kelas--' from dual";
			generate_select_narasumber("id_narasumber",$sqlnarasumber,$id_narasumber);
			?>
			</td>
		</tr>
            <tr>
                <td width="35%" align="right">Tanggal Mulai :</td>
                <td width="65%"><font class="datafield"><?=$tgl_mulai;?></font></td>
            </tr>
            <tr>
                <td width="35%" align="right">Tanggal Selesai :</td>
                <td width="65%"><font class="datafield"><?=$tgl_selesai;?></font></td>
            </tr>
		<tr>
			<td width="35%" align="right">Petugas CS</td>
			<td width="65%">
			<?
			$sqlpetugas="select distinct a.id_pegawai,a.nama from pegawai a,pegawai_pekerjaan b
			where a.id_pegawai=b.id_pegawai and b.id_pekerjaan=23 union select 0,'--Pilih Petugas CS--' from dual";
			generate_select("id_pegawai",$sqlpetugas,$id_pegawai);
			?>
			</td>
		</tr>
			<tr>
				<td width="35%" align="right">Status :</td>
				<td width="65%"><font class="datafield"><?=$status;?></font></td>
			</tr>
		 </table>
		 </td>
     	 <td width="50%" valign="top" align="center">

		 <div align="right">
		 <hr size="1" color="#252525" style="border-top:1px dashed #252525;" width="70%" align="right">
		 <font size='1'><?=$inforecord;?></font>
		 </div>

		 </td>
	  </tr>
	 </table>

	 <p>&nbsp;</p>
	 <img src="images/arrow2.gif" border="0">
	 <a href="<?="?menu=$menu&uid=$uid&page=program_belajar";?>"><b>Back Data Siswa</b></a> | <a href="<?="?menu=$menu&uid=$uid&page=siswa_input&id=$id_siswa";?>"><b>Input Siswa</b></a>

   </td>
  </tr>
  </form>
</table>
<? };//registerInvalid 
}
else
{ echo "<div align='center'><font color='#FF0000'><b>Akses Tidak Diperbolehkan. Hanya Group Administrator</b></font></div>"; }

?>