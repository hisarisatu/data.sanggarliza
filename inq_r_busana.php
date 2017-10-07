 
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
        if (!$default) {
                echo "<option value=0>-- Pilih --</option>\n";
        }
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
*/


$pageFilter ="&tanggal=$tanggal&tanggal2=$tanggal2&id_tipe_baju=$id_tipe_baju&id_baju=$id_baju&id_tipe_kain=$id_tipe_kain&id_kain=$id_kain";

				//if (!$tanggal) {$tanggal=date_format(current_date(),'%Y-%m-1');}
				//if (!$tanggal2) {$tanggal2=date_format(current_date(),'%Y-%m-%d');}
                if ($id_tipe_baju==0) {$id_tipe_baju='%';}
				if ($id_baju==0) {$id_baju='%';}


                if($id_tipe_baju !="") { $filterSQL = " and g.id_tipe_baju like '$id_tipe_baju' "; }
				if($id_baju !="") { $filterSQL .= " and g.id_baju like '$id_baju' "; }
			  {$filterSQL .= " and a.tanggal BETWEEN '$tanggal' AND '$tanggal2' ";}

			
//echo $filterSQL;
//echo $filterSQL1;
			
$runSQL = "select count(*) total from 
(select distinct a.id_client,a.id_acara,a.tanggal, a.waktu, a.created, b.acara,a.tempat,
c.nama_cpw,c.nama_cpp CP,e.detail_layanan
from acara a,p_acara b,client c,paket_sub_paket d,
p_sublayanan e, client_busana g,
p_baju_tipe h,p_baju i
where a.id_acara=b.id_acara 
and a.id_client=c.id_client
  
and a.id_acara=g.id_acara 
and a.id_client=g.id_client 


and g.id_plus=e.id_sublayanan 
and g.id_tipe_baju=h.id_tipe_baju
and g.id_tipe_baju=i.id_tipe_baju
and g.id_baju=i.id_layanan
$filterSQL) b ";
		
$result = mysql_query($runSQL, $connDB);
if ($row = mysql_fetch_array ($result)) { $totalRecord = $row[total]; };
$listRecord = 30;
$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter$cari&pnum=";
pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord);

//echo $runSQL;



$runSQL = "	select distinct a.id_client,a.id_acara,a.tanggal, a.waktu, a.created, b.acara,a.tempat,
c.nama_cpw,c.nama_cpp,e.detail_layanan,h.keterangan tipe_baju,i.layanan jns_baju,g.jml_baju
from acara a,p_acara b,client c,paket_sub_paket d,p_sublayanan e, 
client_busana g,p_baju_tipe h,p_baju i
where a.id_acara=b.id_acara 
and a.id_client=c.id_client
    
and a.id_acara=g.id_acara 
and a.id_client=g.id_client 


and g.id_plus=e.id_sublayanan 
and g.id_tipe_baju=h.id_tipe_baju
and g.id_tipe_baju=i.id_tipe_baju
and g.id_baju=i.id_layanan
$filterSQL
order by tanggal desc,id_client asc
LIMIT $offsetRecord, $listRecord  ";
//echo $runSQL;
?>


<form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
<div align="center" style="width:100%">
<fieldset style="width:600"><legend><strong>Filter</strong></legend>
<table>
<tr>
	<td><b>Range Waktu Acara</b></td>
	<td><b>:</b></td> 
	<td>   
		<input type='text' name='tanggal' id="tanggal" size='11' value='<?=$tanggal?>'>
			 - 
		<input type='text' name='tanggal2' id="tanggal2" size='11' value='<?=$tanggal2?>'>
	</td>		
</tr>

