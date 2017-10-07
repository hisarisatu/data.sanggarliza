<? 
// Sisten Informasi Sanggar LIZA
// Written 11/3/2010 by agusari@gmail.com

include_once("include.php");
include_once("konversi.php");

$id = $_GET['id'];

if(!$act)$act="tampil_diskon";
//echo "$menu - $page - $id - $act ";
?>
<link rel="stylesheet" href="images/style.css" type="text/css">
<?$runSQL = "SELECT DISTINCT a.id_perias, a.id_reperias, a.catatan, b.nama_perias, a.id_user, a.login_ip, a.created, c.id_client, c.nama_cpw,d.id_reperias, d.tanggal
FROM retur_perias a
LEFT JOIN p_perias b ON a.id_perias = b.id_perias
LEFT JOIN acara_perias d ON a.id_reperias = d.id_reperias
LEFT JOIN client c ON a.id_client = c.id_client
WHERE a.id_reperias='$id'";
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id_perias = $row[id_perias];
		$id_reperias = $row[id_reperias];
		$nama_perias=$row[nama_perias];
		$acara = $row[acara];
		$tanggal = $row[tanggal];
		$id_client = $row[id_client];
		$nama_cpw = $row[nama_cpw];
		$catatan = $row[catatan];
		
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
	 <font class="titledata"><b>Rincian Returan Perias</b><br></font>

	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
     <td width="50%" valign="bottom" align="left"> &nbsp; 
	     <font class="titledata" color="#009900"><b>Data Perias Acara</b></font>
		 </td>
     <td width="50%" valign="bottom" align="right">
		<a href="javascript:void(window.open('print_perias.php?id=<?=$id?>','','toolbar=no,menubar=no,scrollbars=yes,status=no'))"><img border=0 src='images/Printer.png' title='Cetak Rincian'></a>&nbsp;&nbsp;
	    
		 </td>
		</tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	  <tr>
     <td width="50%" valign="top" align="center">
     
		 <table border="0" cellpadding="5" cellspacing="0" width="100%">
			<tr><td colspan="2" align="center">&nbsp;</td></tr>
			<tr>
				<td width="24%" align="left"><strong>Nama Perias </td> <td>:</td>
				<td width="71%"><font class="datafield"><?=$nama_perias;?></font></td>
			</tr>
			<tr>
				<td width="24%" align="left"><strong>Tanggal </td> <td>:</td>
				<td width="71%"><font class="datafield"><?=$tanggal;?></font></td>
			</tr>
			<tr>
				<td width="24%" align="right">&nbsp;</td>
				<td width="5%">&nbsp;</td>
			</tr>
			<tr>
				<td width="24%" align="right">&nbsp;</td>
				<td width="5%">&nbsp;</td>
			</tr>
			<tr>
				<td width="24%" align="right">&nbsp;</td>
				<td width="5%">&nbsp;</td>
			</tr>
		 </table>
		 </td>
     <td width="50%" valign="top" align="center">
		 <table border="0" cellpadding="5" cellspacing="0" width="100%">
			<tr><td colspan="2" width="100%" align="center">&nbsp;</td></tr>
			<tr>
				<td width="35%" align="right">&nbsp;</td>
				<td width="65%">&nbsp;</td>
			</tr>
			<tr>
				<td width="35%" align="right">&nbsp;</td>
				<td width="65%">&nbsp;</td>
			</tr>
			<tr>
				<td width="35%" align="right">&nbsp;</td>
				<td width="65%">&nbsp;</td>
			</tr>
			<tr>
				<td width="35%" align="right">&nbsp;</td>
				<td width="65%">&nbsp;</td>
			</tr>
			<tr>
				<td width="35%" align="right">&nbsp;</td>
				<td width="65%">&nbsp;</td>
			</tr>
		 </table>
		
		 </td>
	  </tr>
	 </table>

