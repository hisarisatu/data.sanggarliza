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
?>

<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
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

		$vrb_sewabaju = "sewabaju_".$row[id_jabatan];
		$vlu_sewabaju = $$vrb_sewabaju;
		$vrb_sdribaju = "sdribaju_".$row[id_jabatan];
		$vlu_sdribaju = $$vrb_sdribaju;

		$vrb_sewaselop = "sewaselop_".$row[id_jabatan];
		$vlu_sewaselop = $$vrb_sewaselop;
		$vrb_sdriselop = "sdriselop_".$row[id_jabatan];
		$vlu_sdriselop = $$vrb_sdriselop;

		$vrb_sewablangkon = "sewablangkon_".$row[id_jabatan];
		$vlu_sewablangkon = $$vrb_sewablangkon;
		$vrb_sdriblangkon = "sdriblangkon_".$row[id_jabatan];
		$vlu_sdriblangkon = $$vrb_sdriblangkon;

		$vrb_sewakain = "sewakain_".$row[id_jabatan];
		$vlu_sewakain = $$vrb_sewakain;
		$vrb_sdrikain = "sdrikain_".$row[id_jabatan];
		$vlu_sdrikain = $$vrb_sdrikain;

		$vrb_sewaasesoris = "sewaasesoris_".$row[id_jabatan];
		$vlu_sewaasesoris = $$vrb_sewaasesoris;
		$vrb_sdriasesoris = "sdriasesoris_".$row[id_jabatan];
		$vlu_sdriasesoris = $$vrb_sdriasesoris;

		$vrb_sanggulstd = "sanggulstd_".$row[id_jabatan];
		$vlu_sanggulstd = $$vrb_sanggulstd;
		$vrb_sanggulspc = "sanggulspc_".$row[id_jabatan];
		$vlu_sanggulspc = $$vrb_sanggulspc;

		$vrb_makeupstd = "makeupstd_".$row[id_jabatan];
		$vlu_makeupstd = $$vrb_makeupstd;
		$vrb_makeupspc = "makeupspc_".$row[id_jabatan];
		$vlu_makeupspc = $$vrb_makeupspc;

		$runSQL2 = "select id_client from order_tatabusana where id_client='$id' and id_acara='$id_acara' and id_jabatan='$row[id_jabatan]'";
		$result2 = mysql_query($runSQL2, $connDB);
		if ($row2 = mysql_fetch_array($result2)) {
			//update data
			$runSQL2 = "update order_tatabusana set id_client='$id', id_acara='$id_acara', id_jabatan='$row[id_jabatan]', baju_sewa='$vlu_sewabaju', baju_sendiri='$vlu_sdribaju', kain_sewa='$vlu_sewakain', kain_sendiri='$vlu_sdrikain', selop_sewa='$vlu_sewaselop', selop_sendiri='$vlu_sdriselop', blangkon_sewa='$vlu_sewablangkon', blangkon_sendiri='$vlu_sdriblangkon', asesoris_sewa='$vlu_sewaasesoris', asesoris_sendiri='$vlu_sdriasesoris', catatan='$vlu_catatan', user_update='$SAH[id_user]', ip_update='$REMOTE_ADDR', last_update=now() where id_client='$id' and id_acara='$id_acara' and id_jabatan='$row[id_jabatan]'";
			$update2 = mysql_query($runSQL2, $connDB);
			//echo $runSQL2;
		}else{
			//insert data
			$runSQL2 = "insert into order_tatabusana (id_client, id_acara, id_jabatan, baju_sewa, baju_sendiri, kain_sewa, kain_sendiri, selop_sewa, selop_sendiri, blangkon_sewa, blangkon_sendiri, asesoris_sewa, asesoris_sendiri, catatan, id_user, login_ip, created) VALUES ('$id', '$id_acara', '$row[id_jabatan]', '$vlu_sewabaju', '$vlu_sdribaju', '$vlu_sewakain', '$vlu_sdrikain', '$vlu_sewaselop', '$vlu_sdriselop', '$vlu_sewablangkon', '$vlu_sdriblangkon', '$vlu_sewaasesoris', '$vlu_sdriasesoris', '$vlu_catatan', '$SAH[id_user]', '$REMOTE_ADDR', now())";
			$insert2 = mysql_query($runSQL2, $connDB);
			//echo $runSQL2;
		};

		$runSQL2 = "select id_client from order_tatarias where id_client='$id' and id_acara='$id_acara' and id_jabatan='$row[id_jabatan]'";
		$result2 = mysql_query($runSQL2, $connDB);
		if ($row2 = mysql_fetch_array($result2)) {
			//update data
			$runSQL2 = "update order_tatarias set id_client='$id', id_acara='$id_acara', id_jabatan='$row[id_jabatan]', sgljbl_standart='$vlu_sanggulstd', sgljbl_spesial='$vlu_sanggulspc', makeup_standart='$vlu_makeupstd', makeup_spesial='$vlu_makeupspc', catatan='$vlu_catatan', user_update='$SAH[id_user]', ip_update='$REMOTE_ADDR', last_update=now() where id_client='$id' and id_acara='$id_acara' and id_jabatan='$row[id_jabatan]'";
			$update2 = mysql_query($runSQL2, $connDB);
			//echo $runSQL2;
		}else{
			//insert data
			$runSQL2 = "insert into order_tatarias (id_client, id_acara, id_jabatan, sgljbl_standart, sgljbl_spesial, makeup_standart, makeup_spesial, catatan, id_user, login_ip, created) VALUES ('$id', '$id_acara', '$row[id_jabatan]', '$vlu_sanggulstd', '$vlu_sanggulspc', '$vlu_makeupstd', '$vlu_makeupspc', '$vlu_catatan', '$SAH[id_user]', '$REMOTE_ADDR', now())";
			$insert2 = mysql_query($runSQL2, $connDB);
			//echo $runSQL2;
		};


	};
	redirect("?menu=$menu&uid=$uid&page=view&id=$id");
};//end-if-submit

