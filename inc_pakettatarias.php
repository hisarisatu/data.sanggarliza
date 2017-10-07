<table width="100%" border="0" cellspacing="1" cellpadding="5">
<tr>
	<?
	$inc_runSQL = "select id_jabatan, nama_jabatan from p_jabatan order by id_jabatan asc";
	$inc_result = mysql_query($inc_runSQL, $connDB);
	while ($inc_row = mysql_fetch_array ($inc_result)) { $arr_jabatan[$inc_row[id_jabatan]]=$inc_row[nama_jabatan]; };

	unset($ii);
	$inc_runSQL = "select id_paket, id_acara, id_layanan, id_jabatan, makeup_special, makeup_standart, sgljlb_special, sgljlb_standart, catatan, id_user, login_ip, created from paket_rias where id_paket='$this_id_paket' and id_acara='$this_id_acara' and id_layanan='$this_id_layanan'";
	$inc_result = mysql_query($inc_runSQL, $connDB);
	while ($inc_row = mysql_fetch_array ($inc_result)) {
		$bsn_satuan = "buah";
		if ($ii%2 == 0){ echo "</td></tr><tr><td valign='top'>"; }else{ echo "</td><td valign='top'>"; };
		$ii++;
	?>
	<table width="300" border="0" cellpadding="1" cellspacing="0">
	 <tr>
		 <td width="100%" colspan="2">
			<font color="#009900"><b><?=$ii;?>. <?=$arr_jabatan[$inc_row[id_jabatan]];?></b></font>
			<hr size="1" color="#252525" style="border-top:1px dashed #252525;">
		 </td>
	 </tr>
	 <tr>
		 <td width="50%" vAlign="top">
		 <table width="100%" border="0" cellpadding="0" cellspacing="2">
			 <tr>
				 <td width="100%" colspan="3"> <font class="titleitems"><b>MakeUP Perempuan</b> </td>
			 </tr>
			 <tr>
				 <td width="40%" nowrap> &nbsp; - Standart </td><td width="5%"> : </td>
				 <td width="60%" nowrap> <?=$inc_row[makeup_standart];?> <?=$bsn_satuan;?> </td>
			 </tr>
			 <tr>
				 <td width="40%" nowrap> &nbsp; - Special </td><td width="5%"> : </td>
				 <td width="60%" nowrap> <?=$inc_row[makeup_special];?> <?=$bsn_satuan;?> </td>
			 </tr>
		 </table>
		 </td>
		 <td width="45%" vAlign="top">
		 <table width="100%" border="0" cellpadding="0" cellspacing="2">
			 <tr>
				 <td width="100%" colspan="3"> <font class="titleitems"><b>Sanggul/Jilbab</b> </td>
			 </tr>
			 <tr>
				 <td width="40%" nowrap> &nbsp; - Standart </td><td width="5%"> : </td>
				 <td width="60%" nowrap> <?=$inc_row[sgljlb_standart];?> <?=$bsn_satuan;?> </td>
			 </tr>
			 <tr>
				 <td width="40%" nowrap> &nbsp; - Special </td><td width="5%"> : </td>
				 <td width="60%" nowrap> <?=$inc_row[sgljlb_special];?> <?=$bsn_satuan;?> </td>
			 </tr>
		 </table>
		 </td>
	 </tr>
	</table>	
	<? };//while ?>
 </tr>
</table>