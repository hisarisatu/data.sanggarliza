<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 10 Oktober 2010, lastupdate 10 Oktober 2010


if (($SAH[id_group]==1))
{
include_once("include.php");
$sql = "select id_produk,produk from p_produk order by produk";
$res = mysql_query($sql);
?>
<form method="post" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
<select name="kategori" onchange="javascript:this.form.submit();">
<option value="none">--Pilih Satu--</option>
<?
for($a=0;$a<@mysql_num_rows($res);$a++){
  echo "<option value=\"";
  $id_pekerjaan=mysql_result($res,$a,"id_produk");
  echo "$id_pekerjaan\" ";
  if($id_pekerjaan==$kategori)echo " selected ";
  echo ">";
  echo mysql_result($res,$a,"produk");
}
?>
</select>
</form>
<?
$sql = "select id_layanan,layanan from p_layanan where id_produk='$kategori' order by layanan";
$res = mysql_query($sql);
?>
<form method="post" action="<?="?menu=$menu&uid=$uid&page=$page&act=cari&kategori=$kategori";?>">
<select name="pekerjaan">
<option value="none">--Pilih Satu--</option>
<?
for($a=0;$a<@mysql_num_rows($res);$a++){
  echo "<option value=\"";
  $id_pekerjaan=mysql_result($res,$a,"id_layanan");
  echo "$id_pekerjaan\" ";
  if($id_pekerjaan==$pekerjaan)echo " selected ";
  echo ">";
  echo mysql_result($res,$a,"layanan");
}
?>
</select>
<input type="submit" value="cari" name="tombol">
</form>
<?

if($act=="proses"){
//print_r($pegawai);
for($c=0;$c<count($pegawai);$c++){
$sql="insert into pegawai_pekerjaan values ('$pegawai[$c]','$pekerjaan',0,'-', '$SAH[id_user]', '$REMOTE_ADDR', now(),null,null,null)";
//echo "<br>$sql";
mysql_query($sql);
}
echo "<script type=\"text/javascript\">alert(\"Sudah insert $c pegawai\");</script>";
$act="cari";
}

if($act=="hapus"){
//print_r($pegawai);
for($c=0;$c<count($pegawai);$c++){
$sql="delete from pegawai_pekerjaan where id_pegawai='$pegawai[$c]' and id_pekerjaan='$pekerjaan'";
//echo "<br>$sql";
mysql_query($sql);
}
echo "<script type=\"text/javascript\">alert(\"Sudah hapus $c pegawai\");</script>";
$act="cari";
}

if($act=="cari"){
?>
<form method="post" action="<?="?menu=$menu&uid=$uid&page=$page&act=proses&pekerjaan=$pekerjaan";?>">
Belum terdaftar
<table cellpadding=3 cellspacing=0 style="border-width: 4px;  border-style: double;">
<tr valign=top>
<td>
<?
$rsc=mysql_query("select * from pegawai where id_pegawai not in (select id_pegawai from pegawai_pekerjaan where id_pekerjaan='$pekerjaan')");
$jml=@mysql_num_rows($rsc);
$maxrow=ceil($jml/4);
echo "<table cellpadding=3 cellspacing=0>";
for($b=0;$b<$jml;$b++){
echo "<tr>";
echo "<td>";echo "<input type='checkbox' value='";
echo mysql_result($rsc,$b,"id_pegawai");
echo "' name='pegawai[]'>&nbsp;";
echo mysql_result($rsc,$b,"nama");
echo "</td>";
echo"</tr>";
if(($b+1)%$maxrow==0 && $b!=0)echo "</table></td><td><table cellpadding=3 cellspacing=0>";
}
?>
</table>
</td>
</tr>
</table>
<center><br><input type="submit" value="simpan"></center>
</form>
<form method="post" action="<?="?menu=$menu&uid=$uid&page=$page&act=hapus&pekerjaan=$pekerjaan";?>">
Sudah terdaftar
<table cellpadding=3 cellspacing=0 style="border-width: 4px;  border-style: double;">
<tr valign=top>
<td>
<?
$rsc=mysql_query("select * from pegawai where id_pegawai in (select id_pegawai from pegawai_pekerjaan where id_pekerjaan='$pekerjaan')");
$jml=@mysql_num_rows($rsc);
$maxrow=ceil($jml/4);
echo "<table cellpadding=3 cellspacing=0>";
for($b=0;$b<$jml;$b++){
echo "<tr>";
echo "<td>";echo "<input type='checkbox' value='";
echo mysql_result($rsc,$b,"id_pegawai");
echo "' name='pegawai[]'>&nbsp;";
echo mysql_result($rsc,$b,"nama");
echo "</td>";
echo"</tr>";
if(($b+1)%$maxrow==0 && $b!=0)echo "</table></td><td><table cellpadding=3 cellspacing=0>";
}
?>
</table>
</td>
</tr>
</table>
<center><br><input type="submit" value="hapus"></center>
</form>
<?
}
?>
<?
}
else
{echo"</br>";
echo"</br>";
echo "<div align='center'><font color='#FF0000'><b>Akses Tidak Diperbolehkan. Hanya Group Administrator</b></font></div>"; }
?>