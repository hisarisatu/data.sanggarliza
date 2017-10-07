 
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


$pageFilter ="&tanggal=$tanggal&tanggal2=$tanggal2&id_pegawai=$id_pegawai";

if ($cari <> ""){ 
	$cariSQL = strtoupper($cari);
	$filterSQL = " and upper(nama_cpw) like '%$cariSQL%' or upper(nama_ortu_cpw) like '%$cariSQL%' or upper(tlp_rumah_cpw) like '%$cariSQL%' or upper(tlp_mobile_cpw) like '%$cariSQL%' or upper(alamat_cpw) like '%$cariSQL%' or upper(nama_cpp) like '%$cariSQL%' or upper(nama_ortu_cpp) like '%$cariSQL%' or upper(tlp_rumah_cpp) like '%$cariSQL%' or upper(tlp_mobile_cpp) like '%$cariSQL%' or upper(alamat_cpp) like '%$cariSQL%' or upper(id_pegawai) like '%$cariSQL%' ";
};//if
				//if (!$tanggal) {$tanggal=date_format(current_date(),'%Y-%m-1');}
				//if (!$tanggal2) {$tanggal2=date_format(current_date(),'%Y-%m-%d');}
              //  if ($id_tipe_baju==0) {$id_tipe_baju='%';}
			//	if ($id_baju==0) {$id_baju='%';}

if ($id_pegawai==0) {$id_pegawai='%';}
             ////   if($id_tipe_baju !="") { $filterSQL = " and g.id_tipe_baju like '$id_tipe_baju' "; }
			//	if($id_baju !="") { $filterSQL .= " and g.id_baju like '$id_baju' "; }
			if($id_pegawai!="") $filterSQL .=" and a.id_pegawai like '%$id_pegawai%' ";
			//if($tanggal !="" && tanggal2 !="") {$filterSQL .= " and tanggal BETWEEN '$tanggal' AND '$tanggal2' ";}
            if($nama_cpw!="") $filterSQL .=" and a.nama_cpw like '%$nama_cpw%' ";
			
//echo $filterSQL;
//echo $filterSQL1;
			
$runSQL = "select count(*) total from 
(SELECT distinct a.nama_cpw, a.nama_cpp, b.detail_layanan, b.jml_orang, b.harga, b.satuan, c.nama, c.id_pegawai from client a, pesanan_bebas b, pegawai c where b.id_client=a.id_client and a.id_pegawai=c.id_pegawai $filterSQL ) b ";
		
$result = mysql_query($runSQL, $connDB);
if ($row = mysql_fetch_array ($result)) { $totalRecord = $row[total]; };
$listRecord = 30;
$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter$cari&pnum=";
pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord);

//echo $runSQL;


$runSQL = "	SELECT a.nama_cpw, a.nama_cpp, b.detail_layanan, b.jml_orang, b.harga, b.satuan, c.nama, c.id_pegawai from client a, pesanan_bebas b, pegawai c where b.id_client=a.id_client and a.id_pegawai=c.id_pegawai $filterSQL
 
order by id_bebas desc LIMIT $offsetRecord, $listRecord  ";


?>


<form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
<div align="center" style="width:100%">
<fieldset style="width:600"><legend><strong>Filter</strong></legend>
<table>

<tr>
  <td><b>Petugas CS </b></td><td><b>:</b></td>
  <td>
  <?
js_submit();
$sqlpetugas="select distinct a.id_pegawai,a.nama from pegawai a,pegawai_pekerjaan b
where a.id_pegawai=b.id_pegawai and b.id_pekerjaan=23 union select 0,'--Pilih Petugas CS--' from dual";
generate_select_event("id_pegawai",$sqlpetugas,$id_pegawai,"submit_form()"); 
?>
  </td>
</tr>
<tr>
<td><b>Nama CPW </b></td><td><b>:</b></td>
<td>
<input type="text" name="nama_cpw" value="<?=$nama_cpw;?>" size="15">
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
<div align="center"><font class="titledata"><b>Laporan Konsultasi Layanan Bebas</b></font></div>

<div align="right"><a href="cetak_report.php?tanggal=<?=$tanggal?>&tanggal2=<?=$tanggal2?>&id_layanan=<?=$id_layanan?>&id_pegawai=<?=$id_pegawai?>" target="_blank"><img border="0" src="images/excel2007.jpg" height="25" width="25" alt="Print to Excel" title="Save to Excel" /></a><img src="images/arrow2.gif" border="0">
<b><a href="<?= "?menu=5&uid=$uid&page=inq_r_layanan_bebas"; ?>">List All</a></b>
</div>

<hr size="1" color="#4B4B4B">

Halaman : <?=$pnumlink;?> &nbsp; Total : <b><?=$totalPage;?></b> halaman, <?=$totalRecord?> record.

<table width='863' cellspacing='1' cellpadding='3'>
<tr bgcolor='#A7A7A7' height="25" align="center">
	<td width="59" >No</td>
	<td width="107" >Nama CPW/CPP</td>
	
	<td width="178" >Nama Petugas CS</td>
	<td width="381" >Detail Layanan Bebas</td>
	<td width="117" >Harga Layanan Bebas</td>
  
	
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
	
	<td><?= $rec['nama_cpw'];?>/<?= $rec['nama_cpp'];?></td>
    <td><?= $rec['nama'];?></td>
	<td><?= $rec['detail_layanan'];?></td>
	<td><?= $rec['harga'];?></td>

	


</tr>
<? 

}

//echo $runSQL;
?>
</table>
Halaman : <?=$pnumlink;?> &nbsp; Total : <b><?=$totalPage;?></b> halaman, <?=$totalRecord?> record.