<?PHP
include_once("include.php");
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-disposition:  attachment; filename=r_busana_client.xls");




$pageFilter ="&tanggal=$tanggal&tanggal2=$tanggal2&id_client=$id_client";
                
				//if (!$tanggal) {$tanggal=date(now(),'%Y-%m-1');}
				//if (!$tanggal2) {$tanggal2=date(now(),'%Y-%m-%d');}
                if ($id_client==0) {$id_client='%';}
				if($id_client !="") { $filterSQL = " and a.id_client like '$id_client' "; }				
				if($tanggal !="" && tanggal2 !="") {$filterSQL .= " and tanggal BETWEEN '$tanggal' AND '$tanggal2' ";}
				if($tanggal !="" && tanggal2 !="") {$filterSQL1 = " and tanggal BETWEEN '$tanggal' AND '$tanggal2' ";}
			
//echo $filterSQL;

			
$runSQL = "select count(*) total from 
(select distinct a.id_client,a.id_acara,a.tanggal, a.waktu, a.created, b.acara,a.tempat,
c.nama_cpw,c.nama_cpp CP,e.detail_layanan
from acara a,p_acara b,client c,paket_sub_paket d,p_sublayanan e, client_busana g,p_baju_tipe h,p_baju i,p_baju_tipe j,p_baju k
where 1=1 $filterSQL
and a.id_acara=b.id_acara 
and a.id_client=c.id_client
and a.id_paket=d.id_paket    
and a.id_acara=g.id_acara 
and a.id_client=g.id_client 
and a.id_paket=g.id_paket
and d.id_sublayanan=g.id_plus
and g.id_plus=e.id_sublayanan 
and g.id_tipe_baju=h.id_tipe_baju
and g.id_tipe_baju=i.id_tipe_baju
and g.id_baju=i.id_layanan
and g.id_tipe_kain=j.id_tipe_baju
and g.id_tipe_kain=k.id_tipe_baju
and g.id_kain=k.id_layanan ) b ";
		
$result = mysql_query($runSQL, $connDB);
if ($row = mysql_fetch_array ($result)) { $totalRecord = $row[total]; };
$listRecord = 30;
$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter$cari&pnum=";
pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord);

//echo $runSQL;



$runSQL = "	select distinct a.id_client,a.id_acara,a.tanggal, a.waktu, a.created, b.acara,a.tempat,
c.nama_cpw,c.nama_cpp,e.detail_layanan,h.keterangan tipe_baju,i.layanan jns_baju,g.jml_baju,
j.keterangan tipe_kain,k.layanan jns_kain,g.jml_kain
from acara a,p_acara b,client c,paket_sub_paket d,p_sublayanan e, client_busana g,p_baju_tipe h,p_baju i,p_baju_tipe j,p_baju k
where 1=1 $filterSQL 
and a.id_acara=b.id_acara 
and a.id_client=c.id_client
and a.id_paket=d.id_paket    
and a.id_acara=g.id_acara 
and a.id_client=g.id_client 
and a.id_paket=g.id_paket
and d.id_sublayanan=g.id_plus
and g.id_plus=e.id_sublayanan 
and g.id_tipe_baju=h.id_tipe_baju
and g.id_tipe_baju=i.id_tipe_baju
and g.id_baju=i.id_layanan
and g.id_tipe_kain=j.id_tipe_baju
and g.id_tipe_kain=k.id_tipe_baju
and g.id_kain=k.id_layanan
order by tanggal desc,id_client asc
LIMIT $offsetRecord, $listRecord  ";

?>



<table width='1000' cellspacing='1' cellpadding='3'>
<tr bgcolor='#A7A7A7' height="25" align="center">
	<td>No</td>
	<td>Tanggal Acara</td>
	<td>Waktu</td>
	<td>Nama Pengantin</td>
	<td>Acara</td>
	<td>Tempat</td>
	<td>Layanan</td>
	<td>Jenis Baju</td>
	<td>Jml Baju</td>
	<td>Jenis Kain</td>
	<td>Jml Kain</td>	
</tr>
<?
$res=mysql_query($runSQL);
//echo $runSQL;
while($rec=mysql_fetch_array($res))
{
	$ccc++;
	if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
echo "
<tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
    <td align='center'>".($offsetRecord+$ccc)."</td>";
?>
	<td><?= $rec['tanggal'];?></td>
	<td><?= $rec['waktu'];?></td>
	<td><?= $rec['nama_cpw'];?>/<?= $rec['nama_cpp'];?></td>
	<td><?= $rec['acara'];?></td>
	<td><?= $rec['tempat'];?></td>
	<td><?= $rec['detail_layanan']; ?></td>
	<td><?= $rec['tipe_baju'];?>/<?= $rec['jns_baju'];?></td>
	<td><?= $rec['jml_baju']; ?></td>
	<td><?= $rec['tipe_kain'];?>/<?= $rec['jns_kain'];?></td>
	<td><?= $rec['jml_kain']; ?></td>

</td>
</tr>
<? 

}

//echo $runSQL;
?>
</table>
