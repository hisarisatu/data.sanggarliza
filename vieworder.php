<? 
// Sisten Informasi Sanggar LIZA
// Written by iyok642@yahoo.com; 031-70920002
// update by agusari@gmail.com
// 23 Agustus 2010, lastupdate 09 oktober 2010

include_once("include.php");
//$id_user;
if ((strlen($run) < 1) and ($id <> "")){ 
	$runSQL = "select id_paket, nama_paket, harga_paket, uraian_paket, tgl_inisial, tgl_expire, id_user, login_ip, created, user_update, ip_update, last_update from paket where id_paket='$id'";
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id_paket = $row[id_paket];
		$nama_paket = $row[nama_paket];
		$harga_paket = $row[harga_paket];
		$uraian_paket = $row[uraian_paket];

		if ($row[tgl_inisial] <> ""){
			$tmp_tanggal = explode("-",$row[tgl_inisial]);
			$tgl_inisial = $tmp_tanggal[1]."/".$tmp_tanggal[2]."/".$tmp_tanggal[0];
		};//if
		if ($row[tgl_expire] <> ""){
			$tmp_tanggal = explode("-",$row[tgl_expire]);
			$tgl_expire = $tmp_tanggal[1]."/".$tmp_tanggal[2]."/".$tmp_tanggal[0];
		};//if
	};//if
};//if-id

if ($id_user > 0){
		$runSQL2 = "select id_user, username from sys_username where id_user='$id_user'";
		//echo $runSQL2;
                $result2 = mysql_query($runSQL2, $connDB);
                $username= mysql_result($result2,0,"username");
}

if (strlen($run) > 1){ 

	$nama_paket = ucwords($nama_paket);
	$uraian_paket = ucwords($uraian_paket);
	$tmp_tanggal = explode("/",$tgl_inisial);
	$tgl_inisial = $tmp_tanggal[2]."-".$tmp_tanggal[0]."-".$tmp_tanggal[1];
	$tmp_tanggal = explode("/",$tgl_expire);
	$tgl_expire = $tmp_tanggal[2]."-".$tmp_tanggal[0]."-".$tmp_tanggal[1];

	$ok = 1;

	if (($ok == 1) and ($id_pesanan == "")){
		$registerInvalid = 1;
		$runSQL = "insert into pesanan(id_client,id_paket,tanggal,jam,tempat,id_gaya,tgl_input,creator,tgl_update,updater) VALUES ('$id', '$id_paket','$tgl_inisial', '$jam_inisial', '$tempat', '$id_gaya', now(),'$username',now(),'$username')";
		//echo $runSQL;
		$insert = mysql_query($runSQL, $connDB);
		$id_pesanan = mysql_insert_id($connDB);
                $runSQL = "update pesanan_plus set id_pesanan='$id' where id_pesanan=0";
                $u = mysql_query($runSQL);
	} else if (($ok == 1) and ($id <> "")){
		$registerInvalid = 1;
		$runSQL = "update pesanan set id_paket='$id_paket', , tgl_inisial='$tgl_inisial', tgl_expire='$tgl_expire', user_update='$SAH[id_user]', ip_update='$REMOTE_ADDR', last_update=now() where id_paket='$id'";
		//echo $runSQL;
		$update = mysql_query($runSQL, $connDB);
	};//if
};//end-if-submit

