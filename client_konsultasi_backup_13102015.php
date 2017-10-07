<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 10 Oktober 2010, lastupdate 10 Oktober 2010

include_once("include.php");
$sql="select date_format(a.tanggal,'%d-%m-%Y') tgl_acara,a.tanggal,b.acara,c.nama_cpw,c.nama_cpp from acara a, p_acara b, client c where a.id_client='$id_client' and a.id_acara=b.id_acara and a.id_client=c.id_client";
//echo $sql;
$rs=mysql_query($sql);
$tgl_acara=mysql_result($rs,0,"tgl_acara");
$tgl=mysql_result($rs,0,"tanggal");
?>
<table cellpadding=3 cellspacing=0 style="border-width: 4px;  border-style: double;">
<tr><td>Client</td><td colspan=3>: <?=mysql_result($rs,0,"nama_cpw")?> / <?=mysql_result($rs,0,"nama_cpp")?></td></tr>
<? for($a=0;$a<@mysql_num_rows($rs);$a++){?>
<tr><td>Tanggal</td><td>: <?=mysql_result($rs,$a,"tgl_acara");?></td><td>: <?=mysql_result($rs,$a,"acara")?></td></tr>
<? } ?>
</table><br>

<form method="post" action="<?="?menu=$menu&uid=$uid&page=$page&act=proses&id_client=$id_client";?>">
<table>
<tr><td>Client Hadir :</td><td><input type="text" name="client_hadir"></td></tr>
<tr><td>Isi Konsultasi :</td><td><textarea rows=3 cols=50 name="konsultasi"></textarea></td></tr>
<tr><td>Petugas :</td><td><input type="text" name="petugas"></td></tr>
<tr><td><input type="submit" value="simpan" name="tombol"></td></tr>
</table>
</form>
<?

if($act=="proses"){
$konsultasi = str_replace("'","''",$konsultasi);
$konsultasi = stripslashes($konsultasi);
$konsultasi = nl2br($konsultasi);

$sql="insert into konsultasi values ('$id_client',null,now(),'$konsultasi','$SAH[id_user]', '$REMOTE_ADDR', now(),'$client_hadir','$petugas')";
//echo "<br>$sql";
mysql_query($sql);

//echo "<script type=\"text/javascript\">alert(\"Sudah menugaskan $c pegawai\");</script>";
$act=null;
}

if($act=="hapus"){
//print_r($pegawai);
for($c=0;$c<count($pegawai);$c++){
$sql="delete from pegawai_tugas where id_pegawai='$pegawai[$c]' and id_pekerjaan='$pekerjaan'";
//echo "<br>$sql";
mysql_query($sql);
}
echo "<script type=\"text/javascript\">alert(\"Sudah mengurangi $c pegawai dari tugas\");</script>";
$act="cari";
}

if(!$act){

$sql = "select date_format(tanggal,'%d-%m-%Y') tgl_konsul, isi,client_hadir,petugas from konsultasi where id_client='$id_client' order by created desc";
$rk = mysql_query($sql);
echo "<table width='100%' cellspacing='1' cellpadding='3'>";
echo "<tr bgcolor='#A7A7A7' height='25'>";
echo "<td><b>No</td><td><b>Tanggal</td><td>Client Hadir</td><td>Isi Konsultasi</td><td>Petugas</td></tr>";
for ($k=0;$k<@mysql_num_rows($rk);$k++){
$ccc++;
    if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
    echo "
      <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
          <td align='center'>".($offsetRecord+$ccc)."</td>";?>
<td><?=mysql_result($rk,$k,"tgl_konsul")?></td>
<td><?=mysql_result($rk,$k,"client_hadir")?></td>
<td><?=mysql_result($rk,$k,"isi")?></td>
<td><?=mysql_result($rk,$k,"petugas")?></td></tr>
<?
}
echo "</table>";
}
?>