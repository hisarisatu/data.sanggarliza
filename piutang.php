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
if ($tanggal==0) {$tanggal='%';}
if ($tanggal2==0) {$tanggal2='%';}


  {$filterSQL = "and a.tgl_rencana > '$tanggal' and b.tanggal <= '$tanggal2' ";}
 
//echo $filterSQL;


$runSQL = "	select 
a.nama_cpw, a.nama_cpp, a.tgl_rencana,b.tanggal, sum(b.nilai) as nilai
from client a, client_bayar b
where a.id_client=b.id_client 
$filterSQL
group by a.id_client
order by b.tanggal asc";
//echo $runSQL;

?>



<form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
<div align="center" style="width:100%">
<fieldset style="width:600"><legend><strong>Filter</strong></legend>
<table>
<tr>
	<td><b>Tanggal Acara</b></td>
	<td><b>:</b></td> 
	<td>   
		<input type='text' name='tanggal' id="tanggal" size='11' '></td>
	
</tr>

<tr>
<td><b>Tanggal Bayar</b></td><td><b>:</b></td>
<td><input type='text' name='tanggal2' id="tanggal2" size='11'></td>
</tr>
<tr>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td><input type="submit" name="run2" value="  Go  " class="button" /></td>
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

<div align="center"><font class="titledata"><b>Laporan Piutang  Tgl 
<?=$tanggal?> s.d <?=$tanggal2?></b></font></div>

<div align="right">
<a href="cetak_r_busan11a_client.php?tanggal=<?=$tanggal?>&tanggal2=<?=$tanggal2?>&id_client=<?=$id_client?>?>" target="_blank"><img border="0" src="images/excel2007.jpg" height="25" width="25" alt="Print to Excel" title="Save to Excel" /></a>
<img src="images/arrow2.gif" border="0">
<b><a href="<?= "?menu=5&uid=$uid&page=piutang"; ?>">List All</a></b>
</div>

<hr size="1" color="#4B4B4B">

<table width='1000' cellspacing='1' cellpadding='3'>
<tr bgcolor='#A7A7A7' height="25" align="center">
	<td>No</td>
	<td>Tgl Acara</td>
	<td>Nama Pengantin</td>
	<td>Tgl Bayar</td>		
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
	<td><?= $rec['tgl_rencana'];?></td>
	<td><?= $rec['nama_cpw'];?>/<?= $rec['nama_cpp'];?></td>
	<td ><?= $rec['tanggal'];?></td>
	
	
	<td align='right'><?=number_format($rec['nilai'],0); ?></td>

</tr>
<? 
}
echo "<tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>";
?>
<td> </td>
<td colspan=3 align=center><b> -------- T O T A L  P I U T A N G--------</b></td>
<td align=right><b><?=number_format($nilai_tot,0);?></b></td>
</tr>
</table>
