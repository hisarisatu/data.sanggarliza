<link rel="stylesheet" href="./src/lib/jquery-ui-1.11.1/jquery-ui.css">	
<script src="./src/lib/jquery-1.9.1.js" type="text/javascript"></script>
<script src="./src/lib/jquery-ui-1.11.1/jquery-ui.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="src/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="src/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="src/css/steel/steel.css" />

<? 
// Sisten Informasi Sanggar LIZA
// Written by iyok642@yahoo.com; 031-70920002
// 23 Agustus 2010, lastupdate 23 Agustus 2010
// 07 Oktober 2015  

include_once("include.php");
include_once("p_bulan.php");

function TanggalIndo($date){
	$BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
 
	$tahun = substr($date, 0, 4);
	$bulan = substr($date, 5, 2);
	$tgl   = substr($date, 8, 2);
 
	$result = $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;		
	return($result);
}


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


if($act=="delete_record"){
$sql="delete from non_client where id_non_client='$id'";
@mysql_query($sql);

}

//echo $bulan_rencana;
if ($cari <> ""){ 
	$cariSQL = strtoupper($cari);
	$filterSQL = " and upper(nama_cpw) like '%$cariSQL%'  ";
};//if

if ($id_pegawai==0) {$id_pegawai='%';}

if($bulan_rencana!="")
 	$filterSQL .= " and tanggal like '$thn_rencana-$bulan_rencana' ";
if($nama!="")
	$filterSQL .=" and nama like '%$nama%' ";

if($tanggal !="" && tanggal2 !="")
{$filterSQL .= " and tgl_acara BETWEEN '$tanggal' AND '$tanggal2'";}		

$pageFilter ="&tanggal=$tanggal&tanggal2=$tanggal2&nama=$nama";


$runSQL = "select count(*) total from (Select id_butik, nama, produk, tgl_acara, tgl_dateline, acara, hp, keterangan, harga
from butik

where 1=1 $filterSQL) b";


//echo $runSQL;
$result = mysql_query($runSQL, $connDB);
if ($row = mysql_fetch_array ($result)) { $totalRecord = $row[total]; };
$listRecord = 20;
$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter&cari=$cari&pnum=";
pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord);

unset($ii);
$runSQL = "Select id_butik, nama, produk, tgl_acara, tgl_dateline, acara, hp, keterangan, harga from butik
where 1=1 $filterSQL 
ORDER BY tgl_acara ASC LIMIT $offsetRecord, $listRecord";
//echo $runSQL;
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) {
	$ccc++;
	if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
	$htmlData .= "
	  <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
		  <td align='center'>".($offsetRecord+$ccc)."</td>
		  <td> $row[nama] </td>
		  
		  <td align='center'> ".TanggalIndo($row['tgl_dateline'])." </td>
		   <td > $row[produk] </td>
		   <td align='right'> ".number_format($row[harga],0)."</td>
		  <td align='center'> $row[acara] </td>
		  <td align='center'> ".TanggalIndo($row['tgl_acara'])." </td>
		  <td align='center'> $row[hp] </td>
		   <td > $row[keterangan] </td>
		  ";



//$htmlData .= "<td align='center' nowrap>	   <a href=\"javascript:void(window.open('cetak_bukti_non.php?id_non_client=$row[id_non_client]','operator','toolbar=0,width=900,height=200,top=0, left=60'));\"><img border='0' src='images/Printer.png'></a>";

$htmlData .= "</td><td align='center' nowrap>";
$htmlData .= "
		  <a href='?menu=$menu&uid=$uid&page=butik_input&id=$row[id_butik]'><img border='0' src='images/edit.gif' title='Edit Data'></a>
		 
";
$htmlData .= "</td></tr>";//htmlData


};//end-while

?>
<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Data Butik</b></font>

	 <table width="100%" border="0" cellpadding="5" cellspacing="0">
	  <tr>
		 <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
     <td valign="bottom"><b>Tanggal Acara:
     <input type='text' name='tanggal' id="tanggal" size='11' value='<?=$tanggal?>'>
			 - 
		<input type='text' name='tanggal2' id="tanggal2" size='11' value='<?=$tanggal2?>'>
        
        

 

			 <b> &nbsp; Nama  : 
			 <input type="text" name="nama" value="<?=$nama;?>" size="22"> 
			 <b> &nbsp;
			 <input type="submit" name="run" value="  Go  " class="button">
		 </td>
           <td valign="bottom" align="right">
			 <img src="images/arrow2.gif" border="0">
			 <b><a href="<?="?menu=$menu&uid=$uid&page=butik_input";?>">Input Baru</a> <!--| <a href="<?//= "?menu=$menu&uid=$uid&page=client&act=cari";?>">Cari</a>--></b>
		 </td>
     <td valign="bottom" align="right">
			 <img src="images/arrow2.gif" border="0">
			 <b><a href="<?="?menu=$menu&uid=$uid&page=butik";?>">List All</a> <!--| <a href="<?//= "?menu=$menu&uid=$uid&page=client&act=cari";?>">Cari</a>--></b>
		 </td>
         

		 </form>
         <script type="text/javascript">//<![CDATA[
    $(document).ready(function(){
       $('#tanggal').datepicker({ dateFormat: 'yy-mm-dd',changeMonth : true,
                changeYear : true }); 
       $('#tanggal2').datepicker({ dateFormat: 'yy-mm-dd',changeMonth : true,
                changeYear : true }); 
    });
	 //]]></script>
        <!-- <script type="text/javascript">//<![CDATA[

      var cal = Calendar.setup({
          onSelect: function(cal) { cal.hide() }
      });
      cal.manageFields("tanggal", "tanggal", "%Y-%m-%d");
      cal.manageFields("tanggal2", "tanggal2", "%Y-%m-%d");
    //]]></script>-->
         
         
	  </tr>
	 </table>

	 <table width='99%' cellspacing='1' cellpadding='3'>
		<tr>
		  <td colspan="12" align="left">
		  <hr size="1" color="#4B4B4B">
			Halaman : <?=$pnumlink;?> &nbsp; Total : <b><?=$totalPage;?></b> halaman, <?=$totalRecord?> record.
			</td>
		</tr>
        <!--=== bgcolor='#A7A7A7'====-->
		<tr bgcolor='#A7A7A7' height="25">
			<td width="4%" align='center'>NO</td>
			<td width="8%" align='center'>NAMA </td>
            <td width="8%" align='center'>TGL ACARA </td>
			
			<td width="15%" align='center'>PRODUK</td>
            <td width="7%" align='center'>HARGA</td>
            <td width="6%" align='center'>ACARA</td>
			<td width="7%" align='center'>DEADLINE</td>
            <td width="7%" align='center'>NO HP</td>
            <td width="7%" align='center'>KETERANGAN</td>
            
			
						
			<td width="3%" align='center'>EDIT</td>
			
		</tr>
		<?	if($act!="cari"){
				echo $htmlData;
			}?>
		<tr>
		  <td colspan="12" align="left">
			Halaman : <?=$pnumlink;?> &nbsp; Total : <b><?=$totalPage;?></b> halaman, <?=$totalRecord?> record.
			</td>
		</tr>
	 </table>

   </td>
  </tr>
</table>