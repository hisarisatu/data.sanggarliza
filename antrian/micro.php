<?php
$jam_masuk="23:22:10";
$jam_keluar="23:52:20";

function selisih($jam_masuk,$jam_keluar) {
list($h,$m,$s) = explode(":",$jam_masuk);
$dtAwal = mktime($h,$m,$s,"1","1","1");
list($h,$m,$s) = explode(":",$jam_keluar);
$dtAkhir = mktime($h,$m,$s,"1","1","1");
$dtSelisih = $dtAkhir-$dtAwal;

$totalmenit=$dtSelisih/60;
$jam =explode(".",$totalmenit/60);
$sisamenit=($totalmenit/60)-$jam[0];
$sisamenit2=$sisamenit*60;
$jml_jam=$jam[0];
return $jml_jam." jam ".$sisamenit2." menit";
}

echo "
Jam Masuk : $jam_masuk<br>
Jam Keluar : $jam_keluar<br>
<br>
<h3> WAktu Kerja ".selisih($jam_masuk,$jam_keluar)."</h3>"


?>