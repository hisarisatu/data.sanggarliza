<?
$hari = array ("Minggu","Senin","Selasa","Rabu","Kamis","Jumat","Sabtu");	
$bulan = array ("--All--","Januari","Februari","Maret","April","Mei","Juni",
                "Juli","Agustus","September","Oktober","November","Desember");
$bulannum = array ("00","01","02","03","04","05","06","07","08","09","10","11","12");

//$selecttahun = "<option value='0000'>--All--</option>\n";
if ($tgl == ""){ $tgl=date('d'); }
if ($bln == ""){ $bln=date('m'); }
if ($thn == ""){ $thn=date('Y'); }

unset($selecttanggal);
for($i=1; $i<=31; $i++){ 
	if($i < 10){ $ii='0'.$i; }else{ $ii=$i; };
	if(($tgl == $ii)or(($tgl == "")and( $ii==date('d')))){ $cek="selected"; }else{ unset($cek); }
	$selecttanggal .= "<option value='".$ii."' $cek>".$ii."</option>\n"; 
};//end-for

unset($selectbulan);
for($i=1; $i<count($bulan); $i++){
	if(($bln == $bulannum[$i])or(($bln == "")and(($i+1) == date('m')))){ $cek="selected"; }else{ unset($cek); }
	$selectbulan .= "<option value='".$bulannum[$i]."' $cek>".$bulan[$i]."</option>\n"; 
};//end-for

unset($selectbulanAll);
if ($blnAll == ""){ $blnAll=date('m'); }
for($i=0; $i<count($bulan); $i++){
	if($blnAll == $bulannum[$i]){ $cek="selected"; }else{ unset($cek); }
	$selectbulanAll .= "<option value='".$bulannum[$i]."' $cek>".$bulan[$i]."</option>\n"; 
};//end-for

$start_tahun = 2009;
unset($selecttahun);
if($start_tahun == ""){ $start_tahun=date('Y'); }
for($i=$start_tahun; $i<=date('Y'); $i++) {
	if(($thn==$i)or(($thn=="")and($i==date('Y')))){$cek="selected";}else{unset($cek);}
	$selecttahun.="<option value='$i' $cek>".$i."</option>\n";
};//end-for

$selecttanggal = "<select size=1 name='tgl' class='edyellow'> $selecttanggal </select>";
$selectbulan = "<select size=1 name='bln' class='edyellow'> $selectbulan </select>";
$selectbulanAll = "<select size=1 name='blnAll' class='edyellow'> $selectbulanAll </select>";
$selecttahun = "<select size=1 name='thn' class='edyellow'> $selecttahun </select>";

$bln_lalu = $bln - 1;
$thn_lalu = $thn;
if ($bln_lalu < 1){ $bln_lalu=12; $thn_lalu=$thn-1; }
if($bln_lalu < 10){ $bln_lalu='0'.$bln_lalu; }

//--------

//$selecttahun = "<option value='0000'>--All--</option>\n";
if ($tgl2 == ""){ $tgl2=date('d'); }
if ($bln2 == ""){ $bln2=date('m'); }
if ($thn2 == ""){ $thn2=date('Y'); }

unset($selecttanggal2);
for($i=1; $i<=31; $i++){ 
	if($i < 10){ $ii='0'.$i; }else{ $ii=$i; };
	if(($tgl2 == $ii)or(($tgl2 == "")and( $ii==date('d')))){ $cek="selected"; }else{ unset($cek); }
	$selecttanggal2 .= "<option value='".$ii."' $cek>".$ii."</option>\n"; 
};//end-for

unset($selectbulan2);
for($i=1; $i<count($bulan2); $i++){
	if(($bln2 == $bulannum[$i])or(($bln2 == "")and(($i+1) == date('m')))){ $cek="selected"; }else{ unset($cek); }
	$selectbulan2 .= "<option value='".$bulannum[$i]."' $cek>".$bulan[$i]."</option>\n"; 
};//end-for

$start_tahun2 = 2009;
unset($selecttahun2);
if($start_tahun2 == ""){ $start_tahun2=date('Y'); }
for($i=$start_tahun2; $i<=date('Y'); $i++) {
	if(($thn2==$i)or(($thn2=="")and($i==date('Y')))){$cek="selected";}else{unset($cek);}
	$selecttahun2.="<option value='$i' $cek>".$i."</option>\n";
};//end-for

$selecttanggal2 = "<select size=1 name='tgl2' class='edyellow'> $selecttanggal2 </select>";
$selectbulan2 = "<select size=1 name='bln2' class='edyellow'> $selectbulan2 </select>";
$selecttahun2 = "<select size=1 name='thn2' class='edyellow'> $selecttahun2 </select>";
?>