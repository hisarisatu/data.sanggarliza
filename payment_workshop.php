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
if (($SAH[id_group]==1)or($SAH[id_group]==5)or($SAH[id_group]==9))
{

$pageFilter ="&tanggal=$tanggal&tanggal2=$tanggal2&thn_rencana=$thn_rencana&bulan_rencana=$bulan_rencana&nama_siswa=$nama_siswa&id_siswa=$id_siswa";
//echo $bulan_rencana;
if ($cari <> ""){ 
  $cariSQL = strtoupper($cari);
  $filterSQL = " and upper(nama_siswa) like '%$cariSQL%' or upper(id_siswa) like '%$cariSQL%' or upper(alamat) like '%$cariSQL%' or upper(no_telp) like '%$cariSQL%' or upper(email) like '%$cariSQL%' ";
};//if

if($bulan_rencana!="")
 $filterSQL = " and id_siswa in (select distinct id_siswa from tb_acara_workshop where tanggal like '$thn_rencana-$bulan_rencana-%') ";
if($nama_siswa != "")
  $filterSQL .= " and nama_siswa like '%$nama_siswa%' ";
  if($id_siswa != "")
  $filterSQL .= " and id_siswa like '%$id_siswa%' ";  
if($tanggal !="" && tanggal2 !="")
{$filterSQL .= " and a.tgl_mulai BETWEEN '$tanggal' AND '$tanggal2'";}

$runSQL = "select count(*) total from tb_siswa where 1=1 $filterSQL";
//echo $runSQL;
$result = mysql_query($runSQL, $connDB);
if ($row = mysql_fetch_array ($result)) { $totalRecord = $row[total]; };
$listRecord = 100;
$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter&cari=$cari&pnum=";
pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord);

unset($ii);
$runSQL = "select a.id_siswa, a.nama_siswa, a.alamat, a.no_telp, a.email, date_format(a.tgl_mulai,'%d-%m-%Y') tgl_mulai, date_format(a.tgl_selesai,'%d-%m-%Y') tgl_selesai, a.catatan, a.last_update, ifnull(b.nama,'-')nama, ifnull(c.nama_program,'-')nama_program, ifnull(d.nama_narasumber,'-')nama_narasumber 
from tb_siswa a 
left join pegawai b on a.id_pegawai = b.id_pegawai 
left join tb_program c on a.id_program = c.id_program
left join tb_narasumber d on a.id_narasumber = d.id_narasumber
where 1=1 $filterSQL order by id_siswa desc LIMIT $offsetRecord, $listRecord";
//echo $runSQL;
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) {
  $id_siswa=$row[id_siswa];
  $ccc++;
  if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
  $htmlData .= "
    <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"'>
      <td align='center'>".($offsetRecord+$ccc)."</td>
      <td> $row[nama_siswa]</td>
      <td> $row[alamat] </td>
      <td> $row[no_telp] </td>
      <td> $row[tgl_mulai] </td>
      <td align='center'> $row[nama] </td>
      <td align='center' nowrap><a href=\"javascript:void(window.open('view_workshop.php?id=$row[id_siswa]','',''))\"><img border='0' src='images/view.png' title='Lihat Data'></a></td>";
  $sql="select sum(jumlah) total, sum(diskon) diskon
  from 
  (
  SELECT SUM( harga_paket ) jumlah,'0' diskon
  FROM tb_acara_workshop a, paket b
  WHERE id_siswa ='$id_siswa'
  AND a.id_paket = b.id_paket
  union all
  select sum(harga) jumlah,'0' diskon from tb_pesanan_workshop where id_siswa='$id_siswa'
  and id_acara in (select id_acara from tb_acara_workshop where id_siswa='$id_siswa')
  union all
        select '0' total,diskon from tb_siswa_diskon where id_siswa='$id_siswa'
  ) a";
  $rt=mysql_query($sql);
  $total=@mysql_result($rt,0,"total");

  $ppn= $total * 0.10;

  $diskon=@mysql_result($rt,0,"diskon");

  $sql="select sum(nilai) bayar from tb_siswa_bayar where id_siswa='$id_siswa'";
  $rt=mysql_query($sql);
  $bayar=@mysql_result($rt,0,"bayar");

  $sql_acara = "SELECT p.id_acara, p.id_siswa, q.id_siswa, r.id_acara FROM tb_acara_workshop p, tb_siswa q, p_acara r WHERE p.id_acara = r.id_acara AND p.id_siswa = q.id_siswa AND p.id_siswa = '$id_siswa'";
  $query_acara = mysql_query($sql_acara);
  $data_acara = mysql_fetch_array($query_acara);

  if($data_acara['id_acara'] == '25') {
    $htmlData .= "<td align=right> ".number_format((($total - $diskon) * 0.10) + ($total-$diskon-$bayar),0)." </td>";
 
  } else {
     $htmlData .= "<td align=right> ".number_format($total-$diskon,0)." </td>";
  }

  $htmlData .= "<td align=right> ".number_format($bayar,0)." </td>";

  if($data_acara['id_acara'] == '25') {
  $htmlData .= "<td align=right> ".number_format((($total - $diskon) * 0.10) + ($total-$diskon-$bayar),0)." </td>";
  } else {
  $htmlData .= "<td align=right> ".number_format($total-$diskon-$bayar,0)." </td>";
  }
  $htmlData .= "<td align='center' nowrap>";
  if($SAH[id_group]==1 or $SAH[id_group]==5 or $SAH[id_group]==4){
  $htmlData .= "
        <a href='?menu=$menu&uid=$uid&page=siswa_nota&id=$row[id_siswa]'><img border='0' src='images/pay.jpg' title='Bayar' width=16 height=16></a>
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
    &nbsp;&nbsp; 
<input type="text" name="nama_siswa" value="<?=$nama_siswa;?>" placeholder="Nama" />
<input type="text" name="id_siswa" value="" placeholder="ID Siswa" />


       <!--<b>Cari : <input type="text" name="cari" value="<?=$cari;?>" size="30">-->
       <input type="submit" name="run" value="  Go  " class="button">
     </td>
     <td valign="bottom" align="right">
       <img src="images/arrow2.gif" border="0">
       <b><a href="<?="?menu=$menu&uid=$uid&page=payment_workshop";?>">List All</a> | <a href="<?="?menu=$menu&uid=$uid&page=payment_workshop_cari";?>">Cari</a></b>
     </td>
     </form>
          <script type="text/javascript">
          //<![CDATA[
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
      <td align='center'>NAMA SISWA</td>
      <td align='center'>ALAMAT</td>
      <td align='center'>NO TELEPON</td>
      <td align='center'>TGL RENCANA</td>
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