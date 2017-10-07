<?php 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 23 Agustus 2010, lastupdate 23 Agustus 2010

include_once("include.php");
if (($SAH[id_group]==1))
{
if ($cari <> ""){ 
	$cariSQL = strtoupper($cari);
	$filterSQL = " and upper(keterangan) like upper('%$cariSQL%') ";
};//if


if(($act=="delete")&&($id!="")){
	$rd=mysql_query("delete from p_kain where id_kain='$id'");
	$act=null;
}

$runSQL = "select count(*) total from p_kain where 1=1 $filterSQL";
$result = mysql_query($runSQL, $connDB);
if ($row = mysql_fetch_array ($result)) { $totalRecord = $row[total]; };
$listRecord = 20;
$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter&cari=$cari&pnum=";
pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord);

unset($ii);
$runSQL = "select id_kain,keterangan from p_kain $filterSQL order by id_kain LIMIT $offsetRecord, $listRecord";
$runSQL="select a.id_kain,a.keterangan,a.qty, ifnull(d.keterangan,'-')tipe,
 IFNULL(b.nama,'-')nama, IFNULL(c.nama_warna,'-')warna
 
   from p_kain a
   left join p_baju_tipe d on d.id_tipe_baju=a.id_tipe_baju
   left join daerah b on  a.daerah=b.id
   left join warna c on a.warna=c.id_warna
    where 1=1 $filterSQL
order by id_kain LIMIT $offsetRecord, $listRecord";
#echo "$runSQL<br>";
$result = mysql_query($runSQL, $connDB);
while ($row = @mysql_fetch_array ($result)) {
	$ccc++;
	if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
	$htmlData .= "
	  <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"'>
		  <td align='center'>".($offsetRecord+$ccc)."</td>
		  <td> $row[tipe] </td>
		  <td> $row[keterangan] </td>
                  <td align='center'> $row[nama] </td>
				  <td align='center'> $row[warna] </td>
				  <td align='center'> $row[qty] </td>
                  <td align='center' nowrap>
		  <a href='?menu=$menu&uid=$uid&page=p_kain_add&id=$row[id_kain]'><img border='0' src='images/edit.gif' title='Edit Data'></a>  &nbsp;  <a href='?menu=$menu&uid=$uid&page=p_kain&id=$row[id_kain]&act=delete'><img border='0' src='images/del.gif' title='Hapus Data'></a>
		  </td>
	  </tr>
	";//htmlData
};//end-while

?>
<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Data Tipe Kain</b></font>
	 <table width="100%" border="0" cellpadding="5" cellspacing="0">
	  <tr>
		 <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
     <td valign="bottom">
			 <b>Cari : <input type="text" name="cari" value="<?=$cari;?>" size="30">
			 <input type="submit" name="run" value="  Go  " class="button">
		 </td>
     <td valign="bottom" align="right">
			 <img src="images/arrow2.gif" border="0">
			 <b><a href="<?="?menu=$menu&uid=$uid&page=p_kain";?>">List All</a> | <a href="<?="?menu=$menu&uid=$uid&page=p_kain_add";?>">Tambah</a>
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
			<td align='center'>NO</td>
            <td align='center'>Tipe Kain</td>
			<td align='center'>Jenis Kain</td>
                        <td align='center'>Daerah</td>
                        <td align='center'>Warna</td>
                        <td align='center'>Jumlah</td>
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
<?
}
else
{echo"</br>";
echo"</br>";
echo "<div align='center'><font color='#FF0000'><b>Akses Tidak Diperbolehkan. Hanya Group Administrator</b></font></div>"; }
?>