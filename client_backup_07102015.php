<? 
// Sisten Informasi Sanggar LIZA
// Written by iyok642@yahoo.com; 031-70920002
// 23 Agustus 2010, lastupdate 23 Agustus 2010

include_once("include.php");
include_once("p_bulan.php");

if($act=="delete_record"){
$sql="delete from client where id_client='$id'";
@mysql_query($sql);
$sql="delete from acara where id_client='$id'";
@mysql_query($sql);
$sql="delete from client_bayar where id_client='$id'";
@mysql_query($sql);
$sql="delete from client_busana where id_client='$id'";
@mysql_query($sql);
$sql="delete from client_diskon where id_client='$id'";
@mysql_query($sql);
$sql="delete from konsultasi where id_client='$id'";
@mysql_query($sql);
$sql="delete from pegawai_tugas where id_client='$id'";
@mysql_query($sql);
$sql="delete from pengeluaran where id_client='$id'";
@mysql_query($sql);
$sql="delete from pesanan_plus where id_client='$id'";
@mysql_query($sql);
$act=null;
}

//echo $bulan_rencana;
if ($cari <> ""){ 
	$cariSQL = strtoupper($cari);
	$filterSQL = " and upper(nama_cpw) like '%$cariSQL%' or upper(nama_ortu_cpw) like '%$cariSQL%' or upper(tlp_rumah_cpw) like '%$cariSQL%' or upper(tlp_mobile_cpw) like '%$cariSQL%' or upper(alamat_cpw) like '%$cariSQL%' or upper(nama_cpp) like '%$cariSQL%' or upper(nama_ortu_cpp) like '%$cariSQL%' or upper(tlp_rumah_cpp) like '%$cariSQL%' or upper(tlp_mobile_cpp) like '%$cariSQL%' or upper(alamat_cpp) like '%$cariSQL%' ";
};//if

if($bulan_rencana!="")
 	$filterSQL .= " and tgl_rencana like '$thn_rencana-$bulan_rencana-%' ";
if($nama_cpw!="")
	$filterSQL .=" and nama_cpw like '%$nama_cpw%' ";
$pageFilter ="&thn_rencana=$thn_rencana&bulan_rencana=$bulan_rencana&nama_cpw=$nama_cpw";
$runSQL = "select count(*) total from client where 1=1 $filterSQL";
//echo $runSQL;
$result = mysql_query($runSQL, $connDB);
if ($row = mysql_fetch_array ($result)) { $totalRecord = $row[total]; };
$listRecord = 20;
$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter&cari=$cari&pnum=";
pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord);

unset($ii);
$runSQL = "select id_client, nama_cpw, nama_ortu_cpw, tlp_rumah_cpw, tlp_mobile_cpw, alamat_cpw, nama_cpp, nama_ortu_cpp, tlp_rumah_cpp, tlp_mobile_cpp, alamat_cpp, tgl_rencana, catatan, last_update,date_format(tgl_rencana,'%d-%m-%Y') tgl_rencana from client where 1=1 $filterSQL order by id_client desc LIMIT $offsetRecord, $listRecord";//echo $runSQL;
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) {
	$ccc++;
	if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
	$htmlData .= "
	  <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
		  <td align='center'>".($offsetRecord+$ccc)."</td>
		  <td nowrap> $row[nama_cpw] </td>
		  <td> $row[nama_ortu_cpw] </td>
		  <td> $row[tlp_mobile_cpw] </td>
		  <td> $row[alamat_cpw] </td>
		  <td nowrap> $row[nama_cpp] </td>
		  <td> $row[nama_ortu_cpp] </td>
		  <td> $row[tlp_mobile_cpp] </td>
		  <td> $row[alamat_cpp] </td> ";
/*
$rch=mysql_query("select tanggal from acara where id_client='$row[id_client]' order by created desc");
$nc=@mysql_num_rows($rch);
if($nc!=0){
  $tg=mysql_result($rch,0,"tanggal");    
} else {
  $tg=$row[tgl_rencana];
}*/
$htmlData .= "<td align='center' nowrap>$row[tgl_rencana]";

if($SAH[id_group]==1){
$htmlData .= "</td><td align='center' nowrap>";
$htmlData .= "
		  <a href='?menu=$menu&uid=$uid&page=client_input&id=$row[id_client]'><img border='0' src='images/edit.gif' title='Edit Data'></a>
		  <a href='?menu=$menu&uid=$uid&page=client_delete&id=$row[id_client]'><img border='0' src='images/del.gif' title='Hapus Data'></a>
";
}
$htmlData .= "</td></tr>";//htmlData
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
$rb=mysql_query("select distinct date_format(tgl_rencana,'%Y') thn from client where tgl_rencana != '0000-00-00'");
while($thn=mysql_fetch_array($rb))
{
	echo "<option ";
	if($thn['thn']==$thn_rencana)echo " selected ";
	echo "value='".$thn['thn']."'>".$thn['thn']."</option>";
}
?>
</select>
			
			 <b> &nbsp; Nama CPW : <input type="text" name="nama_cpw" value="<?=$nama_cpw;?>" size="30">
			 
			 <input type="submit" name="run" value="  Go  " class="button">
		 </td>
     <td valign="bottom" align="right">
			 <img src="images/arrow2.gif" border="0">
			 <b><a href="<?="?menu=$menu&uid=$uid&page=client";?>">List All</a> <!--| <a href="<?//= "?menu=$menu&uid=$uid&page=client&act=cari";?>">Cari</a>--></b>
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
			<td align='center'>ORTU CPW</td>
			<td align='center'>HP CPW</td>
			<td align='center'>ALAMAT CPW</td>
			<td align='center'>NAMA CPP</td>
			<td align='center'>ORTU CPP</td>
			<td align='center'>HP CPP</td>
			<td align='center'>ALAMAT CPP</td>
			<td align='center'>TGL RENCANA</td>
			<? if($SAH[id_group]==1){ ?>
			<td align='center'>EDIT<br>HAPUS</td>
			<? } ?>
		</tr>
		<?	if($act!="cari"){
				echo $htmlData;
			}?>
		<tr>
		  <td colspan="12" align="left">
			Halaman : <?=$pnumlink;?> &nbsp; Total : <b><?=$totalPage;?></b> halaman, <?=$totalRecord?> record.
			</td>
		</tr>
	 </table>

   </td>
  </tr>
</table>