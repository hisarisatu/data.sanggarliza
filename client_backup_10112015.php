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
$sql="delete from client where id_client='$id'";
@mysql_query($sql);
$sql="delete from acara where id_client='$id'";
@mysql_query($sql);
$sql="delete from client_bayar where id_client='$id'";
@mysql_query($sql);
$sql="delete from client_busana where id_client='$id'";
@mysql_query($sql);
$sql="delete from client_diskon where id_client='$id'";
@mysql_query($sql);
$sql="delete from konsultasi where id_client='$id'";
@mysql_query($sql);
$sql="delete from _tugas where id_client='$id'";
@mysql_query($sql);
$sql="delete from pengeluaran where id_client='$id'";
@mysql_query($sql);
$sql="delete from pesanan_plus where id_client='$id'";
@mysql_query($sql);
$act=null;
}

//echo $bulan_rencana;
if ($cari <> ""){ 
	$cariSQL = strtoupper($cari);
	$filterSQL = " and upper(nama_cpw) like '%$cariSQL%' or upper(nama_ortu_cpw) like '%$cariSQL%' or upper(tlp_rumah_cpw) like '%$cariSQL%' or upper(tlp_mobile_cpw) like '%$cariSQL%' or upper(alamat_cpw) like '%$cariSQL%' or upper(nama_cpp) like '%$cariSQL%' or upper(nama_ortu_cpp) like '%$cariSQL%' or upper(tlp_rumah_cpp) like '%$cariSQL%' or upper(tlp_mobile_cpp) like '%$cariSQL%' or upper(alamat_cpp) like '%$cariSQL%' or upper(id_pegawai) like '%$cariSQL%' ";
};//if

if ($id_pegawai==0) {$id_pegawai='%';}

if($bulan_rencana!="")
 	$filterSQL .= " and tgl_rencana like '$thn_rencana-$bulan_rencana' ";
if($nama_cpw!="")
	$filterSQL .=" and nama_cpw like '%$nama_cpw%' ";
if($id_pegawai!="")
	$filterSQL .=" and a.id_pegawai like '%$id_pegawai%' ";
if($tanggal !="" && tanggal2 !="")
{$filterSQL .= " and tgl_rencana BETWEEN '$tanggal' AND '$tanggal2'";}		

$pageFilter ="&tanggal=$tanggal&tanggal2=$tanggal2&thn_rencana=$thn_rencana&bulan_rencana=$bulan_rencana&nama_cpw=$nama_cpw&id_pegawai=$id_pegawai";


$runSQL = "select count(*) total from (SELECT distinct a.id_client, a.nama_cpw, a.nama_ortu_cpw, a.tlp_rumah_cpw, a.tlp_mobile_cpw, a.alamat_cpw, a.nama_cpp, a.nama_ortu_cpp, a.tlp_rumah_cpp, a.tlp_mobile_cpp, a.alamat_cpp, a.tgl_rencana, a.catatan, a.last_update, ifnull(a.id_pegawai,'-')id_pegawai, ifnull(b.nama,'-')nama
FROM client a
left join pegawai b on a.id_pegawai = b.id_pegawai 
where 1=1 $filterSQL) b";


//echo $runSQL;
$result = mysql_query($runSQL, $connDB);
if ($row = mysql_fetch_array ($result)) { $totalRecord = $row[total]; };
$listRecord = 20;
$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter&cari=$cari&pnum=";
pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord);