if ($registerInvalid <> 1){
	if ($tgl_inisial == ""){ $tgl_inisial=date('m/d/Y'); }
	if ($tgl_expire == ""){ $tgl_expire=date('m/d/').(date('Y')+5); }
?>

<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page&id=$idc";?>">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Input Pesanan</b></font>

	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
     <td valign="bottom">
		 </td>
     <td valign="bottom" align="right">
			 <img src="images/arrow2.gif" border="0">
			 <a href="<?="?menu=$menu&uid=$uid&page=client";?>"><b>Back</b></a>
		 </td>
	  </tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	 </table>

	 <script language="JavaScript" src="calendar_us.js"></script>
	 <table border="0" cellpadding="5" cellspacing="0" width="650">
		<tr>
            <td width="35%" align="right">Pilih Paket</td>
            <td width="65%"><select name="id_paket">
<?
$sql="select id_paket,nama_paket,harga_paket from paket";
$rs=mysql_query($sql);
for($a=0;$a<mysql_num_rows($rs);$a++){
echo "<option ";
$idp=mysql_result($rs,$a,"id_paket");
if ($idp==$id_produk)echo " selected ";
echo " value=\"$idp\">";
echo mysql_result($rs,$a,"nama_paket");
echo " - Rp. ";
echo number_format(mysql_result($rs,$a,"harga_paket"),0);
echo "</option>";
} ?>
</select> <font color="#FF0000"><b>*</b></font> <?=$iid_paket;?></td>
        </tr>
        <tr>
            <td width="35%" align="right">Tanggal Pelaksanaan</td>
            <td width="65%"><input type="text" name="tgl_inisial" size="12" value="<?=htmlentities(stripslashes($tgl_inisial));?>">
            <script language='JavaScript'> new tcal ({'formname': 'form','controlname': 'tgl_inisial'}); </script>
            </td>
        </tr>
        <tr>
            <td width="35%" align="right">Jam</td>
            <td width="65%"><input type="text" name="jam_inisial" size="12" value="<?=htmlentities(stripslashes($jam_inisial));?>">
            </td>
        </tr>
<tr>
			<td width="35%" align="right">Tempat</td>
			<td width="65%"><input type="text" name="tempat" size="40" value="<?=htmlentities(stripslashes($tempat));?>"> <font color="#FF0000"><b>*</b></font> <?=$itempat;?></td>
		</tr>
		<tr>
            <td width="35%" align="right">Pilih Gaya</td>
            <td width="65%"><select name="id_gaya">
<?
$sql="select id_gaya,gaya from p_gaya";
$rs=mysql_query($sql);
for($a=0;$a<mysql_num_rows($rs);$a++){
echo "<option ";
$idp=mysql_result($rs,$a,"id_gaya");
if ($idp==$id_produk)echo " selected ";
echo " value=\"$idp\">";
echo mysql_result($rs,$a,"gaya");
echo "</option>";
} ?>
</select> <font color="#FF0000"><b>*</b></font> <?=$iid_gaya;?></td>
        </tr>
		<tr valign=top>
			<td width="35%" align="right">&nbsp;</td>
			<td width="65%"><iframe src="sub_pesanan_input.php?idc=<?=$id?>" width="600" frameborder=0></iframe>
<font color="#FF0000"><b>*</b></font> <?=$iuraian_paket;?></td>
		</tr>
		<tr>
			<td width="35%" align="right">&nbsp;</td>
			<td width="65%">
			<input type="hidden" name="id" value="<?=$idc;?>"><br>
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

	$runSQL = "select a.nama_paket,b.tanggal,b.jam,b.tempat,c.gaya from paket a, pesanan b, p_gaya c where a.id_paket=b.id_paket and b.id_client='$id' and b.id_pesanan='$id_pesanan' and b.id_gaya=c.id_gaya";//echo $runSQL;
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$nama_paket = $row[nama_paket];
		$tanggal = $row[tanggal];
		$jam = $row[jam];
		$tempat = $row[tempat];
		$gaya = $row[gaya];
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
	 <font class="titledata"><b>Input/Edit Data Pesanan</b><br></font>
	 <font color="#FF0000"><b>-- Data telah berhasil disimpan --</b><br><br></font>

	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr><td colspan="2" align="right"><a href='<?="?menu=$menu&uid=$uid&page=client_input&id=$id";?>'><img border='0' src='images/edit.gif' title='Edit Data'></a> &nbsp; &nbsp; </td></tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	  <tr>
     <td width="100%" valign="top" align="center">
	 <table border="0" cellpadding="5" cellspacing="0" width="650">
		<tr>
			<td width="35%" align="right">Nama Paket : </td>
			<td width="65%"><font class="datafield"><?=$nama_paket;?></font></td>
		</tr>
		<tr>
			<td width="35%" align="right">Tanggal : </td>
			<td width="65%"><font class="datafield"><?=$tanggal?></font></td>
		</tr>
		<tr valign=top>
			<td width="35%" align="right">Jam : </td>
			<td width="65%"><font class="datafield"><?=$jam?></font></td>
		</tr>
		<tr>
			<td width="35%" align="right">Tempat : </td>
			<td width="65%"><font class="datafield"><?=$tempat;?></font></td>
		</tr>
		<tr>
			<td width="35%" align="right">Gaya : </td>
			<td width="65%"><font class="datafield"><?=$gaya;?></font></td>
		</tr>
	 </table>

		 <div align="right">
		 <hr size="1" color="#252525" style="border-top:1px dashed #252525;" width="220" align="right">
		 <font size='1'><?=$inforecord;?></font>
		 </div>

		 </td>
	  </tr>
	 </table>

	 <p>&nbsp;</p>
	 <img src="images/arrow2.gif" border="0">
	 <a href="<?="?menu=$menu&uid=$uid&page=client";?>"><b>Back Data Pesanan</b></a>
<!-- | 
	 <img src="images/arrow2.gif" border="0">
	 <a href="<?="?menu=$menu&uid=$uid&page=paketview&id=$id";?>"><b>Isi Detail Paket</b></a>
-->
   </td>
  </tr>
  </form>
</table>
<? };//registerInvalid ?>