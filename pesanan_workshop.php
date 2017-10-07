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
if (($SAH[id_group]==1)or($SAH[id_group]==9))
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
  $filterSQL = " and upper(nama_siswa) like '%$cariSQL%' or upper(id_siswa) like '%$cariSQL%' or upper(alamat) like '%$cariSQL%' or upper(no_telp) like '%$cariSQL%' or upper(email) like '%$cariSQL%' or upper(tgl_mulai) like '%$cariSQL%' or upper(tgl_selesai) like '%$cariSQL%' or upper(catatan) like '%$cariSQL%' ";
};//if

if($act=="delete_acara"){
$sql="delete from tb_acara_workshop where id_siswa='$id'";
@mysql_query($sql);
$sql="delete from siswa_diskon where id_siswa='$id'";
@mysql_query($sql);
$sql="delete from pegawai_tugas where id_siswa='$id'";
@mysql_query($sql);
$sql="delete from tb_pesanan_workshop where id_siswa='$id'";
@mysql_query($sql);
$act=null;
}

if ($id_pegawai==0) {$id_pegawai='%';}
if($bulan_rencana!="")
   $filterSQL = " and id_siswa in (select distinct id_siswa from tb_acara_workshop where tanggal like '$thn_rencana-$bulan_rencana-%')";
if($nama_siswa!="")
  $filterSQL .=" and nama_siswa like '%$nama_siswa%' ";
if($id_siswa!="")
  $filterSQL .=" and id_siswa like '%$id_siswa%' ";

if($id_pegawai!="")
$filterSQL .=" and a.id_pegawai like '%$id_pegawai%' ";
 if($tanggal !="" && tanggal2 !="")
{$filterSQL .= " and tgl_mulai BETWEEN '$tanggal' AND '$tanggal2'";}  
 
 $pageFilter ="&tanggal=$tanggal&tanggal2=$tanggal2&id_siswa=$id_siswa&nama_siswa=$nama_siswa&id_pegawai=$id_pegawai";

$runSQL = "select count(*) total from (SELECT distinct a.id_siswa, a.nama_siswa, a.alamat, a.no_telp, a.email, a.tgl_mulai, a.tgl_selesai, a.catatan, a.created, a.last_update,ifnull(a.id_pegawai,'-')id_pegawai, ifnull(b.nama,'-')nama
FROM tb_siswa a
left join pegawai b on a.id_pegawai = b.id_pegawai 
where 1=1 and id_siswa in (select distinct id_siswa from tb_acara_workshop) $filterSQL)b";
//echo $runSQL;
$result = mysql_query($runSQL, $connDB);
if ($row = mysql_fetch_array ($result)) { $totalRecord = $row[total]; };
$listRecord = 20;
$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter&cari=$cari&pnum=";

pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord);

unset($ii);
$runSQL = "SELECT distinct a.id_siswa, a.nama_siswa, a.alamat, a.no_telp, a.email, a.catatan, a.created, c.id_program, c.nama_program, DATE_FORMAT(a.tgl_mulai, '%d-%m-%Y') tgl_mulai, DATE_FORMAT(a.tgl_selesai, '%d-%m-%Y') tgl_selesai, a.last_update,ifnull(a.id_pegawai,'-')id_pegawai, ifnull(b.nama,'-')nama
FROM tb_siswa a
left join pegawai b on a.id_pegawai = b.id_pegawai
left join tb_program c on a.id_program = c.id_program 
where 1=1 and id_siswa in (select distinct id_siswa from tb_acara_workshop) $filterSQL order by date_format(tgl_mulai,'%Y-%m-%d') desc LIMIT $offsetRecord, $listRecord";//echo $runSQL;
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) {
  $ccc++;
  if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
  $htmlData .= "
    <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"'>
      <td align='center'>".($offsetRecord+$ccc)."</td>
      <td> $row[nama_siswa]</td>
      <td> $row[alamat] </td>
      <td> $row[no_telp] </td>
      <td> $row[nama_program] </td>
      <td> $row[tgl_mulai] - $row[tgl_selesai] </td>
      <td align='center'> $row[nama] </td>";

$htmlData .= "<td align='center' nowrap><a href='?menu=$menu&uid=$uid&page=view_workshop&id=$row[id_siswa]'><img border='0' src='images/view.png' title='Lihat Data'></a></td>";
$htmlData .= "</tr>";//htmlData
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
        
       <b> &nbsp; <input type="text" name="nama_siswa" value="<?=$nama_siswa;?>" size="10" placeholder="Nama"> <input type="text" name="id_siswa" value="<?=$id_siswa;?>" size="10" placeholder="ID Siswa">
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
       <b><a href="<?="?menu=$menu&uid=$uid&page=pesanan";?>">List All</a> <!--| <a href="<?//="?menu=$menu&uid=$uid&page=pesanan_cari";?>">Cari</a>--></b>
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
      <td align='center'>NAMA SISWA</td>
      <td align='center'>ALAMAT</td>
      <td align='center'>NO TELEPON</td>
      <td align='center'>PROGRAM</td>
      <td align='center'>TGL ACARA</td>
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
<?
}
else
{echo"</br>";
echo"</br>";
echo "<div align='center'><font color='#FF0000'><b>Akses Tidak Diperbolehkan. Hanya Group Administrator dan Beauty Course</b></font></div>"; }
?>