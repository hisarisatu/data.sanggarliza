<link rel="stylesheet" href="./src/lib/jquery-ui-1.11.1/jquery-ui.css">	
<script src="./src/lib/jquery-1.9.1.js" type="text/javascript"></script>
<script src="./src/lib/jquery-ui-1.11.1/jquery-ui.js" type="text/javascript"></script>
<script src="src/js/jscal2.js"></script>
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
<table cellpadding=3 cellspacing=0 style="border-width: 4px;  border-style: double;">
<tr><td>Client</td><td colspan=3>: <?=mysql_result($rs,0,"nama_cpw")?> / <?=mysql_result($rs,0,"nama_cpp")?></td></tr>
<? for($a=0;$a<@mysql_num_rows($rs);$a++){?>
<tr><td>Tanggal</td><td>: <?=mysql_result($rs,$a,"tgl_acara");?>  (<?=mysql_result($rs,$a,"acara")?>)</td></tr>
<? } ?>


</table><br>
<? } ?>

<?
$sql = "select date_format(tgl_janjiawal,'%d-%M-%Y') tgl_janjiawal, date_format(tgl_janjiakhir,'%d-%M-%Y') tgl_janjiakhir, barang,id_client,id_fitting,keterangan
from jadwal_fitting_new where id_client='$id_client' order by created desc";
$rk = mysql_query($sql);
//$row = mysql_fetch_array($rk);
?>
<table width='500' cellspacing='1' cellpadding='3'>
<tr align=center bgcolor='#A7A7A7' height='25'>
<td><b>No</b></td><td>Tgl Janji Awal</td><td>Tgl Janji Deal</td><td>barang</td><td>keterangan</td> </tr>
<?
for ($k=0;$k<@mysql_num_rows($rk);$k++)
{
$ccc++;
    if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
    echo "
      <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
          <td align='center'>".($ccc)."</td>";?>
<td align=center><?=mysql_result($rk,$k,"tgl_janjiawal")?></td>
<td align=center><?=mysql_result($rk,$k,"tgl_janjiakhir")?></td>
<td><?=mysql_result($rk,$k,"barang")?></td>
<td><?=mysql_result($rk,$k,"keterangan")?></td>
<?
}
echo "</table>";
?>
<p>&nbsp; </p>
<p>&nbsp;</p>
<p>&nbsp; </p>
<script type="text/javascript">
    window.print();
    window.onfocus = function() { window.close(); }
  </script>