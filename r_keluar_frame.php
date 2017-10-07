<html><body>
	<script src="src/js/jscal2.js"></script>
    <script src="src/js/lang/en.js"></script>
    <link rel="stylesheet" type="text/css" href="src/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="src/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="src/css/steel/steel.css" />
</body></html>.


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

	if($tanggal !="" && tanggal2 !="") {$filterSQL = " and tanggal BETWEEN '$tanggal' AND '$tanggal2' ";}
	if($id_client!="") {$filterSQL .= " and b.id_client like '$id_client' ";}
	if (!$id_client) {$id_client='%';}
	//if ($id_client==0) {$id_client='%';}
	if($tanggal !="" && tanggal2 !="") {$filterSQL1 = " and tanggal BETWEEN '$tanggal' AND '$tanggal2' ";}		
			
//echo $filterSQL;


$runSQL = "	select a.id_client,date_format(b.tanggal,'%d-%m-%Y') tgl_keluar,c.keterangan,
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
and b.id_client like '$id_client'
order by tgl_keluar asc";

?>

<script type="text/javascript">//<![CDATA[

      var cal = Calendar.setup({
          onSelect: function(cal) { cal.hide() }
      });
      cal.manageFields("tanggal", "tanggal", "%Y-%m-%d");
      cal.manageFields("tanggal2", "tanggal2", "%Y-%m-%d");
    //]]></script>
<font class="titledata"><b>Laporan Pengeluaran</b></font>
<br>
<table width='400' cellspacing='1' cellpadding='3'>
<tr bgcolor='#A7A7A7' height="25" align="center">
	<td>No</td>
	<td>Tgl Pengeluaran</td>
	<td>Detail Pengeluaran</td>
	<td>Jml Pengeluaran</td>	
</tr>
<?
$res=mysql_query($runSQL);
//echo $runSQL;
while($rec=mysql_fetch_array($res))
{
	
	$nilai_tot +=$rec['jumlah'];
	$ccc++;
	if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
echo "
<tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
    <td align='center'>".($ccc)."</td>";
?>
	<td><?= $rec['tgl_keluar'];?></td>
	<td><?= $rec['detail'];?></td>
	<td align='right'><?=number_format($rec['jumlah'],0); ?></td>	
</td>
</tr>
<? 
}
echo "<tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>";
?>
<td> </td>
<td colspan=2 align=center><b> -- TOTAL PENGELUARAN --</b></td>
<td align=right><b><?=number_format($nilai_tot,0);?></b></td>
</tr>
</table>
