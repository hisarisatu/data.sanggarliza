<? 
// Sisten Informasi Sanggar LIZA
// Written by iyok642@yahoo.com; 031-70920002
// 23 Agustus 2010, lastupdate 23 Agustus 2010

include_once("include.php");
include_once("p_bulan.php");
if (($SAH[id_group]==1)or($SAH[id_group]==9))
{
//echo $bulan_rencana;
//if ($cari <> ""){ 
//	$cariSQL = strtoupper($cari);
//	$filterSQL = " and upper(nama_cpw) like '%$cariSQL%' or upper(nama_ortu_cpw) like '%$cariSQL%' or upper(tlp_rumah_cpw) like '%$cariSQL%' or upper(tlp_mobile_cpw) like '%$cariSQL%' or upper(alamat_cpw) like '%$cariSQL%' or upper(nama_cpp) like '%$cariSQL%' or upper(nama_ortu_cpp) like '%$cariSQL%' or upper(tlp_rumah_cpp) like '%$cariSQL%' or upper(tlp_mobile_cpp) like '%$cariSQL%' or upper(alamat_cpp) like '%$cariSQL%' ";
//};//if

	if($bulan_rencana!="" && $thn_rencana!="")
	{
		$filterSQL = " and tgl_mulai like '$thn_rencana-$bulan_rencana%' ";
	}
	if($nama_cpw!="")
	$filterSQL .=" and nama_siswa like '%$nama_siswa%' ";
$pageFilter ="&thn_rencana=$thn_rencana&bulan_rencana=$bulan_rencana&nama_siswa=$nama_siswa";
	
$runSQL = "SELECT
  COUNT(*) total
FROM tb_siswa
WHERE 1 = 1
    AND id_siswa NOT IN(SELECT DISTINCT
                           id_siswa
                         FROM acara)$filterSQL";
//echo $runSQL;
$result = mysql_query($runSQL, $connDB);
if ($row = mysql_fetch_array ($result)) { $totalRecord = $row[total]; };
$listRecord = 20;
$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter&thn_rencana=$thn_rencana&pnum=";
pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord);

unset($ii);
$runSQL = "SELECT
  a.id_siswa,
  a.nama_siswa,
  a.alamat,
  a.no_telp,
  a.email,
  a.tgl_mulai,
  a.tgl_selesai,
  a.catatan,
  a.created,
  a.id_user,
  a.login_ip,
  a.ip_update,
  a.user_update,
  a.last_update,
  b.nama_program,
  b.id_program,
  DATE_FORMAT(a.tgl_mulai,'%d-%m-%Y') tgl_mulai,
  DATE_FORMAT(a.tgl_selesai,'%d-%m-%Y') tgl_selesai
FROM tb_siswa a LEFT JOIN tb_program b
    ON a.id_program = b.id_program
WHERE 1 = 1
    AND a.id_siswa NOT IN(SELECT DISTINCT
                           id_siswa
                         FROM tb_acara_workshop)$filterSQL
ORDER BY id_siswa DESC
LIMIT $offsetRecord, $listRecord";//echo $runSQL;
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) {
	$ccc++;
	if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
	$htmlData .= "
	  <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"'>
		  <td align='center'>".($offsetRecord+$ccc)."</td>
		  <td> $row[nama_siswa]</td>
		  <td> $row[alamat] </td>
		  <td> $row[no_telp] </td>
		  <td> $row[nama_program] </td>
		  <td> $row[tgl_mulai] - $row[tgl_selesai] </td>";

$htmlData .= "<td align='center' nowrap>";
if(($SAH[id_group]==1) or ($SAH[id_group]==9)){
$htmlData .= "
		  <a href='?menu=$menu&uid=$uid&page=pesanan_input_workshop&id_siswa=$row[id_siswa]'><img border='0' src='images/add.gif' title='Input Pesanan Workshop' qidth=16 height=16></a>
";
}
$htmlData .= "</td></tr>";//htmlData
};//end-while

?>
<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Data Siswa</b></font>

	 <table width="100%" border="0" cellpadding="5" cellspacing="0">
	  <tr>
		 <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
     <td valign="bottom"><b>Bulan Kegiatan:
<select name="bulan_rencana">
<option value="%">-All-</option>
<?
$rb=mysql_query("select distinct date_format(tgl_mulai,'%m') bulan from tb_siswa where tgl_mulai!='0000-00-00'");
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
$rb=mysql_query("select distinct date_format(tgl_mulai,'%Y') thn from tb_siswa where tgl_mulai!='0000-00-00'");
for($bl=0;$bl<@mysql_num_rows($rb);$bl++){
$thn=mysql_result($rb,$bl,"thn");
echo "<option ";
if($thn==$thn_rencana)echo " selected ";
echo "value='$thn'>$thn</option>";
}
?>
</select>
			 <b> &nbsp; Nama Siswa : <input type="text" name="nama_siswa" value="<?=$nama_siswa;?>" size="30">
			 <input type="submit" name="run" value="  Go  " class="button">
		 </td>
     <td valign="bottom" align="right">
			 <img src="images/arrow2.gif" border="0">
			 <b><a href="<?="?menu=$menu&uid=$uid&page=pesanan_baru_workshop";?>">List All</a>
			 
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
			<td align='center'>NAMA SISWA</td>
			<td align='center'>ALAMAT</td>
			<td align='center'>NO TELEPON</td>
			<td align='center'>PROGRAM KELAS</td>
			<td align='center'>TGL MULAI</td>
			<td align='center'>Input<br>Pesanan</td>
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