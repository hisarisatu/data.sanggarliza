<?PHP
include_once("include.php");
header("Content-Type: application/vnd.ms-excel; name='excel'");
header("Content-disposition:  attachment; filename=report_jadwal.xls");




		if($id_pegawai !="") 
			{ $filterSQL = " and id_pegawai like '$id_pegawai' "; }
		if($tanggal !="" && tanggal2 !="")
 			{$filterSQL .= " and tanggal BETWEEN '$tanggal' AND '$tanggal2' ";}
		if($id_layanan !="") 
			{ $filterSQL .= " and id_layanan like '$id_layanan' "; }

if($id_pegawai !="")
{
/*$runSQL = "select c.id_client, a.waktu, a.created, a.id_acara, a.tanggal, b.acara, a.tempat, c.nama_cpw, c.nama_cpp, f.layanan, f.id_layanan, sum(g.jml_orang) jml, h.nama, d.id_pegawai
from acara a, p_acara b, client c, pegawai_tugas d, p_sublayanan e, p_layanan f, paket_sub_paket g, pegawai h
where a.id_acara=b.id_acara and a.id_client=c.id_client and a.id_client=d.id_client and a.id_acara=d.id_acara and d.id_tugas=e.id_sublayanan and e.id_layanan=f.id_layanan and a.id_paket=g.id_paket and e.id_sublayanan=g.id_sublayanan and h.id_pegawai=d.id_pegawai
 ";*/
 

$runSQL = "	select id_client, waktu, created, id_acara, tanggal,acara, tempat, nama_cpw, nama_cpp, layanan, id_layanan, sum(jml_orang) jml, nama
			from ( 
			select distinct a.id_client,a.id_acara,a.tanggal, a.waktu, a.created, b.acara,a.tempat,c.nama_cpw,c.nama_cpp,f.layanan,f.id_layanan,d.jml_orang, g.id_pegawai,h.nama 
			from acara a,p_acara b,client c,paket_sub_paket d, p_sublayanan e,p_layanan f, pegawai_tugas g, pegawai h 
			where a.id_acara=b.id_acara and a.id_client=c.id_client and a.id_paket=d.id_paket and d.id_sublayanan=e.id_sublayanan and e.id_layanan=f.id_layanan  and g.id_tugas=e.id_sublayanan and a.id_client=g.id_client and g.id_pegawai=h.id_pegawai
			union
			select distinct a.id_client,a.id_acara,a.tanggal, a.waktu, a.created, b.acara,a.tempat,c.nama_cpw,c.nama_cpp,f.layanan,f.id_layanan,d.jml_orang, g.id_pegawai,h.nama   
			from acara a,p_acara b,client c,pesanan_plus d,p_sublayanan e,p_layanan f, pegawai_tugas g, pegawai h  
			where a.id_acara=b.id_acara and a.id_client=c.id_client and a.id_client=d.id_client and a.id_acara=d.id_acara and d.id_sublayanan=e.id_sublayanan and e.id_layanan=f.id_layanan and g.id_tugas=e.id_sublayanan and a.id_client=g.id_client and g.id_pegawai=h.id_pegawai ) a where 1=1 $filterSQL 
			group by id_client, id_acara, tanggal,acara, tempat, nama_cpw, nama_cpp, layanan, id_layanan
			order by tanggal asc,id_client asc,layanan asc " ; 
}
else
{
$runSQL = "select id_client, waktu, created, id_acara, tanggal ,acara, tempat, nama_cpw, nama_cpp, layanan, id_layanan, sum(jml_orang) jml
 from 
(
select distinct a.id_client,a.id_acara,a.tanggal, a.waktu, a.created, b.acara,a.tempat,c.nama_cpw,c.nama_cpp,f.layanan,f.id_layanan,d.jml_orang
from
acara a,p_acara b,client c,paket_sub_paket d,p_sublayanan e,p_layanan f
where a.id_acara=b.id_acara and a.id_client=c.id_client and a.id_paket=d.id_paket and d.id_sublayanan=e.id_sublayanan and e.id_layanan=f.id_layanan
union
select distinct a.id_client,a.id_acara,a.tanggal,a.waktu, a.created,b.acara,a.tempat,c.nama_cpw,c.nama_cpp,f.layanan,f.id_layanan,d.jml_orang
from
acara a,p_acara b,client c,pesanan_plus d,p_sublayanan e,p_layanan f
where a.id_acara=b.id_acara and a.id_client=c.id_client and a.id_client=d.id_client and a.id_acara=d.id_acara and d.id_sublayanan=e.id_sublayanan and e.id_layanan=f.id_layanan
) a
where 1=1 $filterSQL group by id_client, id_acara, tanggal,acara, tempat, nama_cpw, nama_cpp, layanan, id_layanan
			order by tanggal asc,id_client asc,layanan asc";
}


