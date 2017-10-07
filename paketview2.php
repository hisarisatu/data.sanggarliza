<? 
// Sisten Informasi Sanggar LIZA
// Written by iyok642@yahoo.com; 031-70920002
// 23 Agustus 2010, lastupdate 23 Agustus 2010

include_once("include.php");

	$runSQL = "select id_paket, id_acara, nama_paket, harga_paket, uraian_paket, tgl_inisial, tgl_expire from p_paket where id_paket='$id'";
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id_paket = $row[id_paket];
		$id_acara = $row[id_acara];
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

	if ($id_acara > 0){
		$runSQL2 = "select id_acara, acara, page from p_acara where id_acara='$id_acara'";
		$result2 = mysql_query($runSQL2, $connDB);
		$ACR = mysql_fetch_array ($result2);
		$nama_acara = $ACR[acara];
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
				<td width="35%" align="right">Nama Acara :</td>
				<td width="65%"><font class="datafield"><?=$nama_acara;?></font></td>
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
$runSQL = "select id_acara, acara, page from p_acara order by id_acara";
$result_p_acara = mysql_query($runSQL, $connDB);
while ($row_p_acara = mysql_fetch_array ($result_p_acara)) {
	echo "- $row_p_acara[id_acara] #$row_p_acara[acara]#$row_p_acara[page]<br>";

	$runSQL = "select id_layanan,layanan from p_layanan order by id_layanan";
	$result_p_layanan = mysql_query($runSQL, $connDB);
	while ($row_p_layanan = mysql_fetch_array ($result_p_layanan)) {
		echo "--- --- $row_p_layanan[id_layanan] #$row_p_layanan[layanan]<br>";

		if ($row_p_layanan[id_layanan] <= 2){
		$runSQL = "select  id_jabatan, nama_jabatan from p_jabatan order by id_jabatan";
		$result_p_jabatan = mysql_query($runSQL, $connDB);
		while ($row_p_jabatan = mysql_fetch_array ($result_p_jabatan)) {
			echo "--- --- --- $row_p_jabatan[id_jabatan] #$row_p_jabatan[nama_jabatan]<br>";

		};//while_p_acara
		};//if



	};//while_p_layanan
};//while_p_acara
?>