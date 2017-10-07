 <script src="src/js/jscal2.js"></script>
    <script src="src/js/lang/en.js"></script>
    <link rel="stylesheet" type="text/css" href="src/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="src/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="src/css/steel/steel.css" />


<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 10 Oktober 2010, lastupdate 10 Oktober 2010

include_once("include.php");
include_once("p_bulan.php");
if($id_client=="")$id_client=$id;

$sql="select date_format(a.tanggal,'%d-%m-%Y') tgl_acara,a.tanggal,b.acara,c.nama_cpw,c.nama_cpp from acara a, p_acara b, client c where a.id_client='$id_client' and a.id_acara=b.id_acara and a.id_client=c.id_client";
$urut=mysql_query("SELECT MAX(no_urut) as no_urut FROM jadwal_fitting_new");
$no_urut=mysql_result($urut,0,"no_urut");
$no_urut+=1;


//echo $sql;
$rs=@mysql_query($sql);
$n=mysql_num_rows($rs);
if($n==0)
{ 
?>
<br><br><br>
<table cellpadding=3 cellspacing=0 style="border-width: 4px;  border-style: double;">
<tr><td colspan="2">-- <strong><em>CLIENT BELUM ORDER / MEMBAYAR DP (TIDAK BISA MELAKUKAN FITTING)</em></strong> --</td></tr></table><br>
<?	
}
else
{
$tgl_acara=mysql_result($rs,0,"tgl_acara");
$tgl=mysql_result($rs,0,"tanggal");
?>
<br><br><br>
<table cellpadding=3 cellspacing=0 style="width:100%; border-width: 4px;  border-style: double;">
<tr>
<td><font size="2">Client</font></td>
<td colspan=3><font size="2">: <?=mysql_result($rs,0,"nama_cpw")?> / <?=mysql_result($rs,0,"nama_cpp")?></font></td>
<? for($a=0;$a<@mysql_num_rows($rs);$a++){?>
<tr>
<td><font size="2">Tanggal</font></td>
<td><font size="2">: <?=mysql_result($rs,$a,"tgl_acara");?>  (<?=mysql_result($rs,$a,"acara")?>)</font></td>
</tr>
<? } ?>
<br>
<? } ?>
</table>
<br><a href="<?="?menu=$menu&uid=$uid&page=jadwal_fitting";?>"><img src="images/back2.png" width="100" height="75"></a><br>
<?
$sql = "select date_format(tgl_janjiawal,'%d-%M-%Y') tgl_janjiawal, date_format(tgl_janjiakhir,'%d-%M-%Y') tgl_janjiakhir, barang,id_client,id_fitting,keterangan
from jadwal_fitting_new where id_client='$id_client' order by created desc";
$rk = mysql_query($sql);
//$row = mysql_fetch_array($rk);
?>
<table width='100%' cellspacing='1' cellpadding='3'>
<tr align=center bgcolor='#A7A7A7' height='25'>
<td><b>No</b></td><td width="10%">Tgl Janji Awal</td><td width="10%">Tgl Janji Deal</td><td><font size="5"><b>BARANG</b></font></td><td>keterangan</td> <? if($SAH[id_group]==1 || $SAH[id_group]==7 || $SAH[id_group]==8){ ?> <td>Edit</td><? } ?></tr>
<?
for ($k=0;$k<@mysql_num_rows($rk);$k++)
{
$ccc++;
    if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
    echo "
      <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
          <td align='center'>".($ccc)."</td>";?>
<td align=center><b><?=mysql_result($rk,$k,"tgl_janjiawal")?></b></td>
<td align=center><b><?=mysql_result($rk,$k,"tgl_janjiakhir")?></b></td>
<td><font size="5"><?=mysql_result($rk,$k,"barang")?></font></td>
<td><font size="4"><b><?=mysql_result($rk,$k,"keterangan")?></b></font></td>
<? if($SAH[id_group]==1 || $SAH[id_group]==7 || $SAH[id_group]==8){ ?>
<td align=center>
<? $id_client=mysql_result($rk,$k,"id_client");
	$id_bayar=mysql_result($rk,$k,"id_fitting");
	echo "<a href=?menu=$menu&uid=$uid&page=jadwal_fitting_edit&id_client=$id_client&id_fitting=$id_fitting>"?>
<img border=0 src='images/edit.gif'></a></td> <? } ?>
</tr>
<?
}
echo "</table>";
?>