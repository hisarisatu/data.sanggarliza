<link rel="stylesheet" href="./src/lib/jquery-ui-1.11.1/jquery-ui.css"> 
<script src="./src/lib/jquery-1.9.1.js" type="text/javascript"></script>
<script src="./src/lib/jquery-ui-1.11.1/jquery-ui.js" type="text/javascript"></script>
    <link rel="stylesheet" type="text/css" href="src/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="src/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="src/css/steel/steel.css" />

<? 
// Sisten Informasi Sanggar LIZA
// Written by iyok642@yahoo.com; 031-70920002
// 23 Agustus 2010, lastupdate 11/3/2010 by agusari@gmail.com


include_once("include.php");
include_once("p_bulan.php");
if (($SAH[id_group]==1)or($SAH[id_group]==5)or($SAH[id_group]==12))
{

$pageFilter ="&tanggal=$tanggal&tanggal2=$tanggal2&thn_rencana=$thn_rencana&bulan_rencana=$bulan_rencana&nama_pengantin=$nama_pengantin&id_client=$id_client";
//echo $bulan_rencana;
if ($cari <> ""){ 
  $cariSQL = strtoupper($cari);
  $filterSQL = " and upper(nama_cpw) like '%$cariSQL%' or upper(id_client) like '%$cariSQL%' or upper(nama_ortu_cpw) like '%$cariSQL%' or upper(tlp_rumah_cpw) like '%$cariSQL%' or upper(tlp_mobile_cpw) like '%$cariSQL%' or upper(alamat_cpw) like '%$cariSQL%' or upper(nama_cpp) like '%$cariSQL%' or upper(nama_ortu_cpp) like '%$cariSQL%' or upper(tlp_rumah_cpp) like '%$cariSQL%' or upper(tlp_mobile_cpp) like '%$cariSQL%' or upper(alamat_cpp) like '%$cariSQL%' ";
};//if

if($bulan_rencana!="")
 $filterSQL = " and id_client in (select distinct id_client from acara where tanggal like '$thn_rencana-$bulan_rencana-%') ";
if($nama_pengantin != "")
  $filterSQL .= " and nama_cpw like '%$nama_pengantin%' ";
  if($id_client != "")
  $filterSQL .= " and id_client like '%$id_client%' ";  
if($tanggal !="" && tanggal2 !="")
{$filterSQL .= " and a.tgl_rencana BETWEEN '$tanggal' AND '$tanggal2'";}

$runSQL = "select count(*) total from client where 1=1 $filterSQL";
//echo $runSQL;
$result = mysql_query($runSQL, $connDB);
if ($row = mysql_fetch_array ($result)) { $totalRecord = $row[total]; };
$listRecord = 100;
$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter&cari=$cari&pnum=";
pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord);

