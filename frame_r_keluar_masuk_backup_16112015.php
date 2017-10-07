<html>
<head>
<title>Untitled</title>
<script language="JavaScript">
onload = function()
{
 document.nameOfIFrame.document.body.style.fontFamily = "Verdana";
 document.nameOfIFrame.document.execCommand("FontSize", "", "9");
}
</script>
 <script src="src/js/jscal2.js"></script>
    <script src="src/js/lang/en.js"></script>
    <link rel="stylesheet" type="text/css" href="src/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="src/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="src/css/steel/steel.css" />

</head>
<body>

<?php
//Last update : 10/30/2010
// by agusari@gmail.com

include_once("include.php");
include_once("p_bulan.php");

function js_submit()
{
        echo "<script language=javascript>\n";
        echo "function submit_form() {\n";
        echo "  document.forms[0].submit();\n";
        echo "}\n";
        echo "</script>\n";

}
function generate_select_event($name,$sql,$default,$onchange)
{
		$result = mysql_query($sql);
        $nrows=0;
        while ($row = mysql_fetch_array ($result))
        {
                $nrows++;
                $key = $row[0];
                $value = $row[1];
                $arr["$key"] = $value;
        }
        echo "<select name=$name onchange=\"$onchange;\">\n";
        while (list($key,$val) = each($arr))
        {
                if ($default==$key) {
                        echo "<option value=$key selected>$val</option>\n";
                } else {
                        echo "<option value=$key>$val</option>\n";
                }
        }
        echo "</select>";
}

function generate_select($name,$sql,$default)
{

		$result = mysql_query($sql);
        $nrows=0;
        while ($row = mysql_fetch_array ($result))
        {
                $nrows++;
                $key = $row[0];
                $value = $row[1];
                $arr["$key"] = $value;
        }

        echo "<select name=$name>\n";
        while (list($key,$val) = each($arr))
        {
                if ($default==$key) {
                        echo "<option value=$key selected>$val</option>\n";
                } else {
                        echo "<option value=$key>$val</option>\n";
                }
        }
        echo "</select>";
}
?>	
<script language="JavaScript" src="calendar_us.js"></script>
	
<?
/*
if (!$tanggal) 
{
	$sqltgl="SELECT date_format( curdate( ) , '%Y-%m-1' ) tgl";
	$result_tgl = mysql_query($sqltgl);
	while ($row = mysql_fetch_array ($result_tgl))
	{$tanggal = $row['tgl'];}
}
if (!$tanggal2) 
{
	$sqltgl2="SELECT date_format( curdate( ) , '%Y-%m-%d' ) tgl2";
	$result_tgl2 = mysql_query($sqltgl2);
	while ($row = mysql_fetch_array ($result_tgl2))
	{$tanggal2 = $row['tgl2'];}
}
*/
$filterSQL1 = " and b.tanggal BETWEEN '$tanggal' AND '$tanggal2' ";
if (!$id_client) {$id_client='%';}			

?>
<form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
<div align="left" style="width:100%">
<fieldset style="width:600"><legend><strong>Filter</strong></legend>
<table>
<tr>
	<td><b>Periode Waktu</b></td>
	<td><b>:</b></td> 
	<td>   
		<input type='text' name='tanggal' id="tanggal" size='11' >
			 - 
		<input type='text' name='tanggal2' id="tanggal2" size='11' >
	    
		<input type="submit" name="run" value="  Go  " class="button">
	</td>
</tr>

<tr>
<td><b>Filter Client </b></td><td><b>:</b></td>
<td>
<?
js_submit();
$sqlclient="select distinct a.id_client,concat( `nama_cpw` , '/', `nama_cpp` ) namacp from client a,acara b 
where a.id_client=b.id_client $filterSQL1
union select '%','--All Pengeluaran--' from dual";
generate_select_event("id_client",$sqlclient,$id_client,"submit_form()"); 
?>
</td>
</tr>
</table>
</fieldset>
</div>
</form>

