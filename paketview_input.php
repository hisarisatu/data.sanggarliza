<? 
// Sisten Informasi Sanggar LIZA
// Written by iyok642@yahoo.com; 031-70920002
// 23 Agustus 2010, lastupdate 23 Agustus 2010

include_once("include.php");

$runSQL = "select id_paket, nama_paket, harga_paket, uraian_paket, tgl_inisial, tgl_expire, id_user, login_ip, created, user_update, ip_update, last_update from paket where id_paket='$id'";
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id_paket = $row[id_paket];
		$nama_paket = $row[nama_paket];
		$harga_paket = $row[harga_paket];
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
	 <font class="titledata"><b>Rincian Paket</b><br></font>

	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
     <td width="40%" valign="bottom" align="left"> &nbsp; 
	     <font class="titledata" color="#009900"><b>Data Paket</b></font>
		 </td>
     <td width="60%" valign="bottom" align="right">
		 <img src="images/arrow2.gif" border="0">
			 <a href="<?="?menu=$menu&uid=$uid&page=paket";?>"><b>Back Data Paket</b></a> | 
	     <a href='<?="?menu=$menu&uid=$uid&page=paket_input&id=$id";?>'><img border='0' src='images/edit.gif' title='Edit Data'></a> &nbsp; &nbsp; 
		 </td>
		</tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	  <tr>
     <td width="40%" valign="top" align="center">
		 <table border="0" cellpadding="5" cellspacing="0" width="100%">
			<tr>
				<td width="35%" align="right">Nama Paket :</td>
				<td width="65%"><font class="datafield"><?=$nama_paket;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Harga Paket :</td>
				<td width="65%"><font class="datafield"><?=$harga_paket;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Tanggal Created :</td>
				<td width="65%"><font class="datafield"><?=$tgl_inisial;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Tanggal Expired :</td>
				<td width="65%"><font class="datafield"><?=$tgl_expired;?></font></td>
			</tr>
		 </table>
		 </td>
     <td width="60%" valign="top" align="center">
		 <div align="left">
		 --Uraian Paket--<br>
		 <font class="datafield"><?=$uraian_paket;?></font>
		 </div>
		 <div align="right">
			 <hr size="1" color="#252525" style="border-top:1px dashed #252525;" width="250" align="right">
			 <font size='1'><?=$inforecord;?></font>
		 </div>
		 </td>
	  </tr>
	 </table>

	 <p>&nbsp;</p>
	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
     <td width="50%" valign="bottom" align="left"> &nbsp; 
	     <font class="titledata" color="#009900"><b>Rincian Paket</b></font>
		 </td>
     <td width="50%" valign="bottom" align="right">
		 </td>
		</tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	 </table>

	 </td>
  </tr>
  </form>
</table>

<?
if (strlen($run) > 1){ 
	$runSQL = "select id_acara, acara, page from p_acara order by id_acara";
	$result = mysql_query($runSQL, $connDB);
	while ($row = mysql_fetch_array ($result)) {
		$vrb_acara = "acara".$row[id_acara];
		$vlu_acara = $$vrb_acara;

		$runSQL = "select id_layanan, layanan, scriptpage from p_layanan order by id_layanan";
		$result_p_layanan = mysql_query($runSQL, $connDB);
		while ($row_p_layanan = mysql_fetch_array ($result_p_layanan)) {
			//echo "--- --- $row_p_layanan[id_layanan] #$row_p_layanan[layanan]<br>";
			$vrb_layanan = $vrb_acara."layanan".$row_p_layanan[id_layanan];
			$vlu_layanan = $$vrb_layanan;
			$vrb_catatan = $vrb_acara."catatan".$row_p_layanan[id_layanan];
			$vlu_catatan = $$vrb_catatan;

			if ($vlu_layanan > 0){
				//$vlu_acara = $row[id_acara];

				$runSQL2 = "select id_paket, id_acara, id_layanan from paket_layanan where id_paket='$id' and id_acara='$row[id_acara]' and id_layanan='$row_p_layanan[id_layanan]'";
				$result2 = mysql_query($runSQL2, $connDB);
				if ($row2 = mysql_fetch_array($result2)) {
					$runSQL2 = "update paket_layanan set layanan='$row_p_layanan[layanan]', scriptpage='$row_p_layanan[scriptpage]', catatan='$vlu_catatan', user_update='$SAH[id_user]', ip_update='$REMOTE_ADDR', last_update=now() where id_paket='$id' and id_acara='$row[id_acara]' and id_layanan='$row_p_layanan[id_layanan]'";
					$update2 = mysql_query($runSQL2, $connDB);
				}else{
					//insert data
					$runSQL2 = "insert into paket_layanan (id_paket, id_acara, id_layanan, layanan, scriptpage, catatan, id_user, login_ip, created) VALUES ('$id', '$row[id_acara]','$row_p_layanan[id_layanan]','$row_p_layanan[layanan]','$row_p_layanan[scriptpage]','$vlu_catatan','$SAH[id_user]', '$REMOTE_ADDR', now())";
					$insert2 = mysql_query($runSQL2, $connDB);
				};
				//echo "$runSQL2<br>";
			};//simpan data

			if ($vlu_layanan <= 0){
				$runSQL2 = "delete from paket_layanan where id_paket='$id' and id_acara='$row[id_acara]' and id_layanan='$row_p_layanan[id_layanan]'";
				$delete = mysql_query($runSQL2, $connDB);
				//echo "$runSQL2<br>";
			};//delete data
		};//while


		if ($vlu_acara > 0){
			$runSQL2 = "select id_paket, id_acara from paket_acara where id_paket='$id' and id_acara='$row[id_acara]'";
			$result2 = mysql_query($runSQL2, $connDB);
			if (!$row2 = mysql_fetch_array($result2)) {
				//insert data
				$runSQL2 = "insert into paket_acara (id_paket, id_acara) VALUES ('$id', '$row[id_acara]')";
				$insert2 = mysql_query($runSQL2, $connDB);
			};
		};//simpan data

		if ($vlu_acara <= 0){
			$runSQL2 = "delete from paket_acara where id_paket='$id' and id_acara='$row[id_acara]'";
			$delete = mysql_query($runSQL2, $connDB);
			//echo "$runSQL2<br>";
		};//delete data
	};//while
	redirect("?menu=$menu&uid=$uid&page=paketview&id=$id");
};//end-if-submit
?>

