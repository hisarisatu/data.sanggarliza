<?php
session_start();

// Included Transfer Pulsa 858
// Copyright (c) 2009 http://iyok642.blogspot.com/
// Written by Priyo Setiawan (iyok642@yahoo.com;031-70920002)
// 07 April 2009, lastupdate 14 April 2009

//==== DATABASE mysqli ====//
/*$hostserver = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbasename  = "sanggarliza";*/

$hostserver = "localhost";
//$dbusername = "h67649_liza642";
$dbusername = "root";
$dbpassword = "";
$dbasename  = "h67649_liza642";

$connDB = @mysqli_connect("$hostserver","$dbusername","$dbpassword", "$dbasename");
if (!$connDB){ 
	$connDB = @mysqli_connect($hostserver, $dbusername, $dbpassword)
	or die("System DB Not Stable #1. please be patient");
};//if



@mysqli_select_db($connDB, $dbasename)
			  or die("System DB Not Stable #2. please be patient");


//redirect parent location
function redirect($goto = 'index.php'){
	mysqlii_close();
	return die("<script> window.parent.location='$goto'; </script>");
}

//redirect close and open new windows
function closeOpenNew($goto = 'index.php', $name = 'operator', $width = '550', $height = '373'){
	mysqli_close();
	$view  = "<script language='JavaScript'>";
	$view .= "a=open('$goto', '$name', \"toolbar=no,menubar=no,scrollbars=no,resizable=no,width=$width,height=$height\");";
	$view .= "a.focus();";
	$view .= "win = top;  win.opener = top;  win.close(); ";
	$view .= "</script>";
	return die($view);
}

//calculate page view
function pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord = 10) {
	global $pnum, $totalRecord, $beginPage, $endPage, $totalPage, $offsetRecord, $pnumlink;

	if (!isset($pnum)) { $pnum=1; };
	if (!isset($listRecord)) { $listRecord=10; };
	if ($totalRecord>0) {
		$totalPage = intval($totalRecord / $listRecord);
		if (($totalRecord % $listRecord)<>0) { $totalPage++;};
		$offsetRecord=($pnum-1) * $listRecord;
			$limitPage=10;
			if ($pnum>$totalPage){$pnum=$totalPage;};
			$nextPage = intval($pnum/$limitPage);
			if (($pnum % $limitPage)<>0) {$nextPage++;};
			//$beginPage = (($nextPage-1)*$limitPage)+1;
			$beginPage = $pnum - ( intval($limitPage/2) );
			if ($beginPage <= 0) { $beginPage = 1; };
			//$endPage = $nextPage*$limitPage;
			$endPage = $pnum + ( intval($limitPage/2) );
			if ($endPage - $beginPage < $limitPage) { $endPage = $endPage + ($limitPage - ($endPage - $beginPage) - 1); }
			if ($endPage>$totalPage) {$endPage=$totalPage;};
	}else{
		$listRecord=0;
		$offsetRecord=0;
	};	
	$beginLINK = "<a href='".$pageLink;	
	$endLINK = "' style='text-decoration:none'>";
	if ($beginPage>1) { $pnumlink .= $beginLINK ."1". $endLINK . "<b>|Awal|</b></a>&nbsp;"; }
	if ($pnum>1) { $pnumlink .= $beginLINK . ($pnum-1) . $endLINK . "<b>|sebelumnya|</b></a>"; };
	for ($hit=$beginPage; $hit<=$endPage; $hit++){
	  if($pnum==$hit) {$pnumlink.="<font color='#FF0000'><b>&nbsp;".$hit."&nbsp;&nbsp;</b></font>";}
	  else {$pnumlink.="&nbsp;".$beginLINK.$hit.$endLINK.$hit."</a>&nbsp;&nbsp;</font>";};
	}; 
	if ($pnum<$totalPage){ $pnumlink.=$beginLINK.($pnum+1).$endLINK."<b>|Berikutnya|</b></a>"; };
	if ($endPage<$totalPage){ $pnumlink.="&nbsp;".$beginLINK.$totalPage.$endLINK."<b>|akhir|</b></a>"; };
	if ($totalPage == 0){ $pnumlink = "<b>0</b>"; };
	return $pnumlink;
}

