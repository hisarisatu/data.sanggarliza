 <link rel="stylesheet" href="./src/lib/jquery-ui-1.11.1/jquery-ui.css">	
<script src="./src/lib/jquery-1.9.1.js" type="text/javascript"></script>
<script src="./src/lib/jquery-ui-1.11.1/jquery-ui.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="src/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="src/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="src/css/steel/steel.css" />

<style> body { background-image: url(image/logo_liza2); background-repeat: no-repeat; background-attachment: fixed; }  </style>
<?php
//Last update : 10/30/2010
// by agusari@gmail.com

include_once("include.php");
include_once("p_bulan.php");


//echo $filterSQL;


$runSQL = "	select a.id_client,date_format(c.tanggal,'%d-%m-%Y') tgl_acara,a.nama_cpw,a.nama_cpp,
date_format(b.tanggal,'%d-%m-%Y') tgl_bayar,b.keterangan,b.catatan,pembayar,nilai,concat(date_format(b.tanggal,'%Y%m'),'-',b.no_kw) no_kwitansi,b.no_kw
from client a,client_bayar b,(select id_client,min(tanggal) tanggal from acara group by id_client) c
where a.id_client=c.id_client
and date_format(b.tanggal,'%d-%m-%Y') not like '00-00-0000'
and a.id_client=b.id_client and b.tanggal BETWEEN '$tanggal' AND '$tanggal2'
order by b.no_kw asc";

?>

</br>
</br>
<div align="center"><font size="5"><b>Laporan Pemasukan Pembayaran Tgl <?=$tanggal?> s.d <?=$tanggal2?></b></font></div>
</br>
</br>

<body background="images/logo_liza2.jpg"><font size="12">
<table  border="1" width='1000' cellspacing='1' cellpadding='3'>
  <tr bordercolor="#666666" bgcolor='#A7A7A7' height="25" align="center">
	<td>No</td>
	<td>Tgl Acara</td>
	<td>Nama Pengantin</td>
	<td>Tgl Bayar</td>
	<td>Detail Pembayaran</td>
	<td>Mode Pembayaran</td>
	<td>Pembayar</td>
	<td>No Kwitansi</td>		
	<td>Nilai Pembayaran</td>
</tr>
<?
$res=mysql_query($runSQL);
//echo $runSQL;
while($rec=mysql_fetch_array($res))
{
	
	$nilai_tot +=$rec['nilai'];
	$ccc++;
	if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
echo "
<tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
    <td align='center'>".($ccc)."</td>";
?>
	<td><?= $rec['tgl_acara'];?></td>
	<td><?= $rec['nama_cpw'];?>/<?= $rec['nama_cpp'];?></td>
	<td><?= $rec['tgl_bayar'];?></td>
	<td><?= $rec['keterangan'];?></td>
	<td><?= $rec['catatan']; ?></td>
	<td><?= $rec['pembayar'];?></td>
	<td><?= $rec['no_kwitansi'];?></td>	
	<td align='right'><?=number_format($rec['nilai'],0); ?></td>
</td>
</tr>
<? 
}
echo "<tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>";
?>
<td> </td>
<td colspan=7 align=center><b> -------- T O T A L  P E M A S U K A N --------</b></td>
<td align=right><b><?=number_format($nilai_tot,0);?></b></td>
</tr>
</table>
</font>
</table></br>

<table align="center" width="1002" height="79" border="0">
  <tr align="center" >
    <td height="23">Dibuat oleh,</td>
    <td>Diperikasa oleh,</td>
    <td>Disetujui Oleh,</td>
    <td>Mengetahui,</td>
  </tr>
  <tr>
    <td height="23">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr align="center">
    <td height="23">(Cashier)</td>
    <td>(Supervisor)</td>
    <td>(Manager)</td>
    <td>(Direktur)</td>
  </tr>
</table>
<p>&nbsp; </p>
<p>&nbsp;</p>
<p>&nbsp; </p>
<script type="text/javascript">
    window.print();
    window.onfocus = function() { window.close(); }
  </script>
