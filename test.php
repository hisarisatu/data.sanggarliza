<?php 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 10 Oktober 2010, lastupdate 10 Oktober 2010

include_once("include.php");
include_once("p_bulan.php");

if($bulan_rencana!="")
 $filterSQL = " and a.tanggal like '$thn_rencana-$bulan_rencana-%' ";
if($nama_cpw!="")
	$filterSQL .=" and nama_cpw like '%$nama_cpw%' ";
$pageFilter ="&thn_rencana=$thn_rencana&bulan_rencana=$bulan_rencana&nama_cpw=$nama_cpw";

$runSQL="select count(1)total
    from acara a
  join p_acara b on a.id_acara=b.id_acara
  join client c  on a.id_client=c.id_client 
  $filterSQL
  ";
#echo "<pre>".print_r($sql_run,true)."</pre>";exit;
#$runSQL = "SELECT count(*) total FROM `acara` a, p_acara b, client c 
#        WHERE a.id_acara = b.id_acara AND a.id_client = c.id_client $filterSQL";

$result = mysql_query($runSQL, $connDB);
if ($row = mysql_fetch_array ($result)) { $totalRecord = $row[total]; };
$listRecord = 20;
$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter&cari=$cari&pnum=";
pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord);

unset($ii);
#$runSQL = "SELECT distinct date_format(a.tanggal,'%d-%m-%Y') tgl_acara, b.acara, c.nama_cpw, c.nama_cpp, a.tempat,a.id_client,a.id_acara
#FROM `acara` a, p_acara b, client c
#where a.id_client=c.id_client
#and a.id_acara=b.id_acara 
#$filterSQL order by tanggal desc 
#LIMIT $offsetRecord, $listRecord"; //echo $runSQL;//developer
$runSQL ="select a.id_client,CONCAT(c.nama_cpw, ' / ', c.nama_cpp) nama_cpwcpp
      ,c.nama_cpw, c.nama_cpp  
      ,date_format(a.tanggal,'%d-%m-%Y')tgl_acara,b.acara
      ,a.tempat,b.id_produk,a.id_acara 
    from acara a
  join p_acara b on a.id_acara=b.id_acara
  join client c  on a.id_client=c.id_client  
  $filterSQL order by tanggal desc 
  LIMIT $offsetRecord, $listRecord
  ";


$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) {
	$ccc++;
	if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
	$htmlData .= "
	  <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"'>
		  <td align='center'>".($offsetRecord+$ccc)."</td>
                  <td> ";
          //if($row[nama_cpw]!=$rp)
          $htmlData .=$row[nama_cpw]." / ".$row[nama_cpp];
          $htmlData .= "</td>
		  <td align=center> $row[tgl_acara] </td>
		  <td> $row[acara] </td>
		  <td> $row[tempat] </td>
                  <td> STS </td>    
		  <td align='center' nowrap>
<a href='?menu=$menu&uid=$uid&page=assign_view&id_acara=$row[id_acara]&id=$row[id_client]'><img border='0' src='images/view.png' height=20 width=20 title='Lihat Petugas'></a>
		  </td>
<td align='center' nowrap>
    <a href='?menu=$menu&uid=$uid&page=acara_sumberdaya&id_client=$row[id_client]&id_acara=$row[id_acara]'><img border='0' src='images/edit.gif' height=16 width=16 title='Sumber Daya Acara'></a>
</td>
	  </tr>
	";//htmlData
$rp=$row[nama_cpw];
};//end-while

?>
<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Data Pesanan External</b></font>

	 <table width="100%" border="0" cellpadding="5" cellspacing="0">
	  <tr>
		 <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=test";?>">
     <td valign="bottom"><b>Bulan Kegiatan: 
<select name="bulan_rencana">
<option value="%">-All-</option>
<?php
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
<?php
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
			 <a href="<?="?menu=$menu&uid=$uid&page=sumberdaya";?>"><b>List All</b></a>
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
                        <td align='center'>NAMA CPW / CPP</td>
			<td align='center'>TANGGAL</td>
			<td align='center'>ACARA</td>
			<td align='center'>TEMPAT</td>
                        <td align='center'>STATUS</td>
			<td align='center'>Pegawai</td>
                        <td align='center'>SumberDaya</td>
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
