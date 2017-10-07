<? 
// Sisten Informasi Sanggar LIZA
// Written by iyok642@yahoo.com; 031-70920002
// 23 Agustus 2010, lastupdate 23 Agustus 2010

include_once("include.php");
include_once("p_bulan.php");

//echo $bulan_rencana;
if ($cari <> ""){ 
	$cariSQL = strtoupper($cari);
	$filterSQL = " and upper(nama_cpw) like '%$cariSQL%' or upper(nama_ortu_cpw) like '%$cariSQL%' or upper(tlp_rumah_cpw) like '%$cariSQL%' or upper(tlp_mobile_cpw) like '%$cariSQL%' or upper(alamat_cpw) like '%$cariSQL%' or upper(nama_cpp) like '%$cariSQL%' or upper(nama_ortu_cpp) like '%$cariSQL%' or upper(tlp_rumah_cpp) like '%$cariSQL%' or upper(tlp_mobile_cpp) like '%$cariSQL%' or upper(alamat_cpp) like '%$cariSQL%' ";
};//if

if($act=="delete_acara"){
$sql="delete from acara where id_client='$id'";
@mysql_query($sql);
$sql="delete from client_diskon where id_client='$id'";
@mysql_query($sql);
$sql="delete from pegawai_tugas where id_client='$id'";
@mysql_query($sql);
$sql="delete from pesanan_plus where id_client='$id'";
@mysql_query($sql);
$act=null;
}

if($bulan_rencana!="")
	 $filterSQL = " and id_client in (select distinct id_client from acara where tanggal like '$thn_rencana-$bulan_rencana-%')";
if($nama_cpw!="")
	$filterSQL .=" and nama_cpw like '%$nama_cpw%' ";
 
 
 $pageFilter ="&thn_rencana=$thn_rencana&bulan_rencana=$bulan_rencana&nama_cpw=$nama_cpw";

$runSQL = "select count(*) total from client where id_client in (select distinct id_client from acara) $filterSQL";
//echo $runSQL;
$result = mysql_query($runSQL, $connDB);
if ($row = mysql_fetch_array ($result)) { $totalRecord = $row[total]; };
$listRecord = 20;
$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter&cari=$cari&pnum=";

pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord);

unset($ii);
$runSQL = "SELECT distinct a.id_client, a.nama_cpw, a.nama_ortu_cpw, a.tlp_rumah_cpw, a.tlp_mobile_cpw, a.alamat_cpw, a.nama_cpp, a.nama_ortu_cpp, a.tlp_rumah_cpp, a.tlp_mobile_cpp, a.alamat_cpp, a.tgl_rencana, a.catatan, a.last_update,ifnull(a.id_pegawai,'-')id_pegawai, ifnull(b.nama,'-')nama
FROM client a
left join pegawai b on a.id_pegawai = b.id_pegawai 
where 1=1 and id_client in (select distinct id_client from acara) $filterSQL order by date_format(tgl_rencana,'%Y-%m-%d') desc LIMIT $offsetRecord, $listRecord";//echo $runSQL;
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
		  <td> $row[tgl_rencana] </td>
		  <td align='center'> $row[nama] </td>";



$htmlData .="<td align='center' nowrap><a href='?menu=$menu&uid=$uid&page=view_ukuran_fiting_wanita_baru&id=$row[id_client]'><img border='0' src='images/view.png' title='Lihat Data'></a></td>
<td align='center' nowrap><a href='?menu=$menu&uid=$uid&page=view_ukuran_fiting_wanita_spesial&id=$row[id_client]'><img border='0' src='images/view.png' title='Lihat Data'></a></td>
<td align='center' nowrap><a href='?menu=$menu&uid=$uid&page=view_ukuran_fiting_wanita_standar&id=$row[id_client]'><img border='0' src='images/view.png' title='Lihat Data'></a></td>
<td align='center' nowrap><a href='?menu=$menu&uid=$uid&page=view_ukuran_wanita_kebaya&id=$row[id_client]'><img border='0' src='images/view.png' title='Lihat Data'></a></td>
<td align='center' nowrap><a href='?menu=$menu&uid=$uid&page=view_wanita_rekap_kebaya&id=$row[id_client]'><img border='0' src='images/view.png' title='Lihat Data'></a></td>";

$htmlData .= "</td></tr>";
//htmlData
};//end-while

?>
<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Data Pesanan</b></font>

	 <table width="100%" border="0" cellpadding="5" cellspacing="0">
	  <tr>
		 <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
     <td valign="bottom"><b>Bulan Kegiatan:
<select name="bulan_rencana">
<option value="%">-All-</option>
<?
$rb=mysql_query("select distinct date_format(tanggal,'%m') bulan from acara");
for($bl=0;$bl<@mysql_num_rows($rb);$bl++){
$bulan=mysql_result($rb,$bl,"bulan");
echo "<option ";
if($bulan==$bulan_rencana)echo " selected ";
echo "value='$bulan'>".nama_bulan($bulan)."</option>";
}
?>
</select> - 
<select name="thn_rencana">
<option value="%">-All-</option>
<?
$rb=mysql_query("select distinct date_format(tanggal,'%Y') thn from acara");
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
			 <b><a href="<?="?menu=$menu&uid=$uid&page=r_ukuran_backroom";?>">List All</a> <!--| <a href="<?//="?menu=$menu&uid=$uid&page=pesanan_cari";?>">Cari</a>--></b>
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
        <!--===== bgcolor='#A7A7A7'=====-->
		<tr bgcolor='#A7A7A7' height="25">
			<td align='center'>NO</td>
			<td align='center'>NAMA CPW</td>
			<td align='center'>ALAMAT CPW</td>
			<td align='center'>HP CPW</td>
			<td align='center'>Tgl Rencana</td>
            <td align='center'>Petugas CS</td>
            <td align='center'>Busana &amp;<br /> No Tas</td>
            <td align='center'>Make Up <br/> Spesial</td>
            <td align='center'>Make Up <br/> Standar</td>
            <td align='center'>Ukuran Kebaya </td>
            <td align='center'>Rekap Kebaya </td>
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