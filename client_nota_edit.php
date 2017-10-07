 <script src="src/js/jscal2.js"></script>
    <script src="src/js/lang/en.js"></script>
    <link rel="stylesheet" type="text/css" href="src/css/jscal2.css" />
    <link rel="stylesheet" type="text/css" href="src/css/border-radius.css" />
    <link rel="stylesheet" type="text/css" href="src/css/steel/steel.css" />


<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 10 Oktober 2010, lastupdate 10 Oktober 2010

include_once("include.php");
$sekarang = date('Y-m-d H:i:s');
if($id_client=="")$id_client=$id;

$sql="select date_format(a.tanggal,'%d-%m-%Y') tgl_acara,a.tanggal,b.acara,c.nama_cpw,c.nama_cpp from acara a, p_acara b, client c where a.id_client='$id_client' and a.id_acara=b.id_acara and a.id_client=c.id_client";
//echo $sql;
$rs=@mysql_query($sql);
$n=mysql_num_rows($rs);
if($n==0)
{ 
?>
<br><br><br>
<table cellpadding=3 cellspacing=0 style="border-width: 4px;  border-style: double;">
<tr><td colspan="2">-- <strong><em>BELUM ADA TAGIHAN</em></strong> --</td></tr></table><br>
<?	
}
else
{
$tgl_acara=mysql_result($rs,0,"tgl_acara");
$tgl=mysql_result($rs,0,"tanggal");
?>
<br><br><br>
<table cellpadding=3 cellspacing=0 style="border-width: 4px;  border-style: double;">
<tr><td>Client</td><td colspan=3>: <?=mysql_result($rs,0,"nama_cpw")?> / <?=mysql_result($rs,0,"nama_cpp")?></td></tr>
<? for($a=0;$a<@mysql_num_rows($rs);$a++){?>
<tr><td>Tanggal</td><td>: <?=mysql_result($rs,$a,"tgl_acara");?></td><td>: <?=mysql_result($rs,$a,"acara")?></td></tr>
<? } 
$sql="select sum(jumlah) total, sum(diskon) diskon
from 
(
select sum(harga_paket) jumlah, '0' diskon from paket where id_paket in (select id_paket from acara where id_client='$id_client')
union
select sum(harga) jumlah, '0' diskon from pesanan_plus where id_client='$id_client'
union
select '0' jumlah, diskon from client_diskon where id_client='$id_client'
) a";
$rt=mysql_query($sql);
$total=@mysql_result($rt,0,"total");
$diskon=@mysql_result($rt,0,"diskon");
?>
<tr><td>Total Biaya (- diskon)</td><td colspan=2>: Rp. <?=number_format($total-$diskon,0)?></td></tr>
<?  
$sql="select sum(nilai) total_bayar from client_bayar where id_client='$id_client'";
$rt=mysql_query($sql);
$total_bayar=@mysql_result($rt,0,"total_bayar");
?>
<tr><td>Total Bayar</td><td colspan=2>: Rp. <?=number_format($total_bayar,0)?></td></tr>
<tr><td>Sisa Bayar</td><td colspan=2>: Rp. <?=number_format($total-$diskon-$total_bayar,0)?></td></tr>
</table><br>
<? } 

$sqlbayar="select * from client_bayar where id_client=$id_client and id_bayar=$id_bayar";
$rst=@mysql_query($sqlbayar);
$tanggal=mysql_result($rst,0,"tanggal");
//echo $sqlbayar;
?>
		
<form name="form" method="post" action="<?="?menu=$menu&uid=$uid&page=$page&act=proses&id_client=$id_client&id_bayar=$id_bayar";?>">
<table>
<tr><td nowrap>Tanggal Bayar</td>
<td><input type='text' name='tgl_bayar' id='tgl_bayar' size='11' value='<?echo $tanggal ;?>'>
   	<script type="text/javascript">//<![CDATA[
      var cal = Calendar.setup({
          onSelect: function(cal) { cal.hide() }
      });
      cal.manageFields("tgl_bayar", "tgl_bayar", "%Y-%m-%d");
     </script>
   
   </td></tr>