<?
$runSQL1 = "select min(created) created from acara where id_client='$id'";
$result1 = mysql_query($runSQL1, $connDB);
if ($row1 = mysql_fetch_array ($result1)) {
	$runSQL2 = "select id_user, login_ip, created from acara where id_client='$id' and created='$row1[created]'";
	$result2 = mysql_query($runSQL2, $connDB);
	if ($row2 = mysql_fetch_array ($result2)) {
		if ($row2[id_user] > 0){
			$runSQL3 = "select id_user, fullname from sys_username where id_user='$row2[id_user]'";
			$result3 = mysql_query($runSQL3, $connDB);
			$CRE = mysql_fetch_array ($result3);
			$acararecord = "Input: $CRE[fullname], $row2[created]";
		};
	};
};

$runSQL1 = "select max(last_update) last_update from acara where id_client='$id'";
$result1 = mysql_query($runSQL1, $connDB);
if ($row1 = mysql_fetch_array ($result1)) {
	$runSQL2 = "select user_update, ip_update, last_update from acara where id_client='$id' and last_update='$row1[last_update]'";
	$result2 = mysql_query($runSQL2, $connDB);
	if ($row2 = mysql_fetch_array ($result2)) {
		if ($row2[user_update] > 0){
			$runSQL2 = "select id_user, fullname from sys_username where id_user='$row2[user_update]'";
			$result2 = mysql_query($runSQL2, $connDB);
			$UPD = mysql_fetch_array ($result2);
			$acararecord .= "<br>Update: $UPD[fullname], $row2[last_update]";
		};//if
	};//if
};//if

$runSQL = "select id_acara, acara from p_acara order by id_acara asc";
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) { $arr_acara[$row[id_acara]]=$row[acara]; }

$runSQL = "select id_gaya, gaya from p_gaya order by id_gaya asc";
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) { $arr_gaya[$row[id_gaya]]=$row[gaya]; }


$runSQL = "select id_paket, nama_paket, harga_paket from paket order by id_paket asc";
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) {
	if($row[harga_paket] > 0){ $infoharga = " - Rp. ".number_format($row[harga_paket],0); }else{ unset($infoharga); }
	$arr_paket[$row[id_paket]]=$row[nama_paket].$infoharga;
};//while


unset($ccc);
$runSQL = "select distinct id_client, id_acara, tanggal, waktu, tempat, catatan from acara where id_client='$id' order by id_acara asc";
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) {
	$ccc++;
	$row[acara] = $arr_acara[$row[id_acara]];
	$row[gaya]  = $arr_gaya[$row[id_gaya]];
	$row[paket] = $arr_paket[$row[id_paket]];

	$htmlAcara .= "
		<tr>
			<td width='15%' nowrap> &nbsp; <b>$ccc. &nbsp; $row[acara]</b> </td>
			<td width='85%'>
			 <table width='100%' border='0' cellpadding='2' cellspacing='0'>
				<tr>
				 <td width='5%'> Tanggal </td><td> : </td><td width='95%'> <font class='datafield'>$row[tanggal]</font>
				 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Jam : <font class='datafield'>$row[waktu]</font>
				 </td>
				</tr>
				<tr>
				 <td width='5%'> Lokasi </td><td> : </td><td width='95%'> <font class='datafield'>$row[tempat]</font></td>
				</tr>";
	$sql = "select id_paket,id_gaya from acara where id_client='$id' and id_acara='$row[id_acara]'";//echo $sql;
	$res2=mysql_query($sql);
	while($row2 = mysql_fetch_array($res2)){
		$sp="select nama_paket from paket where id_paket='$row2[id_paket]'";//echo $sp;
	$pa=mysql_query($sp);
		$sg="select gaya from p_gaya where id_gaya='$row2[id_gaya]'";//echo $sg;
	$ga=mysql_query($sg);
	$htmlAcara.="<tr>
				 <td width='5%'> Paket </td><td> : </td><td width='95%'> <font class='datafield'>".@mysql_result($pa,0,"nama_paket")."&nbsp;&nbsp;&nbsp;&nbsp;Gaya : ".@mysql_result($ga,0,"gaya")."</font></td>
				</tr>
				<tr>
				 <td width='5%'> Ket </td><td> : </td><td width='95%'> <font class='datafield'>$row[catatan]</font>
				 </td>
				</tr>
				";
	}

	$htmlAcara.="</table>
			</td>
		</tr>
	";//htmlAcara
};//while