if ((strlen($run) < 1) and ($id <> "")){ 
	$runSQL = "select id_client, id_acara, id_jabatan, baju_sewa, baju_sendiri, kain_sewa, kain_sendiri, selop_sewa, selop_sendiri, blangkon_sewa, blangkon_sendiri, asesoris_sewa, asesoris_sendiri, catatan from order_tatabusana where id_client='$id' and id_acara='$id_acara' order by id_jabatan asc";
	$result = mysql_query($runSQL, $connDB);
	while ($row = mysql_fetch_array ($result)) {
		$vrb_gaya = "id_gaya".$row[id_acara];
		$$vrb_gaya = $row[id_gaya];

		$vrb_sewabaju = "sewabaju_".$row[id_jabatan];
		$$vrb_sewabaju = $row[baju_sewa];
		$vrb_sdribaju = "sdribaju_".$row[id_jabatan];
		$$vrb_sdribaju = $row[baju_sendiri];

		$vrb_sewaselop = "sewaselop_".$row[id_jabatan];
		$$vrb_sewaselop = $row[selop_sewa];
		$vrb_sdriselop = "sdriselop_".$row[id_jabatan];
		$$vrb_sdriselop = $row[selop_sendiri];

		$vrb_sewablangkon = "sewablangkon_".$row[id_jabatan];
		$$vrb_sewablangkon = $row[blangkon_sewa];
		$vrb_sdriblangkon = "sdriblangkon_".$row[id_jabatan];
		$$vrb_sdriblangkon = $row[blangkon_sendiri];

		$vrb_sewakain = "sewakain_".$row[id_jabatan];
		$$vrb_sewakain = $row[kain_sewa];
		$vrb_sdrikain = "sdrikain_".$row[id_jabatan];
		$$vrb_sdrikain = $row[kain_sendiri];

		$vrb_sewaasesoris = "sewaasesoris_".$row[id_jabatan];
		$$vrb_sewaasesoris = $row[asesoris_sewa];
		$vrb_sdriasesoris = "sdriasesoris_".$row[id_jabatan];
		$$vrb_sdriasesoris = $row[asesoris_sendiri];
	};//while

	$runSQL = "select id_client, id_acara, id_jabatan, sgljbl_standart, sgljbl_spesial, makeup_standart, makeup_spesial, catatan from order_tatarias where id_client='$id' and id_acara='$id_acara' order by id_jabatan asc";
	$result = mysql_query($runSQL, $connDB);
	while ($row = mysql_fetch_array ($result)) {
		$vrb_sanggulstd = "sanggulstd_".$row[id_jabatan];
		$$vrb_sanggulstd = $row[sgljbl_standart];
		$vrb_sanggulspc = "sanggulspc_".$row[id_jabatan];
		$$vrb_sanggulspc = $row[sgljbl_spesial];

		$vrb_makeupstd = "makeupstd_".$row[id_jabatan];
		$$vrb_makeupstd = $row[makeup_standart];
		$vrb_makeupspc = "makeupspc_".$row[id_jabatan];
		$$vrb_makeupspc = $row[makeup_spesial];
	};//while
};//if
?>

	 <p>&nbsp;</p>
   <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
	 <font class="titledata"><b>Input/Edit Rincian Pesanan</b><br></font>
	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
     <td width="50%" valign="bottom" align="left"> &nbsp; </td>
     <td width="50%" valign="bottom" align="right">
		   <img src="images/arrow2.gif" border="0">
	     <a href="<?="?menu=$menu&uid=$uid&page=view&id=$id";?>"><b>Back Rincian</b></a> &nbsp;
		 </td>
		</tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	 </table>

	 <table width="700" border="0" cellpadding="0" cellspacing="5">
		 <tr>
			 <td colspan="2" width="60%"> <b>Tata Busana</b> </td>
			 <td colspan="2" width="40%"> <b>Tata Rias</b> </td>
		 </tr>
		<?
		unset($ii, $row);
		$runSQL = "select id_jabatan, nama_jabatan from p_jabatan order by id_jabatan asc";
		$result = mysql_query($runSQL, $connDB);
		while ($row = mysql_fetch_array ($result)) {
			$ii++;
			$hubkel = $row[id_jabatan];
			if ($row[id_jabatan] == 1){ 
				$bsn_satuan="Buah";
				$rias_satuan="Kali";
			} else { 
				$bsn_satuan="Orang";
				$rias_satuan="Orang";
			};//if
		?>
		 <tr>
			 <td width="3%"></td>
			 <td width="57%" vAlign="top">

				<br><font color="#009900"><b><?=$ii;?>. Busana <?=$row[nama_jabatan];?></b></font>
				<hr size="1" color="#252525" style="border-top:1px dashed #252525;" width="90%" align="left">

				<?
				//$hubkel -> id_jabatan
				//$bsn_satuan -> nama satuan
				if ($bsn_satuan == ""){ $bsn_satuan="Orang"; }

				$vrb_sewabaju = "sewabaju_$hubkel";
				$vlu_sewabaju = $$vrb_sewabaju;
				$vrb_sdribaju = "sdribaju_$hubkel";
				$vlu_sdribaju = $$vrb_sdribaju;

				$vrb_sewaselop = "sewaselop_$hubkel";
				$vlu_sewaselop = $$vrb_sewaselop;
				$vrb_sdriselop = "sdriselop_$hubkel";
				$vlu_sdriselop = $$vrb_sdriselop;

				$vrb_sewablangkon = "sewablangkon_$hubkel";
				$vlu_sewablangkon = $$vrb_sewablangkon;
				$vrb_sdriblangkon = "sdriblangkon_$hubkel";
				$vlu_sdriblangkon = $$vrb_sdriblangkon;

				$vrb_sewakain = "sewakain_$hubkel";
				$vlu_sewakain = $$vrb_sewakain;
				$vrb_sdrikain = "sdrikain_$hubkel";
				$vlu_sdrikain = $$vrb_sdrikain;

				$vrb_sewaasesoris = "sewaasesoris_$hubkel";
				$vlu_sewaasesoris = $$vrb_sewaasesoris;
				$vrb_sdriasesoris = "sdriasesoris_$hubkel";
				$vlu_sdriasesoris = $$vrb_sdriasesoris;
				?>
				<table width="350" border="0" cellpadding="5" cellspacing="0">
				 <tr>
					 <td width="50%" vAlign="top">
					 <table width="100%" border="0" cellpadding="0" cellspacing="2">
						 <tr>
							 <td width="100%" colspan="3"> <b>Baju</b> </td>
						 </tr>
						 <tr>
							 <td width="40%"> &nbsp; &nbsp; - Sewa </td><td width="5%"> : </td>
							 <td width="60%"> <input type="text" name="<?=$vrb_sewabaju;?>" size="3" value="<?=$vlu_sewabaju;?>"> <?=$bsn_satuan;?> </td>
						 </tr>
						 <tr>
							 <td width="40%"> &nbsp; &nbsp; - Sendiri </td><td width="5%"> : </td>
							 <td width="60%"> <input type="text" name="<?=$vrb_sdribaju;?>" size="3" value="<?=$vlu_sdribaju;?>"> <?=$bsn_satuan;?> </td>
						 </tr>
						 <tr>
							 <td width="100%" colspan="3"> <b>Selop</b> </td>
						 </tr>
						 <tr>
							 <td width="40%"> &nbsp; &nbsp; - Sewa </td><td width="5%"> : </td>
							 <td width="60%"> <input type="text" name="<?=$vrb_sewaselop;?>" size="3" value="<?=$vlu_sewaselop;?>"> <?=$bsn_satuan;?> </td>
						 </tr>
						 <tr>
							 <td width="40%"> &nbsp; &nbsp; - Sendiri </td><td width="5%"> : </td>
							 <td width="60%"> <input type="text" name="<?=$vrb_sdriselop;?>" size="3" value="<?=$vlu_sdriselop;?>"> <?=$bsn_satuan;?> </td>
						 </tr>
						 <tr>
							 <td width="100%" colspan="3"> <b>Blangkon</b> </td>
						 </tr>
						 <tr>
							 <td width="40%"> &nbsp; &nbsp; - Sewa </td><td width="5%"> : </td>
							 <td width="60%"> <input type="text" name="<?=$vrb_sewablangkon;?>" size="3" value="<?=$vlu_sewablangkon;?>"> <?=$bsn_satuan;?> </td>
						 </tr>
						 <tr>
							 <td width="40%"> &nbsp; &nbsp; - Sendiri </td><td width="5%"> : </td>
							 <td width="60%"> <input type="text" name="<?=$vrb_sdriblangkon;?>" size="3" value="<?=$vlu_sdriblangkon;?>"> <?=$bsn_satuan;?> </td>
						 </tr>
					 </table>
					 </td>
					 <td width="45%" vAlign="top">
					 <table width="100%" border="0" cellpadding="0" cellspacing="2">
						 <tr>
							 <td width="100%" colspan="3"> <b>Kain</b> </td>
						 </tr>
						 <tr>
							 <td width="40%"> &nbsp; &nbsp; - Sewa </td><td width="5%"> : </td>
							 <td width="60%"> <input type="text" name="<?=$vrb_sewakain;?>" size="3" value="<?=$vlu_sewakain;?>"> <?=$bsn_satuan;?> </td>
						 </tr>
						 <tr>
							 <td width="40%"> &nbsp; &nbsp; - Sendiri </td><td width="5%"> : </td>
							 <td width="60%"> <input type="text" name="<?=$vrb_sdrikain;?>" size="3" value="<?=$vlu_sdrikain;?>"> <?=$bsn_satuan;?> </td>
						 </tr>
						 <tr>
							 <td width="100%" colspan="3"> <b>Asesoris</b> </td>
						 </tr>
						 <tr>
							 <td width="40%"> &nbsp; &nbsp; - Sewa </td><td width="5%"> : </td>
							 <td width="60%"> <input type="text" name="<?=$vrb_sewaasesoris;?>" size="3" value="<?=$vlu_sewaasesoris;?>"> <?=$bsn_satuan;?> </td>
						 </tr>
						 <tr>
							 <td width="40%"> &nbsp; &nbsp; - Sendiri </td><td width="5%"> : </td>
							 <td width="60%"> <input type="text" name="<?=$vrb_sdriasesoris;?>" size="3" value="<?=$vlu_sdriasesoris;?>"> <?=$bsn_satuan;?> </td>
						 </tr>
					 </table>
					 </td>
				 </tr>
				</table>			 
			 
			 </td>
			 <td width="3%"></td>
			 <td width="37%" vAlign="top">

				<br><font color="#009900"><b><?=$ii;?>. Rias <?=$row[nama_jabatan];?></b></font>
				<hr size="1" color="#252525" style="border-top:1px dashed #252525;" width="90%" align="left">
				<?
				//$hubkel -> id_jabatan
				//$bsn_satuan -> nama satuan
				if ($rias_satuan == ""){ $rias_satuan="Orang"; }

				$vrb_sanggulstd = "sanggulstd_$hubkel";
				$vlu_sanggulstd = $$vrb_sanggulstd;
				$vrb_sanggulspc = "sanggulspc_$hubkel";
				$vlu_sanggulspc = $$vrb_sanggulspc;

				$vrb_makeupstd = "makeupstd_$hubkel";
				$vlu_makeupstd = $$vrb_makeupstd;
				$vrb_makeupspc = "makeupspc_$hubkel";
				$vlu_makeupspc = $$vrb_makeupspc;
				?>
				<table width="250" border="0" cellpadding="0" cellspacing="2">
				 <tr>
					 <td width="5%"> &nbsp; </td>
					 <td width="95%">
					 <table width="100%" border="0" cellpadding="0" cellspacing="2">
						 <tr>
							 <td width="100%" colspan="3"> <b>Sanggul/Jilbab</b> </td>
						 </tr>
						 <tr>
							 <td width="25%"> &nbsp; &nbsp; - Standart </td><td width="5%"> : </td>
							 <td width="70%"> <input type="text" name="<?=$vrb_sanggulstd?>" size="3" value="<?=$vlu_sanggulstd;?>"> <?=$rias_satuan;?> </td>
						 </tr>
						 <tr>
							 <td width="25%"> &nbsp; &nbsp; - Special </td><td width="5%"> : </td>
							 <td width="70%"> <input type="text" name="<?=$vrb_sanggulspc?>" size="3" value="<?=$vlu_sanggulspc;?>"> <?=$rias_satuan;?> </td>
						 </tr>
						 <tr>
							 <td width="100%" colspan="3"> <b>Make UP</b> </td>
						 </tr>
						 <tr>
							 <td width="25%"> &nbsp; &nbsp; - Standart </td><td width="5%"> : </td>
							 <td width="70%"> <input type="text" name="<?=$vrb_makeupstd?>" size="3" value="<?=$vlu_makeupstd;?>"> <?=$rias_satuan;?> </td>
						 </tr>
						 <tr>
							 <td width="25%"> &nbsp; &nbsp; - Special </td><td width="5%"> : </td>
							 <td width="70%"> <input type="text" name="<?=$vrb_makeupspc?>" size="3" value="<?=$vlu_makeupspc;?>"> <?=$rias_satuan;?> </td>
						 </tr>
					 </table>
					 </td>
				 </tr>
				</table>

			 </td>
		 </tr>
		<? };?>
	 </table>

   <hr size="1" color="#252525" style="border-top:1px dashed #252525;" width="650">
	 <input type="hidden" name="id" value="<?=$id;?>"><br>
	 <input type="hidden" name="id_acara" value="<?=$id_acara;?>"><br>
	 <input type="submit" value="Simpan" name="run" class="button">

   </td>
  </tr>
  </form>
</table>