<script type="text/javascript">//<![CDATA[

      var cal = Calendar.setup({
          onSelect: function(cal) { cal.hide() }
      });
      cal.manageFields("tanggal", "tanggal", "%Y-%m-%d");
      cal.manageFields("tanggal2", "tanggal2", "%Y-%m-%d");
    //]]></script>

<?
$runSQL = "	select sum(jumlah) jml_keluar from 
(select a.id_client,date_format(b.tanggal,'%d-%m-%Y') tgl_keluar,c.keterangan,
b.detail,d.penerima,concat(a.nama_cpw,'/',a.nama_cpp) ketcp,jumlah
from client a,pengeluaran b,p_pengeluaran c,p_penerima d
where b.id_client=a.id_client
and b.id_jenis=c.id_jenis_pengeluaran
and b.id_penerima=d.id_penerima 
and tanggal BETWEEN '$tanggal' AND '$tanggal2'
and b.id_client like '$id_client'
union
select null,b.tanggal tgl_keluar,c.keterangan,
b.detail,d.penerima,'--Pengeluaran Non Client--',jumlah
from pengeluaran b,p_pengeluaran c,p_penerima d
where b.id_jenis=c.id_jenis_pengeluaran
and b.id_penerima=d.id_penerima
and b.id_client=0 
and tanggal BETWEEN '$tanggal' AND '$tanggal2'
and b.id_client like '$id_client') b";
$res=mysql_query($runSQL);
while($rec=mysql_fetch_array($res))
{
$jumlah_keluar=$rec['jml_keluar'];
}

$runSQL1 = " select sum(nilai) jml_masuk from 	
(select a.id_client,date_format(c.tanggal,'%d-%m-%Y') tgl_acara,a.nama_cpw,a.nama_cpp,
date_format(b.tanggal,'%d-%m-%Y') tgl_bayar,b.keterangan,b.catatan,pembayar,nilai
from client a,client_bayar b,(select id_client,min(tanggal) tanggal from acara group by id_client) c
where a.id_client=c.id_client
and a.id_client=b.id_client and b.tanggal BETWEEN '$tanggal' AND '$tanggal2'
and a.id_client like '$id_client') b";
$res1=mysql_query($runSQL1);
while($rec1=mysql_fetch_array($res1))
{
$jumlah_masuk=$rec1['jml_masuk'];
}
$saldo=$jumlah_masuk-$jumlah_keluar;
?>

<div align="left" style="width:100%">
<fieldset style="width:600"><legend><strong>Resume Saldo </strong></legend>
<table>
<tr>
	<td><b>Periode Waktu</b></td>
	<td><b>:</b></td> 
	<td><b>   
		<?=$tanggal?>
			 s/d 
		<?=$tanggal2?>
	</td>
</tr>
<tr><td><b>Jumlah Pemasukan</b></td><td><b>:</b></td><td align='right'><b><?=number_format($jumlah_masuk,0);?></td></tr>
<tr><td><b>Jumlah Pengeluaran</b></td><td><b>:</b></td><td align='right'><b><?=number_format($jumlah_keluar,0);?></td></tr>
<tr><td><b>Jumlah SALDO</b></td><td><b>:</b></td><td align='right'><b><?=number_format($saldo,0);?></td></tr>
</table>
</fieldset>
</div>


<table width='100%' cellspacing='1' cellpadding='3'>
 <tr>
 <td>
<IFRAME name="nameOfIFrame" SRC="r_masuk_frame.php?&tanggal=<?=$tanggal;?>&tanggal2=<?=$tanggal2;?>&id_client=<?=$id_client;?>" WIDTH=550 HEIGHT=5000 FRAMEBORDER=0 SCROLLING=NO></IFRAME>
</td>
 <td>
<IFRAME name="nameOfIFrame" SRC="r_keluar_frame.php?&tanggal=<?=$tanggal;?>&tanggal2=<?=$tanggal2;?>&id_client=<?=$id_client;?>" WIDTH=550 HEIGHT=5000 FRAMEBORDER=0 SCROLLING=NO></IFRAME>
</td>
</tr>
</table>
