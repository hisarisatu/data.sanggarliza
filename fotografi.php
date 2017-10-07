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
//echo $bulan_rencana;
if ($cari <> ""){ 
	$cariSQL = strtoupper($cari);
	$filterSQL = " and upper(nama_cpw) like '%$cariSQL%' or upper(nama_ortu_cpw) like '%$cariSQL%' or upper(tlp_rumah_cpw) like '%$cariSQL%' or upper(tlp_mobile_cpw) like '%$cariSQL%' or upper(alamat_cpw) like '%$cariSQL%' or upper(nama_cpp) like '%$cariSQL%' or upper(nama_ortu_cpp) like '%$cariSQL%' or upper(tlp_rumah_cpp) like '%$cariSQL%' or upper(tlp_mobile_cpp) like '%$cariSQL%' or upper(alamat_cpp) like '%$cariSQL%' ";
};//if

if($act=="delete_acara"){
$sql="delete from acara where id_client='$id'";
@mysql_query($sql);
$sql="delete from client_diskon where id_client='$id'";
@mysql_query($sql);
$sql="delete from pegawai_tugas where id_client='$id'";
@mysql_query($sql);
$sql="delete from pesanan_plus where id_client='$id'";
@mysql_query($sql);
$act=null;
}

if ($id_pegawai==0) {$id_pegawai='%';}
if($bulan_rencana!="")
	 $filterSQL = " and id_client in (select distinct id_client from acara where tanggal like '$thn_rencana-$bulan_rencana-%')";


if($id_pegawai!="")
$filterSQL .=" and a.id_pegawai like '%$id_pegawai%' ";
 if($tanggal !="" && tanggal2 !="")
{$filterSQL .= " and tanggal BETWEEN '$tanggal' AND '$tanggal2'";}	
 
 $pageFilter ="&tanggal=$tanggal&tanggal2=$tanggal2&id_pegawai=$id_pegawai";

$runSQL = "select count(*) total from (SELECT a.nama_cpw, c.acara, b.tanggal, b.waktu, e.nama_paket, ifnull( f.nama, '-' ) nama
FROM client a
LEFT JOIN acara b ON b.id_client = a.id_client
LEFT JOIN p_acara c ON b.id_acara = c.id_acara
LEFT JOIN paket e ON b.id_paket = e.id_paket
LEFT JOIN pegawai f ON a.id_pegawai = f.id_pegawai
WHERE b.id_paket
IN ( 128, 129, 130, 131, 132, 133, 172, 173, 174, 175, 176, 177, 178, 179, 185,180,181,182,183 ) $filterSQL
GROUP BY b.id_client
UNION ALL
SELECT a.nama_cpw, c.acara, b.tanggal, b.waktu, e.detail_layanan, ifnull( g.nama, '-' ) nama
FROM client a
LEFT JOIN acara b ON b.id_client = a.id_client
LEFT JOIN p_acara c ON b.id_acara = c.id_acara
LEFT JOIN pesanan_plus f ON b.id_client = f.id_client
LEFT JOIN p_sublayanan e ON f.id_sublayanan = e.id_sublayanan
LEFT JOIN pegawai g ON a.id_pegawai = g.id_pegawai
WHERE f.id_sublayanan
IN ( 2241, 1659, 1777, 1835, 1610, 1740, 1856, 1917, 1919, 2116, 2247, 1603, 1648, 1554, 1919, 1917, 1211, 1586, 1568,261,286,294,295,429,963,1310,2241,296,322,405,417,637,1211,1959) $filterSQL
GROUP BY f.id_client
 )b";
//echo $runSQL;
$result = mysql_query($runSQL, $connDB);
if ($row = mysql_fetch_array ($result)) { $totalRecord = $row[total]; };
$listRecord = 20;
$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter&cari=$cari&pnum=";

pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord);

