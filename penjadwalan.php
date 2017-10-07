<? 
// Sisten Informasi Sanggar LIZA
// Written agusari@gmail.com
// 11/5/2010

include_once("include.php");
include_once("p_bulan.php");

//echo $bulan_rencana;

//================================================================================================================
//if ($cari <> ""){ 
//	$cariSQL = strtoupper($cari);
//	$filterSQL = " and upper(nama_cpw) like '%$cariSQL%' or upper(nama_cpp) like '%$cariSQL%' ";
//};//if
//
//if($act=="delete_acara"){
//$sql="delete from acara where id_client='$id'";
//@mysql_query($sql);
//$sql="delete from client_diskon where id_client='$id'";
//@mysql_query($sql);
//$sql="delete from pegawai_tugas where id_client='$id'";
//@mysql_query($sql);
//$sql="delete from pesanan_plus where id_client='$id'";
//@mysql_query($sql);
//$act=null;
//}

$pageFilter ="&thn_rencana=$thn_rencana&bulan_rencana=$bulan_rencana&id_layanan2=$id_layanan2";
//=================================================================================================================
if($bulan_rencana!="")
 	{$filterSQL = " and tgl_acara like '%-$bulan_rencana-$thn_rencana' ";}
 
if($id_layanan2 !="") 
	{$filterSQL .= " and id_layanan like '$id_layanan2' ";}
	
$runSQL = "	select count(*) total from 
			(select * from ( select distinct a.id_client,a.id_acara,date_format(a.tanggal,'%d-%m-%Y') tgl_acara,b.acara,a.tempat,
			c.nama_cpw,c.nama_cpp,f.layanan,f.id_layanan,d.jml_orang from acara a,p_acara b,client c,paket_sub_paket d,
			p_sublayanan e,p_layanan f where a.id_acara=b.id_acara and a.id_client=c.id_client and a.id_paket=d.id_paket 
			and d.id_sublayanan=e.id_sublayanan and e.id_layanan=f.id_layanan union select distinct a.id_client,a.id_acara,
			date_format(a.tanggal,'%d-%m-%Y') tgl_acara,b.acara,a.tempat,c.nama_cpw,c.nama_cpp,f.layanan,f.id_layanan,d.jml_orang 
			from acara a,p_acara b,client c,pesanan_plus d,p_sublayanan e,p_layanan f where a.id_acara=b.id_acara and a.id_client=c.id_client 
			and a.id_client=d.id_client and a.id_acara=d.id_acara and d.id_sublayanan=e.id_sublayanan and e.id_layanan=f.id_layanan ) a 
			where 1=1 $filterSQL group by id_client, id_acara, tgl_acara,acara, tempat, nama_cpw, nama_cpp, layanan, id_layanan) b ";
//echo $runSQL;
$result = mysql_query($runSQL, $connDB);
if ($row = mysql_fetch_array ($result)) { $totalRecord = $row[total]; };
$listRecord = 30;

$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter$cari&pnum=";
pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord);


unset($ii);
$runSQL = "select id_client, id_acara, tgl_acara,acara, tempat, nama_cpw, nama_cpp, layanan, id_layanan, sum(jml_orang) jml
 from 
