<?php
function nama_bulan($angka)
{
switch($angka){
 case "01":
  $nama="Januari";
 break;
 case "02":
  $nama="Februari";
 break;
 case "03":
  $nama="Maret";
 break;
 case "04":
  $nama="April";
 break;
 case "05":
  $nama="Mei";
 break;
 case "06":
  $nama="Juni";
 break;
 case "07":
  $nama="Juli";
 break;
 case "08":
  $nama="Agustus";
 break;
 case "09":
  $nama="September";
 break;
 case "10":
  $nama="Oktober";
 break;
 case "11":
  $nama="November";
 break;
 case "12":
  $nama="Desember";
 break;
 default:
  $nama="Bulan tak dikenal";
 break;
 }
return $nama;
}
?>