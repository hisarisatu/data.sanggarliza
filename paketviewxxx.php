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


<table width="95%" border="0" cellpadding="0" cellspacing="0" align="center">
<tr>
 <td width="100%" colspan="2"> &nbsp; <font class="titleacara"><b>1. Siraman</b></a></td>
</tr>
<tr>
 <td width="5%" > &nbsp; </td>
 <td width="95%">
	<table width="600" border="0" cellspacing="0" cellpadding="0">
		<tr><td colspan="2" width="100%"> <br><font class="titlesubacara"><b>1. Tata Busana</b></font> <a href="<?="?menu=$menu&uid=$uid&page=riasbusana_input&id=$id_client&id_acara=$id_acara";?>"><img border='0' src='images/edit.gif' title='Input/Edit Data'></a></td></tr>
		<tr>
			<td width="5%"></td>
			<td width="95%">

			</td>
		</tr>

		<tr><td colspan="2" width="100%"> <br><font class="titlesubacara"><b>2. MC</b></font> <a href="<?="?menu=$menu&uid=$uid&page=riasbusana_input&id=$id_client&id_acara=$id_acara";?>"><img border='0' src='images/edit.gif' title='Input/Edit Data'></a></td></tr>
		<tr>
			<td width="5%"></td>
			<td width="95%">

			</td>
		</tr>

		<tr><td colspan="2" width="100%"> <br><font class="titlesubacara"><b>3. Perlegkapan</b></font> <a href="<?="?menu=$menu&uid=$uid&page=riasbusana_input&id=$id_client&id_acara=$id_acara";?>"><img border='0' src='images/edit.gif' title='Input/Edit Data'></a></td></tr>
		<tr>
			<td width="5%"></td>
			<td width="95%">

			</td>
		</tr>
	</table>
 </td>
</tr>

<tr>
 <td width="100%" colspan="2"> &nbsp; <br><font class="titleacara"><b>2. Akad Nikah</b></a></td>
</tr>
<tr>
 <td width="5%" > &nbsp; </td>
 <td width="95%">
	<table width="600" border="0" cellspacing="0" cellpadding="0">
		<tr><td colspan="2" width="100%"> <font class="titlesubacara"><b>1. Tata Rias</b></font> <a href="<?="?menu=$menu&uid=$uid&page=riasbusana_input&id=$id_client&id_acara=$id_acara";?>"><img border='0' src='images/edit.gif' title='Input/Edit Data'></a> </td></tr>
		<tr>
			<td width="5%"></td>
			<td width="95%">
			</td>
		</tr>

		<tr><td colspan="2" width="100%"> <br><font class="titlesubacara"><b>2. Tata Busana</b></font> <a href="<?="?menu=$menu&uid=$uid&page=riasbusana_input&id=$id_client&id_acara=$id_acara";?>"><img border='0' src='images/edit.gif' title='Input/Edit Data'></a></td></tr>
		<tr>
			<td width="5%"></td>
			<td width="95%">

			</td>
		</tr>

		<tr><td colspan="2" width="100%"> <br><font class="titlesubacara"><b>3. MC</b></font> <a href="<?="?menu=$menu&uid=$uid&page=riasbusana_input&id=$id_client&id_acara=$id_acara";?>"><img border='0' src='images/edit.gif' title='Input/Edit Data'></a></td></tr>
		<tr>
			<td width="5%"></td>
			<td width="95%">

			</td>
		</tr>

		<tr><td colspan="2" width="100%"> <br><font class="titlesubacara"><b>4. Perlegkapan</b></font> <a href="<?="?menu=$menu&uid=$uid&page=riasbusana_input&id=$id_client&id_acara=$id_acara";?>"><img border='0' src='images/edit.gif' title='Input/Edit Data'></a></td></tr>
		<tr>
			<td width="5%"></td>
			<td width="95%">

			</td>
		</tr>
	</table>
 </td>
</tr>

