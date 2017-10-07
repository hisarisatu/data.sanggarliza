<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 10 Oktober 2010, lastupdate 10 Oktober 2010

include_once("include.php");

if ((strlen($run) < 1) and ($id <> "")){ 
	$runSQL = "select id_pegawai, nama, tlp_rumah, tlp_mobile, alamat, gaji_dasar, transport, uang_makan, catatan, id_status from pegawai where id_pegawai='$id' ";
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id_pegawai = $row[id_pegawai];
		$nama = $row[nama];
		$tlp_rumah = $row[tlp_rumah];
		$tlp_mobile = $row[tlp_mobile];
		$alamat = $row[alamat];
		$id_status = $row[id_status];
		$catatan = $row[catatan];
		$gaji_dasar = $row[gaji_dasar];
		$transport = $row[transport];
		$uang_makan = $row[uang_makan];
	};//if
};//if-id

if (strlen($run) > 1){ 

	$nama = ucwords($nama);
	$alamat = ucwords($alamat);
	$catatan = ucwords($catatan);

	$ok = 1;
	//if (strlen($nama) < 5){ $inama = "<br><font color='#FF0000' size='1'><i>* Nama Pegawai tidak valid"; $ok=0; }
	//if (strlen($alamat) < 5){ $ialamat = "<br><font color='#FF0000' size='1'><i>* Alamat Pegawai tidak valid"; $ok=0; }
	//if ((($tlp_rumah*1) < 11111111) or (($tlp_rumah*1) > 99999999999) or (substr($tlp_rumah,0,1)<>"0")){ $itlp_rumah = "<br><font color='#FF0000' size='1'><i>* Telepon Rumah Pegawai tidak valid"; $ok=0; }
	//if ((($tlp_mobile*1) < 11111111) or (($tlp_mobile*1) > 99999999999) or (substr($tlp_mobile,0,1)<>"0")){ $itlp_mobile = "<br><font color='#FF0000' size='1'><i>* Nomor HP Pegawai tidak valid"; $ok=0; }

	if (($ok == 1) and ($id == "")){
		$registerInvalid = 1;
		$runSQL = "insert into pegawai VALUES (null,'$nama', '$tlp_rumah', '$tlp_mobile', '$alamat', '$id_status', '$gaji_dasar', '$transport', '$uang_makan', '$catatan', '$SAH[id_user]', '$REMOTE_ADDR', now(), '$SAH[id_user]', '$REMOTE_ADDR', now())";
		//echo $runSQL;
		$insert = mysql_query($runSQL, $connDB);
		$id = mysql_insert_id($connDB);
		for($i=0;$i<count($_POST[id_layanan]);$i++){
			$ri=mysql_query("insert into pegawai_pekerjaan(id_pegawai,id_pekerjaan,id_user,login_ip,created) values('$id','$_POST[id_layanan][$i]','$SAH[id_user]', '$REMOTE_ADDR', now())");
		}
	} else if (($ok == 1) and ($id <> "")){
		$registerInvalid = 1;
		$runSQL = "update pegawai set nama='$nama', tlp_rumah='$tlp_rumah', tlp_mobile='$tlp_mobile', alamat='$alamat', id_status='$id_status', gaji_dasar='$gaji_dasar', transport='$transport', uang_makan='$uang_makan', catatan='$catatan', user_update='$SAH[id_user]', ip_update='$REMOTE_ADDR', last_update=now() where id_pegawai='$id'";
		//echo $runSQL;
		$update = mysql_query($runSQL, $connDB);
		//print_r($_POST[id_layanan]);
		mysql_query("delete from pegawai_pekerjaan where id_pegawai='$id'");
		$id_layanan=$_POST[id_layanan];
		for($i=0;$i<count($id_layanan);$i++){
			$si="insert into pegawai_pekerjaan(id_pegawai,id_pekerjaan,id_user,login_ip,created) values('$id','$id_layanan[$i]','$SAH[id_user]', '$REMOTE_ADDR', now())";
			//echo "$si<br>";
			$ri=mysql_query($si);
		}
	};//if
};//end-if-submit

