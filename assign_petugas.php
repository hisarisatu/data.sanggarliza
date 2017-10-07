<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 10 Oktober 2010, lastupdate 10 Oktober 2010

include_once("include.php");
if (($SAH[id_group]==3) or ($SAH[id_group]==1) or ($SAH[id_group]==12))
{
if($id_client=="")$id_client=$id;
$sql="select date_format(a.tanggal,'%d-%m-%Y') tgl_acara,a.tanggal,b.acara,c.nama_cpw,c.nama_cpp from acara a, p_acara b, client c where a.id_acara='$id_acara' and a.id_client='$id_client' and a.id_acara=b.id_acara and a.id_client=c.id_client";
//echo $sql;
$rs=mysql_query($sql);
$tgl_acara=mysql_result($rs,0,"tgl_acara");
$tgl=mysql_result($rs,0,"tanggal");

$sj="select sum(jml_orang) jumlah from (select distinct b.id_layanan,a.jml_orang,b.detail_layanan,b.id_sublayanan from paket_sub_paket a, p_sublayanan b, acara c where a.id_sublayanan=b.id_sublayanan and a.id_paket=c.id_paket and c.id_client='$id_client' and c.id_acara='$id_acara' and b.id_layanan='$id_layanan'
union
select distinct b.id_layanan,a.jml_orang,b.detail_layanan,b.id_sublayanan from pesanan_plus a,p_sublayanan b where a.id_sublayanan=b.id_sublayanan and a.id_acara='$id_acara' and a.id_client='$id_client' and b.id_layanan='$id_layanan') a";
$rj=mysql_query($sj);
$jumlah=mysql_result($rj,0,"jumlah");
//echo $sj;
?>
<table cellpadding=3 cellspacing=0 style="border-width: 4px;  border-style: double;">
<tr><td>Tanggal</td><td>: <?=$tgl_acara?></td></tr>
<tr><td>Acara</td><td>: <?=mysql_result($rs,0,"acara")?></td></tr>
<tr><td>Client</td><td>: <?=mysql_result($rs,0,"nama_cpw")?> / <?=mysql_result($rs,0,"nama_cpp")?></td></tr>
<tr><td>Tugas</td><td>: 
	<?
	$sql="select layanan from p_layanan where id_layanan='$id_layanan'";
	$dl=@mysql_query($sql);
	echo @mysql_result($dl,0,"layanan");
	?></td></tr>
<tr><td>Jumlah</td><td>: <?=$jumlah?></td></tr>
</table><br>
<?

if($act=="proses"){
$cp=count($pegawai);
if($cp>$jumlah){
  echo "Hanya membutuhkan $jumlah";
} else {
for($c=0;$c<count($pegawai);$c++){
$sql="insert into pegawai_tugas values ('$id_acara','$id_client','$tgl','$id_layanan','$id_tugas','$pegawai[$c]','$SAH[id_user]', '$REMOTE_ADDR', now(),null,null,null)";
//echo "<br>$sql";
mysql_query($sql);
}
}
$act=null;
}

if($act=="hapus"){
//print_r($pegawai);
for($c=0;$c<count($pegawai);$c++){
$sql="delete from pegawai_tugas where id_pegawai='$pegawai[$c]' and id_pekerjaan='$id_layanan' and tanggal='$tgl'";
//echo "<br>$sql";
mysql_query($sql);
}
$act=null;
}

?>
<form method="post" action="<?="?menu=$menu&uid=$uid&page=$page&act=proses&id_layanan=$id_layanan&id_client=$id_client&id_acara=$id_acara&id_tugas=$id_tugas&jumlah=$jumlah";?>">
FREE
<table cellpadding=3 cellspacing=0 style="border-width: 4px;  border-style: double;">
<tr valign=top>
<td>
<?
$rsc=mysql_query("select * from pegawai where id_pegawai in (select id_pegawai from pegawai_pekerjaan where id_pekerjaan='$id_layanan') and id_pegawai not in (select id_pegawai from pegawai_tugas where tanggal='$tgl' and id_acara='$id_acara' and id_client='$id_client')");
$jml=@mysql_num_rows($rsc);
$maxrow=ceil($jml/4);
echo "<table cellpadding=3 cellspacing=0>";
for($b=0;$b<$jml;$b++){
echo "<tr>";
echo "<td>";echo "<input type='checkbox' value='";
echo mysql_result($rsc,$b,"id_pegawai");
echo "' name='pegawai[]'>&nbsp;";
echo mysql_result($rsc,$b,"nama");
echo "</td>";
echo"</tr>";
if(($b+1)%$maxrow==0 && $b!=0)echo "</table></td><td><table cellpadding=3 cellspacing=0>";
}
?>
</table>
</td>
</tr>
</table>
<?
$sqc="select * from pegawai where id_pegawai in (select id_pegawai from pegawai_pekerjaan where id_pekerjaan='$id_layanan') and id_pegawai in (select id_pegawai from pegawai_tugas where tanggal='$tgl' and id_acara='$id_acara' and id_client='$id_client')";
//echo $sqc;
$rsc=mysql_query($sqc);
$jml=@mysql_num_rows($rsc);
?>
<center><br><input <? if($jml==$jumlah) echo " disabled "; ?> type="submit" value="tugaskan"></center>
</form>
<form method="post" action="<?="?menu=$menu&uid=$uid&page=$page&act=hapus&id_layanan=$id_layanan&id_client=$id_client&id_acara=$id_acara&id_tugas=$id_tugas&jumlah=$jumlah";?>">
Pegawai bertugas tanggal : <?=$tgl_acara?>
<table cellpadding=3 cellspacing=0 style="border-width: 4px;  border-style: double;">
<tr valign=top>
<td>
<?
$maxrow=ceil($jml/4);
echo "<table cellpadding=3 cellspacing=0>";
for($b=0;$b<$jml;$b++){
echo "<tr>";
echo "<td>";echo "<input type='checkbox' value='";
echo mysql_result($rsc,$b,"id_pegawai");
echo "' name='pegawai[]'>&nbsp;";
echo mysql_result($rsc,$b,"nama");
echo "</td>";
echo"</tr>";
if(($b+1)%$maxrow==0 && $b!=0)echo "</table></td><td><table cellpadding=3 cellspacing=0>";
}
?>
</table>
</td>
</tr>
</table>
<center><br><input type="submit" value="kurangi"></center>
</form><center><a href="javascript:window.close();">Selesai</a></center>
<?
}
else
{ echo "<div align='center'><font color='#FF0000'><b>Akses Tidak Diperbolehkan. Hanya Group Administrator dan CS</b></font></div>"; }


?>