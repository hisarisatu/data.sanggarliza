<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 23 Agustus 2010, lastupdate 23 Agustus 2010

include_once("include.php");
if (($SAH[id_group]==1))
{
if($act=="delpaket"){
mysql_query("delete from bunga_detail where id_bunga='$id'");

mysql_query("delete from bunga_sub_paket where id_bunga not in (select id_bunga from bunga_detail)");
$act=null;
}

if ($cari <> ""){ 
	$cariSQL = strtoupper($cari);
	$filterSQL = " and upper(detail_layanan) like upper('%$cariSQL%')";
};//if

if($c<>""){
$filterSQL = " and int_ext='$c' ";
$c=null;
}

$runSQL = "select count(*) total from bunga_detail where 1=1 $filterSQL";
$result = mysql_query($runSQL, $connDB);
if ($row = mysql_fetch_array ($result)) { $totalRecord = $row[total]; };
$listRecord = 20;
$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter&cari=$cari&pnum=";
pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord);

unset($ii);
$runSQL = "select id_bunga, detail_layanan,date_format(tgl_habis,'%d-%M-%Y') tgl_habis from bunga_detail where 1=1 $filterSQL order by id_bunga LIMIT $offsetRecord, $listRecord";
//echo "$runSQL<br>";
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) {
	$ccc++;
	if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
	$htmlData .= "
	  <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"'>
		  <td align='center'>".($offsetRecord+$ccc)."</td>
		  
                  <td> $row[detail_layanan] </td>
		  
		  
		  <td align=center> $row[tgl_habis]</td>
		  <td align='center' nowrap>
		  <a href='?menu=$menu&uid=$uid&page=p_sub_bunga_add&id=$row[id_bunga]'><img border='0' src='images/edit.gif' title='Edit Data'></a>
		  <a href='?menu=$menu&uid=$uid&page=p_sub_bunga&id=$row[id_bunga]&act=delpaket'><img border='0' src='images/del.gif' title='Hapus Data'></a>

		  </td>
	  </tr>
	";//htmlData
};//end-while

?>
<table border="0" width="1000" cellspacing="0" cellpadding="0" align="center">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Data Bunga</b></font>

	 <table width="100%" border="0" cellpadding="5" cellspacing="0">
	  <tr>
		 <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
     <td valign="bottom">
			 <b>Cari : <input type="text" name="cari" value="<?=$cari;?>" size="30">
			 <input type="submit" name="run" value="  Go  " class="button">
		 </td>
     <td valign="bottom" align="right">
			 <img src="images/arrow2.gif" border="0">
			 <b><a href="<?="?menu=$menu&uid=$uid&page=p_sub_bunga";?>">List All</a> | <a href="<?="?menu=$menu&uid=$uid&page=p_sub_bunga_add";?>">Tambah</a></b>
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
			
			<td align='center'>URAIAN BUNGA</td>
             
                       
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