<tr>
 <td width="100%" colspan="2"> &nbsp; <br><font class="titleacara"><b>3. Resepsi</b></a></td>
</tr>
<tr>
 <td width="5%" > &nbsp; </td>
 <td width="95%">
	<table width="600" border="0" cellspacing="0" cellpadding="0">
		<tr><td colspan="2" width="100%"> <font class="titlesubacara"><b>1. Tata Rias</b></font> <a href="<?="?menu=$menu&uid=$uid&page=riasbusana_input&id=$id_client&id_acara=$id_acara";?>"><img border='0' src='images/edit.gif' title='Input/Edit Data'></a> </td></tr>
		<tr>
			<td width="5%"></td>
			<td width="95%">
			</td>
		</tr>

		<tr><td colspan="2" width="100%"> <br><font class="titlesubacara"><b>2. Tata Busana</b></font> <a href="<?="?menu=$menu&uid=$uid&page=riasbusana_input&id=$id_client&id_acara=$id_acara";?>"><img border='0' src='images/edit.gif' title='Input/Edit Data'></a></td></tr>
		<tr>
			<td width="5%"></td>
			<td width="95%">
			<table width="100%" border="0" cellspacing="1" cellpadding="5">
				<tr>
					<?
					$runSQL = "select id_jabatan, nama_jabatan from p_jabatan order by id_jabatan asc";
					$result = mysql_query($runSQL, $connDB);
					while ($row = mysql_fetch_array ($result)) { $arr_jabatan[$row[id_jabatan]]=$row[nama_jabatan]; }

					unset($ii);
					//$runSQL = "select id_paket, id_acara, id_jabatan, wanita_baju, wanita_kain, wanita_selop, wanita_asesoris, pria_baju, pria_kain, pria_selop, pria_asesoris, pria_blangkon, catatan, id_user, login_ip, created, user_update, ip_update, last_update from paket_busana where id_paket='$id' and id_acara='$id_acara' order by id_jabatan asc";

					$runSQL = "select id_jabatan, nama_jabatan from p_jabatan order by id_jabatan asc";
					$result = mysql_query($runSQL, $connDB);
					while ($row = mysql_fetch_array ($result)) {
						if ($ii%2 == 0){ echo "</td></tr><tr><td valign='top'>"; }else{ echo "</td><td valign='top'>"; }; $ii++;
					?>
					<font color="#009900"><b><?=$ii;?>. <?=$arr_jabatan[$row[id_jabatan]];?></b></font>
					<hr size="1" color="#252525" style="border-top:1px dashed #252525;" width="90%">
					<table width="200" border="0" cellpadding="5" cellspacing="0">
					 <tr>
						 <td width="50%" vAlign="top">
						 <table width="100%" border="0" cellpadding="0" cellspacing="2">
							 <tr>
								 <td width="100%" colspan="3"> <font class="titleitems"><b>Laki-Laki</b> </td>
							 </tr>
							 <tr>
								 <td width="40%" nowrap> &nbsp; - Baju </td><td width="5%"> : </td>
								 <td width="60%" nowrap> <input type="text" name="<?=$vrb_pria_baju;?>" size="1" value="<?=$vlu_pria_baju;?>"> </td>
							 </tr>
							 <tr>
								 <td width="40%" nowrap> &nbsp; - Kain </td><td width="5%"> : </td>
								 <td width="60%" nowrap> <input type="text" name="<?=$vrb_pria_baju;?>" size="1" value="<?=$vlu_pria_baju;?>"> </td>
							 </tr>
							 <tr>
								 <td width="40%" nowrap> &nbsp; - Selop </td><td width="5%"> : </td>
								 <td width="60%" nowrap> <input type="text" name="<?=$vrb_pria_baju;?>" size="1" value="<?=$vlu_pria_baju;?>"> </td>
							 </tr>
							 <tr>
								 <td width="40%" nowrap> &nbsp; - Asesoris </td><td width="5%"> : </td>
								 <td width="60%" nowrap> <input type="text" name="<?=$vrb_pria_baju;?>" size="1" value="<?=$vlu_pria_baju;?>"> </td>
							 </tr>
							 <tr>
								 <td width="40%" nowrap> &nbsp; - Blangkon </td><td width="5%"> : </td>
								 <td width="60%" nowrap> <input type="text" name="<?=$vrb_pria_baju;?>" size="1" value="<?=$vlu_pria_baju;?>"> </td>
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
								 <td width="60%" nowrap> <input type="text" name="<?=$vrb_pria_baju;?>" size="1" value="<?=$vlu_pria_baju;?>"> </td>
							 </tr>
							 <tr>
								 <td width="40%" nowrap> &nbsp; - Kain </td><td width="5%"> : </td>
								 <td width="60%" nowrap> <input type="text" name="<?=$vrb_pria_baju;?>" size="1" value="<?=$vlu_pria_baju;?>"> </td>
							 </tr>
							 <tr>
								 <td width="40%" nowrap> &nbsp; - Selop </td><td width="5%"> : </td>
								 <td width="60%" nowrap> <input type="text" name="<?=$vrb_pria_baju;?>" size="1" value="<?=$vlu_pria_baju;?>"> </td>
							 </tr>
							 <tr>
								 <td width="40%" nowrap> &nbsp; - Asesoris </td><td width="5%"> : </td>
								 <td width="60%" nowrap> <input type="text" name="<?=$vrb_pria_baju;?>" size="1" value="<?=$vlu_pria_baju;?>"> </td>
							 </tr>
						 </table>
						 </td>
					 </tr>
					</table>
					<?
					};//while
					?>
				 </tr>
			</table>
			</td>
		</tr>

		<tr><td colspan="2" width="100%"> <br><font class="titlesubacara"><b>3. Sajen</b></font> <a href="<?="?menu=$menu&uid=$uid&page=sajen_input&id=$id_client&id_acara=$id_acara";?>"><img border='0' src='images/edit.gif' title='Input/Edit Data'></a></td></tr>
		<tr>
			<td width="5%"></td>
			<td width="95%">

			</td>
		</tr>

		<tr><td colspan="2" width="100%"> <br><font class="titlesubacara"><b>4. Master Of Ceremony</b></font> <a href="<?="?menu=$menu&uid=$uid&page=mc_input&id=$id_client&id_acara=$id_acara";?>"><img border='0' src='images/edit.gif' title='Input/Edit Data'></a></td></tr>
		<tr>
			<td width="5%"></td>
			<td width="95%">
		
			</td>
		</tr>

		<tr><td colspan="2" width="100%"> <br><font class="titlesubacara"><b>5. Tarian</b></font> <a href="<?="?menu=$menu&uid=$uid&page=tarian_input&id=$id_client&id_acara=$id_acara";?>"><img border='0' src='images/edit.gif' title='Input/Edit Data'></a></td></tr>
		<tr>
			<td width="5%"></td>
			<td width="95%">

			</td>
		</tr>

		<tr><td colspan="2" width="100%"> <br><font class="titlesubacara"><b>6. Upacara Adat</b></font> <a href="<?="?menu=$menu&uid=$uid&page=adat_input&id=$id_client&id_acara=$id_acara";?>"><img border='0' src='images/edit.gif' title='Input/Edit Data'></a></td></tr>
		<tr>
			<td width="5%"></td>
			<td width="95%">

			</td>
		</tr>


		<tr><td colspan="2" width="100%"> <br><font class="titlesubacara"><b>7. Lainnya</b></font> <a href="<?="?menu=$menu&uid=$uid&page=lainnya_input&id=$id_client&id_acara=$id_acara";?>"><img border='0' src='images/edit.gif' title='Input/Edit Data'></a></td></tr>
		<tr>
			<td width="5%"></td>
			<td width="95%">
			</td>
		</tr>
	</table>

	 </td>
  </tr>
</table>