if ($htmlAcara == ""){
	$htmlAcara .= "
		<tr>
			<td width='100%' align='center'>
		  <font color='#FF0000'>-- Tidak ada Jenis Acara yang dipilih --</font><br>
			<img src='images/arrow2.gif' border='0'>
			<a href=\"?menu=$menu&uid=$uid&page=pesanan_input&id=$id\"><b>Input Acara</b></a>
      </td>
		</tr>
	";//htmlAcara
};//if
?>
	
	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
     <td width="50%" valign="bottom" align="left"> &nbsp; 
	     <font class="titledata" color="#009900"><b>Rincian Returan</b></font>
		 </td>
     <td width="50%" valign="bottom" align="right">
         
         </td>
		</tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	  <tr>
     <td colspan="2" valign="top" align="center">
<table cellspacing='0' cellpadding='5' align=left>
<?
$sql = "select distinct c.acara, a.id_acara, date_format(b.tanggal,'%d-%m-%Y') tgl_prosesi, b.waktu, b.tempat, c.id_acara from acara a, acara_perias b, p_acara c where a.id_acara=b.id_acara and a.id_acara=c.id_acara and b.id_reperias='$id' GROUP BY b.id_acara";
//echo $sql;
$res = mysql_query($sql);
for($n1=0;$n1<mysql_num_rows($res);$n1++){
 $id_acara=mysql_result($res,$n1,"id_acara");
 echo "<tr><td colspan=2 style='border-width: 1px; border-style: outset;'><b>Acara : ";
 echo mysql_result($res,$n1,"acara");
  echo ", Tempat : ";
 echo mysql_result($res,$n1,"tempat");
 echo ", Tanggal : ";
 echo mysql_result($res,$n1,"tgl_prosesi");
 echo " Jam : ";
 echo mysql_result($res,$n1,"waktu");
 echo "</b></td></tr>";
echo "<tr><td nowrap>";
		
	


$sql="select b.detail_perias,a.jml_orang,a.harga,a.id_reperias,a.id_rias
from pesanan_perias a, p_subperias b 
where a.id_subperias=b.id_subperias 
and a.id_reperias='$id' and id_acara='$id_acara'";
//echo $sql;
$rpp=mysql_query($sql);
$jpp=@mysql_num_rows($rpp);
if($jpp!=0) 
for($p=0;$p<$jpp;$p++){
	$id_reperias=mysql_result($rpp,$p,"id_reperias");
	$id_plus=mysql_result($rpp,$p,"id_rias");
	echo "<tr><td>";
	echo "&nbsp;&nbsp;";
	$no++;
	echo $no.". ";
	echo mysql_result($rpp,$p,"detail_perias");
	echo "&nbsp;[";
	echo mysql_result($rpp,$p,"jml_orang");
	echo "&nbsp;";
	echo "x]";
	echo "</td><td align=right>Rp. ";
	echo number_format(mysql_result($rpp,$p,"harga") * mysql_result($rpp,$p,"jml_orang"),0);
	echo "</td></tr>";
}
echo "<tr><td colspan=2>&nbsp;</td></tr>";
}
/*$sql="select sum(jumlah) total
from 
(

select sum(harga) jumlah from pesanan_perias where id_reperias='$id'
and id_acara in (select id_acara from acara_perias where id_reperias='$id')
) a";*/