(
select distinct a.id_client,a.id_acara,date_format(a.tanggal,'%d-%m-%Y') tgl_acara,b.acara,a.tempat,c.nama_cpw,c.nama_cpp,f.layanan,f.id_layanan,d.jml_orang
from
acara a,p_acara b,client c,paket_sub_paket d,p_sublayanan e,p_layanan f
where a.id_acara=b.id_acara and a.id_client=c.id_client and a.id_paket=d.id_paket and d.id_sublayanan=e.id_sublayanan and e.id_layanan=f.id_layanan
union
select distinct a.id_client,a.id_acara,date_format(a.tanggal,'%d-%m-%Y') tgl_acara,b.acara,a.tempat,c.nama_cpw,c.nama_cpp,f.layanan,f.id_layanan,d.jml_orang
from
acara a,p_acara b,client c,pesanan_plus d,p_sublayanan e,p_layanan f
where a.id_acara=b.id_acara and a.id_client=c.id_client and a.id_client=d.id_client and a.id_acara=d.id_acara and d.id_sublayanan=e.id_sublayanan and e.id_layanan=f.id_layanan
) a
where 1=1 $filterSQL 
group by id_client, id_acara, tgl_acara,acara, tempat, nama_cpw, nama_cpp, layanan, id_layanan
order by id_client desc,id_acara asc,layanan asc
LIMIT $offsetRecord, $listRecord";
//echo $runSQL;
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) {
	$id_acara=$row[id_acara];
	$id_client=$row[id_client];
	$id_layanan=$row[id_layanan];
	$ccc++;
	if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
	if($row[id_client]!=$n){
	$htmlData .= "
	  <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
		  <td align='center'>".($offsetRecord+$ccc)."</td>
		  <td nowrap> $row[nama_cpw] / $row[nama_cpp]</td>";
	}else{
		$htmlData .= "
	  <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
		  <td align='center'>".($offsetRecord+$ccc)."</td>
		  <td>&nbsp;</td>";
	}
	$htmlData.="
		  <td nowrap> $row[tgl_acara] </td>
		  <td nowrap> $row[acara] </td>
		  <td nowrap> $row[tempat] </td>
		  <td> $row[layanan] </td>";
$sl="select count(*) jml from pegawai_tugas where id_acara='$id_acara' and id_client='$id_client' and id_pekerjaan='$id_layanan'";
//echo "$sl<br>";
$nl=mysql_query($sl);$l=mysql_result($nl,0,"jml");
//$htmlData .= "<td align='center' nowrap>&nbsp;</td><td align='center' nowrap>&nbsp;";

$htmlData .= "<td align='center' nowrap>";
$htmlData .= "<a href='?menu=$menu&uid=$uid&page=penjadwalan_edit&id=$row[id_client]&id_acara=$row[id_acara]&id_layanan=$row[id_layanan]'><img border='0' src='images/edit.gif' title='Update Penjadwalan'></a></td>
<td align='center' nowrap>";
if ($l==$row[jml])$htmlData .= "<img src='images/status.gif' border=0>";
$htmlData .= "$row[jml] <a href=javascript:void(window.open('?menu=$menu&uid=$uid&page=acara_sumberdaya&id_client=$row[id_client]&id_acara=$row[id_acara]&id_layanan=$row[id_layanan]','Petugas','toolbar=1,width=800,height=500'))><img border='0' src='images/res.gif' height=16 width=16 title='Petugas'></a></td>";
/*
<a href=\"javascript:void(window.open('assign_petugas.php?id_client=$id_client&id_acara=$id_acara,'operator','toolbar=0,width=500,height=200'));\">

if($SAH[id_group]==1){
$htmlData .= "
		  <a href='?menu=$menu&uid=$uid&page=penjadwalan&id=$row[id_client]&act=delete_acara'><img border='0' src='images/del.gif' title='Hapus penjadwalan' qidth=16 height=16></a>
";
}
*/
$htmlData .= "</td></tr>";//htmlData
$n=$row[id_client];
};//end-while

?>
<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Data Penjadwalan</b></font>

	 <table width="100%" border="0" cellpadding="5" cellspacing="0">
	  <tr>
		 <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
     <td valign="bottom"><b>Bulan :
<select name="bulan_rencana">
<option value="%">-All-</option>
<?
$rb=mysql_query("select distinct date_format(tanggal,'%m') bulan from acara order by tanggal asc");
for($bl=0;$bl<@mysql_num_rows($rb);$bl++){
$bulan=mysql_result($rb,$bl,"bulan");
echo "<option ";
if($bulan==$bulan_rencana)echo " selected ";
echo "value='$bulan'>".nama_bulan($bulan)."</option>";
}
?>
</select> - 
<select name="thn_rencana">
<option value="%">-aLL-</option>
<?
$rb=mysql_query("select distinct date_format(tanggal,'%Y') thn from acara order by tanggal asc");
for($bl=0;$bl<@mysql_num_rows($rb);$bl++){
$thn=mysql_result($rb,$bl,"thn");
echo "<option ";
if($thn==$thn_rencana)echo " selected ";
echo "value='$thn'>$thn</option>";
}
?>
</select>





<? //if($act=="cari"){ ?>
<b>  Pelayanan : <select name="id_layanan2"><option value="">-aLL-</option>
		<?
		$ja=mysql_query("select * from p_layanan order by layanan asc");
		while($bj=mysql_fetch_array($ja))
		{
			echo "<option ";
			if($bj['id_layanan']==$id_layanan2) {echo " selected=selected ";}
			echo "value='".$bj['id_layanan']."'>".$bj['layanan']."</option>";
		}
		?>
		</select>

<? //$act=null; } ?>
			 <input type="submit" name="run" value="  Go  " class="button">
		 </td>
     <td valign="bottom" align="right">
			 <img src="images/arrow2.gif" border="0">
			 <b><a href="<?="?menu=$menu&uid=$uid&page=penjadwalan";?>">List All</a> 
			 
			 <!--| <a href="<?="?menu=$menu&uid=$uid&page=penjadwalan&act=cari";?>">Cari</a>--></b>
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
			<td align='center'>NAMA CPW/CPP</td>
			<td align='center'>Tanggal</td>
			<td align='center'>Acara</td>
			<td align='center'>Tempat</td>
			<td align='center'>Layanan</td>
			<td align='center'>Detail</td>
			<td align='center'>Petugas</td>
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