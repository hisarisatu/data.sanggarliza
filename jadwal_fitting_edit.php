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

$sql="select date_format(a.tanggal,'%d-%m-%Y') tgl_acara,a.tanggal,b.acara,c.nama_cpw,c.nama_cpp from acara a, p_acara b, client c where a.id_client='$id_client' and a.id_acara=b.id_acara and a.id_client=c.id_client";
//echo $sql;
$rs=@mysql_query($sql);
$n=mysql_num_rows($rs);
if($n==0)
{ 
?>
<br><br><br>
<table cellpadding=3 cellspacing=0 style="border-width: 4px;  border-style: double;">
<tr><td colspan="2">-- <strong><em>BELUM ADA ORDER = BELUM BISA FITTING</em></strong> --</td></tr></table><br>
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
<tr><td>Tanggal</td><td>: <?=mysql_result($rs,$a,"tgl_acara");?></td><td>( <?=mysql_result($rs,$a,"acara")?> )</td></tr>
<? } 
} 

$sqlfitting="select * from jadwal_fitting_new where id_client=$id_client and id_fitting=$id_fitting";
$rst=@mysql_query($sqlfitting);
$tanggal=mysql_result($rst,0,"tgl_janjiakhir");
//echo $sqlbayar;
?>
		
<form name="form" method="post" action="<?="?menu=$menu&uid=$uid&page=$page&act=proses&id_client=$id_client&id_fitting=$id_fitting";?>">

<table>
<tr><td nowrap>Tanggal Janji Awal</td>
<td><input type='text' name='tgl_janjiawal' id='tgl_janjiawal' size='11' value=''>
   	<script type="text/javascript">//<![CDATA[
      var cal = Calendar.setup({
          onSelect: function(cal) { cal.hide() }
      });
      cal.manageFields("tgl_janjiawal", "tgl_janjiawal", "%Y-%m-%d");
     </script>
   
   </td></tr>
   
<tr><td nowrap>Tanggal Janji Deal</td>
<td><input type='text' name='tgl_janjiakhir' id='tgl_janjiakhir' size='11' value=''>
   	<script type="text/javascript">//<![CDATA[
      var cal = Calendar.setup({
          onSelect: function(cal) { cal.hide() }
      });
      cal.manageFields("tgl_janjiakhir", "tgl_janjiakhir", "%Y-%m-%d");
     </script>
   
   </td></tr>   
<tr><td>Barang yang Harus Disiapkan</td><td><textarea rows=4 cols=30 name="barang" ><?=mysql_result($rst,0,"barang");?></textarea></td></tr>
<tr><td>Keterangan</td><td><textarea rows=4 cols=30 name="keterangan" ><?=mysql_result($rst,0,"keterangan");?></textarea></td></tr>
<tr><td colspan=2 align=center><input type="submit" value="Delete" name="delete"><b> | </b><input type="submit" value="Edit" name="edit"></td></tr>
<tr><td colspan=2 align=center><a href="<?="?menu=$menu&uid=$uid&page=jadwal_fitting_input&id=$id_client";?>" > 
<img src="images/back2.png" width="100" height="75"></a> </td></tr>
</form>
<?

if($delete){
$keterangan = nl2br($keterangan);
$keterangan = stripslashes($keterangan);

$barang = nl2br($barang);
$barang = stripslashes($barang);

$sql="delete from jadwal_fitting_new where id_client=$id_client and id_fitting=$id_fitting ";
?>
<br><br>
<table cellpadding=3 cellspacing=0 style="border-width: 4px;  border-style: double;">
<tr><td colspan="2">-- <strong><em>Delete penjadwalan Sukses!!!!</em></strong> --</td></tr></table><br><br>
<?
mysql_query($sql);
$act=null;

}

if($edit){

$keterangan = nl2br($keterangan);
$keterangan = stripslashes($keterangan);

$barang = nl2br($barang);
$barang = stripslashes($barang);

$sql="update jadwal_fitting_new
set tgl_janjiawal='$tgl_janjiawal',tgl_janjiakhir='$tgl_janjiakhir',barang='$barang',keterangan='$keterangan',
id_user='$SAH[id_user]',login_ip='$REMOTE_ADDR',created=now()
where id_client=$id_client and id_fitting=$id_fitting ";
?>
<br><br>
<table cellpadding=3 cellspacing=0 style="border-width: 4px;  border-style: double;">
<tr><td colspan="2">-- <strong><em>Update penjadwalan Sukses!!!!</em></strong> --</td></tr></table><br><br>
<?
mysql_query($sql);
$act=null;

}


if(!$act){

$sql = "select date_format(tgl_janjiawal,'%d-%m-%Y') tgl_janjiawal, date_format(tgl_janjiakhir,'%d-%m-%Y') tgl_janjiakhir, barang, keterangan,id_client,id_fitting
from jadwal_fitting_new where id_client='$id_client' order by created desc";
$rk = mysql_query($sql);
//$row = mysql_fetch_array($rk);
echo "<table width='500' cellspacing='1' cellpadding='3'>";
echo "<tr align=center bgcolor='#A7A7A7' height='25'>";
echo "<td><b>No</td><td>Tanggal Janji awal</td><td>Tanggal Janji Akhir</td><td>Barang yg harus disiapkan</td><td>Keterangan</td><td><img src='images/edit.gif' border=0></td></tr>";
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
	$id_fitting=mysql_result($rk,$k,"id_fitting");
	echo "<a href=?menu=$menu&uid=$uid&page=jadwal_fitting_edit&id_client=$id_client&id_fitting=$id_fitting>"?><img border=0 src='images/edit.gif'></a></td>
	
</tr>
<?
}
echo "</table>";
}
?>