<tr><td>Nilai</td><td><input type="text" name="nilai" value='<?=mysql_result($rst,0,"nilai");?>'></td></tr>
<tr><td>Keterangan</td><td><textarea rows=2 cols=30 name="keterangan" ><?=mysql_result($rst,0,"keterangan");?></textarea></td></tr>
<tr><td>Nama Pembayar</td><td><input type="text" name="pembayar" value='<?=mysql_result($rst,0,"pembayar");?>'></td></tr>
<tr><td>Catatan</td><td><textarea rows=3 cols=30 name="catatan" ><?=mysql_result($rst,0,"catatan");?></textarea></td></tr>
<tr><td colspan=2 align=center><input type="submit" value="Delete" name="delete"><b>  |  </b><input type="submit" value="Edit" name="edit"></td></tr>
<tr><td colspan=2 align=center><a href="<?="?menu=$menu&uid=$uid&page=client_nota&id=$id_client";?>"> 
<img src="images/back2.png" width="100" height="75"></a> </td></tr>
</form>
<?

if($delete){
$keterangan = str_replace("'","''",$keterangan);
$keterangan = nl2br($keterangan);
$keterangan = stripslashes($keterangan);

$catatan = str_replace("'","''",$catatan);
$catatan = nl2br($catatan);
$catatan = stripslashes($catatan);

$sql="delete from client_bayar where id_client=$id_client and id_bayar=$id_bayar ";


$sql_hapus_bayar="insert into hapus_bayar values('','$id_client','$id_bayar','$tgl_bayar','$nilai','$keterangan','$pembayar','$catatan','$SAH[id_user]','$REMOTE_ADDR','$sekarang)";
mysql_query($sql_hapus_bayar);
?>
<br><br>
<table cellpadding=3 cellspacing=0 style="border-width: 4px;  border-style: double;">
<tr><td colspan="2">-- <strong><em>Delete Pembayaran Sukses!!!!</em></strong> --</td></tr></table><br><br>
<?
mysql_query($sql);
$act=null;

}

if($edit){
$keterangan = str_replace("'","''",$keterangan);
$keterangan = nl2br($keterangan);
$keterangan = stripslashes($keterangan);

$catatan = str_replace("'","''",$catatan);
$catatan = nl2br($catatan);
$catatan = stripslashes($catatan);

$sql="update client_bayar 
set tanggal='$tgl_bayar',nilai='$nilai',keterangan='$keterangan',pembayar='$pembayar',catatan='$catatan',
id_user='$SAH[id_user]',login_ip='$REMOTE_ADDR',created='$sekarang'
where id_client=$id_client and id_bayar=$id_bayar ";
?>
<br><br>
<table cellpadding=3 cellspacing=0 style="border-width: 4px;  border-style: double;">
<tr><td colspan="2">-- <strong><em>Update Pembayaran Sukses!!!!</em></strong> --</td></tr></table><br><br>
<?
mysql_query($sql);
$act=null;

}


if(!$act){

$sql = "select date_format(tanggal,'%d-%m-%Y') tgl_bayar, nilai, keterangan,id_client,id_bayar,catatan, 
concat(date_format(tanggal,'%Y%m'),'-',no_kw) no_kwitansi
from client_bayar where id_client='$id_client' order by created desc";
$rk = mysql_query($sql);
//$row = mysql_fetch_array($rk);
echo "<table width='500' cellspacing='1' cellpadding='3'>";
echo "<tr align=center bgcolor='#A7A7A7' height='25'>";
echo "<td><b>No</td><td><b>Tanggal</td><td>Nilai</td><td>Keterangan</td><td>Catatan</td><td>No-Kwitansi</td><td><img src='images/Printer.png' border=0></td><td><img src='images/edit.gif' border=0></td></tr>";
for ($k=0;$k<@mysql_num_rows($rk);$k++){
$ccc++;
    if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
    echo "
      <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
          <td align='center'>".($ccc)."</td>";?>
<td align=center><?=mysql_result($rk,$k,"tgl_bayar")?></td>
<td align=right><?=number_format(mysql_result($rk,$k,"nilai"),0)?></td>
<td><?=mysql_result($rk,$k,"keterangan")?></td>
<td><?=mysql_result($rk,$k,"catatan")?></td>
<td><?=mysql_result($rk,$k,"no_kwitansi")?></td>
<td align=center>
<? $id_client=mysql_result($rk,$k,"id_client");
	$id_bayar=mysql_result($rk,$k,"id_bayar");
	echo "<a href=\"javascript:void(window.open('cetak_bukti.php?id_client=$id_client&id_bayar=$id_bayar','',''))\">"; ?><img border=0 src='images/Printer.png'></a></td>
<td align=center>
<? $id_client=mysql_result($rk,$k,"id_client");
	$id_bayar=mysql_result($rk,$k,"id_bayar");
	echo "<a href=?menu=$menu&uid=$uid&page=client_nota_edit&id_client=$id_client&id_bayar=$id_bayar>"?><img border=0 src='images/edit.gif'></a></td>
	
</tr>
<?
}
echo "</table>";
}
?>