/*if($id_pegawai !="") 
{ 
	$runSQL .= " and d.id_pegawai like '$id_pegawai' ";
	if($tanggal !="" && tanggal2 !="")
		{$runSQL .= " and a.tanggal BETWEEN '$tanggal' AND '$tanggal2' ";}
	if($id_layanan !="") 
		{ $runSQL .= " and e.id_layanan like '$id_layanan' "; }
		
	$runSQL .=" group by c.id_client, a.id_acara, tanggal, b.acara, a.tempat, c.nama_cpw, c.nama_cpp, f.layanan, f.id_layanan
order by tanggal asc, c.id_client asc, f.layanan asc";
}

else
{
	if($tanggal !="" && tanggal2 !="")
 		{$runSQL .= " and tanggal BETWEEN '$tanggal' AND '$tanggal2' ";}
	if($id_layanan !="") 
		{ $runSQL .= " and id_layanan like '$id_layanan' "; }
		
	$runSQL .=" group by id_client, id_acara, tanggal, acara, tempat, nama_cpw, nama_cpp, layanan, id_layanan
				order by tanggal asc,id_client asc,layanan asc ";
}*/


?>


<table width='850' border="1" cellspacing='1' cellpadding='3'>
<tr bgcolor='#A7A7A7' height="25" align="center">
	<td>No</td>
	<td>Tanggal Acara</td>
	<td>Waktu</td>
	<td>Jenis Layanan</td>
	<td>Nama Pengantin</td>
	<td>Acara</td>
	<td>Tempat</td>
	<td>Pelaksana</td>
	<td>Status</td>
	<td>Tgl Booking</td>
</tr>

<?

$res=mysql_query($runSQL);
if($id_pegawai=="")
{
	for($a=0;$a<@mysql_num_rows($res);$a++){
	$id_acara=mysql_result($res,$a,"id_acara");
	$id_client=mysql_result($res,$a,"id_client");
	$id_layanan=mysql_result($res,$a,"id_layanan");
		$ccc++;
		$sl=mysql_query("select a.id_pegawai, a.nama from pegawai a, pegawai_tugas b where b.id_acara='$id_acara' and b.id_client='$id_client' and b.id_pekerjaan='$id_layanan' and a.id_pegawai=b.id_pegawai ");
	
		if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
	echo "
	<tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
		<td align='center'>".($offsetRecord+$ccc)."</td>";?>
		<td><?= mysql_result($res,$a,"tanggal");?></td>
		<td><?=mysql_result($res,$a,"waktu")?></td>
		<td><?=mysql_result($res,$a,"layanan")?></td>
		<td><?=mysql_result($res,$a,"nama_cpw")?>/<?=mysql_result($res,$a,"nama_cpp")?></td>
		<td><?=mysql_result($res,$a,"acara")?></td>
		<td><?=mysql_result($res,$a,"tempat")?></td>
		<td>
		<?
			while($nama=mysql_fetch_array($sl))
			{
				echo $nama['nama'];
				echo "<br>";
			}
		?>
		</td>
		<td></td>
		<td><?=mysql_result($res,$a,"created")?></td>
	</td>
	</tr>
	<? }
} ?>
<?
if($id_pegawai!="")
{
while($rec=mysql_fetch_array($res))
{
	$ccc++;
	if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
echo "
<tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
    <td align='center'>".($offsetRecord+$ccc)."</td>";?>
	<td><?= $rec['tanggal'];?></td>
	<td><?= $rec['waktu'];?></td>
	<td><?= $rec['layanan'];?></td>
	<td><?= $rec['nama_cpw'];?>/<?= $rec['nama_cpp'];?></td>
	<td><?= $rec['acara'];?></td>
	<td><?= $rec['tempat'];?></td>
	<td><?= $rec['nama']; ?></td>
	<td></td>
	<td><?=$rec['created'];?></td>
</td>
</tr>
<? }
} ?>
</table>