$sql_jml = "SELECT DISTINCT SUM(harga * jml_orang) AS harga_rias
FROM pesanan_perias
 WHERE  id_reperias='$id' AND id_acara != 0 GROUP BY id_reperias";

$sql_bayar = mysql_query($sql_jml);
$total     = @mysql_result($sql_bayar,0,"harga_rias");

?>

<tr>
<td><b>Total Bayar</b></td>
<td align=right style="border-width: 1px; border-style: double;" nowrap><font style="font-size:larger;"><u>Rp. <?=number_format($total,0)?></td>
</tr>

</td></tr>

</table>

<table width='100%' cellspacing='0' cellpadding='3'>
<tr><td> <hr size="1" color="#4B4B4B"> </td></tr>
</table>

<table align=left>
<tr>
	<td colspan=3><u><b>Catatan :</b></u> <?=$catatan;?> </td>
</tr>
<!--
<tr>
	<td align=right>1.</td>
	<td></td>
	<td>Pelunasan Pembayaran setidaknya sudah dilakukan selambat-lambatnya 1 minggu sebelum acara</td>
</tr>
<tr>
	<td align=right>2.</td>
	<td></td>
	<td>Bila terdapat tambahan pada saat acara berlangsung, dapat dibayar paling lambat 3 hari setelah acara.</td>
</tr>
<tr>
	<td align=right>3.</td>
	<td></td>
	<td>Untuk dapat memudahkan pembayaran dapat dilakukan melalui tunai, cek atau transfer ke rekening kami di</td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td><b><i>Bank BCA Cab. Gudang Peluru atas nama Lilis Purmasih dengan no. rek. 272-3010241  atau </i></b></td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td><b><i>Bank Mandiri Cab. Lapangan Ros atas Nama Sanggar Liza dengan No. Rek. 124-0066699969</i></b></td>
</tr>
<tr>
	<td align=right>4.</td>
	<td></td>
	<td>Pembatalan Upacara Adat yang dilakukan + 3 minggu sebelum acara akan dikenakan <b>charge 50%</b></td>
</tr>
<tr>
	<td align=right>5.</td>
	<td>a.</td>
	<td>Bila terjadi pembatalan sewa (pakaian, kain) 1 hari sebelum acara akan dikenakan charge 50%</td>
</tr>
<tr>
	<td></td>
	<td>b.</td>
	<td>Bila terjadi pembatalan sewa (pakaian, kain) pada saat acara berlangsung maka dikenakan charge 100%</td>
</tr>
</table>
		 </td>
		</tr>
	 </table>
	 <p>&nbsp;</p>
	 <a href="javascript:window.close()"><b>Close</b></a>

   </td>
  </tr>
  -->
  </form>
</table>

<?php 
	
	$id = $_GET['id']; 

	if (isset($_POST['simpan_cat'])) {
		
		$catatan 		= htmlentities(strip_tags($_POST['catatan']));

		$sql_cat = "UPDATE retur_perias SET catatan = '$catatan' WHERE id_reperias = '$id'";
		mysql_query($sql_cat) or die('Gagal menyimpan catatan');

		echo "<meta http-equiv='refresh' content='0; URL=?menu=$menu&uid=$uid&page=$page&id=$id'>";
	}
?>

<form action="<?="?menu=$menu&uid=$uid&page=$page&id=$id";?>" method="POST">
<table border="0" cellpadding="5" cellspacing="0" width="100%">
	<tr><td colspan="2" align="center">&nbsp;</td></tr>
	<tr>
		<td width="15%" align="left">Input Catatan </td> <td>:</td>
		<td width="90%"><font class="datafield"><textarea name="catatan" value="<?=$catatan?>" rows="2" cols="40"></textarea></font></td>
	</tr>
	<tr>
		<td width="15%" align="left"> </td> <td></td>
		<td width="15%" align="left"><input type="submit" name="simpan_cat" value="Simpan"> </td>
	</tr>
</table>
</form>