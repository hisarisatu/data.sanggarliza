<? 
// Sisten Informasi Sanggar LIZA
// Written by iyok642@yahoo.com; 031-70920002
// update by agusari@gmail.com
// 23 Agustus 2010, lastupdate 09 oktober 2010

include_once("include.php");

if (($SAH[id_group]==1))
{


if ((strlen($run) < 1) and ($id <> "")){ 
	$runSQL = "select id_paket, nama_paket, uraian_paket, tgl_inisial, tgl_expire, id_user, login_ip, created, user_update, ip_update, last_update from bunga_paket where id_paket='$id'";
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id_paket = $row[id_paket];
		$nama_paket = $row[nama_paket];
		
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

if (strlen($run) > 1){ 

	$nama_paket = ucwords($nama_paket);
	$uraian_paket = ucwords($uraian_paket);
	$tmp_tanggal = explode("/",$tgl_inisial);
	$tgl_inisial = $tmp_tanggal[2]."-".$tmp_tanggal[0]."-".$tmp_tanggal[1];
	$tmp_tanggal = explode("/",$tgl_expire);
	$tgl_expire = $tmp_tanggal[2]."-".$tmp_tanggal[0]."-".$tmp_tanggal[1];

	$ok = 1;
	if (strlen($nama_paket) < 5){ $inama_paket = "<br><font color='#FF0000' size='1'><i>* Nama Paket tidak valid"; $ok=0; }
	if ($harga_paket < 0){ $iharga_paket = "<br><font color='#FF0000' size='1'><i>* Harga Paket tidak valid"; $ok=0; }
	//if (strlen($uraian_paket) < 20){ $iuraian_paket = "<br><font color='#FF0000' size='1'><i>* Uraian Paket tidak lengkap"; $ok=0; }

	if (($ok == 1) and ($id == "")){
		$registerInvalid = 1;
		$runSQL = "insert into bunga_paket (nama_paket, uraian_paket, tgl_inisial, tgl_expire, id_user, login_ip, created) VALUES ('$nama_paket', '$uraian_paket', '$tgl_inisial', '$tgl_expire', '$SAH[id_user]', '$REMOTE_ADDR', now())";
		//echo $runSQL;
		$insert = mysql_query($runSQL, $connDB);
		$id = mysql_insert_id($connDB);
                $runSQL = "update bunga_sub_paket set id_paket='$id' where id_paket=0";
                $u = mysql_query($runSQL);
	} else if (($ok == 1) and ($id <> "")){
		$registerInvalid = 1;
		$runSQL = "update bunga_paket set nama_paket='$nama_paket', uraian_paket='$uraian_paket', tgl_inisial='$tgl_inisial', tgl_expire='$tgl_expire', user_update='$SAH[id_user]', ip_update='$REMOTE_ADDR', last_update=now() where id_paket='$id'";
		//echo $runSQL;
		$update = mysql_query($runSQL, $connDB);
	};//if
};//end-if-submit

if ($registerInvalid <> 1){
	if ($tgl_inisial == ""){ $tgl_inisial=date('m/d/Y'); }
	if ($tgl_expire == ""){ $tgl_expire=date('m/d/').(date('Y')+5); }
?>

<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Input/Edit Data Paket</b></font>

	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
     <td valign="bottom">
		 </td>
     <td valign="bottom" align="right">
			 <img src="images/arrow2.gif" border="0">
			 <a href="<?="?menu=$menu&uid=$uid&page=paket";?>"><b>Back Data Paket</b></a>
		   <?if ($id <> ""){?> | <a href="<?="?menu=$menu&uid=$uid&page=paketview&id=$id";?>"><b>Goto Rincian</b></a><?}?>
		 </td>
	  </tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	 </table>

	 <script language="JavaScript" src="calendar_us.js"></script>
	 <table border="0" cellpadding="5" cellspacing="0" width="650">
		<tr>
			<td width="100%" align="right">Nama Paket</td>
			<td width="65%"><input type="text" name="nama_paket" size="40" value="<?=htmlentities(stripslashes($nama_paket));?>"> <font color="#FF0000"><b>*</b></font> <?=$inama_paket;?></td>
		</tr>
		<tr valign=top>
			<td width="100%" align="right">Uraian Paket</td>
			<td width="65%"><iframe src="sub_bunga_input.php?id=<?=$id?>" width="800" frameborder=0></iframe>
<!--<textarea name="uraian_paket" cols="50" rows="3"><?=htmlentities(stripslashes($uraian_paket));?></textarea>-->
<font color="#FF0000"><b>*</b></font> <?=$iuraian_paket;?></td>
		</tr>
		<tr>
			<td width="100%" align="right">Tanggal Inisial</td>
			<td width="65%"><input type="text" name="tgl_inisial" size="12" value="<?=htmlentities(stripslashes($tgl_inisial));?>">
			<script language='JavaScript'> new tcal ({'formname': 'form','controlname': 'tgl_inisial'}); </script>
			</td>
		</tr>
		<tr>
			<td width="100%" align="right">Tanggal Expired</td>
			<td width="65%"><input type="text" name="tgl_expire" size="12" value="<?=htmlentities(stripslashes($tgl_expire));?>">
			<script language='JavaScript'> new tcal ({'formname': 'form','controlname': 'tgl_expire'}); </script>
			</td>
		</tr>
		<tr>
			<td width="100%" align="right">&nbsp;</td>
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

	$runSQL = "select id_paket, nama_paket, uraian_paket, tgl_inisial, tgl_expire, id_user, login_ip, created, user_update, ip_update, last_update from bunga_paket where id_paket='$id'";
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id_paket = $row[id_paket];
		$nama_paket = $row[nama_paket];
		
		$uraian_paket = nl2br($row[uraian_paket]);
		$tgl_inisial = $row[tgl_inisial];
		$tgl_expire = $row[tgl_expire];
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
	 <font class="titledata"><b>Input/Edit Data Paket</b><br></font>
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
		<tr valign=top>
		  <td width="35%" align="right">Uraian Paket : </td>
		  <td width="65%"><font class="datafield">
  <?
$sql="select a.detail_layanan from bunga_detail a, bunga_sub_paket b where a.id_bunga=b.id_bunga and b.id_paket='$id'";
$rs=mysql_query($sql);

for($a=0;$a<mysql_num_rows($rs);$a++){
echo "&raquo;&nbsp;";
echo mysql_result($rs,$a,"detail_layanan");
echo "&nbsp;&nbsp;";
echo "<br>";
}
?>
  </font></td>
		  </tr>
		<tr>
			<td width="35%" align="right">Tanggal Inisial : </td>
			<td width="65%"><font class="datafield"><?=$tgl_inisial;?></font></td>
		</tr>
		<tr>
			<td width="35%" align="right">Tanggal Expired : </td>
			<td width="65%"><font class="datafield"><?=$tgl_expire;?></font></td>
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
	 <a href="<?="?menu=$menu&uid=$uid&page=p_bunga";?>"><b>Back Data Paket</b></a>
<!-- | 
	 <img src="images/arrow2.gif" border="0">
	 <a href="<?="?menu=$menu&uid=$uid&page=paketview&id=$id";?>"><b>Isi Detail Paket</b></a>
-->
   </td>
  </tr>
  </form>
</table>
<? };//registerInvalid 

}
else
{ echo "<div align='center'><font color='#FF0000'><b>Akses Tidak Diperbolehkan. Hanya Group Administrator</b></font></div>"; }



?>