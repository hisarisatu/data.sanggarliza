 <script src="src/js/jscal2.js"></script>
    <script src="src/js/lang/en.js"></script>
    <link rel="stylesheet" type="text/css" href="src/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="src/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="src/css/steel/steel.css" />


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
if (!$jns_filter) {$filterSQL = " and b.tanggal BETWEEN '$tanggal' AND '$tanggal2' ";}
if($jns_filter==2) {$filterSQL = " and c.tanggal BETWEEN '$tanggal' AND '$tanggal2' ";}
if($jns_filter==1) {$filterSQL = " and b.tanggal BETWEEN '$tanggal' AND '$tanggal2' ";}
			
//echo $filterSQL;


$runSQL = "	select a.id_client,date_format(c.tanggal,'%d-%m-%Y') tgl_acara,a.nama_cpw,a.nama_cpp,
date_format(b.tanggal,'%d-%m-%Y') tgl_bayar,b.keterangan,b.catatan,pembayar,nilai,concat(date_format(b.tanggal,'%Y%m'),'-',b.no_kw) no_kwitansi,b.no_kw
from client a,client_bayar b,(select id_client,min(tanggal) tanggal from acara group by id_client) c
where a.id_client=c.id_client
and date_format(b.tanggal,'%d-%m-%Y') not like '00-00-0000'
and a.id_client=b.id_client $filterSQL
order by b.no_kw asc";

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
$sqlfilter="select '1','Filter By Tgl Bayar' from dual union select '2','Filter By Tgl Acara' from dual ";
generate_select_event("jns_filter",$sqlfilter,$jns_filter,"submit_form()"); 
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


<div align="center"><font class="titledata"><b>Laporan Pemasukan Pembayaran Tgl <?=$tanggal?> s.d <?=$tanggal2?></b></font></div>

<div align="right">
<a href="cetak_r_busana_client.php?tanggal=<?=$tanggal?>&tanggal2=<?=$tanggal2?>&id_client=<?=$id_client?>?>" target="_blank"><img border="0" src="images/excel2007.jpg" height="25" width="25" alt="Print to Excel" title="Save to Excel" /></a>
<img src="images/arrow2.gif" border="0">
<b><a href="<?= "?menu=5&uid=$uid&page=r_busana_client"; ?>">List All</a></b>
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
