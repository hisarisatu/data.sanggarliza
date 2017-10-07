<? 
// Tools SMS Gateway
// Written by Priyo Setiawan; iyok642@yahoo.com
// http://iyok642.blogspot.com/ (031-70920002)
// 08 Maret 2010, lastupdate 04 April 2010

include_once("include.php");
include_once("include_sms.php");

if (!$connUP2){ 
	$connUP2 = OCILogon($connUpd[0],$connUpd[1],$connUpd[2]);
};//if-connUP2

//flag reset after 10mnt = 1/24jam * 0.16667jam (20mnt/60mnt) = 0.013889  (1=24jam)
$runSQL = "delete from DCS_FLAGCALL where (sysdate-tgl_flag) > 0.041666667";
$OCIParseDelete = OCIParse($conn, $runSQL);
OCIExecute($OCIParseDelete, OCI_DEFAULT);
OCIFreeStatement($OCIParseDelete);

$lockcall=0;
if ($run == ""){
	$runSQL = "select b.fullname, a.ip_address, to_char(a.tgl_flag,'DD-MON-YYYY HH24:MI:SS') tgl_flag from DCS_FLAGCALL a, DCS_SYSUSERNAME b where a.id_user=b.id_user and a.ndem='$ndem' and a.datel='$datel' and a.area='$area' order by a.tgl_flag desc";
	$OCIParse = OCIParse($conn, $runSQL);
	OCIExecute($OCIParse, OCI_DEFAULT);
	if (OCIFetch($OCIParse)){ 
		$lock_fullname   = OCIResult($OCIParse,1);
		$lock_ip_address = OCIResult($OCIParse,2);
		$lock_tgl_flag   = OCIResult($OCIParse,3);
		$lockcall = 1;
	};//if

	if (($lockcall == 0) and (($SAH[id_group] == 3)or($SAH[id_group] == 1))){
		$runSQL = "insert into DCS_FLAGCALL (ndem, datel, area, tgl_flag, id_user, ip_address, status) values ($ndem, '$datel', '$area', sysdate, $SAH[id_user], '$REMOTE_ADDR', 'READ')";
		$OCIParseInsert = OCIParse($conn, $runSQL);
		OCIExecute($OCIParseInsert, OCI_DEFAULT);
		OCIFreeStatement($OCIParseInsert);
	};//if
};//if

$runSQL = "
select distinct a.ndem, a.id_call, a.datel, a.area, a.status
from DCS_HASILCALL a
where a.tgl_call=(select max(tgl_call) from DCS_HASILCALL where ndem=a.ndem and datel=a.datel and area=a.area)
and a.ndem='$ndem' and a.datel='$datel' and a.area='$area' and a.mdf='$mdf'";
$OCIParse = OCIParse($conn, $runSQL);
OCIExecute($OCIParse, OCI_DEFAULT);
while (OCIFetch($OCIParse)){
	for ($iyk=1;  $iyk<=OCINumCols($OCIParse);  $iyk++) {
		$colom_name = strtolower(OCIColumnName($OCIParse,$iyk));
		$row[$colom_name] = OCIResult($OCIParse,$iyk);
	};//for
	$last_status = $row[status];
};//while

