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
if (($SAH[id_group]==9) or ($SAH[id_group]==1))
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
/*
?>
<script language="JavaScript" src="calendar_us.js"></script>


<?
*/

/*
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
*/
//echo $bulan_rencana;
if ($cari <> ""){ 
  $cariSQL = strtoupper($cari);
  $filterSQL = "AND UPPER(nama_siswa) LIKE '%$cariSQL%' OR UPPER(id_siswa) LIKE '%$cariSQL%' OR UPPER(alamat) LIKE '%$cariSQL%' OR UPPER(no_telp) LIKE '%$cariSQL%' OR UPPER(email) LIKE '%$cariSQL%' OR UPPER(tgl_mulai) LIKE '%$cariSQL%' OR UPPER(tgl_selesai) LIKE '%$cariSQL%' OR UPPER(catatan) LIKE '%$cariSQL%' OR UPPER(created) LIKE '%$cariSQL%' OR UPPER(id_user) LIKE '%$cariSQL%' OR UPPER(id_pegawai) LIKE '%$cariSQL%'";
};//if

if ($id_pegawai==0) {$id_pegawai='%';}

if($bulan_rencana!="")
  $filterSQL .= " and tgl_mulai like '$thn_rencana-$bulan_rencana' ";
if($nama_siswa!="")
  $filterSQL .=" and nama_siswa like '%$nama_siswa%' ";
if($id_siswa!="")
  $filterSQL .=" and id_siswa like '%$id_siswa%' ";
if($id_pegawai!="")
  $filterSQL .=" and a.id_pegawai like '%$id_pegawai%' ";
if($tanggal !="" && tanggal2 !="")
{$filterSQL .= " and tgl_mulai BETWEEN '$tanggal' AND '$tanggal2'";}    

$pageFilter ="&tanggal=$tanggal&tanggal2=$tanggal2&thn_rencana=$thn_rencana&bulan_rencana=$bulan_rencana&id_siswa=$id_siswa&nama_siswa=$nama_siswa&id_pegawai=$id_pegawai";


$runSQL = "select count(*) total from (SELECT distinct a.id_siswa, a.nama_siswa, a.alamat, a.no_telp, a.email, a.tgl_mulai, a.tgl_selesai, a.catatan, a.created, a.id_user, a.login_ip, a.ip_update, a.user_update, a.last_update, ifnull(a.id_pegawai,'-')id_pegawai, ifnull(b.nama,'-')nama
FROM tb_siswa a
left join pegawai b on a.id_pegawai = b.id_pegawai 
where status = 'Aktif' $filterSQL) b";


//echo $runSQL;
$result = mysql_query($runSQL, $connDB);
if ($row = mysql_fetch_array ($result)) { $totalRecord = $row[total]; };
$listRecord = 20;
$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter&cari=$cari&pnum=";
pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord);

unset($ii);
$runSQL = "SELECT DISTINCT
  a.id_siswa,
  a.nama_siswa,
  a.alamat,
  a.no_telp,
  a.email,
  a.tgl_mulai,
  a.tgl_selesai,
  a.catatan,
  a.created,
  a.id_user,
  a.login_ip,
  a.ip_update,
  a.user_update,
  a.last_update,
  IFNULL(a.id_pegawai,'-') id_pegawai,
  IFNULL(b.nama,'-') nama,
  IFNULL(c.nama_program,'-') nama_program,
  IFNULL(d.nama_narasumber,'-') nama_narasumber
FROM tb_siswa a
  LEFT JOIN pegawai b
    ON a.id_pegawai = b.id_pegawai
  LEFT JOIN tb_program c
    ON a.id_program = c.id_program
  LEFT JOIN tb_narasumber d
    ON a.id_narasumber = d.id_narasumber
WHERE status = 'Aktif' $filterSQL
ORDER BY id_siswa DESC
LIMIT $offsetRecord, $listRecord";

//echo $runSQL;
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) {
  $ccc++;
  if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
  $htmlData .= "
    <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
      <td align='center'>".($offsetRecord+$ccc)."</td>
      <td> $row[nama_siswa] </td>
      
      <td> $row[no_telp] </td>
      <td> $row[email] </td>
      <td > $row[alamat] </td>
      
      <td> $row[nama_program] </td>
      <td> $row[nama_narasumber] </td>";
/*
$rch=mysql_query("select tanggal from acara where id_client='$row[id_client]' order by created desc");
$nc=@mysql_num_rows($rch);
if($nc!=0){
  $tg=mysql_result($rch,0,"tanggal");    
} else {
  $tg=$row[tgl_rencana];
}*/
$htmlData .= "<td align='center' nowrap>$row[tgl_mulai] - $row[tgl_selesai]";
//$htmlData .= "<td align='center' >$row[nama]";
if(($SAH[id_group]==1)or($SAH[id_group]==9)){
$htmlData .= "</td><td align='center' nowrap>";
$htmlData .= "
      <a href='?menu=$menu&uid=$uid&page=siswa_input&id=$row[id_siswa]'><img border='0' src='images/edit.gif' title='Edit Data'></a>      
";
}
$htmlData .= "</td></tr>";//htmlData
};//end-while

?>
<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <tr>
   <td width="100%" align="center" vAlign="top">
   <font class="titledata"><b>Data Siswa</b></font>

   <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr>
     <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
     <td valign="bottom"><b>Bulan Kegiatan:
     <input type='text' name='tanggal' id="tanggal" size='11' value='<?=$tanggal?>'>
       - 
    <input type='text' name='tanggal2' id="tanggal2" size='11' value='<?=$tanggal2?>'>
        
        

 

       <b> &nbsp; <input type="text" name="nama_siswa" value="<?=$nama_siswa;?>" placeholder="Nama Siswa" size="10"> &nbsp;  <input type="text" name="id_siswa" value="<?=$id_siswa;?>" placeholder="ID Siswa" size="10"> 
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
       <b><a href="<?="?menu=$menu&uid=$uid&page=program_belajar";?>">List All</a></b>
     </td>
     <td><a href="<?="?menu=$menu&uid=$uid&page=siswa_input";?>"><img border='0' src='images/add.gif' title='Input Siswa'></a></td>
         

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
      <td width="12%" align='center'>NAMA SISWA</td>
      <td width="8%" align='center'>NO TELEPON</td>
      <td width="9%" align='center'>EMAIL</td>
      <td width="8%" align='center'>ALAMAT</td>
      <td width="8%" align='center'>PROGRAM</td>
      <td width="8%" align='center'>NARASUMBER</td>
      <td width="10%" align='center'>TGL ACARA</td>
      <? if(($SAH[id_group]==1)or($SAH[id_group]==9)){ ?>
      <td width="8%" align='center'>EDIT<br>HAPUS</td>
      <? } ?>
    </tr>
    <?  if($act!="cari"){
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

<?php

}else{ echo "<div align='center'><font color='#FF0000'><b><br><br>Akses Tidak Diperbolehkan. Hanya Group Administrator dan Beauty Course</b></font></div>"; }
?>