if ($registerInvalid <> 1){
?>

<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Input/Edit Data Pegawai</b></font>

	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
     <td valign="bottom">
		 </td>
     <td valign="bottom" align="right">
			 <img src="images/arrow2.gif" border="0">
			 <a href="<?="?menu=$menu&uid=$uid&page=pegawai";?>"><b>Back Data Pegawai</b></a>
		 </td>
	  </tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	 </table>

	 <table border="0" cellpadding="5" cellspacing="0" width="650">
		<tr><td colspan="2" width="100%" align="center"> <b>Data isian Pegawai</b> </td></tr>
		<tr>
			<td width="35%" align="right">Nama Lengkap</td>
			<td width="65%"><input type="text" name="nama" size="40" value="<?=htmlentities(stripslashes($nama));?>"> <font color="#FF0000"><b>*</b></font> <?=$inama;?></td>
		</tr>
		<tr>
			<td width="35%" align="right">Telepon Rumah</td>
			<td width="65%"><input type="text" name="tlp_rumah" size="20" value="<?=htmlentities(stripslashes($tlp_rumah));?>"> <font color="#FF0000"><b>*</b></font> <?=$itlp_rumah;?></td>
		</tr>
		<tr>
			<td width="35%" align="right">Nomor HP</td>
			<td width="65%"><input type="text" name="tlp_mobile" size="20" value="<?=htmlentities(stripslashes($tlp_mobile));?>"> <font color="#FF0000"><b>*</b></font> <?=$itlp_mobile;?></td>
		</tr>
		<tr>
			<td width="35%" align="right">Alamat</td>
			<td width="65%"><input type="text" name="alamat" size="55" value="<?=htmlentities(stripslashes($alamat));?>"> <font color="#FF0000"><b>*</b></font> <?=$ialamat;?></td>
		</tr>
		<tr>
			<td width="35%" align="right">Catatan</td>
			<td width="65%"><input type="text" name="catatan" size="55" value="<?=htmlentities(stripslashes($catatan));?>"></td>
		</tr>
		<tr>
			<td width="35%" align="right">Status</td>
			<td width="65%">
			<select name="id_status">
				<?
				$rsp=mysql_query("select id_status,status from p_pegawai_status");
				for($r=0;$r<@mysql_num_rows($rsp);$r++){
					$sp=mysql_result($rsp,$r,"id_status");
					echo "<option value=\"$sp\" ";
					if($id_status==0)echo " selected ";
					echo ">";
					echo mysql_result($rsp,$r,"status");
				}
				?>
			</select>
			</td>
		</tr>
		<tr>
			<td width="35%" align="right">Gaji Dasar</td>
			<td width="65%"><input type="text" name="gaji_dasar" size="55" value="<?=htmlentities(stripslashes($gaji_dasar));?>"></td>
		</tr>
		<tr>
			<td width="35%" align="right">Transportasi</td>
			<td width="65%"><input type="text" name="transport" size="55" value="<?=htmlentities(stripslashes($transport));?>"></td>
		</tr>
		<tr>
			<td width="35%" align="right">Uang Makan</td>
			<td width="65%"><input type="text" name="uang_makan" size="55" value="<?=htmlentities(stripslashes($uang_makan));?>"></td>
		</tr>
		<tr>
			<td width="35%" align="right">Bagian Layanan</td>
			<td width="65%">
				<table>
				<tr>
				<?
				$rl=mysql_query("select id_layanan,layanan from p_layanan");
				$limit=6;$a=0;$total=mysql_num_rows($rl);
				while($r=mysql_fetch_array($rl)){
					$a++;
					$rcek=mysql_query("select count(*) jml from pegawai_pekerjaan where id_pegawai='$id' and id_pekerjaan='$r[id_layanan]'");
					$cek=@mysql_result($rcek,0,"jml");
					if($a%$limit==1)echo "<tr>";
					echo "<td nowrap><input type=\"checkbox\" value=\"$r[id_layanan]\" ";
					if($cek!=0)echo " checked ";
					echo " name=\"id_layanan[]\">$r[layanan]</td>";
					if($a==$limit)echo "</tr>";
				}
				?>
				</tr>
				</table>
			</td>
		</tr>
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

	$runSQL = "select a.id_pegawai, nama, tlp_rumah, tlp_mobile, alamat, gaji_dasar, transport, uang_makan, catatan, status, id_user, login_ip, created, user_update, ip_update, last_update from pegawai a, p_pegawai_status b where a.id_pegawai='$id' and a.id_status=b.id_status";
	//echo $runSQL;/developer
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id_pegawai = $row[id_pegawai];
		$nama = $row[nama];
		$tlp_rumah = $row[tlp_rumah];
		$tlp_mobile = $row[tlp_mobile];
		$alamat = $row[alamat];
		$gaji_dasar = $row[gaji_dasar];
		$transport = $row[transport];
		$uang_makan = $row[uang_makan];
		$status = $row[status];
		$catatan = $row[catatan];
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
	 <font class="titledata"><b>Input/Edit Data Pegawai</b><br></font>
	 <font color="#FF0000"><b>-- Data telah berhasil disimpan --</b><br><br></font>

	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr><td colspan="2" align="right"><a href='<?="?menu=$menu&uid=$uid&page=pegawai_input&id=$id";?>'><img border='0' src='images/edit.gif' title='Edit Data'></a> &nbsp; &nbsp; </td></tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	  <tr>
     <td width="50%" valign="top" align="center">
		 <table border="0" cellpadding="5" cellspacing="0" width="100%">
			<tr><td colspan="2" width="100%" align="center"> <b>Data Pegawai</b> </td></tr>
			<tr>
				<td width="35%" align="right">Nama Lengkap :</td>
				<td width="65%"><font class="datafield"><?=$nama;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Telepon Rumah :</td>
				<td width="65%"><font class="datafield"><?=$tlp_rumah;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Nomor HP :</td>
				<td width="65%"><font class="datafield"><?=$tlp_mobile;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Alamat :</td>
				<td width="65%"><font class="datafield"><?=$alamat;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Gaji Dasar :</td>
				<td width="65%"><font class="datafield"><?=number_format($gaji_dasar,0);?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Uang Transport :</td>
				<td width="65%"><font class="datafield"><?=number_format($transport,0);?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Uang Makan :</td>
				<td width="65%"><font class="datafield"><?=number_format($uang_makan,0);?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Catatan Tambahan :</td>
				<td width="65%"><font class="datafield"><?=$catatan;?></font></td>
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
	 <a href="<?="?menu=$menu&uid=$uid&page=pegawai";?>"><b>Back Data Pegawai</b></a>

   </td>
  </tr>
  </form>
</table>
<? };//registerInvalid ?>