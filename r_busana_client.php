   <!-- 
    <script src="src/js/jscal2.js"></script>
    <script src="src/js/lang/en.js"></script>
    -->
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

?>
  <!--  
<script language="JavaScript" src="calendar_us.js"></script>
-->

<?php



$pageFilter ="&tanggal=$tanggal&tanggal2=$tanggal2&id_client=$id_client";
                
				//if (!$tanggal) {$tanggal=date(now(),'%Y-%m-1');}
				//if (!$tanggal2) {$tanggal2=date(now(),'%Y-%m-%d');}
                if ($id_client==0) {$id_client='%';}
				if($id_client !="") { $filterSQL = " and a.id_client like '$id_client' "; }				
				if($tanggal !="" && tanggal2 !="") {$filterSQL .= " and tanggal BETWEEN '$tanggal' AND '$tanggal2' ";}
				if($tanggal !="" && tanggal2 !="") {$filterSQL1 = " and tanggal BETWEEN '$tanggal' AND '$tanggal2' ";}
			
//echo $filterSQL;

			
$runSQL = "select count(*) total from 
(select distinct a.id_client,a.id_acara,a.tanggal, a.waktu, a.created, b.acara,a.tempat,
c.nama_cpw,c.nama_cpp CP,e.detail_layanan
from acara a,p_acara b,client c,paket_sub_paket d,p_sublayanan e, client_busana g,p_baju_tipe h,p_baju i,p_baju_tipe j,p_baju k
where 1=1 $filterSQL
and a.id_acara=b.id_acara 
and a.id_client=c.id_client
and a.id_paket=d.id_paket    
and a.id_acara=g.id_acara 
and a.id_client=g.id_client 
and a.id_paket=g.id_paket
and d.id_sublayanan=g.id_plus
and g.id_plus=e.id_sublayanan 
and g.id_tipe_baju=h.id_tipe_baju
and g.id_tipe_baju=i.id_tipe_baju
and g.id_baju=i.id_layanan
and g.id_tipe_kain=j.id_tipe_baju
and g.id_tipe_kain=k.id_tipe_baju
and g.id_kain=k.id_layanan ) b ";
		
$result = mysql_query($runSQL, $connDB);
if ($row = mysql_fetch_array ($result)) { $totalRecord = $row[total]; };
$listRecord = 30;
$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter$cari&pnum=";
pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord);

//echo $runSQL;



$runSQL = "	select distinct a.id_client,a.id_acara,a.tanggal, a.waktu, a.created, b.acara,a.tempat,
c.nama_cpw,c.nama_cpp,e.detail_layanan,h.keterangan tipe_baju,i.layanan jns_baju,g.jml_baju,
j.keterangan tipe_kain,k.layanan jns_kain,g.jml_kain
from acara a,p_acara b,client c,paket_sub_paket d,p_sublayanan e, client_busana g,p_baju_tipe h,p_baju i,p_baju_tipe j,p_baju k
where 1=1 $filterSQL 
and a.id_acara=b.id_acara 
and a.id_client=c.id_client
and a.id_paket=d.id_paket    
and a.id_acara=g.id_acara 
and a.id_client=g.id_client 
and a.id_paket=g.id_paket
and d.id_sublayanan=g.id_plus
and g.id_plus=e.id_sublayanan 
and g.id_tipe_baju=h.id_tipe_baju
and g.id_tipe_baju=i.id_tipe_baju
and g.id_baju=i.id_layanan
and g.id_tipe_kain=j.id_tipe_baju
and g.id_tipe_kain=k.id_tipe_baju
and g.id_kain=k.id_layanan
order by tanggal desc,id_client asc
LIMIT $offsetRecord, $listRecord  ";

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
<td><b>Nama Client </b></td><td><b>:</b></td>
<td>
<?php
js_submit();
$sqlclient="select distinct a.id_client,concat( `nama_cpw` , '/', `nama_cpp` ) namacp from client a,acara b 
where a.id_client=b.id_client $filterSQL1
union select '0','--Pilih Nama Client--' from dual";
generate_select_event("id_client",$sqlclient,$id_client,"submit_form()"); 
?>
</td>
</tr>
<tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><input type="submit" name="run" value="  Go  " class="button"></td>
    <tr>
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
      var cal = Calendar.setup({
          onSelect: function(cal) { cal.hide() }
      });
      cal.manageFields("tanggal", "tanggal", "%Y-%m-%d");
      cal.manageFields("tanggal2", "tanggal2", "%Y-%m-%d");
      */
    //]]></script>
<div align="center"><font class="titledata"><b>Laporan Pengunaan Baju & Kain</b></font></div>

<div align="right">
<a href="cetak_r_busana_client.php?tanggal=<?=$tanggal?>&tanggal2=<?=$tanggal2?>&id_client=<?=$id_client?>?>" target="_blank"><img border="0" src="images/excel2007.jpg" height="25" width="25" alt="Print to Excel" title="Save to Excel" /></a>
<img src="images/arrow2.gif" border="0">
<b><a href="<?= "?menu=5&uid=$uid&page=r_busana_client"; ?>">List All</a></b>
</div>

<hr size="1" color="#4B4B4B">

Halaman : <?=$pnumlink;?> &nbsp; Total : <b><?=$totalPage;?></b> halaman, <?=$totalRecord?> record.

<table width='1000' cellspacing='1' cellpadding='3'>
<tr bgcolor='#A7A7A7' height="25" align="center">
	<td>No</td>
	<td>Tanggal Acara</td>
	<td>Waktu</td>
	<td>Nama Pengantin</td>
	<td>Acara</td>
	<td>Tempat</td>
	<td>Layanan</td>
	<td>Jenis Baju</td>
	<td>Jml Baju</td>
	<td>Jenis Kain</td>
	<td>Jml Kain</td>	
</tr>
<?php
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
	<td><?= $rec['tipe_kain'];?>/<?= $rec['jns_kain'];?></td>
	<td><?= $rec['jml_kain']; ?></td>

</td>
</tr>
<? 

}

//echo $runSQL;
?>
</table>
Halaman : <?=$pnumlink;?> &nbsp; Total : <b><?=$totalPage;?></b> halaman, <?=$totalRecord?> record.