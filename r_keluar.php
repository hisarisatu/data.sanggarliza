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
if (!$tanggals) 
{
	$sqltgl="SELECT date_format( curdate( ) , '%Y-%m-1' ) tgl";
	$result_tgl = mysql_query($sqltgl);
	while ($row = mysql_fetch_array ($result_tgl))
	{$tanggals = $row['tgl'];}
}
if (!$tanggals2) 
{
	$sqltgl2="SELECT date_format( curdate( ) , '%Y-%m-%d' ) tgl2";
	$result_tgl2 = mysql_query($sqltgl2);
	while ($row = mysql_fetch_array ($result_tgl2))
	{$tanggals2 = $row['tgl2'];}
}
*/
	if($tanggal !="" && tanggal2 !="") {$filterSQL = " and tanggal BETWEEN '$tanggal' AND '$tanggal2' ";}
	if($id_client!="") {$filterSQL .= " and b.id_client like '$id_client' ";}
	if (!$id_client) {$id_client='%';}
	//if ($id_client==0) {$id_client='%';}
//	if($tanggal !="" && tanggal2 !="") {$filterSQL1 = " and tanggal BETWEEN '$tanggal' AND '$tanggal2' ";}		
			
//echo $filterSQL;


$runSQL = "	select b.id_pengeluaran,a.id_client,a.nama_cpw,date_format(b.tanggal,'%d-%m-%Y') tgl_keluar,c.keterangan,
b.detail,b.penerima,b.jumlah, IFNULL(c.keterangan,'-')jenis_bagian, IFNULL(d.keterangan,'-')noakun
from client a, pengeluaran b

left join p_pengeluaran c on b.id_jenis_bagian=c.id_jenis_bagian
left join p_noakun d on b.id_noakun=d.id_noakun
where b.id_client=a.id_client  $filterSQL
group by b.id_pengeluaran

union
select b.id_pengeluaran,null,IFNULL(null,'-')nama_cpw,date_format(b.tanggal,'%d-%m-%Y') tgl_keluar,c.keterangan,
b.detail,b.penerima, b.jumlah, IFNULL(c.keterangan,'-')jenis_bagian, IFNULL(d.keterangan,'-')noakun
from pengeluaran b
left join p_pengeluaran c on b.id_jenis_bagian=c.id_jenis_bagian
left join p_noakun d on b.id_noakun=d.id_noakun
where 
b.id_client=0 $filterSQL
group by b.id_pengeluaran
order by tgl_keluar asc";
?>


<form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
<div align="center" style="width:100%">
<fieldset style="width:600"><legend><strong>Filter</strong></legend>
<table>
<tr>
	<td><b>Periode Waktu</b></td>
	<td><b>:</b></td> 
	<td>   
		<input type='text' name='tanggal' id="tanggal" size='11' value='<?=$tanggals?>'>
			 - 
		<input type='text' name='tanggal2' id="tanggal2" size='11' value='<?=$tanggals2?>'>
	    
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
union select '%','--All Pengeluaran--' from dual ";
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
<div align="center"><font class="titledata"><b>Laporan Pengeluaran</b></font></div>

<div align="right">
<a href="cetak_pengeluaran.php?tanggal=<?=$tanggal?>&tanggal2=<?=$tanggal2?>&id_client=<?=$id_client?>?>" target="_blank"><img border="0" src="images/excel2007.jpg" height="25" width="25" alt="Print to Excel" title="Save to Excel" /></a>
<img src="images/arrow2.gif" border="0">
<b><a href="<?= "?menu=5&uid=$uid&page=r_keluar"; ?>">List All</a></b>
</div>

<hr size="1" color="#4B4B4B">

<table width='1000' cellspacing='1' cellpadding='3'>
<tr bgcolor='#A7A7A7' height="25" align="center">
	<td>No</td>
	<td>Tgl Pengeluaran</td>
	<td>Jenis Bagian</td>
    <td>No Akun</td>
    <td>Nama Client</td>
	<td>Detail Pengeluaran</td>
	<td>Penerima</td>
	<td>Jml Pengeluaran</td>	
	<td><img border=0 src='images/edit.gif'></td>
</tr>
<?
$res=mysql_query($runSQL);
//echo $runSQL;
while($rec=mysql_fetch_array($res))
{
	$id_pengeluaran=$rec['id_pengeluaran'];
	$nilai_tot +=$rec['jumlah'];
	$ccc++;
	if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
echo "
<tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
    <td align='center'>".($ccc)."</td>";
?>
	<td align="center"><?= $rec['tgl_keluar'];?></td>
	<td align="center"><?= $rec['jenis_bagian'];?></td>
    <td align="center"><?= $rec['noakun'];?></td>
    <td align="center"><?= $rec['nama_cpw'];?></td>
	<td><?= $rec['detail'];?></td>
	<td align="center"><?= $rec['penerima'];?></td>
	
	<td align='right'><?=number_format($rec['jumlah'],0); ?></td>		
	<td><a href=?menu=<?=$menu;?>&uid=<?=$uid;?>&page=pengeluaran_edit&id_pengeluaran=<?=$id_pengeluaran;?>>
	<img border=0 src='images/edit.gif'></a></td>
</tr>
<? 
}
echo "<tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>";
?>
<td> </td>
<td colspan=6 align=center><b> -------- T O T A L  P E N G E L U A R A N --------</b></td>
<td align=right><b><?=number_format($nilai_tot,0);?></b></td>
<td></td>
</tr>
</table>
