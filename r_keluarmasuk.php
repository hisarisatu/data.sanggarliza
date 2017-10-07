<?php
include_once("include.php");
include_once("p_bulan.php");

if(!$bulan_rencana)$bulan_rencana=date("m");
if(!$thn_rencana)$thn_rencana=date("Y");
?>
<table width="100%" border="0" cellpadding="5" cellspacing="0">
<tr>
<form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
<td valign="bottom"><b>Bulan Kegiatan:
<select name="bulan_rencana">
<option value="%">-All-</option>
<?
for($bl=0;$bl<12;$bl++){
	$bulan=$bl+1;if($bulan<10)$bulan="0".$bulan;
	echo "<option ";
	if($bulan==$bulan_rencana)echo " selected ";
	echo "value='$bulan'>".nama_bulan($bulan)."</option>";
}
?>
</select> - 
<select name="thn_rencana">
<?
for($thn=date("Y")-1;$thn<date("Y")+3;$thn++){
echo "<option ";
if($thn==$thn_rencana)echo " selected ";
echo "value='$thn'>$thn</option>";
}
?>
</select>
<input type="submit" name="run" value="  Go  " class="button">
</td>
<td valign="bottom" align="right"></td>
</form>
</tr>
</table>
<?
$sql="select date_format(tanggal,'%d-%m-%Y') tanggal,detail,masuk,keluar from 
(
SELECT tanggal,detail,'-' masuk,jumlah keluar FROM `pengeluaran`
union
select tanggal,keterangan,nilai,'-' keluar from client_bayar
) a 
where tanggal like '$thn_rencana-$bulan_rencana-%'
order by tanggal desc
";
$result=mysql_query($sql);
$totalRecord = mysql_num_rows($result);
$listRecord = 10;
$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter&cari=$cari&pnum=";
pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord);
unset($ii);
?>
Halaman : <?=$pnumlink;?> &nbsp; Total : <b><?=$totalPage;?></b> halaman, <?=$totalRecord?> record.
<table width='600' cellspacing='1' cellpadding='3'>
<tr bgcolor='#A7A7A7' height="25" align=center>
	<td><b>No</td>
	<td><b>Tanggal</td>
	<td><b>Detail</td>
	<td><b>Jumlah Masuk</td>
	<td><b>Jumlah Keluar</td>
</tr>
<?
while ($row = mysql_fetch_array ($result)) {
	$ccc++;
    if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
echo "
<tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
    <td align='center'>".($ccc)."</td>";?>
	<td><?=$row[tanggal]?></td>
	<td><?=$row[detail]?></td>
	<td align=right><?=number_format($row[masuk],0)?></td>
	<td align=right><?=number_format($row[keluar],0)?></td>
</tr>
<? } ?>
</table>
Halaman : <?=$pnumlink;?> &nbsp; Total : <b><?=$totalPage;?></b> halaman, <?=$totalRecord?> record.