<tr>
<td><b>Tipe Baju </b></td><td><b>:</b></td>
<td>
<?
js_submit();
$sqltipebaju="select distinct id_tipe_baju,keterangan from p_baju_tipe where upper(keterangan) not like '%KAIN%' union select '0','--Pilih Tipe Baju--' from dual";
generate_select_event("id_tipe_baju",$sqltipebaju,$id_tipe_baju,"submit_form()"); 
?>
</td>
</tr>
<tr>
<td><b>Jenis Baju </b></td><td><b>:</b></td>
<td>
<?
js_submit();
$sqlbaju="select * from (select distinct id_layanan,layanan from p_baju where id_tipe_baju like '$id_tipe_baju' union select '0','--Pilih Jenis Baju--' from dual) a order by layanan";
generate_select("id_baju",$sqlbaju,$id_baju);
?>
</td>
</tr>


<tr>
<td colspan="3">
	<input type="submit" name="run" value="  Go  " class="button">
</td>
</tr>
</table>
</fieldset>
</div>
</form>

<script type="text/javascript">//<![CDATA[
    $(document).ready(function(){
       $('#tanggal').datepicker({ dateFormat: 'yy-mm-dd' }); 
       $('#tanggal2').datepicker({ dateFormat: 'yy-mm-dd' }); 
    });
	/*
<script type="text/javascript">//<![CDATA[

      var cal = Calendar.setup({
          onSelect: function(cal) { cal.hide() }
      });
      cal.manageFields("tanggal", "tanggal", "%Y-%m-%d");
      cal.manageFields("tanggal2", "tanggal2", "%Y-%m-%d");*/
    //]]></script>
<div align="center"><font class="titledata"><b>Laporan Penjadwalan Acara</b></font></div>

<div align="right">
<a href="cetak_report_busana_terpakai.php?tanggal=<?=$tanggal?>&tanggal2=<?=$tanggal2?>&id_tipe_baju=<?=$id_tipe_baju?>" target="_blank"><img border="0" src="images/excel2007.jpg" height="25" width="25" alt="Print to Excel" title="Save to Excel" /></a>

<img src="images/arrow2.gif" border="0">
<b><a href="<?= "?menu=5&uid=$uid&page=r_jadwal"; ?>">List All</a></b>
</div>

<hr size="1" color="#4B4B4B">

Halaman : <?=$pnumlink;?> &nbsp; Total : <b><?=$totalPage;?></b> halaman, <?=$totalRecord?> record.

<table width='1000' cellspacing='1' cellpadding='3'>
<tr bgcolor='#A7A7A7' height="25" align="center">
	<td rowspan='2'>No</td>
	<td rowspan='2'>Tanggal Acara</td>
	<td rowspan='2'>Waktu</td>
	<td rowspan='2'>Nama Pengantin</td>
	<td rowspan='2'>Acara</td>
	<td rowspan='2'>Tempat</td>
	<td rowspan='2'>Layanan</td>
	<td rowspan='2'>Jenis Baju</td>
	<td colspan='3'>Stok Baju</td>
</tr>
<tr bgcolor='#A7A7A7' height="25" align="center">
	<td>Kap</td>
	<td>Pakai</td>
	<td>Sisa</td>
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
    <td align='center'>".($offsetRecord+$ccc)."</td>";
?>
	<td><?= $rec['tanggal'];?></td>
	<td><?= $rec['waktu'];?></td>
	<td><?= $rec['nama_cpw'];?>/<?= $rec['nama_cpp'];?></td>
	<td><?= $rec['acara'];?></td>
	<td><?= $rec['tempat'];?></td>
	<td><?= $rec['detail_layanan']; ?></td>
	<td><?= $rec['tipe_baju'];?>/<?= $rec['jns_baju'];?></td>
	
	<td><?= $rec['jml_baju']; ?></td>
	

</td>
</tr>
<? 
/*<td><?= $rec['kap_baju']-$rec['jml_baju']; ?></td>*/
/*<td><?= $rec['kap_baju']; ?></td>*/
}

//echo $runSQL;
?>
</table>
Halaman : <?=$pnumlink;?> &nbsp; Total : <b><?=$totalPage;?></b> halaman, <?=$totalRecord?> record.