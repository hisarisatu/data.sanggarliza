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

<?
if (strlen($run) > 1){ 

	unset($del_acara);
	$runSQL = "select id_jabatan, nama_jabatan from p_jabatan order by id_jabatan asc";
	$result = mysql_query($runSQL, $connDB);
	while ($row = mysql_fetch_array ($result)) {

		$hubkel = $row[id_jabatan];
		$vrb_makeupstd = "makeupstd_$hubkel";
		$vlu_makeupstd = $$vrb_makeupstd;
		$vrb_makeupspc = "makeupspc_$hubkel";
		$vlu_makeupspc = $$vrb_makeupspc;
		$vrb_sgljlbstd = "sgljlbstd_$hubkel";
		$vlu_sgljlbstd = $$vrb_sgljlbstd;
		$vrb_sgljlbspc = "sgljlbspc_$hubkel";
		$vlu_sgljlbspc = $$vrb_sgljlbspc;

		if (($vlu_makeupspc>0) or ($vlu_makeupstd>0) or ($vlu_sgljlbspc>0) or ($vlu_sgljlbstd>0)){

			$runSQL2 = "select id_paket from paket_rias where id_paket='$id' and id_acara='$id_acara' and id_layanan='$id_layanan' and id_jabatan='$row[id_jabatan]'";
			$result2 = mysql_query($runSQL2, $connDB);
			if ($row2 = mysql_fetch_array($result2)) {
				//update data
				$runSQL2 = "update paket_rias set makeup_special='$vlu_makeupspc', makeup_standart='$vlu_makeupstd', sgljlb_special='$vlu_sgljlbspc', sgljlb_standart='$vlu_sgljlbstd', catatan='$vlu_catatan', user_update='$SAH[id_user]', ip_update='$REMOTE_ADDR', last_update=now() where id_paket='$id' and id_acara='$id_acara' and id_layanan='$id_layanan' and id_jabatan='$row[id_jabatan]'";
				$update2 = mysql_query($runSQL2, $connDB);
			}else{
				//insert data
				$runSQL2 = "insert into paket_rias (id_paket, id_acara, id_layanan, id_jabatan, makeup_special, makeup_standart, sgljlb_special, sgljlb_standart, catatan, id_user, login_ip, created) VALUES ('$id', '$id_acara', '$id_layanan', '$row[id_jabatan]', '$vlu_makeupspc', '$vlu_makeupstd', '$vlu_sgljlbspc', '$vlu_sgljlbstd', '$vlu_catatan', '$SAH[id_user]', '$REMOTE_ADDR', now())";
				$insert2 = mysql_query($runSQL2, $connDB);
			};//if
			//echo "$runSQL2<br>";
		}else{
			$runSQL2 = "delete from paket_rias where id_paket='$id' and id_acara='$id_acara' and id_layanan='$id_layanan' and id_jabatan='$row[id_jabatan]'";
			$delete2 = mysql_query($runSQL2, $connDB);
		};//if
	};//end.while
	redirect("?menu=$menu&uid=$uid&page=paketview&id=$id");
};//end-if-submit

