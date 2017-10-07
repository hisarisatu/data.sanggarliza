<table width="100%" border="0" cellspacing="1" cellpadding="5">
<tr>
	<?
	$inc_runSQL = "select id_jabatan, nama_jabatan from p_jabatan order by id_jabatan asc";
	$inc_result = mysql_query($inc_runSQL, $connDB);
	while ($inc_row = mysql_fetch_array ($inc_result)) { $arr_jabatan[$inc_row[id_jabatan]]=$inc_row[nama_jabatan]; };

	unset($ii);
	$inc_runSQL = "select id_paket, id_acara, id_layanan, id_jabatan, wanitabaju, wanitakain, wanitaselop, wanitaasesoris, priabaju, priakain, priaselop, priaasesoris, priablangkon, catatan, id_user, login_ip, created from paket_busana where id_paket='$this_id_paket' and id_acara='$this_id_acara' and id_layanan='$this_id_layanan'";
	$inc_result = mysql_query($inc_runSQL, $connDB);
	while ($inc_row = mysql_fetch_array ($inc_result)) {
		$bsn_satuan = "buah";
		if ($ii%2 == 0){ echo "</td></tr><tr><td valign='top'>"; }else{ echo "</td><td valign='top'>"; };
		$ii++;
	?>
	<font color="#009900"><b><?=$ii;?>. <?=$arr_jabatan[$inc_row[id_jabatan]];?></b></font>
	<hr size="1" color="#252525" style="border-top:1px dashed #252525;" width="90%">
	<table width="300" border="0" cellpadding="5" cellspacing="0">
	 <tr>
		 <td width="50%" vAlign="top">
		 <table width="100%" border="0" cellpadding="0" cellspacing="2">
			 <tr>
				 <td width="100%" colspan="3"> <font class="titleitems"><b>Laki-Laki</b> </td>
			 </tr>
			 <tr>
				 <td width="40%" nowrap> &nbsp; - Baju </td><td width="5%"> : </td>
				 <td width="60%" nowrap> <?=$inc_row[priabaju];?> <?=$bsn_satuan;?> </td>
			 </tr>
			 <tr>
				 <td width="40%" nowrap> &nbsp; - Kain </td><td width="5%"> : </td>
				 <td width="60%" nowrap> <?=$inc_row[priakain];?> <?=$bsn_satuan;?> </td>
			 </tr>
			 <tr>
				 <td width="40%" nowrap> &nbsp; - Selop </td><td width="5%"> : </td>
				 <td width="60%" nowrap> <?=$inc_row[priaselop];?> <?=$bsn_satuan;?> </td>
			 </tr>
			 <tr>
				 <td width="40%" nowrap> &nbsp; - Asesoris </td><td width="5%"> : </td>
				 <td width="60%" nowrap> <?=$inc_row[priaasesoris];?> <?=$bsn_satuan;?> </td>
			 </tr>
			 <tr>
				 <td width="40%" nowrap> &nbsp; - Blangkon </td><td width="5%"> : </td>
				 <td width="60%" nowrap> <?=$inc_row[priablangkon];?> <?=$bsn_satuan;?> </td>
			 </tr>
		 </table>
		 </td>
		 <td width="45%" vAlign="top">
		 <table width="100%" border="0" cellpadding="0" cellspacing="2">
			 <tr>
				 <td width="100%" colspan="3"> <font class="titleitems"><b>Perempuan</b> </td>
			 </tr>
			 <tr>
				 <td width="40%" nowrap> &nbsp; - Baju </td><td width="5%"> : </td>
				 <td width="60%" nowrap> <?=$inc_row[wanitabaju];?> <?=$bsn_satuan;?> </td>
			 </tr>
			 <tr>
				 <td width="40%" nowrap> &nbsp; - Kain </td><td width="5%"> : </td>
				 <td width="60%" nowrap> <?=$inc_row[wanitakain];?> <?=$bsn_satuan;?> </td>
			 </tr>
			 <tr>
				 <td width="40%" nowrap> &nbsp; - Selop </td><td width="5%"> : </td>
				 <td width="60%" nowrap> <?=$inc_row[wanitaselop];?> <?=$bsn_satuan;?> </td>
			 </tr>
			 <tr>
				 <td width="40%" nowrap> &nbsp; - Asesoris </td><td width="5%"> : </td>
				 <td width="60%" nowrap> <?=$inc_row[wanitaasesoris];?> <?=$bsn_satuan;?> </td>
			 </tr>
		 </table>
		 </td>
	 </tr>
	</table>	
	<? };//while ?>
 </tr>
</table>