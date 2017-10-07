 <link rel="stylesheet" href="./src/lib/jquery-ui-1.11.1/jquery-ui.css">	
<script src="./src/lib/jquery-1.9.1.js" type="text/javascript"></script>
<script src="./src/lib/jquery-ui-1.11.1/jquery-ui.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="src/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="src/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="src/css/steel/steel.css" />

<style> body { background-image: url(image/logo_liza2.jpg); background-repeat: no-repeat; background-attachment: fixed; }  </style>
<?php
//Last update : 10/30/2010
// by agusari@gmail.com

include_once("include.php");
include_once("p_bulan.php");


//echo $filterSQL;




$runSQL = "select a.id_client, a.nama_cpw, a.tlp_mobile_cpw, a.nama_cpp, a.tlp_mobile_cpp, a.tgl_rencana, b.tgl_janjiawal, b.tgl_janjiakhir, b.barang, b.keterangan, ifnull(c.nama,'-')nama
 from client a 
 left join jadwal_fitting_new b on a.id_client=b.id_client 
 left join pegawai c on a.id_pegawai=c.id_pegawai
 where a.id_client=b.id_client and b.tgl_janjiakhir BETWEEN '$tanggal' AND '$tanggal2'
order by id_client desc";

?>

</br>
</br>
<div align="center"><font size="5"><b>Laporan Jadwal Fitting Tgl <font color="red"><?=$tanggal?></font> s.d <font color="red"><?=$tanggal2?></font></b></font></div>
</br>
</br>

<body background="http://data.sanggarliza.com/images/logo_liza2.jpg"><font size="12">
<table  align="center" border="1" width='1000' cellspacing='1'>
  <tr bgcolor='#A7A7A7' height="25">
			<td width="4%" align='center'>NO</td>
			<td width="12%" align='center'>NAMA CPW</td>
			<td width="12%" align='center'>HP CPW</td>
			<td width="8%" align='center'>Nama CPP</td>
			<td width="12%" align='center'>HP CPP</td>
			<td width="10%" align='center'>TGL RENCANA</td>
			<td width="10%" align='center'>JANJI AWAL</td>
			<td width="10%" align='center'>JANJI AKHIR</td>
			<td width="100%" align='center'>BARANG</td>
			<td width="10%" align='center'>KETERANGAN</td>
            <td width="10%" align='center'>PETUGAS CS</td>
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
    <td align='center'>".($ccc)."</td>";
?>
	
		  <td align='center'><? echo $rec['nama_cpw']; ?></td>
		  <td align='center'><? echo $rec['tlp_mobile_cpw'];?></td>
		  <td align='center'><? echo $rec['nama_cpp']; ?></td>
		  <td align='center'><? echo $rec['tlp_mobile_cpp']; ?></td>
		  <td align='center'><? echo $rec['tgl_rencana']; ?></td>
		  <td align='center'><? echo $rec['tgl_janjiawal']; ?></td>
		  <td align='center'><? echo $rec['tgl_janjiakhir']; ?></td>
		  <td><? echo $rec['barang']; ?></td>
		  <td><? echo $rec['keterangan']; ?></td> 
		  <td><? echo $rec['nama']; ?></td>

</tr>
<? 
}
echo "<tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>";
?>
</tr>
</table>
</font>
</table></br>

<table align="center" width="1002" height="79" border="0">
  <tr align="center" >
    <td height="23">Dibuat oleh,</td>
    <td>Diperikasa oleh,</td>
  </tr>
  <tr>
    <td height="23">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr align="center">
    <td height="23">(Admin Fitting)</td>
    <td>(KaBag. Gudang)</td>
  </tr>
</table>
<p>&nbsp; </p>
<p>&nbsp;</p>
<p>&nbsp; </p>
<script type="text/javascript">
    window.print();
    window.onfocus = function() { window.close(); }
  </script>