unset($ii);
$runSQL = "SELECT distinct a.id_client, a.nama_cpw, a.nama_ortu_cpw, a.tlp_rumah_cpw, a.tlp_mobile_cpw, a.alamat_cpw, a.nama_cpp, a.nama_ortu_cpp, a.tlp_rumah_cpp, a.tlp_mobile_cpp, a.alamat_cpp, a.tgl_rencana, a.catatan, a.last_update,ifnull(a.id_pegawai,'-')id_pegawai, ifnull(b.nama,'-')nama
FROM client a
left join pegawai b on a.id_pegawai = b.id_pegawai 
where 1=1 $filterSQL 
order by id_client desc LIMIT $offsetRecord, $listRecord";
//echo $runSQL;
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) {
	$ccc++;
	if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
	$htmlData .= "
	  <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
		  <td align='center'>".($offsetRecord+$ccc)."</td>
		  <td nowrap> $row[nama_cpw] </td>
		  <td> $row[nama_ortu_cpw] </td>
		  <td> $row[tlp_mobile_cpw] </td>
		  <td> $row[alamat_cpw] </td>
		  <td nowrap> $row[nama_cpp] </td>
		  <td> $row[nama_ortu_cpp] </td>
		  <td> $row[tlp_mobile_cpp] </td>
		  <td> $row[alamat_cpp] </td> ";
/*
$rch=mysql_query("select tanggal from acara where id_client='$row[id_client]' order by created desc");
$nc=@mysql_num_rows($rch);
if($nc!=0){
  $tg=mysql_result($rch,0,"tanggal");    
} else {
  $tg=$row[tgl_rencana];
}*/
$htmlData .= "<td align='center' nowrap>$row[tgl_rencana]";
$htmlData .= "<td align='center' >$row[nama]";
$htmlData .= "<td align='center' nowrap>
		  <a href='?menu=$menu&uid=$uid&page=client_lihat&id=$row[id_client]'><img border='0' src='images/view.png' title='Edit Data'></a>";
if($SAH[id_group]==1){
$htmlData .= "</td><td align='center' nowrap>";
$htmlData .= "
		  <a href='?menu=$menu&uid=$uid&page=client_input&id=$row[id_client]'><img border='0' src='images/edit.gif' title='Edit Data'></a>
		  <a href='?menu=$menu&uid=$uid&page=client_delete&id=$row[id_client]'><img border='0' src='images/del.gif' title='Hapus Data'></a>
";
}
$htmlData .= "</td></tr>";//htmlData
};//end-while

?>
<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Data Client</b></font>

	 <table width="100%" border="0" cellpadding="5" cellspacing="0">
	  <tr>
		 <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
     <td valign="bottom"><b>Bulan Kegiatan:
     <input type='text' name='tanggal' id="tanggal" size='11' value='<?=$tanggal?>'>
			 - 
		<input type='text' name='tanggal2' id="tanggal2" size='11' value='<?=$tanggal2?>'>
        
        

 

			 <b> &nbsp; Nama CPW : <input type="text" name="nama_cpw" value="<?=$nama_cpw;?>" size="15"> 
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
			 <b><a href="<?="?menu=$menu&uid=$uid&page=client";?>">List All</a> <!--| <a href="<?//= "?menu=$menu&uid=$uid&page=client&act=cari";?>">Cari</a>--></b>
		 </td>
         

		 </form>
         <script type="text/javascript">//<![CDATA[
    $(document).ready(function(){
       $('#tanggal').datepicker({ dateFormat: 'yy-mm-dd' }); 
       $('#tanggal2').datepicker({ dateFormat: 'yy-mm-dd' }); 
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

	 <table width='96%' cellspacing='1' cellpadding='3'>
		<tr>
		  <td colspan="12" align="left">
		  <hr size="1" color="#4B4B4B">
			Halaman : <?=$pnumlink;?> &nbsp; Total : <b><?=$totalPage;?></b> halaman, <?=$totalRecord?> record.
			</td>
		</tr>
		<tr bgcolor='#A7A7A7' height="25">
			<td width="4%" align='center'>NO</td>
			<td width="4%" align='center'>NAMA CPW</td>
			<td width="10%" align='center'>ORTU CPW</td>
			<td width="6%" align='center'>HP CPW</td>
			<td width="11%" align='center'>ALAMAT CPW</td>
			<td width="9%" align='center'>NAMA CPP</td>
			<td width="8%" align='center'>ORTU CPP</td>
			<td width="6%" align='center'>HP CPP</td>
			<td width="11%" align='center'>ALAMAT CPP</td>
			<td width="12%" align='center'>TGL RENCANA</td>
            <td width="11%" align='center'>PETUGAS CS</td>
            <td width="11%" align='center'>LIHAT</td>
			<? if($SAH[id_group]==1){ ?>
			<td width="8%" align='center'>EDIT<br>HAPUS</td>
			<? } ?>
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