//detail informasi pelanggan DEMAND_FE_ALL
unset($ccc, $row);
$htmlData = "<tr bgcolor='#ABBDE9'><td width='100%' height='20' align='center'><b>Detail Informasi Pelanggan</b></td></tr>";
$runSQL = "select ndem, to_char(tgl_re,'DD-MON-YYYY HH24:MI:SS') TGL_DAFTAR, nom NAMA_PLG, jalan||' '||nvoie ALAMAT, kcontact, datel, area, mdf from DEMAND_FE_ALL where ndem='$ndem' and datel='$datel' and area='$area' and mdf='$mdf'";
$OCIParse = OCIParse($conn, $runSQL);
OCIExecute($OCIParse, OCI_DEFAULT);
while (OCIFetch($OCIParse)){
	for ($iyk=1;  $iyk<=OCINumCols($OCIParse);  $iyk++) {
		$colom_name = strtolower(OCIColumnName($OCIParse,$iyk));
		$row[$colom_name] = OCIResult($OCIParse,$iyk);

		$save_tgl_re = $row[tgl_daftar];
		$save_nom   = removeSlash($row[nama_plg]);
		$save_jalan = removeSlash($row[alamat]);

		if ($row[kcontact] <> ""){ $row[kcontact] = wordwrap($row[kcontact], 40, "<br>", 1); };
		if ($iyk%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
		$fontColor = "<font size='1'>";
		$htmlData .= "
		  <tr bgcolor='$color'>
			<td width='100%'>
			<table width='370' cellspacing='0' cellpadding='0'>
			  <tr>
				  <td width='100' align='right' nowrap><font size='1'>".strtoupper($colom_name)."</td>
				  <td width='20' align='center' nowrap>:</td>
				  <td width='250'align='left'><font size='1' color='#000099'>".$row[$colom_name]."</td>
			  </tr>
			</table>
			</td>
		  </tr>\n";
	};//for
	$demand_fe_all = 1;
};//end-while

if ($demand_fe_all <> 1){
	$sqlField = "ndem, to_char(tgl_re,'DD-MON-YYYY HH24:MI:SS') TGL_DAFTAR, nom NAMA_PLG, '--jln-- '||nvoie ALAMAT, kcontact, datel, area, mdf,";
};//if

//detail informasi pelanggan DEMAND_SPEEDY_ALL_NEW
unset($ccc, $row);
$runSQL = "select $sqlField rk, nd nd_telp, nd_speedy, nd_contact, agency, chanel, paket, etat from DEMAND_SPEEDY_ALL_NEW where ndem='$ndem' and datel='$datel' and area='$area' and mdf='$mdf'";
$OCIParse = OCIParse($connUP2, $runSQL);
OCIExecute($OCIParse, OCI_DEFAULT);
while (OCIFetch($OCIParse)){
	for ($iyk=1;  $iyk<=OCINumCols($OCIParse);  $iyk++) {
		$colom_name = strtolower(OCIColumnName($OCIParse,$iyk));
		$row[$colom_name] = OCIResult($OCIParse,$iyk);

		if ($save_tgl_re == ""){ $save_tgl_re = $row[tgl_daftar]; };
		if ($save_nom == ""){ $save_nom   = removeSlash($row[nama_plg]); };
		if ($save_jalan == ""){ $save_jalan = removeSlash($row[alamat]); };
		$save_nd = $row[nd];
		$save_nd_speedy = $row[nd_speedy];
		$save_nd_contact = $row[nd_contact];

		if ($colom_name == "etat"){ 
			//$row[etat] = $arr_etat[$row[etat]];
			$this_datel = $datel;
			$this_area  = $area;
			$this_mdf   = $mdf;
			$this_ndem  = $ndem;
			include("p_etat.php");	//return $ps_status
			$row[etat] = $ps_status2;
		};//if

		if ($row[kcontact] <> ""){ $row[kcontact] = wordwrap($row[kcontact], 40, "<br>", 1); };
		if ($iyk%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
		$fontColor = "<font size='1'>";
		$htmlData .= "
		  <tr bgcolor='$color'>
			<td width='100%'>
			<table width='370' cellspacing='0' cellpadding='0'>
			  <tr>
				  <td width='100' align='right' nowrap><font size='1'>".strtoupper($colom_name)."</td>
				  <td width='20' align='center' nowrap>:</td>
				  <td width='250'align='left'><font size='1' color='#000099'>".$row[$colom_name]."</td>
			  </tr>
			</table>
			</td>
		  </tr>\n";
	};//for
	$detail_informasi = 1;
};//end-while

//detail informasi pelanggan H_DEMAND_SPEEDY_ALL_NEW
if ($detail_informasi == ""){
	unset($ccc, $row);
	$runSQL = "select $sqlField rk, nd nd_telp, nd_speedy, nd_contact, agency, chanel, paket, etat from H_DEMAND_SPEEDY_ALL_NEW where ndem='$ndem' and datel='$datel' and area='$area' and mdf='$mdf'";
	$OCIParse = OCIParse($connUP2, $runSQL);
	OCIExecute($OCIParse, OCI_DEFAULT);
	while (OCIFetch($OCIParse)){
		for ($iyk=1;  $iyk<=OCINumCols($OCIParse);  $iyk++) {
			$colom_name = strtolower(OCIColumnName($OCIParse,$iyk));
			$row[$colom_name] = OCIResult($OCIParse,$iyk);

			if ($save_tgl_re == ""){ $save_tgl_re = $row[tgl_daftar]; };
			if ($save_nom == ""){ $save_nom   = removeSlash($row[nama_plg]); };
			if ($save_jalan == ""){ $save_jalan = removeSlash($row[alamat]); };
			if ($save_nd == ""){ $save_nd = $row[nd]; };
			if ($save_nd_speedy == ""){ $save_nd_speedy = $row[nd_speedy]; };
			if ($save_nd_contact == ""){ $save_nd_contact = $row[nd_contact]; };
			
			if ($colom_name == "etat"){ 
				//$row[etat] = $arr_etat[$row[etat]];
				$this_datel = $datel;
				$this_area  = $area;
				$this_mdf   = $mdf;
				$this_ndem  = $ndem;
				include("p_etat.php");	//return $ps_status
				$row[etat] = $ps_status2;
			};//if

			if ($row[kcontact] <> ""){ $row[kcontact] = wordwrap($row[kcontact], 40, "<br>", 1); };
			if ($iyk%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
			$fontColor = "<font size='1'>";
			$htmlData .= "
			  <tr bgcolor='$color'>
				<td width='100%'>
				<table width='370' cellspacing='0' cellpadding='0'>
				  <tr>
					  <td width='100' align='right' nowrap><font size='1'>".strtoupper($colom_name)."</td>
					  <td width='20' align='center' nowrap>:</td>
					  <td width='250'align='left'><font size='1' color='#000099'>".$row[$colom_name]."</td>
				  </tr>
				</table>
				</td>
			  </tr>\n";
		};//for
		$detail_informasi = 1;
	};//end-while
};//if

//detail informasi pelanggan DEMAND_FE_ALL
if ($detail_informasi == ""){
	unset($ccc, $row);
	$runSQL = "select nd nd_telp, nd_speedy, nd_contact, etat from DEMAND_FE_ALL where ndem='$ndem' and datel='$datel' and area='$area' and mdf='$mdf'";
	$OCIParse = OCIParse($conn, $runSQL);
	OCIExecute($OCIParse, OCI_DEFAULT);
	while (OCIFetch($OCIParse)){
		for ($iyk=1;  $iyk<=OCINumCols($OCIParse);  $iyk++) {
			$colom_name = strtolower(OCIColumnName($OCIParse,$iyk));
			$row[$colom_name] = OCIResult($OCIParse,$iyk);
			
			if ($colom_name == "etat"){ 
				//$row[etat] = $arr_etat[$row[etat]];
				$this_datel = $datel;
				$this_area  = $area;
				$this_mdf   = $mdf;
				$this_ndem  = $ndem;
				include("p_etat.php");	//return $ps_status
				$row[etat] = $ps_status2;
			};//if

			if ($row[kcontact] <> ""){ $row[kcontact] = wordwrap($row[kcontact], 40, "<br>", 1); };
			if ($iyk%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
			$fontColor = "<font size='1'>";
			$htmlData .= "
			  <tr bgcolor='$color'>
				<td width='100%'>
				<table width='370' cellspacing='0' cellpadding='0'>
				  <tr>
					  <td width='100' align='right' nowrap><font size='1'>".strtoupper($colom_name)."</td>
					  <td width='20' align='center' nowrap>:</td>
					  <td width='250'align='left'><font size='1' color='#000099'>".$row[$colom_name]."</td>
				  </tr>
				</table>
				</td>
			  </tr>\n";
		};//for
	};//end-while
};//if


//submit data hasilcall
if (strlen($run) > 1){ 
	$ok = 1;
	$terpakai = 0;
	if ($setter <> ""){ 
		$split = explode(":", $setter);
		$id_setter = $split[0];
		$id_waktu  = $split[1];
	};//if
	
	if (($id_setter <> "")and($id_waktu <> "")){
		$runSQL = "select count(*) terpakai from DCS_HASILCALL where id_setter=$id_setter and id_waktu=$id_waktu and to_char(tgl_janji,'MM/DD/YYYY')='$tanggal'";
		$OCIParse = OCIParse($conn, $runSQL);
		OCIExecute($OCIParse, OCI_DEFAULT);
		if (OCIFetch($OCIParse)){ $terpakai = OCIResult($OCIParse,1); };
	};//if
	
	if ((($flexi_hp*1) < 111111111) or (($flexi_hp*1) > 99999999999) or (substr($flexi_hp,0,1)<>"0")){ $iflexi_hp = "<br><font color='#FF0000' size='1'><i>* Flexi/HP tidak valid"; $ok=0; }
	if (strlen($nama_cp) < 4){ $inama_cp = "<br><font color='#FF0000' size='1'><i>* Nama Kontak tidak valid"; $ok=0; }
	if (($ndem=="")or($datel=="")or($area=="")or($mdf=="")){ $iparameter = "<br><font color='#FF0000' size='1'><i>* Kode Parameter tidak valid"; $ok=0; }

	if ($id_call == ""){ $iid_call = "<br><font color='#FF0000' size='1'><i>* Hasil Call tidak valid"; $ok=0; }
	if ($id_call == 1){
		if ($terpakai > 0){ $isetter = "<br><font color='#FF0000' size='1'><i>* Jadwal Setter telah terpakai"; $ok=0; }
		if (($id_setter == "")or($id_waktu == "")){ $isetter = "<br><font color='#FF0000'><i>* Jadwal Setter belum dipilih"; $ok=0; }
	};//if

	//ok-simpan-data-valid
	if ($ok == 1){
		$registerInvalid = 1;
		if ($ncli == ""){ $ncli="NULL";}
		if ($ndos == ""){ $ndos="NULL";}
		//if ($save_nd == ""){ $save_nd = "NULL"; }
		//if ($save_nd_speedy == ""){ $save_nd_speedy = "NULL"; }
		//if ($save_nd_contact == ""){ $save_nd_contact = "NULL"; }

		unset($info_plg);
		if ($save_nd <> "")       { if($info_plg==""){ $info_plg.=$save_nd; }else { $info_plg.="/".$save_nd; }; };
		if ($save_nd_speedy <> ""){ if($info_plg==""){ $info_plg.=$save_nd_speedy; }else { $info_plg.="/".$save_nd_speedy; }; };
		if ($info_plg <> ""){ $info_plg .= "\n"; };
		$info_plg .= substr($save_nom,0,25) ."\n";
		$info_plg .= substr($save_jalan,0,25);
		$nama_cp = strtoupper($nama_cp);
		if ($SAH[id_user] == ""){ $SAH[id_user]=0; };
		$jmlcall = $jmlcall + 1;

		if ($id_call == 1){
			//OK-JANJI APPOINTMENT

			$runSQL2 = "select mulai, sampai from DCS_P_WAKTU where id_waktu=$id_waktu";
			$OCIParse2 = OCIParse($conn, $runSQL2);
			OCIExecute($OCIParse2, OCI_DEFAULT);
			if (OCIFetch($OCIParse2)){ 
				$mulai = OCIResult($OCIParse2,1);
				$sampai = OCIResult($OCIParse2,2);
			};//if

			$runSQL2 = "select nama_setter, telp_setter from DCS_SETTER where id_setter=$id_setter";
			$OCIParse2 = OCIParse($conn, $runSQL2);
			OCIExecute($OCIParse2, OCI_DEFAULT);
			if (OCIFetch($OCIParse2)){ 
				$nama_setter = strtoupper(OCIResult($OCIParse2,1));
				$telp_setter = OCIResult($OCIParse2,2);
			};//if

			if ($modem == ""){ $modem = "CDMA1"; };
			if ($tanggal <> ""){
				$tmp = explode("/",$tanggal);
				$tgl = $tmp[1];   $bln = $tmp[0];  	$thn = $tmp[2];
			};//if
			$namahari = getDay($tgl, $bln, $thn);

			//kirim sms ke pelanggan hasilcall
			$pesan_pelanggan = "Yth.Plg Telkom,\n\nKonfirm jadwal setting speedy $namahari, $tgl/$bln/$thn pk.$mulai-$sampai\nPetugas $nama_setter/$telp_setter.\n\nTerimkasih.";
			$pesan_pelanggan = substr($pesan_pelanggan, 0, 160);
			$id_sms = sendSMS($flexi_hp, $pesan_pelanggan, 0, $SAH[username], $modem);
			$id_outbox_plg = saveOUTBOX($flexi_hp, $pesan_pelanggan, 0, $SAH[username], $modem, $id_sms);
			if ($id_outbox_plg == ""){ $id_outbox_plg=0; }
			
			//kirim sms ke petugas setter
			$pesan_setter = "REQ-SETTER NOMOR: $mdf-$ndem,\n$namahari, $tgl/$bln/$thn Pk.$mulai-$sampai\n\n$info_plg.\n$area#$mdf\n\nCP:$nama_cp/$flexi_hp\nTerimkasih.";
			$pesan_setter = substr($pesan_setter, 0, 160);
			$id_sms = sendSMS($telp_setter, $pesan_setter, 0, $SAH[username], $modem);
			$id_outbox_str = saveOUTBOX($telp_setter, $pesan_setter, 0, $SAH[username], $modem, $id_sms);
			if ($id_outbox_str == ""){ $id_outbox_str=0; }

			//kirim sms ke mdf petugas rwom
			$pesan_rwom = "REQ-RWOM NOMOR: $mdf-$ndem,\n$namahari, $tgl/$bln/$thn Pk.$mulai-$sampai\n\n$info_plg.\n$area#$mdf\n\nSetter:$nama_setter/$telp_setter\nTerimkasih.";
			$pesan_rwom = substr($pesan_rwom, 0, 160);
			$runSQL2 = "select nama_petugas, telp_petugas from DCS_RWOM where datel='$datel' and area='$area' and mdf='$mdf'";
			$OCIParse2 = OCIParse($conn, $runSQL2);
			OCIExecute($OCIParse2, OCI_DEFAULT);
			if (OCIFetch($OCIParse2)){ 
				$nama_petugas = OCIResult($OCIParse2,1);
				$telp_petugas = OCIResult($OCIParse2,2);
				$id_sms = sendSMS($telp_petugas, $pesan_rwom, 0, $SAH[username], $modem);
			  $id_outbox_mdf = saveOUTBOX($telp_petugas, $pesan_rwom, 0, $SAH[username], $modem, $id_sms);
			};//if
			if ($id_outbox_mdf == ""){ $id_outbox_mdf=0; }

			$runSQL = "insert into DCS_HASILCALL (ndem, datel, area, mdf, tgl_re, nd, nd_speedy, nd_contact, nom, jalan, tgl_call, id_call, keterangan, nama_cp, flexi_hp, id_outbox_plg, tgl_janji, id_setter, id_waktu, id_outbox_str, id_outbox_mdf, tgl_realisasi, id_inbox_str, status, id_user, ip_address, call_count) VALUES ($ndem, '$datel', '$area', '$mdf', to_date('$save_tgl_re','DD-MON-YYYY HH24:MI:SS'), '$save_nd', '$save_nd_speedy', '$save_nd_contact', '$save_nom', '$save_jalan', sysdate, $id_call, '$keterangan', '$nama_cp', '$flexi_hp', $id_outbox_plg, to_date('$tanggal','MM/DD/YYYY'), $id_setter, $id_waktu, $id_outbox_str, $id_outbox_mdf, NULL, NULL, 'APPOINTMENT', $SAH[id_user], '$REMOTE_ADDR', '$jmlcall')";
		} else {
			$runSQL = "insert into DCS_HASILCALL (ndem, datel, area, mdf, tgl_re, nd, nd_speedy, nd_contact, nom, jalan, tgl_call, id_call, keterangan, nama_cp, flexi_hp, id_outbox_plg, tgl_janji, id_setter, id_waktu, id_outbox_str, tgl_realisasi, id_inbox_str, status, id_user, ip_address, call_count) VALUES ($ndem, '$datel', '$area', '$mdf', to_date('$save_tgl_re','DD-MON-YYYY HH24:MI:SS'), '$save_nd', '$save_nd_speedy', '$save_nd_contact', '$save_nom', '$save_jalan', sysdate, $id_call, '$keterangan', '$nama_cp', '$flexi_hp', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'PENDING', $SAH[id_user], '$REMOTE_ADDR', '$jmlcall')";
		};//if-id_call

		
		//-- awal split data --//
			$runSPLT = "insert into DCS_STEPCALL select * from DCS_HASILCALL where ndem='$ndem' and datel='$datel' and area='$area' and mdf='$mdf'";
			$OCIParseInsert = OCIParse($conn, $runSPLT);
			OCIExecute($OCIParseInsert, OCI_DEFAULT);
			OCIFreeStatement($OCIParseInsert);
			
			$runSPLT = "delete from DCS_HASILCALL where ndem='$ndem' and datel='$datel' and area='$area' and mdf='$mdf'";
			$OCIParseDelete = OCIParse($conn, $runSPLT);
			OCIExecute($OCIParseDelete, OCI_DEFAULT);
			OCIFreeStatement($OCIParseDelete);
		//-- akhir split data --//
		
		//simpan data hasilcall
		$OCIParseInsert = OCIParse($conn, $runSQL);
		OCIExecute($OCIParseInsert, OCI_DEFAULT);
		OCIFreeStatement($OCIParseInsert);

		//BACKUP DATA HASILCALL = $connUP2
		$OCIParseInsert = @OCIParse($connUP2, $runSQL);
		@OCIExecute($OCIParseInsert, OCI_DEFAULT);
		@OCIFreeStatement($OCIParseInsert);

		//release lock-call ndem
		$runSQL = "delete from DCS_FLAGCALL where ndem='$ndem' and datel='$datel' and area='$area'";
		$OCIParseDelete = OCIParse($conn, $runSQL);
		OCIExecute($OCIParseDelete, OCI_DEFAULT);
		OCIFreeStatement($OCIParseDelete);
	};//if-ok-hasilcall
};//end-if-submit

//cek jk pernah hasilcall
unset($ccc, $row);
$runSQL = "
select count(*) jmlcall, to_char(max(tgl_call),'DD-MON-YYYY HH24:MI:SS') LAST_CALL 
from (
  select ndem, datel, area, mdf, tgl_call
  from DCS_HASILCALL where ndem='$ndem' and datel='$datel' and area='$area' and mdf='$mdf'
  union
  select ndem, datel, area, mdf, tgl_call
  from DCS_STEPCALL where ndem='$ndem' and datel='$datel' and area='$area' and mdf='$mdf'
)";

$OCIParse = OCIParse($conn, $runSQL);
OCIExecute($OCIParse, OCI_DEFAULT);
if (OCIFetch($OCIParse)){
	$jmlcall = OCIResult($OCIParse,1);
	$last_call = OCIResult($OCIParse,2);
};//end-if
if ($jmlcall >= 1){
	$htmlPernahCall = "
	 <table width='370' cellspacing='1' cellpadding='3'>
	  <tr bgcolor='#ABBDE9'><td width='100%' height='20' align='center'><b>Pernah Call</b></td></tr>
	  <tr bgcolor='#EBEFFA'>
		 <td width='100%' align='center'>
		 <font size='1' color='#006600'>Pelanggan pernah dihubungi <a href='?menu=$menu&uid=$uid&page=speedy_call_result&ndem=$ndem&datel=$datel&area=$area&mdf=$mdf'><b>$jmlcall</b></a> kali,<br>terakhir pada tanggal $last_call.
		 </td>
	  </tr>
	 </table>";
};//end-if

if ($id_call == ""){ $cek="selected"; };
$select_call .= "<option value='' $cek>-- PILIH --</option>\n";
$runSQL = "select id_call, info_call from DCS_P_CALL";
$OCIParse = OCIParse($conn, $runSQL);
OCIExecute($OCIParse, OCI_DEFAULT);
while (OCIFetch($OCIParse)){
	for ($iyk=1;  $iyk<=OCINumCols($OCIParse);  $iyk++) {
		$colom_name = strtolower(OCIColumnName($OCIParse,$iyk));
		$row[$colom_name] = OCIResult($OCIParse,$iyk);
	};//for
	if ($id_call==$row[id_call]) { $cek="selected"; $id_call=$row[id_call]; }else{ unset($cek); }
	$select_call .= "<option value='$row[id_call]' $cek>$row[info_call]</option>\n"; 
};//while
$select_call = "<select size=1 name='id_call'> $select_call </select>";

$sekarang = date("YmdHis");
if ($tanggal == ""){ $tanggal = "$bln/$tgl/$thn"; };
if ($tanggal <> ""){
	$tmp = explode("/",$tanggal);
	$pilihtgl = $tmp[2].$tmp[0].$tmp[1];
};//if

unset($ccc, $row);
$runSQL = "select a.id_setter, a.nama_setter, a.telp_setter, a.id_waktu, nvl(b.jml_app,0) jumlah from
( select id_setter, nama_setter, telp_setter, id_waktu from DCS_SETTER 
  where datel='$datel' and area='$area' and mdf like '%$mdf%' and active='1') a,
( select id_setter, count(*) jml_app from DCS_HASILCALL 
  where to_char(tgl_janji,'YYYY/MM')=to_char(sysdate,'YYYY/MM') and datel='$datel' and area='$area'
  group by id_setter ) b
where a.id_setter=b.id_setter(+)
order by jumlah asc, a.id_setter";

//echo "<pre>$runSQL</pre>";
$OCIParse = OCIParse($conn, $runSQL);
OCIExecute($OCIParse, OCI_DEFAULT);
while (OCIFetch($OCIParse)){
	for ($iyk=1;  $iyk<=OCINumCols($OCIParse);  $iyk++) {
		$colom_name = strtolower(OCIColumnName($OCIParse,$iyk));
		$row[$colom_name] = OCIResult($OCIParse,$iyk);
	};//for

	$arr_jadwal_waktu=array();
	if ($row[id_waktu] <> ""){ $arr_jadwal_waktu = explode(";", $row[id_waktu]); }
	if ($i%2 > 0){ $color="#EBEFFA"; $class="inputfree"; }else{ $color="#D7E0F4"; $class="inputfree2";}; $i++;

	$arr_waktu = array();
	unset($row2);
	$runSQL2 = "select tgl_janji, id_setter, id_waktu from DCS_HASILCALL where id_setter=$row[id_setter] and to_char(tgl_janji,'MM/DD/YYYY')='$tanggal'";
	$OCIParse2 = OCIParse($conn, $runSQL2);
	OCIExecute($OCIParse2, OCI_DEFAULT);
	while (OCIFetch($OCIParse2)){
		for ($iyk=1;  $iyk<=OCINumCols($OCIParse2);  $iyk++) {
			$colom_name2 = strtolower(OCIColumnName($OCIParse2,$iyk));
			$row2[$colom_name2] = OCIResult($OCIParse2,$iyk);
		};//for
		array_push($arr_waktu, $row2[id_waktu]);
	};//end-while

	unset($arr_tgl_off, $tgl_off, $tmp, $selbulan, $seltanggal);
	if ($tanggal <> ""){ $tmp = explode("/", $tanggal); $selbulan=$tmp[0].$tmp[2]; $seltanggal=$tmp[1]; }

	$arr_tgl_off = array();
	$runSQL2 = "select tgl_off from DCS_KALENDER where id_setter=$row[id_setter] and to_char(thn_bln,'MMYYYY')='$selbulan'";
	$OCIParse2 = OCIParse($conn, $runSQL2);
	OCIExecute($OCIParse2, OCI_DEFAULT);
	while (OCIFetch($OCIParse2)){
		for ($iyk=1;  $iyk<=OCINumCols($OCIParse2);  $iyk++) {
			$colom_name2 = strtolower(OCIColumnName($OCIParse2,$iyk));
			$row2[$colom_name2] = OCIResult($OCIParse2,$iyk);
		};//for
		$tgl_off   = $row2[tgl_off];
	};//while
	if ($tgl_off <> ""){ $arr_tgl_off = explode(";", $tgl_off); }

	unset($htmlJadwal, $row2);
	$runSQL2 = "select id_waktu, mulai, sampai from DCS_P_WAKTU";
	$OCIParse2 = OCIParse($conn, $runSQL2);
	OCIExecute($OCIParse2, OCI_DEFAULT);
	while (OCIFetch($OCIParse2)){
		for ($iyk=1;  $iyk<=OCINumCols($OCIParse2);  $iyk++) {
			$colom_name2 = strtolower(OCIColumnName($OCIParse2,$iyk));
			$row2[$colom_name2] = OCIResult($OCIParse2,$iyk);
		};//for
		
		$sampaijam = $row2[sampai] - 2;
		if ($sampaijam <= 9){ $sampaijam = "0".$sampaijam; };
		$thistanggal = $pilihtgl.$sampaijam."0000";

		$this_setter = "$row[id_setter]:$row2[id_waktu]";
		if ($setter == $this_setter){ $checked="checked"; }else{ unset($checked); }

		if (in_array($row2[id_waktu], $arr_waktu)){
			$htmlJadwal .= "<td width='14%' align='center'><font size='1' color='#0000FF'>x<br>$row2[mulai]-$row2[sampai]</td>\n";
		} else {
			if (in_array($row2[id_waktu], $arr_jadwal_waktu)){
				if ($thistanggal >= $sekarang){ 
					if (in_array($seltanggal, $arr_tgl_off)){
						$htmlJadwal .= "<td width='14%' align='center'><font size='1' color='#FFFFFF'>~<br>$row2[mulai]-$row2[sampai]</td>\n";
					} else {
						$htmlInput = "<input type='radio' name='setter' value='$this_setter' $checked class='$class'>"; 
						$htmlJadwal .= "<td width='14%' align='center'><font size='1'>$htmlInput<br>$row2[mulai]-$row2[sampai]</td>\n";
					};//if
				}else{
					$htmlJadwal .= "<td width='14%' align='center'><font size='1' color='#FF0000'>o<br>$row2[mulai]-$row2[sampai]</td>\n";
			};//if
			} else {
				$htmlJadwal .= "<td width='14%' align='center'><font size='1' color='#8C8C8C'>-<br>$row2[mulai]-$row2[sampai]</td>\n";
			};//if
		};//if
	};//end-while

	$len = strpos($row[nama_setter], "-");
	if ($len <> ""){ $row[nama_setter] = substr($row[nama_setter],0,$len); }
	else { $row[nama_setter] = substr($row[nama_setter],0,15); }

	$htmlSetter .= "
	<tr bgcolor='$color'>
		<td width='100%' align='center'>
		 <table width='370' cellspacing='0' cellpadding='0'>
		  <tr>
			  <td width='25%' align='right' nowrap><font size='1'>$row[nama_setter]<br><i><font color='#4FA27E'>$row[telp_setter]-$row[jumlah]</td>
			  <td width='5%' align='center' nowrap>:</td>
			  $htmlJadwal
		  </tr>
		 </table>
		</td>
	</tr>\n";
};//end-while

if ($htmlSetter == ""){ $htmlSetter="<tr><td>Tidak ada petugas setter speedy di <a href='?menu=$menu&uid=$uid&page=speedy_psetter&datel=$datel&area=$area&mdf=$mdf'>$area-$mdf</a></td></tr>"; }
$htmlSetter = "<table width='370' cellspacing='1' cellpadding='3'>$htmlSetter</table>";

?>
<p>&nbsp;</p>
<form name='a' method='POST' action="<?="?menu=$menu&uid=$uid&page=$page";?>">
<table border="0" width="800" cellspacing="0" cellpadding="0" align="center">
  <tr>
   <td width="100%" align="center" vAlign="top">
	<table width="100%" border="0" cellpadding="3" cellspacing="0">
	  <tr><td width="100%" colspan="3" align="center"><font size="3"><b>Call Pelanggan</td></tr>
     <tr><td width="100%" colspan="3"><hr size="1" color="#9BB4E6"></td></tr>
     <tr>
       <td width="50%" align="center" vAlign="top">
			 <table width='370' cellspacing='1' cellpadding='3'>
			 <?=$htmlData;?>
			 </table>
			 <br><br>
			 <?=$htmlPernahCall;?>
		 </td>
       <td>&nbsp;</td>
       <td width="50%" align="center" vAlign="top">

			<? if ($registerInvalid <> 1){ ?>

			 <table width='370' cellspacing='1' cellpadding='3'>
			  <tr bgcolor='#ABBDE9'><td width="100%" height='20' align="center"><b>Hasil Call</b></td></tr>
			  <tr bgcolor='#EBEFFA'>
				 <td width="100%" align="center">
					 <table width='370' cellspacing='0' cellpadding='0'>
					  <tr>
						  <td width='25%' align='right' nowrap><font size='1'>Hasil Call</td>
						  <td width='5%' align='center' nowrap>:</td>
						  <td width='70%'align='left'><?=$select_call;?><?=$iid_call;?></td>
					  </tr>
					 </table>
				 </td>
			  </tr>
			  <tr bgcolor='#D7E0F4'>
				 <td width="100%" align="center">
					 <table width='370' cellspacing='0' cellpadding='0'>
					  <tr>
						  <td width='25%' align='right' nowrap><font size='1'>Nama Kontak</td>
						  <td width='5%' align='center' nowrap>:</td>
						  <td width='70%'align='left'><input type="text" name="nama_cp" value="<?=htmlentities(stripslashes($nama_cp));?>" size="20"><?=$inama_cp;?></td>
					  </tr>
					 </table>
				 </td>
			  </tr>
			  <tr bgcolor='#EBEFFA'>
				 <td width="100%" align="center">
					 <table width='370' cellspacing='0' cellpadding='0'>
					  <tr>
						  <td width='25%' align='right' nowrap><font size='1'>Nomor Flexi/HP</td>
						  <td width='5%' align='center' nowrap>:</td>
						  <td width='70%'align='left'><input type="text" name="flexi_hp" value="<?=htmlentities(stripslashes($flexi_hp));?>" size="15"> <font size='1' color='#444444'><i>*) SMS konfirm pelanngan<?=$iflexi_hp;?></td>
					  </tr>
					 </table>
				 </td>
			  </tr>
			  <tr bgcolor='#D7E0F4'>
				 <td width="100%" align="center">
					 <table width='370' cellspacing='0' cellpadding='0'>
					  <tr>
						  <td width='25%' align='right' nowrap><font size='1'>Keterangan</td>
						  <td width='5%' align='center' nowrap>:</td>
						  <td width='70%'align='left'><input type="text" name="keterangan" value="<?=htmlentities(stripslashes($keterangan));?>" size="40"><?=$iketerangan;?></td>
					  </tr>
					 </table>
				 </td>
			  </tr>
			 </table>
			 <br>
			 <table width='370' cellspacing='1' cellpadding='3'>
			  <tr bgcolor='#ABBDE9'><td width="100%" height='20' align="center"><b>Janji Petugas Setting</b></td></tr>
			  <tr bgcolor='#EBEFFA'>
				 <td width="100%" align="center">
					 <table width='370' cellspacing='0' cellpadding='0'>
					  <tr>
						  <td width='25%' align='right' nowrap><font size='1'>Jadwal</td>
						  <td width='5%' align='center' nowrap>:</td>
						  <td width='70%'align='left'>
							<input type="text" name="tanggal" size="10" value="<?=$tanggal;?>">
							<script language="JavaScript" src="calendar_us.js"></script>
							<script language="JavaScript">
							new tcal ({
								'formname': 'a',
								'controlname': 'tanggal'
							});
							</script>
							<a href="#" onclick="runPilihan('jadwal', a.tanggal.value)" title="refresh jadwal setter"><img border="0" src="img/refresh.png"></a>
					  </tr>
					 </table>
				 </td>
			  </tr>
			 </table>
			 <font id="jadwal"> <?=$htmlSetter;?> </font>
			 <?=$isetter;?><br>

			 <? if ($lockcall == 0) {?>
			 <? if ($last_status == "APPOINTMENT"){ ?>
				 <table width='300' border='1' cellpadding='5' cellspacing='5' style='border-collapse:collapse' bordercolor='#FF0000'>
					<tr bgcolor='#FFFF33'>
						<td width='100%' align='center'>
						<font color='#FF0000'><b>Maaf Sdr. <?=$SAH[fullname];?></b>,<br>
						Status terakhir APPOINTMENT tidak dapat dilakukan Call sebelum tiket di Close.
						</font>
						</td>
					</tr>
				 </table>
			 <? } else if (($SAH[id_group] == 3)or($SAH[id_group] == 1)) { ?>
				 <input type='hidden' name='datel' value='<?=$datel?>'>
				 <input type='hidden' name='area' value='<?=$area?>'>
				 <input type='hidden' name='mdf' value='<?=$mdf?>'>
				 <input type='hidden' name='ndem' value='<?=$ndem?>'>
				 <input type='hidden' name='jmlcall' value='<?=$jmlcall?>'>
				 <br><input type='submit' value=' Simpan ' name='run' class='button'>
			 <? }else{ ?>
				 <table width='300' border='1' cellpadding='5' cellspacing='5' style='border-collapse:collapse' bordercolor='#FF0000'>
					<tr bgcolor='#FFFF33'>
						<td width='100%' align='center'>
						<font color='#FF0000'><b>Maaf Sdr. <?=$SAH[fullname];?></b>,<br>
						Hanya Petugas SSC yang dapat melakukan Call.
						</font>
						</td>
					</tr>
				 </table>
			 <? }; ?>
			 <? }else{ ?>
				 <table width='355' border='1' cellpadding='5' cellspacing='5' style='border-collapse:collapse' bordercolor='#FF0000'>
					<tr bgcolor='#FFFF33'>
						<td width='100%' align='center'>
				    <font color='#FF0000'><b>Maaf Sdr. <?=$SAH[fullname];?></b>,<br>
						Data sedang dicall oleh <?="<i>$lock_fullname</i> di <i>$lock_ip_address</i> pada <i>$lock_tgl_flag</i>";?>, silakan call record selanjutnya.<br>Sistem lock automatic reset 20 menit...
				    <br><br>
		        [ <?="<a href='?menu=$menu&uid=$uid&page=speedy_fe1&datel=$datel&area=$area&mdf=$mdf'>";?><b>Lihat Data Call<b></a> ]
						</font>
						</td>
					</tr>
				 </table>
			 <? }; ?>

			<? } else { ?>

			 <table width='370' cellspacing='1' cellpadding='3'>
			  <tr bgcolor='#ABBDE9'><td width='100%' height='20' align='center'><b>Save Success</b></td></tr>
			  <tr bgcolor='#EBEFFA'>
				 <td width='100%' align='center'>
				 <font size='1' color='#006600'>Data Call telah disimpan oleh <b><?=$SAH[fullname];?></b> (<?=$SAH[username];?>).
				 </td>
			  </tr>
			 </table>
			 <br>

			<?
			//hasilcall DCS_HASILCALL
			unset($ccc, $row);
			$htmlCall = "<tr bgcolor='#ABBDE9'><td width='100%' height='20' align='center'><b>Data Hasil Call</b></td></tr>";
			//$runSQL = "select to_char(tgl_call,'DD-MON-YYYY HH24:MI:SS') TANGGAL_CALL, id_call, nd ND_TELP, nd_speedy, nd_contact, nom, jalan, nama_cp, flexi_hp, keterangan KETERANGAN_CP, tgl_janji, id_waktu, id_setter, id_outbox_plg, id_outbox_str, id_outbox_mdf, id_inbox_str, to_char(tgl_realisasi,'DD-MON-YYYY HH24:MI:SS') tgl_realisasi, id_hasilset, id_pktmodem, merk_modem, sn_modem, hasilsetting, status, id_user, id_user_close from DCS_HASILCALL where ndem='$ndem' and datel='$datel' and area='$area' and mdf='$mdf' order by tgl_call desc";

			$runSQL = "
			select * from (
			select tgl_call, to_char(tgl_call,'DD-MON-YYYY HH24:MI:SS') TANGGAL_CALL, id_call, nd ND_TELP, nd_speedy, nd_contact, nom, jalan,
			  nama_cp, flexi_hp, keterangan KETERANGAN_CP, tgl_janji, id_waktu, id_setter, id_outbox_plg, id_outbox_str, id_outbox_mdf,
			  id_inbox_str, to_char(tgl_realisasi,'DD-MON-YYYY HH24:MI:SS') tgl_realisasi, id_hasilset, id_pktmodem,
			  merk_modem, sn_modem, hasilsetting, status, id_user, id_user_close 
			from DCS_HASILCALL where ndem='$ndem' and datel='$datel' and area='$area' and mdf='$mdf'
			union
			select tgl_call, to_char(tgl_call,'DD-MON-YYYY HH24:MI:SS') TANGGAL_CALL, id_call, nd ND_TELP, nd_speedy, nd_contact, nom, jalan,
			  nama_cp, flexi_hp, keterangan KETERANGAN_CP, tgl_janji, id_waktu, id_setter, id_outbox_plg, id_outbox_str, id_outbox_mdf,
			  id_inbox_str, to_char(tgl_realisasi,'DD-MON-YYYY HH24:MI:SS') tgl_realisasi, id_hasilset, id_pktmodem,
			  merk_modem, sn_modem, hasilsetting, status, id_user, id_user_close 
			from DCS_STEPCALL where ndem='$ndem' and datel='$datel' and area='$area' and mdf='$mdf'
			) order by tgl_call desc
			";

			//echo "<pre>$runSQL</pre>";
			unset($row);  $ccc = 0;
			$OCIParse = OCIParse($conn, $runSQL);
			OCIExecute($OCIParse, OCI_DEFAULT);
			while (OCIFetch($OCIParse)){
				for ($iyk=1;  $iyk<=OCINumCols($OCIParse);  $iyk++) {
					$colom_name = strtolower(OCIColumnName($OCIParse,$iyk));
					$row[$colom_name] = OCIResult($OCIParse,$iyk);
					unset($link1, $phone);

					if ($colom_name == "tgl_call"){ unset($colom_name); }
					if (($colom_name == "id_user") and ($row[$colom_name] <> "")){
						$runSQL2 = "select username, fullname from DCS_SYSUSERNAME where id_user=$row[id_user]";
						$OCIParse2 = OCIParse($conn, $runSQL2);
						OCIExecute($OCIParse2, OCI_DEFAULT);
						if (OCIFetch($OCIParse2)){ 
							$colom_name = "petugas_call";
							$row[$colom_name] = OCIResult($OCIParse2,2)." (".OCIResult($OCIParse2,1).")";
						};//if
					};//if-id_user

					if (($colom_name == "id_user_close") and ($row[$colom_name] <> "")){
						$runSQL2 = "select username, fullname from DCS_SYSUSERNAME where id_user=$row[id_user_close]";
						$OCIParse2 = OCIParse($conn, $runSQL2);
						OCIExecute($OCIParse2, OCI_DEFAULT);
						if (OCIFetch($OCIParse2)){ 
							$colom_name = "petugas_close";
							$row[$colom_name] = OCIResult($OCIParse2,2)." (".OCIResult($OCIParse2,1).")";
						};//if
					};//if-id_user
					
					if (($colom_name == "id_call") and ($row[$colom_name] <> "")){
						$runSQL2 = "select info_call from DCS_P_CALL where id_call=$row[id_call]";
						$OCIParse2 = OCIParse($conn, $runSQL2);
						OCIExecute($OCIParse2, OCI_DEFAULT);
						if (OCIFetch($OCIParse2)){ 
							$colom_name = "hasil_call";
							$row[$colom_name] = OCIResult($OCIParse2,1);
						};//if
					};//if-id_call
					
					if (($colom_name == "id_waktu") and ($row[$colom_name] <> "")){
						$runSQL2 = "select mulai, sampai from DCS_P_WAKTU where id_waktu=$row[id_waktu]";
						$OCIParse2 = OCIParse($conn, $runSQL2);
						OCIExecute($OCIParse2, OCI_DEFAULT);
						if (OCIFetch($OCIParse2)){ 
							$colom_name = "waktu";
							$row[$colom_name] = "Pukul ".OCIResult($OCIParse2,1).":00 s/d ".OCIResult($OCIParse2,2).":00";
						};//if
					};//if-id_waktu
					
					if (($colom_name == "id_setter") and ($row[$colom_name] <> "")){
						$runSQL2 = "select nama_setter, telp_setter from DCS_SETTER where id_setter=$row[id_setter]";
						$OCIParse2 = OCIParse($conn, $runSQL2);
						OCIExecute($OCIParse2, OCI_DEFAULT);
						if (OCIFetch($OCIParse2)){ 
							$colom_name = "nama_setter";
							$row[$colom_name] = OCIResult($OCIParse2,1)." (".OCIResult($OCIParse2,2).")";
						};//if
					};//if-id_setter

					if ($colom_name == "id_outbox_plg"){
						if ($row[$colom_name] > 0){
							$runSQL2 = "select phone, message, mess_send from SMS_OUTBOX where id=$row[id_outbox_plg]";
							$OCIParse2 = OCIParse($conn, $runSQL2);
							OCIExecute($OCIParse2, OCI_DEFAULT);
							if (OCIFetch($OCIParse2)){ 
								$colom_name = "sms_pelanggan";
								$row[$colom_name] = nl2br(OCIResult($OCIParse2,2));
								$phone = OCIResult($OCIParse2,1);
								$link1 = "<br><a href='?menu=$menu&uid=$uid&page=sms_kirim&telepon=$phone'><font color='#006600'>New SMS</font></a>";
							};//if
						}else{ $row[$colom_name] = ""; };
					};//if-id_outbox_plg

					if ($colom_name == "id_outbox_str"){
						if ($row[$colom_name] > 0){
							$runSQL2 = "select phone, message, mess_send from SMS_OUTBOX where id=$row[id_outbox_str]";
							$OCIParse2 = OCIParse($conn, $runSQL2);
							OCIExecute($OCIParse2, OCI_DEFAULT);
							if (OCIFetch($OCIParse2)){ 
								$colom_name = "sms_setter";
								$row[$colom_name] = nl2br(OCIResult($OCIParse2,2));
								$phone = OCIResult($OCIParse2,1);
								$link1 = "<br><a href='?menu=$menu&uid=$uid&page=sms_kirim&telepon=$phone'><font color='#006600'>New SMS</font></a>";
							};//if
						}else{ $row[$colom_name] = ""; };
					};//if-id_outbox_str

					if ($colom_name == "id_outbox_mdf"){
						if ($row[$colom_name] > 0){
							$runSQL2 = "select phone, message, mess_send from SMS_OUTBOX where id=$row[id_outbox_mdf]";
							$OCIParse2 = OCIParse($conn, $runSQL2);
							OCIExecute($OCIParse2, OCI_DEFAULT);
							if (OCIFetch($OCIParse2)){ 
								$colom_name = "sms_backroom";
								$row[$colom_name] = nl2br(OCIResult($OCIParse2,2));
								$phone = OCIResult($OCIParse2,1);
								$link1 = "<br><a href='?menu=$menu&uid=$uid&page=sms_kirim&telepon=$phone'><font color='#006600'>New SMS</font></a>";
							};//if
						}else{ $row[$colom_name] = ""; };
					};//if-id_outbox_mdf

					if ($colom_name == "id_inbox_str"){
						if ($row[$colom_name] > 0){
							$runSQL2 = "select phone, message, mess_recieve from SMS_INBOX where id=$row[id_inbox_str]";
							$OCIParse2 = OCIParse($conn, $runSQL2);
							OCIExecute($OCIParse2, OCI_DEFAULT);
							if (OCIFetch($OCIParse2)){ 
								$colom_name = "sms_closetiket";
								$row[$colom_name] = nl2br(OCIResult($OCIParse2,2));
								$phone = OCIResult($OCIParse2,1);
								$link1 = "<br><a href='?menu=$menu&uid=$uid&page=sms_kirim&telepon=$phone'><font color='#006600'>New SMS</font></a>";
							};//if
						}else{ $row[$colom_name] = ""; };
					};//if-id_inbox_str

					if (($colom_name == "id_hasilset") and ($row[$colom_name] <> "")){
						$runSQL2 = "select id_hasilset, hasil_seting from DCS_P_HASILSET where id_hasilset=$row[id_hasilset]";
						$OCIParse2 = OCIParse($conn, $runSQL2);
						OCIExecute($OCIParse2, OCI_DEFAULT);
						if (OCIFetch($OCIParse2)){ 
							$colom_name = "hasil_setting";
							$row[$colom_name] = OCIResult($OCIParse2,2);
						};//if
					};//if-id_hasilset

					if (($colom_name == "id_pktmodem") and ($row[$colom_name] <> "")){
						$runSQL2 = "select id_pktmodem, paket_modem from DCS_P_PKTMODEM where id_pktmodem=$row[id_pktmodem]";
						$OCIParse2 = OCIParse($conn, $runSQL2);
						OCIExecute($OCIParse2, OCI_DEFAULT);
						if (OCIFetch($OCIParse2)){ 
							$colom_name = "paket_modem";
							$row[$colom_name] = OCIResult($OCIParse2,2);
						};//if
					};//if-id_pktmodem

					if ($row[keterangan] <> ""){ $row[keterangan] = wordwrap($row[keterangan], 40, "<br>", 1); };
					if (($colom_name == "hasilsetting") and ($row[$colom_name] <> "")){
						$colom_name="ket_setting";
						$row[$colom_name]=wordwrap($row[hasilsetting], 40, "<br>", 1);
					};//if

					if ($row[$colom_name] <> ""){
						$ccc++; if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
						$fontColor = "<font size='1'>";
						$htmlCall .= "
						  <tr bgcolor='$color'>
							<td width='100%'>
							<table width='370' cellspacing='0' cellpadding='0'>
							  <tr>
								  <td width='100' align='right' nowrap><font size='1'>".strtoupper($colom_name)." $link1</td>
								  <td width='20' align='center' nowrap>:</td>
								  <td width='250'align='left'><font size='1' color='#000099'>".$row[$colom_name]."</td>
							  </tr>
							</table>
							</td>
						  </tr>\n";
					};//if
				};//for
				$htmlCall .= "<tr><td>&nbsp;</td></tr>";	
			};//end.while
			?>

			 <table width='370' cellspacing='1' cellpadding='3'>
			 <?=$htmlCall;?>
			 </table>

			<? };//$registerInvalid?>

		 </td>
	  </tr>
    </table>
   </td>
  </tr>
</table>
</form>

<script language="Javascript" type="text/javascript">
	function initXML() {
		try { return new ActiveXObject("Msxml2.XMLHTTP");  } catch(e) {} //IE
		try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
		try { return new XMLHttpRequest(); } catch(e) {} //Native Javascript
		alert("Error XMLHttpRequest");
		return null;
	};

	function runPilihan(src, val) {
		var req = initXML();
		req.onreadystatechange = function () {
			if (req.readyState==4) {
				if (req.status==200) { document.getElementById(src).innerHTML=req.responseText; } //return value	
			}
		};
		req.open("GET", "p_setter.php?kode="+src+"&id="+val+"<?="&menu=$menu&uid=$uid&datel=$datel&area=$area&mdf=$mdf";?>"); //make connection
		req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=iso-8859-1"); //set Header
		req.send(null); //send value
	}
</script>

<p>&nbsp;</p>
<table width='250' border='1' align='right' cellpadding='0' cellspacing='0' style='border-collapse:collapse' bordercolor='#9BB4E6'>
  <tr>
	<td width='100%'>
	 <table width='100%' cellspacing='1' cellpadding='3'>
	  <tr bgcolor='#EBEFFA'>
		 <td width='100%' align='center'>
		 <font size='1' color='#868686'>
		 <b>Info SMS Gateway</b><br><i>
		 Server time : <?=$server_time;?><br>
		 Last Receive : <?=$last_receive_sms;?><br>
		 Last Sending : <?=$last_send_sms;?><br>
		 </font>
		 </td>
	  </tr>
	 </table>
    </td>
  </tr>
</table>
