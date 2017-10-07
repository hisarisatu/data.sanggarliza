<?
include_once("include.php");
include_once("p_bulan.php");


$rb=mysql_query(" select distinct date_format(created,'%m') bulan from retur_perias where id_client='$id_client'");
for($bl=0;$bl<@mysql_num_rows($rb);$bl++) {
$bulan2=mysql_result($rb,$bl,"bulan");
$bulan=nama_bulan($bulan2);
}
$rb=mysql_query(" select distinct date_format(created,'%d')hari from retur_perias where id_client='$id_client'");
for($bl=0;$bl<@mysql_num_rows($rb);$bl++) {
$hari=mysql_result($rb,$bl,"hari");
}

$rb=mysql_query(" select distinct date_format(created,'%Y') Tahun from retur_perias where id_client='$id_client'");
for($bl=0;$bl<@mysql_num_rows($rb);$bl++) {
$tahun=mysql_result($rb,$bl,"Tahun");
}

$sql="SELECT DISTINCT a.id_perias, a.id_reperias, a.no_kw_retur, a.catatan, a.id_client, b.nama_perias, a.id_user, a.login_ip, a.created, c.id_client, c.nama_cpw,d.id_reperias, d.tanggal
FROM retur_perias a
LEFT JOIN p_perias b ON a.id_perias = b.id_perias
LEFT JOIN acara_perias d ON a.id_reperias = d.id_reperias
LEFT JOIN client c ON a.id_client = c.id_client
WHERE a.id_client='$id_client'";
$res=mysql_query($sql);

$d = mysql_fetch_array($res);
?>

<table align="right">
	<tr>
		<td align="right">
			<?php echo 'NO : R - '.$tahun.'' .$bulan2.' - ' .$d['no_kw_retur']; ?>
		</td>
	</tr>
	<tr>
		<td align="right">
			<?php echo 'ID-Client : '.$d['id_client']; ?>
		</td>
	</tr>
</table> 

<table width="100%">
<tr align=center>
	<td><font color="red" size="5"><b>PERINCIAN RETUR</b></font></td>
</tr>

<tr align=center>
	<td><font color="red" size="5"><b> UNTUK  
    <?=strtoupper(mysql_result($res,0,"nama_cpw"))?></b></font></td>
</tr>
<!--<tr align=center>
	<td><font color="red" size="5"><b><?//=strtoupper(mysql_result($res,0,"acara"))?> </b></font></td>
</tr>-->
</table><?
include_once("konversi.php");



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
};
//while


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
	 <p>&nbsp;</p>
	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
     <td width="50%" valign="bottom" align="left"> &nbsp; 
	     <font class="titledata" color="#009900"><b>Rincian Returan</b></font>
		 </td>
     <td width="50%" valign="bottom" align="right">
         <!-- <a href='<?="?menu=$menu&uid=$uid&page=pesanan_returan&id=$id";?>'><img border='0' src='images/edit.gif' title='Edit Data'></a> &nbsp; &nbsp;  -->
         </td>
		</tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	  <tr>
     <td colspan="2" valign="top" align="center">
<table cellspacing='0' cellpadding='5' align=left>
<?

//DISINI EDIT QUERY UNTUK REPORT RETUR 

$sql = "SELECT DISTINCT
  c.acara,
  a.id_acara,
  DATE_FORMAT(b.tanggal,'%d-%m-%Y')    tgl_prosesi,
  b.waktu,
  b.tempat,
  c.id_acara,
  b.id_reperias
FROM acara a,
  acara_perias b,
  p_acara c
WHERE a.id_acara = b.id_acara
    AND a.id_acara = c.id_acara
    AND b.id_client = '$id_client' GROUP BY b.id_acara";//echo $sql;
