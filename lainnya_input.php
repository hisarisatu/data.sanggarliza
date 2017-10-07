<? 
// Sisten Informasi Sanggar LIZA
// Written by iyok642@yahoo.com; 031-70920002
// 23 Agustus 2010, lastupdate 23 Agustus 2010

include_once("include.php");

$runSQL = "select id_client, nama_cpw, nama_ortu_cpw, tlp_rumah_cpw, tlp_mobile_cpw, alamat_cpw, nama_cpp, nama_ortu_cpp, tlp_rumah_cpp, tlp_mobile_cpp, alamat_cpp, catatan, id_user, login_ip, created, user_update, ip_update, last_update from client where id_client='$id'";
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

unset($ccc);
$runSQL = "select id_acara, acara from p_acara where id_acara='$id_acara'";
$result = mysql_query($runSQL, $connDB);
if ($row = mysql_fetch_array ($result)) { $infoacara = $row[acara]; }
?>

<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <tr>
   <td width="100%" align="center" vAlign="top">

	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
     <td width="50%" valign="bottom" align="left"> &nbsp; 
	     <font class="titledata" color="#009900"><b>Data Client</b></font>
		 </td>
     <td width="50%" valign="bottom" align="right">
	     <a href='<?="?menu=$menu&uid=$uid&page=client_input&id=$id";?>'><img border='0' src='images/edit.gif' title='Edit Data'></a> &nbsp; &nbsp; 
		 </td>
		</tr>
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
				<td width="35%" align="right">Catatan Tambahan :</td>
				<td width="65%"><font class="datafield"><?=$catatan;?></font></td>
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

<?
if (strlen($run) > 1){ 
	for ($zzz=1; $zzz<=8; $zzz++){
		$vrb_lain = "lain".$zzz;
		$vlu_lain = $$vrb_lain;
		$vrb_catatan = "catatan".$zzz;
		$vlu_catatan = $$vrb_catatan;
		$vrb_harga = "harga".$zzz;
		$vlu_harga = $$vrb_harga;

		if ($vlu_catatan <> ""){
			$runSQL2 = "select id_client from order_lain where id_client='$id' and id_acara='$id_acara' and id_lain='$zzz'";
			$result2 = mysql_query($runSQL2, $connDB);
			if ($row2 = mysql_fetch_array($result2)) {
				//update data
				$runSQL2 = "update order_lain set catatan='$vlu_catatan', harga_baru=$vlu_harga, user_update='$SAH[id_user]', ip_update='$REMOTE_ADDR', last_update=now() where id_client='$id' and id_acara='$id_acara' and id_lain='$zzz'";
				$update2 = mysql_query($runSQL2, $connDB);
			}else{
				//insert data
				$runSQL2 = "insert into order_lain (id_client, id_acara, id_lain, catatan, harga_baru, id_user, login_ip, created) VALUES ('$id', '$id_acara', '$zzz', '$vlu_catatan', $vlu_harga, '$SAH[id_user]', '$REMOTE_ADDR', now())";
				$insert2 = mysql_query($runSQL2, $connDB);
			};
			//echo $runSQL2;
		};//simpan data

		if ($vlu_catatan == ""){
			$runSQL2 = "delete from order_lain where id_client='$id' and id_acara='$id_acara' and id_lain='$zzz'";
			$delete = mysql_query($runSQL2, $connDB);
			//echo "$runSQL2<br>";
		};//delete data
	};//while
	redirect("?menu=$menu&uid=$uid&page=view&id=$id");
};//end-if-submit


if ($registerInvalid <> 1){
	if ((strlen($run) < 1) and ($id <> "")){ 
		$runSQL = "select id_client, id_acara, id_lain, catatan, harga_baru from order_lain where id_client='$id' and id_acara='$id_acara' order by id_lain asc";
		$result = mysql_query($runSQL, $connDB);
		while ($row = mysql_fetch_array ($result)) {
			$vrb_lain = "lain".$row[id_lain];
			$$vrb_lain = $row[id_lain];
			$vrb_catatan = "catatan".$row[id_lain];
			$$vrb_catatan = $row[catatan];
			$vrb_harga = "harga".$row[id_lain];
			$$vrb_harga = $row[harga_baru];
		};//while
	};//if

	for ($zzz=1; $zzz<=8; $zzz++){
		$vrb_lain = "lain".$zzz;
		$vlu_lain = $$vrb_lain;
		$vrb_catatan = "catatan".$zzz;
		$vlu_catatan = $$vrb_catatan;
		$vrb_harga = "harga".$zzz;
		$vlu_harga = $$vrb_harga;
		if ($vlu_lain == $zzz){ $checked="checked"; }else{ unset($checked); };

		$ccc++;
		if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
		$htmlData .= "
			<tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"'>
				<td align='center'> <input type='hidden' name='$vrb_lain' value='$zzz'> <b>$zzz.<b></td>
				<td>
				 <table width='100%' border='0' cellpadding='2' cellspacing='0'>
					<tr>
					 <td> Tambahan </td><td> : </td><td> <input type='text' name='$vrb_catatan' size='70' value=\"".htmlentities(stripslashes($vlu_catatan))."\"></td>
					</tr>
					<tr>
					 <td> Harga </td><td> : </td><td> <input type='text' name='$vrb_harga' size='10' value=\"$vlu_harga\"></td>
					</tr>
				 </table>
				</td>
			</tr>
		";//htmlData
	};//end-while
?>

	 <p>&nbsp;</p>
   <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
	 <font class="titledata"><b>Input/Edit Tambahan</b><br></font>
	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
     <td width="50%" valign="bottom" align="left">*) Bagian dari detail isian acara <?=$infoacara;?></td>
     <td width="50%" valign="bottom" align="right">
		   <img src="images/arrow2.gif" border="0">
	     <a href="<?="?menu=$menu&uid=$uid&page=view&id=$id";?>"><b>Back Rincian</b></a> &nbsp;
		 </td>
		</tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	  <tr>
     <td colspan="2" valign="top" align="center">
		 <script language="JavaScript" src="calendar_us.js"></script>
			 <table width='600' cellspacing='1' cellpadding='3'>
			  <?=$htmlData;?>
				<tr>
					<td width="100%" colspan="2" align="center">
					 <input type="hidden" name="id" value="<?=$id;?>"><br>
					 <input type="hidden" name="id_acara" value="<?=$id_acara;?>"><br>
					 <input type="submit" value="Simpan" name="run" class="button">
					</td>
				</tr>
				<tr>
					<td width="100%" colspan="2" align="left">
					Keterangan : <br>
					- Untuk memilih MC berilah tanda Cek pada kolom sebelah kiri Nama MC.<br>
					- Kosongkan isian <b>Ubah Harga</b> jika tidak ada perubahan harga.<br>
					</td>
				</tr>
			 </table>
		 </td>
		</tr>
	 </table>
   </form>

   </td>
  </tr>
</table>
<? };//registerInvalid ?>