unset($ii);
$runSQL = "select a.id_client, a.nama_cpw, a.nama_ortu_cpw, a.tlp_rumah_cpw, a.tlp_mobile_cpw, a.alamat_cpw, a.nama_cpp, a.nama_ortu_cpp, a.tlp_rumah_cpp, a.tlp_mobile_cpp, a.alamat_cpp, date_format(a.tgl_rencana,'%d-%m-%Y') tgl_rencana, a.catatan, a.last_update, ifnull(b.nama,'-')nama 
from client a 
left join pegawai b on a.id_pegawai = b.id_pegawai 
where 1=1 $filterSQL order by id_client desc LIMIT $offsetRecord, $listRecord";
//echo $runSQL;
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) {
  $id_client=$row[id_client];
  $ccc++;
  if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
  $htmlData .= "
    <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"'>
      <td align='center'>".($offsetRecord+$ccc)."</td>
      <td> $row[nama_cpw] / $row[nama_cpp]</td>
      <td> $row[alamat_cpw] </td>
      <td> $row[tlp_mobile_cpw] </td>
      <td> $row[tgl_rencana] </td>
      <td align='center'> $row[nama] </td>
      <td align='center' nowrap><a href=\"javascript:void(window.open('view_pesanan.php?id=$row[id_client]','',''))\"><img border='0' src='images/view.png' title='Lihat Data'></a></td>";
  $sql="select sum(jumlah) total, sum(diskon) diskon
  from 
  (
  SELECT SUM( harga_paket ) jumlah,'0' diskon
  FROM acara a, paket b
  WHERE id_client ='$id_client'
  AND a.id_paket = b.id_paket
  union all
  select sum(harga) jumlah,'0' diskon from pesanan_plus where id_client='$id_client'
  and id_acara in (select id_acara from acara where id_client='$id_client')
  union all
        select sum(harga) jumlah,'0' from pesanan_bebas where id_client='$id_client'
        and id_acara in (select id_acara from acara where id_client='$id_client')
  union all
        select '0' total,diskon from client_diskon where id_client='$id_client'
  ) a";
  $rt=mysql_query($sql);
  $total=@mysql_result($rt,0,"total");
  $ppn= $total * 0.10;
  $diskon=@mysql_result($rt,0,"diskon");
  $htmlData .= "<td align=right> ".number_format($total-$diskon,0)." </td>";
  $sql="select sum(nilai) bayar from client_bayar where id_client='$id_client'";
  $rt=mysql_query($sql);
  $bayar=@mysql_result($rt,0,"bayar");
  $htmlData .= "<td align=right> ".number_format($bayar,0)." </td>";

  $sql_acara = "SELECT p.id_acara, p.id_client, q.id_client, r.id_acara FROM acara p, client q, p_acara r WHERE p.id_acara = r.id_acara AND p.id_client = q.id_client AND p.id_client = '$id_client'";
  $query_acara = mysql_query($sql_acara);
  $data_acara = mysql_fetch_array($query_acara);

  if($data_acara['id_acara'] == '25') {
  $htmlData .= "<td align=right> ".number_format($total-$diskon-$bayar+$ppn,0)." </td>";
  } else {
  $htmlData .= "<td align=right> ".number_format($total-$diskon-$bayar,0)." </td>";
  }
  $htmlData .= "<td align='center' nowrap>";
  if($SAH[id_group]==1 or $SAH[id_group]==5){
  $htmlData .= "
        <a href='?menu=$menu&uid=$uid&page=client_nota&id=$row[id_client]'><img border='0' src='images/pay.jpg' title='Bayar' width=16 height=16></a>
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
    &nbsp;&nbsp; 
<input type="text" name="nama_pengantin" value="<?=$nama_pengantin;?>" placeholder="Nama Client (CPW)" />
<input type="text" name="id_client" value="" placeholder="ID Client" />


       <!--<b>Cari : <input type="text" name="cari" value="<?=$cari;?>" size="30">-->
       <input type="submit" name="run" value="  Go  " class="button">
     </td>
     <td valign="bottom" align="right">
       <img src="images/arrow2.gif" border="0">
       <b><a href="<?="?menu=$menu&uid=$uid&page=payment";?>">List All</a> | <a href="<?="?menu=$menu&uid=$uid&page=payment_cari";?>">Cari</a></b>
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
      <td align='center'>NAMA CPW</td>
      <td align='center'>ALAMAT CPW</td>
      <td align='center'>HP CPW</td>
      <td align='center'>Tgl Rencana</td>
            <td align='center'>Petugas CS</td>
      <td align='center'>Detil<br>Pesanan</td>
      <td align='center'>Tagihan<br>(-Diskon)</td>
      <td align='center'>Jml Bayar</td>
      <td align='center'>Sisa</td>
      <td align='center'>Bayar</td>
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
echo "<div align='center'><font color='#FF0000'><b>Akses Tidak Diperbolehkan. Hanya Group Administrator dan Keuangan</b></font></div>"; }
?>