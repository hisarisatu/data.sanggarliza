<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 10 Oktober 2010, lastupdate 10 Oktober 2010

include_once("include.php");

if ($cari <> ""){ 
	$cariSQL = strtoupper($cari);
	$filterSQL = "where upper(nama) like '%$cariSQL%' or upper(tlp_rumah) like '%$cariSQL%' or upper(tlp_mobile) like '%$cariSQL%' or upper(alamat) like '%$cariSQL%' ";
};//if

$runSQL = "select count(*) total from pegawai $filterSQL";
$result = mysql_query($runSQL, $connDB);
if ($row = mysql_fetch_array ($result)) { $totalRecord = $row[total]; };
$listRecord = 20;
$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter&cari=$cari&pnum=";
pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord);

unset($ii);
$runSQL = "select id_pegawai, nama, tlp_rumah, tlp_mobile, alamat, catatan from pegawai $filterSQL order by id_pegawai desc LIMIT $offsetRecord, $listRecord";
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) {
	$ccc++;
	if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
	$htmlData .= "
	  <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"'>
		  <td align='center'>".($offsetRecord+$ccc)."</td>
		  <td> $row[nama] </td>
		  <td> $row[tlp_rumah] </td>
		  <td> $row[tlp_mobile] </td>
		  <td> $row[alamat] </td>
		  <td align='center' nowrap>
		  <a href='?menu=$menu&uid=$uid&page=pegawai_input&id=$row[id_pegawai]'><img border='0' src='images/edit.gif' title='Edit Data'></a>
		  <a href='?menu=$menu&uid=$uid&page=pegawai_view&id=$row[id_pegawai]'><img border='0' src='images/view.png' title='Lihat Data'></a>
		  </td>
	  </tr>
	";//htmlData
};//end-while

?>
<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Data Pegawai</b></font>

	 <table width="100%" border="0" cellpadding="5" cellspacing="0">
	  <tr>
		 <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
     <td valign="bottom">
			 <b>Cari : <input type="text" name="cari" value="<?=$cari;?>" size="30">
			 <input type="submit" name="run" value="  Go  " class="button">
		 </td>
     <td valign="bottom" align="right">
			 <img src="images/arrow2.gif" border="0">
			 <b><a href="<?="?menu=$menu&uid=$uid&page=pegawai";?>">List All</a> | <a href="<?="?menu=$menu&uid=$uid&page=pegawai_input";?>">Tambah</a></b>
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
			<td align='center'>NAMA</td>
			<td align='center'>Telp</td>
			<td align='center'>HP</td>
			<td align='center'>ALAMAT</td>
			<td align='center'>EDIT<br>LIHAT</td>
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
