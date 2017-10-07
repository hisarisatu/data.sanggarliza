 <link rel="stylesheet" href="./src/lib/jquery-ui-1.11.1/jquery-ui.css">	
<script src="./src/lib/jquery-1.9.1.js" type="text/javascript"></script>
<script src="./src/lib/jquery-ui-1.11.1/jquery-ui.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="src/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="src/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="src/css/steel/steel.css" />


<?php
//Last update : 10/30/2010
// by agusari@gmail.com

include_once("include.php");
include_once("p_bulan.php");
if (($SAH[id_group]==1)or($SAH[id_group]==5))
{
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
/*
?>
<script language="JavaScript" src="calendar_us.js"></script>


<?

              
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
if (!$jns_filter) {$filterSQL = " and b.tanggal BETWEEN '$tanggal' AND '$tanggal2' ";}
if($jns_filter==2) {$filterSQL = " and c.tanggal BETWEEN '$tanggal' AND '$tanggal2' ";}
if($jns_filter==1) {$filterSQL = " and b.tanggal BETWEEN '$tanggal' AND '$tanggal2' ";}
if($catatan!="")
	{$filterSQL .=" and b.catatan like '%$catatan%' ";}		
//echo $filterSQL;


$runSQL = "select a.id_client ,date_format(c.tanggal,'%d-%m-%Y') tgl_acara, CONCAT ( a.nama_cpw, '/', a.nama_cpp) nama, date_format(b.tanggal,'%d-%m-%Y')tgl_bayar,
b.keterangan,b.catatan ,pembayar,nilai,concat(date_format(b.tanggal,'%Y%m'),'-',b.no_kw) no_kwitansi
from client a,client_bayar b,(select id_client,min(tanggal) tanggal from acara group by id_client) c 
where a.id_client=c.id_client and date_format(b.tanggal,'%d-%m-%Y') not like '00-00-0000' 
and a.id_client=b.id_client  $filterSQL

union all 

Select b.id_non_client , ifnull(a.keterangan,'-')tgl_acara,  b.nama  as nama,  DATE_FORMAT(b.tanggal, '%d-%m-%Y')tgl_bayar, b.detail as keterangan, 
b.catatan  , concat ('-' , b.nama, '-') pembayar ,b.jumlah, b.kwitansi
from non_client b, p_pengeluaran a 
where b.divisi=a.id_jenis_bagian $filterSQL group by b.id_non_client

union all 

Select a.id_siswa ,date_format(c.tanggal,'%d-%m-%Y') tgl_acara, CONCAT (a.nama_siswa) nama, date_format(b.tanggal,'%d-%m-%Y')tgl_bayar,
b.keterangan,b.catatan ,pembayar,nilai,concat(date_format(b.tanggal,'%Y%m'),'-',b.no_kw) no_kwitansi
from tb_siswa a,tb_siswa_bayar b,(select id_siswa,min(tanggal) tanggal from tb_acara_workshop group by id_siswa) c 
where a.id_siswa=c.id_siswa and date_format(b.tanggal,'%d-%m-%Y') not like '00-00-0000' 
and a.id_siswa=b.id_siswa  $filterSQL
";
//echo $runSQL;
?>


<form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
<div align="center" style="width:100%">
<fieldset style="width:600"><legend><strong>Filter</strong></legend>
<table>
<tr>
	<td><b>Periode Waktu</b></td>
	<td><b>:</b></td> 
	<td>   
		<input type='text' name='tanggal' id="tanggal" size='11' '>
			 - 
		<input type='text' name='tanggal2' id="tanggal2" size='11' '>
	    
		<input type="submit" name="run" value="  Go  " class="button">
	</td>
	
	
	
	
</tr>

<tr>
<td><b>Jenis Filter </b></td><td><b>:</b></td>
<td>
<?
js_submit();
$sqlfilter="select '1','Filter By Tgl Bayar' from dual ";
generate_select_event("jns_filter",$sqlfilter,$jns_filter,"submit_form()"); 
?>
</td>
<tr>
<td><b>Catatan</b></td><td><b>:</b></td>
<td><input type="text" name="catatan" value="<?=$catatan;?>" size="15"></td>
</tr>
</tr>
</table>
</fieldset>
</div>
</form>

<script type="text/javascript">//<![CDATA[
    $(document).ready(function(){
       $('#tanggal').datepicker({ dateFormat: 'yy-mm-dd',changeMonth : true,
                changeYear : true }); 
       $('#tanggal2').datepicker({ dateFormat: 'yy-mm-dd',changeMonth : true,
                changeYear : true }); 
    });
	 //]]></script>

<!--
<script type="text/javascript">//<![CDATA[

      var cal = Calendar.setup({
          onSelect: function(cal) { cal.hide() }
      });
      cal.manageFields("tanggal", "tanggal", "%Y-%m-%d");
      cal.manageFields("tanggal2", "tanggal2", "%Y-%m-%d");
    //]]></script>
-->

<div align="center"><font class="titledata"><b>Laporan Pemasukan Pembayaran Tgl <?=$tanggal?> s.d <?=$tanggal2?></b></font></div>

<div align="right">
&nbsp;

<a href="print_r_masuk_lengkap.php?tanggal=<?=$tanggal?>&tanggal2=<?=$tanggal2?>&catatan=<?=$catatan?>" target="_blank"><img border="0" src="images/Printer.png" height="25" width="25" alt="Print to Excel" title="Cetak pemasukan" /></a>
&nbsp;&nbsp;&nbsp;
<a href="print_r_masuk_lengakp.php?tanggal=<?=$tanggal?>&tanggal2=<?=$tanggal2?>" target="_blank"><img border="0" src="images/excel2007.jpg" height="25" width="25" alt="Print to Excel" title="Save to Excel" /></a>


<img src="images/arrow2.gif" border="0">
<b><a href="<?= "?menu=5&uid=$uid&page=print_r_masuk"; ?>">List All</a></b>
</div>

<hr size="1" color="#4B4B4B">

<table width='1000' cellspacing='1' cellpadding='3'>
<tr bgcolor='#A7A7A7' height="25" align="center">
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
	<td><?= $rec['nama'];?></td>
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
<?
}
else
{echo"</br>";
echo"</br>";
echo "<div align='center'><font color='#FF0000'><b>Akses Tidak Diperbolehkan. Hanya Group Administrator dan Keuangan</b></font></div>"; }
?>