unset($ii);
$runSQL = "(SELECT b.id_client,a.nama_cpw, c.acara,b.tanggal, date_format(b.tanggal,'%d-%m-%Y')tanggal1, b.waktu, b.tempat, e.nama_paket as detail, ifnull( f.nama, '-' ) nama
FROM client a
LEFT JOIN acara b ON b.id_client = a.id_client
LEFT JOIN p_acara c ON b.id_acara = c.id_acara
LEFT JOIN paket e ON b.id_paket = e.id_paket
LEFT JOIN pegawai f ON a.id_pegawai = f.id_pegawai
WHERE b.id_paket
IN ( 128, 129, 130, 131, 132, 133, 172, 173, 174, 175, 176, 177, 178, 179, 185,180,181,182,183 ) $filterSQL
GROUP BY b.id_client)
UNION all
(SELECT b.id_client,a.nama_cpw, c.acara,b.tanggal, date_format(b.tanggal,'%d-%m-%Y')tanggal1, b.waktu, b.tempat, e.detail_layanan as detail, ifnull( g.nama, '-' ) nama
FROM client a
LEFT JOIN acara b ON b.id_client = a.id_client
LEFT JOIN p_acara c ON b.id_acara = c.id_acara
LEFT JOIN pesanan_plus f ON b.id_client = f.id_client
LEFT JOIN p_sublayanan e ON f.id_sublayanan = e.id_sublayanan
LEFT JOIN pegawai g ON a.id_pegawai = g.id_pegawai
WHERE f.id_sublayanan
IN ( 2241, 1659, 1777, 1835, 1610, 1740, 1856, 1917, 1919, 2116, 2247, 1603, 1648, 1554, 1919, 1917, 1211, 1586, 1568,261,286,294,295,429,963,1310,2241,296,322,405,417,637,1211,1959,2470 ) $filterSQL
GROUP BY f.id_client)
ORDER BY tanggal DESC 
LIMIT $offsetRecord, $listRecord";//echo $runSQL; 
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) {
	$ccc++;
	if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
	$htmlData .= "
	  <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"'>
		  <td align='center'>".($offsetRecord+$ccc)."</td>
		  <td> $row[nama_cpw] </td>
		  <td> $row[acara] </td>
		  <td> $row[tanggal1] </td>
		  <td> $row[detail] </td>
		  <td align='center'> $row[nama] </td>";

$htmlData .= "<td align='center' nowrap><a href='?menu=$menu&uid=$uid&page=view_fotografi&id=$row[id_client]'><img border='0' src='images/view.png' title='Lihat Data'></a></td>";

;//htmlData
};//end-while

?>
<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Data Pesanan</b></font>

	 <table width="100%" border="0" cellpadding="5" cellspacing="0">
	  <tr>
		 <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
     <td valign="bottom"><b>Bulan Kegiatan:
 <input type='text' name='tanggal' id="tanggal" size='11' value='<?=$tanggal?>'>
			 - 
		<input type='text' name='tanggal2' id="tanggal2" size='11' value='<?=$tanggal2?>'>
        
			
             
                <b> &nbsp; Petugas CS : 
<?
js_submit();
$sqlpetugas="select distinct a.id_pegawai,a.nama from pegawai a,pegawai_pekerjaan b
where a.id_pegawai=b.id_pegawai and b.id_pekerjaan=23 union select 0,'--Pilih Petugas CS--' from dual";
generate_select_event("id_pegawai",$sqlpetugas,$id_pegawai,"submit_form()"); 
?>
			 <input type="submit" name="run" value="  Go  " class="button">
		 </td>
     <td valign="bottom" align="right">
			 <img src="images/arrow2.gif" border="0">
			 <b><a href="<?="?menu=$menu&uid=$uid&page=fotografi";?>">List All</a> <!--| <a href="<?//="?menu=$menu&uid=$uid&page=pesanan_cari";?>">Cari</a>--></b>
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
	  </tr>
	  </tr>
	 </table>

	 <table width='100%' cellspacing='1' cellpadding='3'>
		<tr>
		  <td colspan="12" align="left">
		  <hr size="1" color="#4B4B4B">
			Halaman : <?=$pnumlink;?> &nbsp; Total : <b><?=$totalPage;?></b> halaman, <?=$totalRecord?> record.
			</td>
		</tr>
        <!--===== bgcolor='#A7A7A7'=====-->
		<tr bgcolor='#A7A7A7' height="25">
			<td align='center'>NO</td>
			<td align='center'>NAMA CPW</td>
			<td align='center'>ACARA</td>
			<td align='center'>TANGGAL</td>
			<td align='center'>PAKET</td>
            <td align='center'>Petugas CS</td>
			<td align='center'>Detail<br>Pesanan</td>
			
		</tr>
		<?=$htmlData;?>
		<tr>
		  <td colspan="12" align="left">
			Halaman : <?=$pnumlink;?> &nbsp; Total : <b><?=$totalPage;?></b> halaman, <?=$totalRecord?> record.
			</td>
		</tr>
	 </table>

   </td>
  </tr>
</table>