if ((strlen($run) < 1) and ($id <> "")){ 
	$runSQL = "select id_paket, id_acara, id_layanan, id_jabatan, makeup_special, makeup_standart, sgljlb_special, sgljlb_standart, catatan, id_user, login_ip, created from paket_rias where id_paket='$id' and id_acara='$id_acara' and id_layanan='$id_layanan'";
	$result = mysql_query($runSQL, $connDB);
	while ($row = mysql_fetch_array ($result)) {
		$hubkel= $row[id_jabatan];

		$vrb_makeupstd = "makeupstd_$hubkel";
		$$vrb_makeupstd = $row[makeup_standart];
		$vrb_makeupspc = "makeupspc_$hubkel";
		$$vrb_makeupspc = $row[makeup_special];
		$vrb_sgljlbstd = "sgljlbstd_$hubkel";
		$$vrb_sgljlbstd = $row[sgljlb_standart];
		$vrb_sgljlbspc = "sgljlbspc_$hubkel";
		$$vrb_sgljlbspc = $row[sgljlb_special];
	};//end.while
};//end-if
?>

	 <p>&nbsp;</p>
	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
     <td width="50%" valign="bottom" align="left"> &nbsp; 
	     <font class="titledata" color="#009900"><b>Rincian Paket - Tata Rias</b></font>
		 </td>
     <td width="50%" valign="bottom" align="right">
		 <img src="images/arrow2.gif" border="0">
			 <a href="<?="?menu=$menu&uid=$uid&page=paketview&id=$id";?>"><b>Back Detail Paket</b></a> &nbsp; &nbsp; 
		 </td>
		</tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	 </table>

    <table width="700" border="0" cellspacing="1" cellpadding="5">
      <tr>
        <?
        unset($ii);
        $runSQL = "select id_jabatan, nama_jabatan from p_jabatan order by id_jabatan asc";
        $result = mysql_query($runSQL, $connDB);
        while ($row = mysql_fetch_array ($result)) {
					$hubkel= $row[id_jabatan];
					if ($bsn_satuan == ""){ $bsn_satuan="Orang"; }

					$vrb_makeupstd = "makeupstd_$hubkel";
					$vlu_makeupstd = $$vrb_makeupstd;
					$vrb_makeupspc = "makeupspc_$hubkel";
					$vlu_makeupspc = $$vrb_makeupspc;
					$vrb_sgljlbstd = "sgljlbstd_$hubkel";
					$vlu_sgljlbstd = $$vrb_sgljlbstd;
					$vrb_sgljlbspc = "sgljlbspc_$hubkel";
					$vlu_sgljlbspc = $$vrb_sgljlbspc;

					if ($ii%2 == 0){ echo "</td></tr><tr><td valign='top'>"; }else{ echo "</td><td valign='top'>"; };
					$ii++;
				?>
        <font color="#009900"><b><?=$ii;?>. <?=$row[nama_jabatan];?></b></font>
        <hr size="1" color="#252525" style="border-top:1px dashed #252525;" width="90%">
				<table width="350" border="0" cellpadding="5" cellspacing="0">
				 <tr>
					 <td width="50%" vAlign="top">
					 <table width="100%" border="0" cellpadding="0" cellspacing="2">
						 <tr>
							 <td width="100%" colspan="3"> <font class="titleitems"><b>MakeUP Perempuan</b> </td>
						 </tr>
						 <tr>
							 <td width="40%"> &nbsp; - Standart </td><td width="5%"> : </td>
							 <td width="60%"> <input type="text" name="<?=$vrb_makeupstd;?>" size="1" value="<?=$vlu_makeupstd;?>"> <?=$bsn_satuan;?> </td>
						 </tr>
						 <tr>
							 <td width="40%"> &nbsp; - Special </td><td width="5%"> : </td>
							 <td width="60%"> <input type="text" name="<?=$vrb_makeupspc;?>" size="1" value="<?=$vlu_makeupspc;?>"> <?=$bsn_satuan;?> </td>
						 </tr>
					 </table>
					 </td>
					 <td width="45%" vAlign="top">
					 <table width="100%" border="0" cellpadding="0" cellspacing="2">
						 <tr>
							 <td width="100%" colspan="3"> <font class="titleitems"><b>Sanggul/Jilbab</b> </td>
						 </tr>
						 <tr>
							 <td width="40%"> &nbsp; - Standart </td><td width="5%"> : </td>
							 <td width="60%"> <input type="text" name="<?=$vrb_sgljlbstd;?>" size="1" value="<?=$vlu_sgljlbstd;?>"> <?=$bsn_satuan;?> </td>
						 </tr>
						 <tr>
							 <td width="40%"> &nbsp; - Special </td><td width="5%"> : </td>
							 <td width="60%"> <input type="text" name="<?=$vrb_sgljlbspc;?>" size="1" value="<?=$vlu_sgljlbspc;?>"> <?=$bsn_satuan;?> </td>
						 </tr>
					 </table>
					 </td>
				 </tr>
				</table>	
        <? };//while ?>
       </tr>
       <tr>
				<td colspan="2" align="center">
					 <input type="hidden" name="id" value="<?=$id;?>">
					 <input type="hidden" name="id_acara" value="<?=$id_acara;?>">
					 <input type="hidden" name="id_layanan" value="<?=$id_layanan;?>">
					 <input type="submit" value="Simpan" name="run" class="button">
				</td>
       </tr>
       <tr>
				<td colspan="2">
					<img src="images/arrow2.gif" border="0">
					<a href="<?="?menu=$menu&uid=$uid&page=hubungankeluarga_input&id=$id";?>"><b>Tambah Hubungan Keluarga</b></a>
				</td>
       </tr>
    </table>

		<p align="center">
		</p>

	 </td>
  </tr>
  </form>
</table>
