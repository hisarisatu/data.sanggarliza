<? 
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


if (($SAH[id_group]==3) or ($SAH[id_group]==1) or ($SAH[id_group]==5))
{



if ((strlen($run) < 1) and ($id <> "")){ 
	$runSQL = "select id_client, nama_cpw, nama_ortu_cpw, tlp_rumah_cpw, tlp_mobile_cpw, alamat_cpw, nama_cpp, nama_ortu_cpp, tlp_rumah_cpp, tlp_mobile_cpp, alamat_cpp, tgl_rencana, catatan,email,facebook,twiter,id_pegawai from client where id_client='$id'";
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id_client = $row[id_client];
		$nama_cpw = $row[nama_cpw];
		$nama_ortu_cpw = $row[nama_ortu_cpw];
		$tlp_rumah_cpw = $row[tlp_rumah_cpw];
		$tlp_mobile_cpw = $row[tlp_mobile_cpw];
		$alamat_cpw = $row[alamat_cpw];
		$nama_cpp = $row[nama_cpp];
		$nama_ortu_cpp = $row[nama_ortu_cpp];
		$tlp_rumah_cpp = $row[tlp_rumah_cpp];
		$tlp_mobile_cpp = $row[tlp_mobile_cpp];
		$alamat_cpp = $row[alamat_cpp];
        $tgl_rencana = $row[tgl_rencana];
		$tmp_tanggal = explode("-",$tgl_rencana);
        $new_tanggal = $tmp_tanggal[1]."/".$tmp_tanggal[2]."/".$tmp_tanggal[0]; 
		$catatan = $row[catatan];
		$email = $row[email];
		$facebook = $row[facebook];
		$twiter = $row[twiter];
		$id_pegawai = $row[id_pegawai];
	};//if
};//if-id

