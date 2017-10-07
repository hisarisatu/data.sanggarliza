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
if (($SAH[id_group]==1) or ($SAH[id_group]==5)) 
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



if($bulan_rencana!="")
  $filterSQL .= " and tanggal like '$thn_rencana-$bulan_rencana' ";

if($nama_perias!="")
  $filterSQL .=" and nama_perias like '%$nama_perias%' ";

if($tanggal !="" && $tanggal2 !="")
{ $filterSQL .= " and a.tanggal BETWEEN '$tanggal' AND '$tanggal2'";}  
 
 $pageFilter ="&tanggal=$tanggal&tanggal2=$tanggal2&thn_rencana=$thn_rencana&bulan_rencana=$bulan_rencana&nama_perias=$nama_perias";

$runSQL = "SELECT count(*) total from (SELECT distinct a.id_reperias, a.tanggal, a.id_perias, b.nama_perias
FROM retur_perias a
left join p_perias b on a.id_perias = b.id_perias 
where 1=1  $filterSQL) b";

//echo $runSQL;
$result = mysql_query($runSQL, $connDB);
if ($row = mysql_fetch_array ($result)) { $totalRecord = $row[total]; };
$listRecord = 20;
$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter&cari=$cari&pnum=";

pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord);

unset($ii);
$runSQL = "SELECT distinct a.id_reperias, a.id_perias, a.tanggal ,a.id_client, b.nama_perias, c.id_client, c.nama_cpw, c.alamat_cpw, d.id_reperias, d.tanggal as tgl_acara 
FROM retur_perias a
left join p_perias b     on a.id_perias = b.id_perias
left join acara_perias d on a.id_reperias = d.id_reperias
left join client c       on a.id_client = c.id_client 
where 1=1  $filterSQL    group by a.id_client, a.id_perias desc LIMIT $offsetRecord, $listRecord";

//echo $runSQL;
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) {
    $ccc++;
    if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
    $htmlData .= "
      <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"'>
          <td align='center'>".($offsetRecord+$ccc)."</td>
          <td> $row[id_client] </td>
          <td> $row[nama_cpw] </td>
          <td> $row[alamat_cpw] </td>
          <td> $row[nama_perias] </td>
          <td align='center'> $row[tgl_acara] </td>";

$htmlData .= "<td align='center' nowrap><a href='?menu=$menu&uid=$uid&page=view_returan&id=$row[id_reperias]'><img border='0' src='images/view.png' title='Lihat Data'></a></td>";
$htmlData .= "</tr>";
//htmlData
};
//end-while

?>
<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <tr>
   <td width="100%" align="center" vAlign="top">
     <font class="titledata"><b>Data Returan Perias</b></font>

     <table width="100%" border="0" cellpadding="5" cellspacing="0">
      <tr>
         <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
     <td valign="bottom"><b>Bulan Kegiatan:
        <input type='text' name='tanggal' id="tanggal" size='11' value='<?=$tanggal?>'>
             - 
        <input type='text' name='tanggal2' id="tanggal2" size='11' value='<?=$tanggal2?>'>
        
             <b> &nbsp; Nama Perias : <input type="text" name="nama_perias" value="<?=$nama_perias;?>" size="15">
             
               
             <input type="submit" name="run" value="  Go  " class="button">
         </td>
     <td valign="bottom" align="right">
             <img src="images/arrow2.gif" border="0">
             <b><a href="<?="?menu=$menu&uid=$uid&page=returan";?>">List All</a> <!--| <a href="<?//="?menu=$menu&uid=$uid&page=pesanan_cari";?>">Cari</a>--></b>
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
            <td align='center'>ID CLIENT</td>
            <td align='center'>NAMA CPW/</td>
            <td align='center'>ALAMAT</td>
            <td align='center'>NAMA PERIAS</td>
            <!--<td align='center'>ACARA</td>-->
            <td align='center'>TGL ACARA</td>
            <td align='center'>Detail<br>Returan</td>

        
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
<?php

} else {
echo "<div><font color='red' algin='center'> <b>Akses tidak diperbolehkan. Hanya Group Aministrator dan Keuangan</font></b> </div>";
}
?>