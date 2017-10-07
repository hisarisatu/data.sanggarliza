  <link rel="stylesheet" href="./src/lib/jquery-ui-1.11.1/jquery-ui.css"> 
<script src="./src/lib/jquery-1.9.1.js" type="text/javascript"></script>
<script src="./src/lib/jquery-ui-1.11.1/jquery-ui.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="src/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="src/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="src/css/steel/steel.css" />


<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 10 Oktober 2010, lastupdate 10 Oktober 2010

include_once("include.php");
include_once("p_bulan.php");



if($nama_cpw!="")
  $filterSQL .=" and nama_cpw like '%$nama_cpw%' ";
if($id_client!="")
  $filterSQL .=" and id_client like '%$id_client%' ";
if($tanggal !="" && tanggal2 !="")
{$filterSQL .= " and tanggal BETWEEN '$tanggal' AND '$tanggal2'";}    


$pageFilter ="&tanggal=$tanggal&tanggal2=$tanggal2&id_client=$id_client&nama_cpw=$nama_cpw";




$runSQL = "SELECT count(*) total FROM `acara` a, p_acara b, client c, pegawai_tugas d WHERE a.id_acara = b.id_acara AND a.id_client = c.id_client AND a.id_client=d.id_client AND a.id_acara=d.id_acara AND d.status='1' AND d.tgl_notif <= DATE_ADD(CURDATE(), INTERVAL 30 DAY) $filterSQL";
$result = mysql_query($runSQL, $connDB);
if ($row = mysql_fetch_array ($result)) { $totalRecord = $row[total]; };
$listRecord = 20;
$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter&cari=$cari&pnum=";
pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord);

unset($ii);
$runSQL = "SELECT DISTINCT DATE_FORMAT(a.tanggal,'%d-%m-%Y') tgl_acara, b.acara, c.id_client, c.nama_cpw, c.nama_cpp, a.tempat,a.id_client,a.id_acara, d.id_pegawai,d.id_client,d.id_acara, d.created, a.tanggal, e.id_pegawai, e.nama, d.status AS status_mc
FROM acara a, p_acara b, client c, pegawai_tugas d, pegawai e
WHERE a.id_client=c.id_client AND a.id_client=d.id_client AND a.id_acara=d.id_acara AND d.id_pegawai=e.id_pegawai
AND a.id_acara=b.id_acara AND d.status='1' AND d.tgl_notif <= DATE_ADD(CURDATE(), INTERVAL 30 DAY) $filterSQL ORDER BY a.tanggal ASC LIMIT $offsetRecord, $listRecord"; 
//echo $runSQL;//developer
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) {

$sql_sts="SELECT DISTINCT
  id_client,
  id_acara,
  id_tugas,
  id_pegawai,
  status
FROM 
  pegawai_tugas 
WHERE id_client=".$row['id_client']." and id_acara=".$row['id_acara']." ";
  
  $data_sts = mysql_query($sql_sts);
  $data_sts = mysql_fetch_assoc($data_sts);
  $ccc++;
  if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
  $htmlData .= "
    <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"'>
      <td align='center'>".($offsetRecord+$ccc)."</td>
      <td> ";
          //if($row[nama_cpw]!=$rp)
          $htmlData .=$row[nama_cpw]." / ".$row[nama_cpp];
          $htmlData .= "</td>
      <td align=center> $row[tgl_acara] </td>
      <td> $row[acara] </td>
      <td> $row[nama] </td>
      <td> $row[tempat] </td>
      <td>
  ";//htmlData
        
    if ($data_sts['status'] == 0) {

        $htmlData .="&nbsp;";
            
    } elseif ($data_sts['status'] == 1) {

        $htmlData .="<center><a href=\"proses_book_mc.php?id_client=$row[id_client]&id_acara=$row[id_acara]&id_tugas=$data_sts[id_tugas]\" onClick=\"return confirm('Apakah Ända sudah menghubungi ".$row[nama] ." ?, Jika sudah tekan Ok, dan Jika belum tekan Cancel.');\"><img src=\"images/arw.gif\"></a></center>";
    
    } elseif ($data_sts['status'] == 2) {

        $htmlData .="<center><img src='images/ok.png'></center>";

    } elseif ($data_sts['status'] == 3) {

        $htmlData .="<img src='images/delete.gif'>";

    } else {

        $htmlData .="&nbsp;";
    }

    $htmlData .="</td>";

$rp=$row[nama_cpw];
};//end-while

?>
<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <tr>
   <td width="100%" align="center" vAlign="top">
   <font class="titledata" style="color:red;"><b>PENJADWALAN ACARA</b></font>

   <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr>
     <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
    <td valign="bottom"><b>Bulan Kegiatan:
 <input type='text' name='tanggal' id="tanggal" size='11' value='<?=$tanggal?>'>
       - 
    <input type='text' name='tanggal2' id="tanggal2" size='11' value='<?=$tanggal2?>'>

      <b> &nbsp; <input type="text" name="nama_cpw" value="<?=$nama_cpw;?>" size="20" placeholder="Nama CPW"> <input type="text" name="id_client" value="<?=$id_client;?>" size="10" placeholder="ID client">
       <input type="submit" name="run" value="  Go  " class="button">
     </td>
     <td valign="bottom" align="right">
       <img src="images/arrow2.gif" border="0">
       <a href="<?="?menu=$menu&uid=$uid&page=sumberdaya";?>"><b>List All</b></a>
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
   </table>

   <table width='100%' cellspacing='1' cellpadding='3'>
    <tr>
      <td colspan="12" align="left">
      <hr size="1" color="#4B4B4B">
      Halaman : <?=$pnumlink;?> &nbsp; Total : <b><?=$totalPage;?></b> halaman, <?=$totalRecord?> record.
      </td>
    </tr>
    <tr bgcolor='#A7A7A7' height="25">
      <td align='center'>NO</td>
      <td align='center'>NAMA CPW / CPP</td>
      <td align='center'>TANGGAL</td>
      <td align='center'>ACARA</td>
      <td align='center'>PELAKSANA</td>
      <td align='center'>TEMPAT</td>
      <td align='center'>Status</td>
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