$res = mysql_query($sql);
for($n1=0;$n1<mysql_num_rows($res);$n1++){
 $id_acara=mysql_result($res,$n1,"id_acara");
 echo "<tr><td colspan=2 style='border-width: 1px; border-style: outset;'><b>Acara : ";
 echo mysql_result($res,$n1,"acara");
  echo ", Tempat : ";
 echo mysql_result($res,$n1,"tempat");
 echo ", tanggal : ";
 echo mysql_result($res,$n1,"tgl_prosesi");
 echo " jam : ";
 echo mysql_result($res,$n1,"waktu");
 echo "</b></td></tr>";
echo "<tr><td nowrap>";
		
	


$sql="SELECT DISTINCT SUM(a.jml_orang) AS total_orang, SUM(a.harga * a.jml_orang) AS harga,
  a.*,b.*,c.*

FROM 
  pesanan_perias a,
  p_subperias b,
  p_perias c

    WHERE a.id_subperias = b.id_subperias
    
    AND b.id_perias   = c.id_perias

    AND a.id_client   = '$id_client'  
    AND a.id_acara    = '$id_acara'
     GROUP BY a.id_reperias";
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
	echo mysql_result($rpp,$p,"nama_perias");
	echo "</td><td align=right>";
	echo "&nbsp;";
	echo mysql_result($rpp,$p,"total_orang");
	echo "&nbsp;";
	echo "";
	echo "</td></tr>";
}
echo "<tr><td colspan=2>&nbsp;</td></tr>";
}

$sql="SELECT DISTINCT SUM(a.jml_orang) AS harga_per_acara,
  a.*,b.*,c.*

FROM 
  pesanan_perias a,
  p_subperias b,
  p_perias c

    WHERE a.id_subperias = b.id_subperias
    
    AND b.id_perias   = c.id_perias

    AND a.id_client   = '$id_client'  

    GROUP BY a.id_client";
$rt=mysql_query($sql);
$total=@mysql_result($rt,0,"harga_per_acara");

$sql2="SELECT DISTINCT SUM(b.jml_orang) AS total_orang,
  a.id_acara,
  a.id_client,
  a.id_paket,
  a.tanggal,
  a.tempat,
  a.catatan,
  b.id_paket,
  b.id_sublayanan,
  b.jml_orang,
  b.satuan,
  c.id_paket,
  c.nama_paket,
  c.harga_paket,
  d.id_layanan,
  d.id_produk,
  d.layanan,
  e.id_sublayanan,
  e.id_layanan,
  e.detail_layanan,
  e.harga_dasar,
  f.id_client,
  f.nama_cpw
FROM acara a,
  paket_sub_paket b,
  paket c,
  p_sublayanan e,
  p_layanan d,
  client f
WHERE (d.id_layanan = 1
        OR d.id_layanan = 17
        OR d.id_layanan = 18)
    AND a.id_client = f.id_client
    AND a.id_paket = c.id_paket
    AND a.id_paket = b.id_paket
    AND b.id_paket = c.id_paket
    AND b.id_sublayanan = e.id_sublayanan
    AND d.id_layanan = e.id_layanan
    AND a.id_client = '$id_client'";
$rt2=mysql_query($sql2);
$total_awal=@mysql_result($rt2,0,"total_orang");

$total_pakai = $total - $total_awal;
?>
<tr>
<td><b>Total Rias</b></td>
<td align=right style="border-width: 1px; border-style: double;" nowrap><font style="font-size:larger;"><?=$total;?> x</td>
</tr>
<tr><td>&nbsp;</td><td>&nbsp;</td></tr>

</table>

<table cellspacing='0' cellpadding='3'>
<tr><td> <hr size="1" color="#4B4B4B"> </td></tr>
</table>


</td></tr>

<table align=left>
<?php
	$sql_catatan   = "SELECT catatan FROM retur_perias WHERE id_reperias = '$id' ";
	$query_catatan = mysql_query($sql_catatan);
	$tampil = mysql_fetch_array($query_catatan);
 ?>
<tr>
	<td colspan=3><u><b>Catatan : </b></u><?php echo $tampil['catatan']; ?></td>
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

<br><br><br>
<table border="0" align="right">
	<tr>
		<td align="right" style="margin-left:200px;">
			<?php echo 'Jakarta, '.$hari. ' - '.$bulan. ' - '.$tahun.''; ?>
		</td>
	</tr>
</table>
<script type="text/javascript">
    window.print();
    window.onfocus = function() { window.close(); }
</script>