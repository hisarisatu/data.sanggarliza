<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 23 Agustus 2010, lastupdate 23 Agustus 2010

include_once("include.php");
if (($SAH[id_group]==1)or($SAH[id_group]==9))
{
if ($cari <> ""){ 
	$cariSQL = strtoupper($cari);
	$filterSQL = " and upper(nama_narasumber) like upper('%$cariSQL%') ";
};//if

$runSQL = "select count(*) total from tb_narasumber where 1=1 $filterSQL";
$result = mysql_query($runSQL, $connDB);
if ($row = mysql_fetch_array ($result)) { $totalRecord = $row[total]; };
$listRecord = 20;
$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter&cari=$cari&pnum=";
pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord);

unset($ii);
$runSQL = "select a.id_narasumber, a.id_program, a.kode, a.nama_narasumber, a.no_telp, b.id_program, b.nama_program, b.kode, a.kode as kode_narasumber from tb_narasumber a, tb_program b where a.id_program = b.id_program $filterSQL order by a.id_narasumber LIMIT $offsetRecord, $listRecord";
//echo "$runSQL<br>";
$result = mysql_query($runSQL, $connDB);
while ($row = @mysql_fetch_array ($result)) {
	$ccc++;
	if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
	$htmlData .= "
	  <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"'>
		  <td align='center'>".($offsetRecord+$ccc)."</td>
		  <td> $row[kode_narasumber] </td>
		  <td align=center> $row[nama_narasumber] </td>
		  <td align=center> $row[no_telp] </td>
		  <td align=center> $row[nama_program] </td>
                  <td align='center' nowrap>
		  <a href='?menu=$menu&uid=$uid&page=p_narasumber_add&id=$row[id_narasumber]'><img border='0' src='images/edit.gif' title='Edit Data'></a>
		  </td>
	  </tr>
	";//htmlData
};//end-while

?>
<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Data Narasumber</b></font>
	 <table width="100%" border="0" cellpadding="5" cellspacing="0">
	  <tr>
		 <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
     <td valign="bottom">
			 <b>Cari : <input type="text" name="cari" value="<?=$cari;?>" size="30">
			 <input type="submit" name="run" value="  Go  " class="button">
		 </td>
     <td valign="bottom" align="right">
			 <img src="images/arrow2.gif" border="0">
			 <b><a href="<?="?menu=$menu&uid=$uid&page=p_narasumber";?>">List All</a> | <a href="<?="?menu=$menu&uid=$uid&page=p_narasumber_plus";?>">Tambah</a></b>
		 </td>
		 </form>
	  </tr>
		<tr><td colspan="2"><hr size="1" color="#4B4B4B"></td></tr>
	 </table>

	 <table width='700' cellspacing='1' cellpadding='3'>
		<tr>
		  <td colspan="12" align="left">
			Halaman : <?=$pnumlink;?> &nbsp; Total : <b><?=$totalPage;?></b> halaman, <?=$totalRecord?> record.
			</td>
		</tr>
		<tr bgcolor='#A7A7A7' height="25">
			<td width="94" align='center'>NO</td>
			<td width="257" align='center'>KODE NARASUMBER</td>
			<td width="257" align='center'>NAMA NARASUMBER</td>
			<td width="257" align='center'>NO TELEPON</td>
			<td width="257" align='center'>NAMA PROGRAM</td>
            <td width="163" align='center'>EDIT<br>LIHAT</td>
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
<?
}
else
{echo"</br>";
echo"</br>";
echo "<div align='center'><font color='#FF0000'><b>Akses Tidak Diperbolehkan. Hanya Group Administrator dan Beauty Course</b></font></div>"; }
?>