<? 
// Sisten Informasi Sanggar LIZA
// Written by iyok642@yahoo.com; 031-70920002
// 23 Agustus 2010, lastupdate 23 Agustus 2010

include_once("include.php");
include_once("p_bulan.php");

//echo $bulan_rencana;
//if ($cari <> ""){ 
//	$cariSQL = strtoupper($cari);
//	$filterSQL = " and upper(nama_cpw) like '%$cariSQL%' or upper(nama_ortu_cpw) like '%$cariSQL%' or upper(tlp_rumah_cpw) like '%$cariSQL%' or upper(tlp_mobile_cpw) like '%$cariSQL%' or upper(alamat_cpw) like '%$cariSQL%' or upper(nama_cpp) like '%$cariSQL%' or upper(nama_ortu_cpp) like '%$cariSQL%' or upper(tlp_rumah_cpp) like '%$cariSQL%' or upper(tlp_mobile_cpp) like '%$cariSQL%' or upper(alamat_cpp) like '%$cariSQL%' ";
//};//if

	if($bulan_rencana!="" && $thn_rencana!="")
	{
		$filterSQL = " and tgl_rencana like '$thn_rencana-$bulan_rencana%' ";
	}
	if($nama_cpw!="")
	$filterSQL .=" and nama_cpw like '%$nama_cpw%' ";
$pageFilter ="&thn_rencana=$thn_rencana&bulan_rencana=$bulan_rencana&nama_cpw=$nama_cpw";
	
$runSQL = "select count(*) total from client where 1=1 and id_client not in (select distinct id_client from acara) $filterSQL";
//echo $runSQL;
$result = mysql_query($runSQL, $connDB);
if ($row = mysql_fetch_array ($result)) { $totalRecord = $row[total]; };
$listRecord = 20;
$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter&thn_rencana=$thn_rencana&pnum=";
pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord);

unset($ii);
$runSQL = "select id_client, nama_cpw, nama_ortu_cpw, tlp_rumah_cpw, tlp_mobile_cpw, alamat_cpw, nama_cpp, nama_ortu_cpp, tlp_rumah_cpp, tlp_mobile_cpp, alamat_cpp, date_format(tgl_rencana,'%d-%m-%Y') tgl_rencana, catatan, last_update from client where 1=1 and id_client not in (select distinct id_client from acara) $filterSQL order by id_client desc LIMIT $offsetRecord, $listRecord";//echo $runSQL;
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) {
	$ccc++;
	if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
	$htmlData .= "
	  <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"'>
		  <td align='center'>".($offsetRecord+$ccc)."</td>
		  <td> $row[nama_cpw] / $row[nama_cpp]</td>
		  <td> $row[alamat_cpw] </td>
		  <td> $row[tlp_mobile_cpw] </td>
		  <td> $row[tgl_rencana] </td>";
if(($SAH[id_group]==1) or ($SAH[id_group]==3) or ($SAH[id_group]==12)){
$htmlData .= "<td align='center' nowrap>";

$htmlData .= "
		  <a href='?menu=$menu&uid=$uid&page=pesanan_input&id=$row[id_client]'><img border='0' src='images/add.gif' title='Input Pesanan' qidth=16 height=16></a></td></tr>
";
}
$htmlData .= "";//htmlData
};//end-while

?>
<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Data Client</b></font>

	 <table width="100%" border="0" cellpadding="5" cellspacing="0">
	  <tr>
		 <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
     <td valign="bottom"><b>Bulan Kegiatan:
<select name="bulan_rencana">
<option value="%">-All-</option>
<?
$rb=mysql_query("select distinct date_format(tgl_rencana,'%m') bulan from client where tgl_rencana!='0000-00-00'");
while($bulan=mysql_fetch_array($rb))
{
echo "<option ";
if($bulan['bulan']==$bulan_rencana)echo " selected ";
echo "value='".$bulan['bulan']."'>".nama_bulan($bulan['bulan'])."</option>";
}
?>
</select> - 
<select name="thn_rencana">
<option value="%">-All-</option>
<?
$rb=mysql_query("select distinct date_format(tgl_rencana,'%Y') thn from client where tgl_rencana!='0000-00-00'");
for($bl=0;$bl<@mysql_num_rows($rb);$bl++){
$thn=mysql_result($rb,$bl,"thn");
echo "<option ";
if($thn==$thn_rencana)echo " selected ";
echo "value='$thn'>$thn</option>";
}
?>
</select>
			 <b> &nbsp; Nama CPW : <input type="text" name="nama_cpw" value="<?=$nama_cpw;?>" size="30">
			 <input type="submit" name="run" value="  Go  " class="button">
		 </td>
     <td valign="bottom" align="right">
			 <img src="images/arrow2.gif" border="0">
			 <b><a href="<?="?menu=$menu&uid=$uid&page=pesanan_baru";?>">List All</a>
			 
			  <!--| <a href="<?//="?menu=$menu&uid=$uid&page=pesanan_cari_baru";?>">Cari</a>--></b>
		 </td>
		 </form>
	  </tr>
	 </table>

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
<?
if (($SAH[id_group]==1)or($SAH[id_group]==3) or ($SAH[id_group]==12))
{
?>
			<td align='center'>Input<br>Pesanan</td>
<? 
} else {}
?>

		</tr>
		<?=$htmlData;?>
		<tr>
		  <td colspan="12" align="left">
			Halaman : <?=$pnumlink;?> &nbsp; Total : <b><?=$totalPage;?></b> halaman, <?=$totalRecord?> record.
			</td>
		</tr>
	 </table>

   </td>
  </tr>
</table>