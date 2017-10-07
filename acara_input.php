<? 
// Sisten Informasi Sanggar LIZA
// Written by iyok642@yahoo.com; 031-70920002
// Update by agusari@gmail.com
// 23 Agustus 2010, lastupdate 09 oktober 2010

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

	unset($del_acara);
	$runSQL = "select id_acara, acara from p_acara order by id_acara asc";
	$result = mysql_query($runSQL, $connDB);
	while ($row = mysql_fetch_array ($result)) {
		$vrb_gaya = "id_gaya".$row[id_acara];
		$vlu_gaya = $$vrb_gaya;
		$vrb_paket = "id_paket".$row[id_acara];
		$vlu_paket = $$vrb_paket;
		$vrb_tanggal = "tanggal".$row[id_acara];
		$vlu_tanggal = $$vrb_tanggal;
		$vrb_waktu = "waktu".$row[id_acara];
		$vlu_waktu = $$vrb_waktu;
		$vrb_tempat = "tempat".$row[id_acara];
		$vlu_tempat = $$vrb_tempat;
		$vlu_tempat = ucwords($vlu_tempat);
		$vrb_catatan = "catatan".$row[id_acara];
		$vlu_catatan = $$vrb_catatan;
		$vlu_catatan = ucwords($vlu_catatan);

		if ($vlu_tanggal <> ""){
			$tmp_tanggal = explode("/",$vlu_tanggal);
			$new_tanggal = $tmp_tanggal[2]."-".$tmp_tanggal[0]."-".$tmp_tanggal[1];

			$runSQL2 = "select id_client from acara where id_client='$id' and id_acara='$id_pelaksanaan'";
//echo $runSQL2;exit;
			$result2 = mysql_query($runSQL2, $connDB);
			if ($row2 = mysql_fetch_array($result2)) {
				//update data
				$runSQL2 = "update acara set id_client='$id', id_acara='$id_pelaksanaan', id_gaya='$vlu_gaya', id_paket='$vlu_paket', tanggal='$new_tanggal', waktu='$vlu_waktu', tempat='$vlu_tempat', catatan='$vlu_catatan', user_update='$SAH[id_user]', ip_update='$REMOTE_ADDR', last_update=now() where id_client='$id' and id_acara='$row[id_acara]'";
				$update2 = mysql_query($runSQL2, $connDB);
				
			}else{
				//insert data
				$runSQL2 = "insert into acara (id_client, id_acara, id_gaya, id_paket, tanggal, waktu, tempat, catatan, id_user, login_ip, created) VALUES ('$id', '$id_pelaksanaan', '$vlu_gaya', '$vlu_paket', '$new_tanggal', '$vlu_waktu', '$vlu_tempat', '$vlu_catatan', '$SAH[id_user]', '$REMOTE_ADDR', now())";
				$insert2 = mysql_query($runSQL2, $connDB);
				//echo $runSQL2;exit;
			};
		};//simpan data

		if ($vlu_tanggal == ""){
			$runSQL2 = "delete from acara where id_client='$id' and id_acara='$id_pelaksanaan'";
			$delete = mysql_query($runSQL2, $connDB);
                        $runSQL2 = "delete from pesanan_plus where id_client='$id' and id_acara='$id_pelaksanaan'";
                        $delete = mysql_query($runSQL2, $connDB);
			//echo "$runSQL2<br>";
		};
	};
	redirect("?menu=$menu&uid=$uid&page=view&id=$id");
};//end-if-submit