function decimal($number){
	$tmp = explode(".",$number);
	if (count($tmp) > 0) { $number = $tmp[0] .".". substr($tmp[1],0,2); };
	return $number;
}

include_once("tanggal.php");
function getDay($tgl, $bln, $thn){
	global $hari;
	$num_hari = date("w", mktime (0,0,0,$bln,$tgl,$thn));
	return $hari[$num_hari];
};//getDay

function getMon($bln){
	global $bulannum, $bulan;
	for ($i=0; $i<count($bulan); $i++){
		if ($bulannum[$i] == $bln) { $nama_bln = $bulan[$i]; break; }
	};//for
	return $nama_bln;
};//getMon

function currency($number){
	/*
	$rrr = substr($number,-3);  $sisa = str_replace($rrr);
	//$tmp = explode(".",$sisa);
	//if (count($tmp) > 0) { $number = $tmp[0] .".". substr($tmp[1],0,2); };
	$digit = strlen($number);
	for ($ii=$digit; $ii>=3; $ii=$ii-3){
		$belakang = substr($number,-3);  $number = substr($number,0, $ii);
		if ($currency <> ""){ $currency="$currency.$belakang"; }else{ $currency=$belakang; }
	};
	if ($number <> ""){ $currency="$number.$currency"; }
	*/
	return $number;
};//end-decimal

function ribuan($number){
	$digit = strlen($number);
	if ($number > 999){
		if ($digit > 6){ $number = round($number/1000000,2)."jt"; }
		else if ($digit > 3){ $number = round($number/1000,1)."rb"; };
	};//if
	return $number;
};//end-ribuan

function findPhone($phone_number) {
	global $connDB, $databaseSMS;
   /*
	$result = mysqli_query("select kode_outlet, nama_outlet, nama_pemilik from outlet where telp_pemilik='$phone_number' or telp_flexi='$phone_number' limit 1", $connDB);
   while ($row = mysqli_fetch_array($result)) { 
		$row[nama_pemilik] = ucwords($row[nama_pemilik]);
		$row[nama_outlet] = ucwords($row[nama_outlet]);
      return "$row[nama_pemilik] ($row[nama_outlet])";
   };
   $result = mysqli_query("select petugas from petugas where telepon='$phone_number' limit 1", $connDB);
   while ($row = mysqli_fetch_array($result)) { 
		$row[petugas] = ucwords($row[petugas]);
      return "$row[petugas] (Canvaser)";
   };
   $result = mysqli_query("select nama, info, aplikasi from $databaseSMS.sms_register where phone='$phone_number' limit 1", $connDB);
   while ($row = mysqli_fetch_array($result)) { 
		$row[nama] = ucwords($row[nama]);
		$row[info] = ucwords($row[info]);
      return "$row[nama] ($row[info])";
   };
	*/
   return "Unregister";
};//end-function-findPhone


//setting parameter web
$result = mysqli_query($connDB, "select variable,value from sys_settings");
while ($row = mysqli_fetch_assoc ($result)) { 
	$row['value'] = addslashes($row['value']);
	$variable = "\$".$row['variable']."=\"".$row['value']."\";";
	eval($variable);
};//while

// Script PHP : iyok642@yahoo.com; mail.box@telkom.net //

function create_dd($id,$val=array(),$q){
    $result=  mysqli_query($connDB, $q);
    $x=0;
    while ($row = mysqli_fetch_array ($result)) { 
        $array[]=array($val[0]=>$row[$val[0]],$val[1]=>$row[$val[1]]);
   $x++; }
    $html="<select name='$id' id='$id'>";
    foreach($array as $rw){
        $html.="<option value='".$rw[$val[0]]."'>";
        $html.=$rw[$val[1]];
        $html.="</option>";
    }
    $html.="</select>";
    return  $html;
}
 


function pre($sql){
    echo "<pre>".print_r($sql,true)."</pre>";
}
?>