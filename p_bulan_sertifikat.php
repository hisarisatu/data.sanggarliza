<?php
function nama_bulan($angka)
{
switch($angka){
 case "01":
  $nama="January";
 break;
 case "02":
  $nama="February";
 break;
 case "03":
  $nama="March";
 break;
 case "04":
  $nama="April";
 break;
 case "05":
  $nama="May";
 break;
 case "06":
  $nama="June";
 break;
 case "07":
  $nama="July";
 break;
 case "08":
  $nama="August";
 break;
 case "09":
  $nama="September";
 break;
 case "10":
  $nama="October";
 break;
 case "11":
  $nama="November";
 break;
 case "12":
  $nama="December";
 break;
 default:
  $nama="Bulan tak dikenal";
 break;
 }
return $nama;
}
?>