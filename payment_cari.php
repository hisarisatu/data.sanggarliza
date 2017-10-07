<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 10 Oktober 2010, lastupdate 10 Oktober 2010

include_once("include.php");
include_once("p_bulan.php");

if ($cari <> ""){ 
	$cariSQL = strtoupper($cari);
	$filterSQL = " and upper(nama_cpw) like '%$cariSQL%' or upper(nama_cpp) like '%$cariSQL%' ";
};//if

if($bulan_rencana!="")
 $filterSQL = " and a.tanggal like '$thn_rencana-$bulan_rencana-%' ";

$runSQL = "SELECT count(*) total FROM `acara` a, p_acara b, client c WHERE a.id_acara = b.id_acara AND a.id_client = c.id_client $filterSQL";
$result = mysql_query($runSQL, $connDB);
if ($row = mysql_fetch_array ($result)) { $totalRecord = $row[total]; };
$listRecord = 20;
$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter&cari=$cari&pnum=";
pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord);

unset($ii);
$runSQL = "select id_client, nama_cpw, nama_ortu_cpw, tlp_rumah_cpw, tlp_mobile_cpw, alamat_cpw, nama_cpp, date_format(tgl_rencana,'%d-%m-%Y') tgl_rencana, catatan, last_update from client where 1=1 $filterSQL order by id_client desc LIMIT $offsetRecord, $listRecord";//echo $runSQL;
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) {
	$id_client=$row[id_client];
	$ccc++;
	if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
	$htmlData .= "
	  <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"'>
		  <td align='center'>".($offsetRecord+$ccc)."</td>
		  <td> $row[nama_cpw] / $row[nama_cpp]</td>
		  <td> $row[alamat_cpw] </td>
		  <td> $row[tlp_mobile_cpw] </td>
		  <td> $row[tgl_rencana] </td>
		  <td align='center' nowrap><a href='?menu=$menu&uid=$uid&page=view&id=$row[id_client]'><img border='0' src='images/view.png' title='Lihat Data'></a></td>";
	$sql="select sum(jumlah) total, sum(diskon) diskon
	from 
	(
	SELECT SUM( harga_paket ) jumlah,'0' diskon
	FROM acara a, paket b
	WHERE id_client ='$id_client'
	AND a.id_paket = b.id_paket
	union all
	select sum(harga) jumlah,'0' diskon from pesanan_plus where id_client='$id_client'
	and id_acara in (select id_acara from acara where id_client='$id_client')
	union all
        select sum(harga) jumlah,'0' from pesanan_bebas where id_client='$id_client'
        and id_acara in (select id_acara from acara where id_client='$id_client')
	union all
        select '0' total,diskon from client_diskon where id_client='$id_client'
	) a";
	$rt=mysql_query($sql);
	$total=@mysql_result($rt,0,"total");
	$htmlData .= "<td align=right> ".number_format($total,0)." </td>";
	$diskon=@mysql_result($rt,0,"diskon");
	$htmlData .= "<td align=right> ".number_format($diskon,0)." </td>";
	$sql="select sum(nilai) bayar from client_bayar where id_client='$id_client'";
	$rt=mysql_query($sql);
	$bayar=@mysql_result($rt,0,"bayar");
	$htmlData .= "<td align=right> ".number_format($bayar,0)." </td>";
	$htmlData .= "<td align=right> ".number_format($total-$diskon-$bayar,0)." </td>";
	$htmlData .= "<td align='center' nowrap>";
	if($SAH[id_group]==1){
	$htmlData .= "
			  <a href='?menu=$menu&uid=$uid&page=client_nota&id=$row[id_client]'><img border='0' src='images/pay.jpg' title='Bayar' qidth=16 height=16></a>
	";
}
$htmlData .= "</td></tr>";//htmlData
};//end-while

?>
<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Data Payment</b></font>

	 <table width="100%" border="0" cellpadding="5" cellspacing="0">
	  <tr>
		 <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
     <td valign="bottom"><b>Cari : <input type="text" name="cari" value="<?=$cari;?>" size="30">
			 <input type="submit" name="run" value="  Go  " class="button">
		 </td>
     <td valign="bottom" align="right">
			 <img src="images/arrow2.gif" border="0">
			 <a href="<?="?menu=$menu&uid=$uid&page=payment";?>"><b>List All</b></a>
		 </td>
		 </form>
	  </tr>
	 </table>
<? 
if($cari==""){
$pnumlink=0;
$totalPage=0;
$totalRecord=0;
} ?>

	 <table width='100%' cellspacing='1' cellpadding='3'>
		<tr>
		  <td colspan="12" align="left">
		  <hr size="1" color="#4B4B4B">
			Halaman : <?=$pnumlink;?> &nbsp; Total : <b><?=$totalPage;?></b> halaman, <?=$totalRecord?> record.
			</td>
		</tr>
		<tr bgcolor='#A7A7A7' height="25">
			<td align='center'>NO</td>
			<td align='center'>NAMA CPW</td>
			<td align='center'>ALAMAT CPW</td>
			<td align='center'>HP CPW</td>
			<td align='center'>Tgl Rencana</td>
			<td align='center'>Detil<br>Pesanan</td>
			<td align='center'>Tagihan</td>
			<td align='center'>Diskon</td>
			<td align='center'>Jml Bayar</td>
			<td align='center'>Sisa</td>
			<td align='center'>Bayar</td>
		</tr>
<? if($cari<>"")echo $htmlData; ?>
		<tr>
		  <td colspan="12" align="left">
			Halaman : <?=$pnumlink;?> &nbsp; Total : <b><?=$totalPage;?></b> halaman, <?=$totalRecord?> record.
			</td>
		</tr>
	 </table>

   </td>
  </tr>
</table>