if (strlen($run) > 1){ 

	$nama_cpw = ucwords($nama_cpw);
	$nama_ortu_cpw = ucwords($nama_ortu_cpw);
	$alamat_cpw = ucwords($alamat_cpw);
	$nama_cpp = ucwords($nama_cpp);
	$nama_ortu_cpp = ucwords($nama_ortu_cpp);
	$alamat_cpp = ucwords($alamat_cpp);
	$catatan = ucwords($catatan);
        $tmp_tanggal = explode("/",$tgl_rencana);
        $new_tanggal = $tmp_tanggal[2]."-".$tmp_tanggal[0]."-".$tmp_tanggal[1]; 

	$ok = 1;
	if (strlen($nama_cpw) < 5){ $inama_cpw = "<br><font color='#FF0000' size='1'><i>* Nama CPW tidak valid"; $ok=0; }
	//if (strlen($alamat_cpw) < 5){ $ialamat_cpw = "<br><font color='#FF0000' size='1'><i>* Alamat CPW tidak valid"; $ok=0; }
	//if ((($tlp_rumah_cpw*1) < 11111111) or (($tlp_rumah_cpw*1) > 99999999999) or (substr($tlp_rumah_cpw,0,1)<>"0")){ $itlp_rumah_cpw = "<br><font color='#FF0000' size='1'><i>* Telepon Rumah CPW tidak valid"; $ok=0; }
	//if ((($tlp_mobile_cpw*1) < 11111111) or (($tlp_mobile_cpw*1) > 99999999999) or (substr($tlp_mobile_cpw,0,1)<>"0")){ $itlp_mobile_cpw = "<br><font color='#FF0000' size='1'><i>* Nomor HP CPW tidak valid"; $ok=0; }

//if (strlen($email) < 5){ $iemail = "<br><font color='#FF0000' size='1'><i>* Email tidak valid"; $ok=0; }

if (strlen($id_pegawai) < 1){ $iid_pegawai = "<br><font color='#FF0000' size='1'><i>* Petugas CS tidak valid"; $ok=0; }

	if (($ok == 1) and ($id == "")){
		$registerInvalid = 1;
		$runSQL = "insert into client (nama_cpw, nama_ortu_cpw, tlp_rumah_cpw, tlp_mobile_cpw, alamat_cpw, nama_cpp, nama_ortu_cpp, tlp_rumah_cpp, tlp_mobile_cpp, alamat_cpp, tgl_rencana, catatan, id_user, login_ip, created,email,facebook,twiter,id_pegawai) VALUES ('$nama_cpw', '$nama_ortu_cpw', '$tlp_rumah_cpw', '$tlp_mobile_cpw', '$alamat_cpw', '$nama_cpp', '$nama_ortu_cpp', '$tlp_rumah_cpp', '$tlp_mobile_cpp', '$alamat_cpp', '$new_tanggal','$catatan', '$SAH[id_user]', '$REMOTE_ADDR', now(),'$email','$facebook','$twiter','$id_pegawai')";
		//echo $runSQL;
		$insert = mysql_query($runSQL, $connDB);
		$id = mysql_insert_id($connDB);
	} else if (($ok == 1) and ($id <> "")){
		$registerInvalid = 1;
		$runSQL = "update client set nama_cpw='$nama_cpw', nama_ortu_cpw='$nama_ortu_cpw', tlp_rumah_cpw='$tlp_rumah_cpw', tlp_mobile_cpw='$tlp_mobile_cpw', alamat_cpw='$alamat_cpw', nama_cpp='$nama_cpp', nama_ortu_cpp='$nama_ortu_cpp', tlp_rumah_cpp='$tlp_rumah_cpp', tlp_mobile_cpp='$tlp_mobile_cpp', alamat_cpp='$alamat_cpp', tgl_rencana='$new_tanggal', catatan='$catatan', user_update='$SAH[id_user]', ip_update='$REMOTE_ADDR', last_update=now(),email='$email',facebook='$facebook',twiter='$twiter',id_pegawai='$id_pegawai' where id_client='$id'";
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
	 <font class="titledata"><b>Input/Edit Data Client</b></font>

	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
     <td valign="bottom">
		 </td>
     <td valign="bottom" align="right">
			 <img src="images/arrow2.gif" border="0">
			 <a href="<?="?menu=$menu&uid=$uid&page=client";?>"><b>Back Data Client</b></a>
		 </td>
	  </tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	 </table>
         <script language="JavaScript" src="calendar_us.js"></script>
	 <table border="0" cellpadding="5" cellspacing="0" width="650">
		<tr><td colspan="2" width="100%" align="center"> <b>Data isian Calon Pengantin Wanita (CPW)</b> </td></tr>
		<tr>
			<td width="35%" align="right">Nama Lengkap CPW</td>
			<td width="65%"><input type="text" name="nama_cpw" size="40" value="<?=htmlentities(stripslashes($nama_cpw));?>"> <font color="#FF0000"><b>*</b></font> <?=$inama_cpw;?></td>
		</tr>
		<tr>
			<td width="35%" align="right">Nama Orang Tua CPW</td>
			<td width="65%"><input type="text" name="nama_ortu_cpw" size="40" value="<?=htmlentities(stripslashes($nama_ortu_cpw));?>"></td>
		</tr>
		<tr>
			<td width="35%" align="right">Telepon Rumah CPW</td>
			<td width="65%"><input type="text" name="tlp_rumah_cpw" size="20" value="<?=htmlentities(stripslashes($tlp_rumah_cpw));?>"> <font color="#FF0000"><b>*</b></font> <?=$itlp_rumah_cpw;?></td>
		</tr>
		<tr>
			<td width="35%" align="right">Nomor HP CPW</td>
			<td width="65%"><input type="text" name="tlp_mobile_cpw" size="20" value="<?=htmlentities(stripslashes($tlp_mobile_cpw));?>"> <font color="#FF0000"><b>*</b></font> <?=$itlp_mobile_cpw;?></td>
		</tr>
		<tr>
			<td width="35%" align="right">Alamat CPW</td>
			<td width="65%"><input type="text" name="alamat_cpw" size="55" value="<?=htmlentities(stripslashes($alamat_cpw));?>"> <font color="#FF0000"><b>*</b></font> <?=$ialamat_cpw;?></td>
		</tr>
		<tr><td colspan="2" width="100%" align="center"> <br><b>Data isian Calon Pengantin Pria (CPP)</b> </td></tr>
		<tr>
			<td width="35%" align="right">Nama Lengkap CPP</td>
			<td width="65%"><input type="text" name="nama_cpp" size="40" value="<?=htmlentities(stripslashes($nama_cpp));?>"> <?=$inama_cpp;?></td>
		</tr>
		<tr>
			<td width="35%" align="right">Nama Orang Tua CPP</td>
			<td width="65%"><input type="text" name="nama_ortu_cpp" size="40" value="<?=htmlentities(stripslashes($nama_ortu_cpp));?>"></td>
		</tr>
		<tr>
			<td width="35%" align="right">Telepon Rumah CPP</td>
			<td width="65%"><input type="text" name="tlp_rumah_cpp" size="20" value="<?=htmlentities(stripslashes($tlp_rumah_cpp));?>"></td>
		</tr>
		<tr>
			<td width="35%" align="right">Nomor HP CPP</td>
			<td width="65%"><input type="text" name="tlp_mobile_cpp" size="20" value="<?=htmlentities(stripslashes($tlp_mobile_cpp));?>"></td>
		</tr>
		<tr>
			<td width="35%" align="right">Alamat CPP</td>
			<td width="65%"><input type="text" name="alamat_cpp" size="55" value="<?=htmlentities(stripslashes($alamat_cpp));?>"></td>
		</tr><tr>
			<td width="35%" align="right"> Tanggal </td><td> <input type='text' name='tgl_rencana' size='11' value='<?=$new_tanggal?>'>
			<script language='JavaScript'> new tcal ({'formname': 'form','controlname': 'tgl_rencana'}); </script>
			</td>
			</tr>

		<tr><td colspan="2" width="100%" align="center"> <br><b>Catatan Tambahan bila ada informasi khusus.</b> </td></tr>
		<tr>
			<td width="35%" align="right">Catatan</td>
			<td width="65%"><input type="text" name="catatan" size="55" value="<?=htmlentities(stripslashes($catatan));?>"></td>
		</tr>
		<tr>
			<td width="35%" align="right">Email CPW/CPP</td>
			<td width="65%"><input type="text" name="email" size="20" value="<?=htmlentities(stripslashes($email));?>"> <font color="#FF0000"><b>*</b></font> <?=$iemail;?></td>
		</tr>
		<tr>
			<td width="35%" align="right">Facebook</td>
			<td width="65%"><input type="text" name="facebook" size="20" value="<?=htmlentities(stripslashes($facebook));?>"></td>
		</tr>
		<tr>
			<td width="35%" align="right">Twiter</td>
			<td width="65%"><input type="text" name="twiter" size="20" value="<?=htmlentities(stripslashes($twiter));?>"></td>
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
      - Pastikan anda telah memasukan data isian dengan lengkap dan benar!<br>
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

	$runSQL = "select id_client, nama_cpw, nama_ortu_cpw, tlp_rumah_cpw, tlp_mobile_cpw, alamat_cpw, nama_cpp, nama_ortu_cpp, tlp_rumah_cpp, tlp_mobile_cpp, alamat_cpp, tgl_rencana, catatan, id_user, login_ip, created, user_update, ip_update, last_update,email,facebook,twiter,id_pegawai from client where id_client='$id'";
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id_client = $row[id_client];
		$nama_cpw = $row[nama_cpw];
		$nama_ortu_cpw = $row[nama_ortu_cpw];
		$tlp_rumah_cpw = $row[tlp_rumah_cpw];
		$tlp_mobile_cpw = $row[tlp_mobile_cpw];
		$alamat_cpw = $row[alamat_cpw];
		$nama_cpp = $row[nama_cpp];
		$nama_ortu_cpp = $row[nama_ortu_cpp];
		$tlp_rumah_cpp = $row[tlp_rumah_cpp];
		$tlp_mobile_cpp = $row[tlp_mobile_cpp];
		$alamat_cpp = $row[alamat_cpp];
        $tgl_rencana = $row[tgl_rencana];
		$catatan = $row[catatan];
		$email = $row[email];
		$facebook = $row[facebook];
		$twiter = $row[twiter];
		$id_pegawai = $row[id_pegawai];
		$id_user = $row[id_user];
		$login_ip = $row[login_ip];
		$created = $row[created];
		$user_update = $row[user_update];
		$ip_update = $row[ip_update];
		$last_update = $row[last_update];
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
	 <font class="titledata"><b>Input/Edit Data Client</b><br></font>
	 <font color="#FF0000"><b>-- Data telah berhasil disimpan --</b><br><br></font>

	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr><td colspan="2" align="right"><a href='<?="?menu=$menu&uid=$uid&page=client_input&id=$id";?>'><img border='0' src='images/edit.gif' title='Edit Data'></a> &nbsp; &nbsp; </td></tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	  <tr>
     <td width="50%" valign="top" align="center">
		 <table border="0" cellpadding="5" cellspacing="0" width="100%">
			<tr><td colspan="2" width="100%" align="center"> <b>Data Calon Pengantin Wanita (CPW)</b> </td></tr>
			<tr>
				<td width="35%" align="right">Nama Lengkap CPW :</td>
				<td width="65%"><font class="datafield"><?=$nama_cpw;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Nama Orang Tua CPW :</td>
				<td width="65%"><font class="datafield"><?=$nama_ortu_cpw;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Telepon Rumah CPW :</td>
				<td width="65%"><font class="datafield"><?=$tlp_rumah_cpw;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Nomor HP CPW :</td>
				<td width="65%"><font class="datafield"><?=$tlp_mobile_cpw;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Alamat CPW :</td>
				<td width="65%"><font class="datafield"><?=$alamat_cpw;?></font></td>
			</tr>
            <tr>
                <td width="35%" align="right">Tanggal Rencana :</td>
                <td width="65%"><font class="datafield"><?=$tgl_rencana;?></font></td>
            </tr>
			<tr>
				<td width="35%" align="right">Catatan Tambahan :</td>
				<td width="65%"><font class="datafield"><?=$catatan;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Email CPW/CPP :</td>
				<td width="65%"><font class="datafield"><?=$email;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Facebook :</td>
				<td width="65%"><font class="datafield"><?=$facebook;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Twiter :</td>
				<td width="65%"><font class="datafield"><?=$twiter;?></font></td>
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
			
		 </table>
		 </td>
     <td width="50%" valign="top" align="center">
		 <table border="0" cellpadding="5" cellspacing="0" width="100%">
			<tr><td colspan="2" width="100%" align="center"> <b>Data Calon Pengantin Pria (CPP)</b> </td></tr>
			<tr>
				<td width="35%" align="right">Nama Lengkap CPP :</td>
				<td width="65%"><font class="datafield"><?=$nama_cpp;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Nama Orang Tua CPP :</td>
				<td width="65%"><font class="datafield"><?=$nama_ortu_cpp;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Telepon Rumah CPP :</td>
				<td width="65%"><font class="datafield"><?=$tlp_rumah_cpp;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Nomor HP CPP :</td>
				<td width="65%"><font class="datafield"><?=$tlp_mobile_cpp;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Alamat CPP :</td>
				<td width="65%"><font class="datafield"><?=$alamat_cpp;?></font></td>
			</tr>
		 </table>

		 <div align="right">
		 <hr size="1" color="#252525" style="border-top:1px dashed #252525;" width="70%" align="right">
		 <font size='1'><?=$inforecord;?></font>
		 </div>

		 </td>
	  </tr>
	 </table>

	 <p>&nbsp;</p>
	 <img src="images/arrow2.gif" border="0">
	 <a href="<?="?menu=$menu&uid=$uid&page=client";?>"><b>Back Data Client</b></a> | <a href="<?="?menu=$menu&uid=$uid&page=pesanan_input&id=$id_client";?>"><b>Input Pesanan</b></a>

   </td>
  </tr>
  </form>
</table>
<? };//registerInvalid 
}
else
{ echo "<div align='center'><font color='#FF0000'><b>Akses Tidak Diperbolehkan. Hanya Group Administrator</b></font></div>"; }

?>