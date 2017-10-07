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

$runSQL = "SELECT COUNT(*) AS total,
  DATE_FORMAT(c.tanggal,'%d-%m-%Y') tgl_acara,
  b.id_client,
  b.nama_cpw,
  b.nama_cpp,
  c.id_acara,
  c.tanggal,
  c.tempat,
  c.waktu,
  d.id_acara, d.acara,
  f.id_client,
  f.id_sublayanan,
  g.id_sublayanan,
  g.id_layanan,
  h.id_layanan
FROM client b
  INNER JOIN acara c
    ON b.id_client = c.id_client
  INNER JOIN p_acara d
    ON c.id_acara = d.id_acara
  INNER JOIN pesanan_plus f
    ON b.id_client = f.id_client
  INNER JOIN p_sublayanan g
    ON f.id_sublayanan = g.id_sublayanan
  INNER JOIN p_layanan h
    ON g.id_layanan = h.id_layanan
WHERE c.id_acara != '8'
    AND c.id_acara != '10'
    AND c.id_acara != '14' 
    AND c.id_acara != '15' 
    AND c.id_acara != '16' 
    AND c.id_acara != '18' 
    AND c.id_acara != '19' 
    AND c.id_acara != '20' 
    AND c.id_acara != '25' 
    AND g.id_layanan = '17'
    AND h.id_layanan = '17'
    AND c.tanggal between '2017-05-30' AND '2019-12-29'
    AND b.id_client 
    NOT IN (SELECT id_client FROM pegawai_tugas)
    AND b.id_client IN (SELECT id_client FROM client_bayar) $filterSQL";
$result = mysql_query($runSQL, $connDB);
if ($row = mysql_fetch_array ($result)) { $totalRecord = $row[total]; };
$listRecord = 30;
$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter&cari=$cari&pnum=";
pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord);
unset($ii);

$runSQL = "SELECT
  DATE_FORMAT(c.tanggal,'%d-%m-%Y') tgl_acara,
  b.id_client,
  b.nama_cpw,
  b.nama_cpp,
  c.id_acara,
  c.tanggal,
  c.tempat,
  c.waktu,
  d.id_acara, d.acara,
  f.id_client,
  f.id_sublayanan,
  g.id_sublayanan,
  g.id_layanan,
  h.id_layanan
FROM client b
  INNER JOIN acara c
    ON b.id_client = c.id_client
  INNER JOIN p_acara d
    ON c.id_acara = d.id_acara
  INNER JOIN pesanan_plus f
    ON b.id_client = f.id_client
  INNER JOIN p_sublayanan g
    ON f.id_sublayanan = g.id_sublayanan
  INNER JOIN p_layanan h
    ON g.id_layanan = h.id_layanan
WHERE c.id_acara != '8'
    AND c.id_acara != '10'
    AND c.id_acara != '14' 
    AND c.id_acara != '15' 
    AND c.id_acara != '16' 
    AND c.id_acara != '18' 
    AND c.id_acara != '19' 
    AND c.id_acara != '20' 
    AND c.id_acara != '25' 
    AND g.id_layanan = '17'
    AND h.id_layanan = '17'
    AND c.tanggal between '2017-05-30' AND '2019-12-29'
    AND b.id_client 
    NOT IN (SELECT id_client FROM pegawai_tugas)
    AND b.id_client IN (SELECT id_client FROM client_bayar) ORDER BY b.id_client ASC"; 

//echo $runSQL;//developer
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) {

  $ccc++;
  if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
  $htmlData .= "
    <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"'>
      <td align='center'>".($offsetRecord+$ccc)."</td>
      <td>".$row[id_client]."</td>
      <td> ";
          //if($row[nama_cpw]!=$rp)
          $htmlData .=$row[nama_cpw]." / ".$row[nama_cpp];
          $htmlData .= "</td>
      <td align=center> $row[acara] </td>
      <td> $row[tempat] </td>
      <td> $row[tgl_acara] </td>
  ";//htmlData

$rp=$row[nama_cpw];
};//end-while

?>

<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="100%" align="center" vAlign="top">
    <font class="titledata" style="color:red;"><b>PERIAS CLIENT BELUM TERJADWAL</b></font>
    <br>
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
      <td align='center'>ID CLIENT</td>
      <td align='center'>NAMA CPW / CPP</td>
      <td align='center'>ACARA</td>
      <td align='center'>TEMPAT</td>
      <td align='center'>TANGGAL ACARA</td>
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