if ($registerInvalid <> 1){

	if ((strlen($run) < 1) and ($id <> "")){ 
		$runSQL = "select id_client, id_acara, id_gaya, id_paket, tanggal, waktu, tempat, catatan from acara where id_client='$id' order by id_acara asc";
		$result = mysql_query($runSQL, $connDB);
		while ($row = mysql_fetch_array ($result)) {
			if ($row[tanggal] <> ""){
				$tmp_tanggal = explode("-",$row[tanggal]);
				$row[tanggal] = $tmp_tanggal[1]."/".$tmp_tanggal[2]."/".$tmp_tanggal[0];
			};//if
			$vrb_gaya = "id_gaya".$row[id_acara];
			$$vrb_gaya = $row[id_gaya];
			$vrb_paket = "id_paket".$row[id_acara];
			$vlu_paket = $$vrb_paket;
			$vrb_tanggal = "tanggal".$row[id_acara];
			$$vrb_tanggal = $row[tanggal];
			$vrb_waktu = "waktu".$row[id_acara];
			$$vrb_waktu = $row[waktu];
			$vrb_tempat = "tempat".$row[id_acara];
			$$vrb_tempat = $row[tempat];
			$vrb_catatan = "catatan".$row[id_acara];
			$$vrb_catatan = $row[catatan];
		};//while
	};//if


	unset($ccc);
	$runSQL = "select id_acara, acara from p_acara order by id_acara asc";
	$result = mysql_query($runSQL, $connDB);
	while ($row = mysql_fetch_array ($result)) {
		
		$vrb_gaya = "id_gaya".$row[id_acara];
		$vlu_gaya = $$vrb_gaya;
		$vrb_paket = "id_paket".$row[id_acara];
		$vlu_paket = $$vrb_paket;
		$vrb_tanggal = "tanggal".$row[id_acara];
		$vlu_tanggal = $$vrb_tanggal;
		$vrb_waktu = "waktu".$row[id_acara];
		$vlu_waktu = $$vrb_waktu;
		$vrb_tempat = "tempat".$row[id_acara];
		$vlu_tempat = $$vrb_tempat;
		$vlu_tempat = ucwords($vlu_tempat);
		$vrb_catatan = "catatan".$row[id_acara];
		$vlu_catatan = $$vrb_catatan;
		$vlu_catatan = ucwords($vlu_catatan);
       }
		unset($selectgaya);
		$selectgaya = "<option value=''>-- Pilih Gaya --</option>\n"; 
		$runSQL2 = "select id_gaya, gaya from p_gaya order by id_gaya asc";
		$result2 = mysql_query($runSQL2, $connDB);
		while ($row2 = mysql_fetch_array ($result2)) {
			if ($vlu_gaya==$row2[id_gaya]) { $cek="selected"; $vlu_gaya=$row2[id_gaya]; }else{ unset($cek); }
			$selectgaya .= "<option value='".$row2[id_gaya]."' $cek>$row2[gaya]</option>\n"; 
		};//while
		$selectgaya = "<select size=1 name='$vrb_gaya' class='edyellow'> $selectgaya </select>";

		unset($ii,$selectpaket);
		$selectpaket = "<option value=''>-- Pilih Paket --</option>\n"; 
		$runSQL2 = "select id_paket, nama_paket, harga_paket from paket where tgl_inisial<now() and (tgl_expire is null or tgl_expire>now()) order by id_paket asc";
		$result2 = mysql_query($runSQL2, $connDB);
		while ($row2 = mysql_fetch_array ($result2)) {
			$ii++;
			if ($vlu_paket==$row2[id_paket]) { $cek="selected"; $vlu_paket=$row2[id_paket]; }else{ unset($cek); }
			if ($row2[harga_paket] > 0){ $infoharga=" - Rp. ".number_format($row2[harga_paket],0); }else{ unset($infoharga); }
			$selectpaket .= "<option value='".$row2[id_paket]."' $cek>$ii. $row2[nama_paket]$infoharga</option>\n"; 
		};//while
		$selectpaket = "<select size=1 name='$vrb_paket' class='edyellow'> $selectpaket </select>";

		$ccc++;
		if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
		$htmlData .= "
			<tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"'>
				<!--<td> &nbsp; <b>$ccc. &nbsp; $row[acara]</b> </td>-->
				<td>
				 <table width='100%' border='0' cellpadding='2' cellspacing='0' align=left>
<tr>
<td>Kategori</td><td> : </td>
<td><select name='id_produk' onchange='javascript:this.form.submit();'>";

$sql='select id_produk,produk from p_produk';
$rs=mysql_query($sql);
for($a=0;$a<mysql_num_rows($rs);$a++){
$htmlData .= "<option ";
$idp=mysql_result($rs,$a,'id_produk');
if ($idp==$id_produk)$htmlData .= " selected ";
$htmlData .= "  value=\"$idp\">";
$htmlData .= mysql_result($rs,$a,'produk');
$htmlData .= "</option>";
} 
$htmlData .= "</select> <font color='#FF0000'><b>*</b></font></td>
        </tr>
<tr>
<td>Acara</td><td> : </td>
<td><select name='id_pelaksanaan'>";
if(!isset($id_produk))$id_produk=1;
$sql="select id_acara,acara from p_acara where id_produk='$id_produk'";
$rs=mysql_query($sql);
for($a=0;$a<mysql_num_rows($rs);$a++){
$htmlData .= "<option ";
$idp=mysql_result($rs,$a,'id_acara');
if ($idp==$row[id_acara])$htmlData .= " selected ";
$htmlData .= "  value=\"$idp\">";
$htmlData .= mysql_result($rs,$a,'acara');
$htmlData .= "</option>";
} 
$htmlData .= "</select> <font color='#FF0000'><b>*</b></font></td>
        </tr>
<tr>
					 <td> Tanggal </td><td> : </td><td> <input type='text' name='$vrb_tanggal' size='11' value=''>
					 <script language='JavaScript'> new tcal ({'formname': 'form','controlname': '$vrb_tanggal'}); </script>
					 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Jam : <input type='text' name='$vrb_waktu' size='10' value=\"\">
					 </td>
					</tr>
					<tr>
					 <td> Gaya </td><td> : </td><td> $selectgaya
					 &nbsp; &nbsp; &nbsp; Ket : <input type='text' name='$vrb_catatan' size='35' value=''>
					 </td>
					</tr>
					<tr>
					 <td> Paket </td><td> : </td><td> $selectpaket </td>
					</tr>
					<tr>
					 <td> Lokasi </td><td> : </td><td> <input type='text' name='$vrb_tempat' size='70' value=\"\"></td>
					</tr>
				 </table>
				</td>
			</tr>
		";//htmlData
	//};//end-while
?>

	 <p>&nbsp;</p>
   <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
	 <font class="titledata"><b>Input/Edit Jenis Acara</b><br></font>
	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
     <!--<td width="50%" valign="bottom" align="left"> &nbsp; <font color='#FF0000'>*) Isi hanya pada <b>Jenis Acara</b> yang dipilih!</font></td>-->
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
					 <input type="submit" value="Simpan" name="run" class="button">
					</td>
				</tr>
				<tr>
					<td width="100%" colspan="2" align="left">
					Keterangan : <br>
					- Pastikan Tanggal telah diisi pada <b>Jenis Acara</b> yang dipilih!<br>
					- Untuk membatalkan pilihan <b>Jenis Acara</b> anda cukup mengkosongi form isian.
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