<form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
<?
if ((strlen($run) < 1) and ($id <> "")){ 
	$runSQL = "select id_paket, id_acara from paket_acara where id_paket='$id' order by id_acara asc";
	$result = mysql_query($runSQL, $connDB);
	while ($row_p_acara = mysql_fetch_array ($result)) {
		$vrb_acara = "acara".$row_p_acara[id_acara];
		$$vrb_acara = $row_p_acara[id_acara];

		$ccc = 0;
		$runSQL = "select id_paket, id_acara, id_layanan, tambahan, catatan, id_user, login_ip, created, user_update, ip_update, last_update from paket_layanan where id_paket='$id' and id_acara='$row_p_acara[id_acara]' order by id_layanan";
		$result_p_layanan = mysql_query($runSQL, $connDB);
		while ($row_p_layanan = mysql_fetch_array ($result_p_layanan)) {
			//echo "--- --- $row_p_layanan[id_layanan] #$row_p_layanan[catatan]<br>";
			$vrb_layanan = $vrb_acara."layanan".$row_p_layanan[id_layanan];
			$$vrb_layanan = $row_p_layanan[id_layanan];
			$vrb_catatan = $vrb_acara."catatan".$row_p_layanan[id_layanan];
			$$vrb_catatan = $row_p_layanan[catatan];
		};//while
	};//while
};//if


$runSQL = "select id_acara, acara, page from p_acara order by id_acara";
$result_p_acara = mysql_query($runSQL, $connDB);
while ($row_p_acara = mysql_fetch_array ($result_p_acara)) {
	//echo "- $row_p_acara[id_acara] #$row_p_acara[acara]#$row_p_acara[page]<br>";
	$vrb_acara = "acara".$row_p_acara[id_acara];
	$vlu_acara = $$vrb_acara;
	if ($vlu_acara == $row_p_acara[id_acara]){ $checked="checked"; }else{ unset($checked); };
?>
<table width="95%" border="0" cellpadding="0" cellspacing="0" align="center">
	<tr>
		<td width="100%" colspan="2">
	  <input type="checkbox" <?=$checked;?> name="<?=$vrb_acara;?>" value="<?=$row_p_acara[id_acara];?>">
    <font class="titleacara"><b><?=$row_p_acara[acara];?></b></td>
	</tr>
	<tr>
	 <td width="5%" > &nbsp; </td>
	 <td width="95%">
	 <?
		$runSQL = "select id_layanan, layanan, scriptpage from p_layanan order by id_layanan";
		$result_p_layanan = mysql_query($runSQL, $connDB);
		while ($row_p_layanan = mysql_fetch_array ($result_p_layanan)) {
			//echo "--- --- $row_p_layanan[id_layanan] #$row_p_layanan[layanan]<br>";
			$vrb_layanan = $vrb_acara."layanan".$row_p_layanan[id_layanan];
			$vlu_layanan = $$vrb_layanan;
			$vrb_catatan = $vrb_acara."catatan".$row_p_layanan[id_layanan];
			$vlu_catatan = $$vrb_catatan;
			if ($vlu_layanan == $row_p_layanan[id_layanan]){ $checked="checked"; }else{ unset($checked); };
	  ?>
		<table width="600" border="0" cellspacing="0" cellpadding="0">
			<tr>
			   <td colspan="2" width="100%">
			   <input type="checkbox" <?=$checked;?> name="<?=$vrb_layanan;?>" value="<?=$row_p_layanan[id_layanan];?>">
				 <font class="titlesubacara"><b><?=$row_p_layanan[layanan];?></b></font>
				<!--
				 <?if ($row_p_layanan[scriptpage] <> ""){ ?>
				 <a href="<?="?menu=$menu&uid=$uid&page=paket$row_p_layanan[scriptpage]_input&id=$id&id_acara=$row_p_acara[id_acara]&id_layanan=$row_p_layanan[id_layanan]";?>"><img border='0' src='images/edit.gif' title='Input/Edit Data'></a>
				 <?};?>
				 -->
				 </td>
			</tr>
			<tr>
				 <td width="5%" > &nbsp; </td>
				 <td width="95%">
				 <textarea name="<?=$vrb_catatan;?>" cols="50" rows="1"><?=htmlentities(stripslashes($vlu_catatan));?></textarea>
				 </td>
			</tr>
		</table>
		<? };//while_p_layanan ?>
		<img src="images/arrow2.gif" border="0">
		<a href="<?="?menu=$menu&uid=$uid&page=pakettambahan_input&id=$id&id_acara=$row_p_acara[id_acara]";?>"><b>Tambah Layanan</b></a>
	 </td>
	</tr>
</table>
<br>
<? };//while_p_acara ?>

 <input type="hidden" name="id" value="<?=$id;?>"><br>
 <input type="submit" value="Update" name="run" class="button">
</form>

<p align="center">
<img src="images/arrow2.gif" border="0">
<a href="<?="?menu=$menu&uid=$uid&page=paket";?>"><b>Back Data Paket</b></a>
</p>
