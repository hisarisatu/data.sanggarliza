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
if($id_client=="")$id_client=$id;

$sql="select date_format(a.tanggal,'%d-%m-%Y') tgl_acara, a.tanggal, b.acara, b.id_gaya, c.nama_cpw, c.nama_cpp, c.tlp_mobile_cpw, c.alamat_cpw from acara a, p_acara b, client c where a.id_client='$id_client' and a.id_acara=b.id_acara and a.id_client=c.id_client";

$urut=mysql_query("SELECT MAX(no_urut) as no_urut FROM client_bayar");
$no_urut=mysql_result($urut,0,"no_urut");
$no_urut+=1;


//echo $sql;
$rs=@mysql_query($sql);
$n=mysql_num_rows($rs);
if($n==0)
{ 
?>
<br><br>
<table cellpadding=3 cellspacing=0 style="border-width: 4px;  border-style: double;">
<tr><td colspan="2">-- <strong><em>CLIENT BELUM ORDER / MEMBAYAR DP (TIDAK BISA MELAKUKAN FITTING)</em></strong> --</td></tr></table><br>
<?	
}
else
{
$tgl_acara=mysql_result($rs,0,"tgl_acara");
$tgl=mysql_result($rs,0,"tanggal");
?>
<table cellpadding=3 cellspacing=0 style="border-width: 4px;  border-style: double;">
<tr><td>Client</td><td colspan=3>: <?=mysql_result($rs,0,"nama_cpw")?> / <?=mysql_result($rs,0,"nama_cpp")?></td></tr>
<? for($a=0;$a<@mysql_num_rows($rs);$a++){?>
<tr><td>Tanggal</td><td>: <?=mysql_result($rs,$a,"tgl_acara");?>  (<?=mysql_result($rs,$a,"acara")?>)</td></tr>
<tr><td>No HP CPW</td><td>: <?=mysql_result($rs,$a,"tlp_mobile_cpw");?></td></tr>
<tr><td>Alamat CPW</td><td>: <?=mysql_result($rs,$a,"alamat_cpw");?></td></tr>
<? } ?>


</table><br>
<? } ?>
		
<form name="form" method="post" action="<?="?menu=$menu&uid=$uid&page=$page&act=proses&id_client=$id_client";?>">
<table>
<tr><td nowrap>Tanggal Janji Awal</td>
<td><input type='text' name='tgl_janjiawal' id='tgl_janjiawal' size='10' value='<?=$tgl_janjiawal?>' placeholder="janji awal">
   	<script type="text/javascript">//<![CDATA[
      var cal1 = Calendar.setup({
          onSelect: function(cal1) { cal1.hide() }
      });
      cal1.manageFields("tgl_janjiawal", "tgl_janjiawal", "%d-%m-%Y");
     </script>
   
   </td></tr>
   
<tr><td nowrap>Tanggal Janji Deal</td>
<td><input type='text' name='tgl_janjiakhir' id='tgl_janjiakhir' size='10' value='<?=$tgl_janjiakhir?>' placeholder="janji Deal">
   	<script type="text/javascript">//<![CDATA[
      var cal2 = Calendar.setup({
          onSelect: function(cal2) { cal2.hide() }
      });
      cal2.manageFields("tgl_janjiakhir", "tgl_janjiakhir", "%d-%m-%Y");
     </script>
   
   </td></tr>
   

<tr><td>Barang yang Harus Disiapkan</td><td><textarea rows=5 cols=50 name="barang" placeholder="Harap diisi dengan baik, benar, dan teliti"></textarea><font color="#FF0000"><b>*</b> jangan lupa Menulis <b>Jumlah Barang</b> dan <b>Ukuran</b> </font></td></tr>
<tr><td>Keterangan</td><td><textarea rows=3 cols=30 name="keterangan"></textarea></td></tr>
<tr><td colspan=2 align=center><input type="submit" value="simpan" name="tombol"></td></tr>
</form>
<?

if($act=="proses"){
$barang = str_replace("'","''",$barang);
$barang = nl2br($barang);
$barang = stripslashes($barang);

$keterangan = str_replace("'","''",$keterangan);
$keterangan = nl2br($keterangan);
$keterangan = stripslashes($keterangan);

$sql="insert into jadwal_fitting_new values ('$id_client',null,'$tgl_janjiawal','$tgl_janjiakhir','$barang','$keterangan','$SAH[id_user]', '$REMOTE_ADDR', now(),'$no_urut')";
//echo "<br>$sql";
mysql_query($sql);
$act=null;
}

if(!$act){

$sql = "select date_format(tanggal,'%d-%M-%Y') tgl_janjiawal, date_format(tanggal,'%d-%M-%Y') tgl_janjiakhir, barang,id_client,id_fitting,keterangan
from client_bayar where id_client='$id_client' order by created desc";
$rk = mysql_query($sql);
//$row = mysql_fetch_array($rk);
echo "<table width='500' cellspacing='1' cellpadding='3'>";
echo "<tr align=center bgcolor='#A7A7A7' height='25'>";
echo "<td><b>No</td><td><b>Tgl_Janji_Awal</td><td>Tgl_janji_akhir</td><td>barang</td><td>keterangan</td><td><img src='images/Printer.png' border=0></td><td><img src='images/edit.gif' border=0></td></tr>";
for ($k=0;$k<@mysql_num_rows($rk);$k++){
$ccc++;
    if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
    echo "
      <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
          <td align='center'>".($ccc)."</td>";?>
<td align=center><?=mysql_result($rk,$k,"tgl_janjiawal")?></td>
<td align=center><?=mysql_result($rk,$k,"tgl_janjiakhir")?></td>
<td><?=mysql_result($rk,$k,"barang")?></td>
<td><?=mysql_result($rk,$k,"keterangan")?></td>
<td align=center>
<? $id_client=mysql_result($rk,$k,"id_client");
	$id_bayar=mysql_result($rk,$k,"id_fitting");
	echo "<a href=\"javascript:void(window.open('cetak_bukti.php?id_client=$id_client&id_fitting=$id_fitting','',''))\">"; ?><img border=0 src='images/Printer.png'></a></td>
<td align=center>
<? $id_client=mysql_result($rk,$k,"id_client");
	$id_bayar=mysql_result($rk,$k,"id_fitting");
	echo "<a href=?menu=$menu&uid=$uid&page=client_nota_edit&id_client=$id_client&id_fitting=$id_fitting>"?><img border=0 src='images/edit.gif'></a></td>

	
</tr>
<?
}
echo "</table>";
}
?>