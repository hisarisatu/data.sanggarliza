<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 23 Agustus 2010, lastupdate 23 Agustus 2010

include_once("include.php");
if (($SAH[id_group]==1))
{
if($act=="delpaket"){
mysql_query("delete from p_sublayanan where id_sublayanan='$id'");
mysql_query("delete from pesanan_plus where id_sublayanan not in (select id_sublayanan from p_sublayanan)");
mysql_query("delete from paket_sub_paket where id_sublayanan not in (select id_sublayanan from p_sublayanan)");
$act=null;
}

if ($cari <> ""){ 
	$cariSQL = strtoupper($cari);
	$filterSQL = " and upper(detail_layanan) like upper('%$cariSQL%') or harga_dasar like '%$cariSQL%' ";
};//if

if($c<>""){
$filterSQL = " and int_ext='$c' ";
$c=null;
}

$runSQL = "select count(*) total from p_sublayanan where 1=1 $filterSQL";
$result = mysql_query($runSQL, $connDB);
if ($row = mysql_fetch_array ($result)) { $totalRecord = $row[total]; };
$listRecord = 20;
$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter&cari=$cari&pnum=";
pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord);

unset($ii);
$runSQL = "select a.id_sublayanan, a.detail_layanan, a.harga_dasar, a.detail_layanan, b.id_layanan, b.layanan, a.int_ext,date_format(tgl_habis,'%d-%M-%Y') tgl_habis from p_sublayanan a, p_layanan b where b.id_layanan=a.id_layanan $filterSQL order by id_layanan,detail_layanan LIMIT $offsetRecord, $listRecord";
//echo "$runSQL<br>";
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) {
	$ccc++;
	if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
	$htmlData .= "
	  <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"'>
		  <td align='center'>".($offsetRecord+$ccc)."</td>
		  <td> $row[layanan] </td>
                  <td> $row[detail_layanan] </td>
		  <td align=right> ".number_format($row[harga_dasar],0)." </td>
		  <td align=right> $row[int_ext]</td>
		  <td align=center> $row[tgl_habis]</td>
		  <td align='center' nowrap>
		  <a href='?menu=$menu&uid=$uid&page=sub_paket_add&id=$row[id_sublayanan]'><img border='0' src='images/edit.gif' title='Edit Data'></a>
		  <a href='?menu=$menu&uid=$uid&page=sub_paket&id=$row[id_sublayanan]&act=delpaket'><img border='0' src='images/del.gif' title='Hapus Data'></a>

		  </td>
	  </tr>
	";//htmlData
};//end-while

?>
<table border="0" width="1000" cellspacing="0" cellpadding="0" align="center">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Data Layanan</b></font>

	 <table width="100%" border="0" cellpadding="5" cellspacing="0">
	  <tr>
		 <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
     <td valign="bottom">
			 <b>Cari : <input type="text" name="cari" value="<?=$cari;?>" size="30">
			 <input type="submit" name="run" value="  Go  " class="button">
		 </td>
     <td valign="bottom" align="right">
			 <img src="images/arrow2.gif" border="0">
			 <b><a href="<?="?menu=$menu&uid=$uid&page=sub_paket";?>">List All</a> | <a href="<?="?menu=$menu&uid=$uid&page=sub_paket_add";?>">Tambah</a></b>
		 </td>
		 </form>
	  </tr>
		<tr><td colspan="2"><hr size="1" color="#4B4B4B"></td></tr>
	 </table>

	 <table width='1000' cellspacing='1' cellpadding='3'>
		<tr>
		  <td colspan="12" align="left">
			Halaman : <?=$pnumlink;?> &nbsp; Total : <b><?=$totalPage;?></b> halaman, <?=$totalRecord?> record.
			</td>
		</tr>
		<tr bgcolor='#A7A7A7' height="25">
			<td align='center'>NO</td>
			<td align='center'>Group Layanan</td>
			<td align='center'>URAIAN Layanan</td>
                        <td align='center'>HARGA Dasar</td>
                        <td align='center'><a href="<?="?menu=$menu&uid=$uid&page=sub_paket&c=internal";?>">Internal</a>/<br><a href="<?="?menu=$menu&uid=$uid&page=sub_paket&c=external";?>">External</a></td>
			<td align='center'>TGL AKHIR</td>
			<td align='center'>PROSES</td>
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
echo "<div align='center'><font color='#FF0000'><b>Akses Tidak Diperbolehkan. Hanya Group Administrator</b></font></div>"; }
?>