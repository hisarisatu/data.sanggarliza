<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 10 Oktober 2010, lastupdate 10 Oktober 2010

include_once("include.php");

$runSQL = "select id_pegawai, nama, tlp_rumah, tlp_mobile, alamat, catatan, id_user, login_ip, created, user_update, ip_update, last_update from pegawai where id_pegawai='$id'";
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id_pegawai = $row[id_pegawai];
		$nama = $row[nama];
		$tlp_rumah = $row[tlp_rumah];
		$tlp_mobile = $row[tlp_mobile];
		$alamat = $row[alamat];
		$catatan = $row[catatan];
		$id_user = $row[id_user];
		$login_ip = $row[login_ip];
		$created = $row[created];
		$user_update = $row[user_update];
		$ip_update = $row[ip_update];
		$last_update = $row[last_update];
	};

	if ($id_user > 0){
		$runSQL2 = "select id_user, fullname from sys_username where id_user='$id_user'";
		$result2 = mysql_query($runSQL2, $connDB);
		$CRE = mysql_fetch_array ($result2);
		$inforecord = "Input: $CRE[fullname], $created";
	};

	if ($user_update > 0){
		$runSQL2 = "select id_user, fullname from sys_username where id_user='$user_update'";
		$result2 = mysql_query($runSQL2, $connDB);
		$UPD = mysql_fetch_array ($result2);
		$inforecord .= "<br>Update: $UPD[fullname], $last_update";
	};
?>

<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr><td><h3>Data Pegawai</h3></td><td align="right"><a href='<?="?menu=$menu&uid=$uid&page=pegawai_input&id=$id";?>'><img border='0' src='images/edit.gif' title='Edit Data'></a> &nbsp; &nbsp; </td></tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	  <tr>
     <td width="50%" valign="top" align="center">
		 <table border="0" cellpadding="5" cellspacing="0" width="100%">
			<tr>
				<td width="35%" align="right">Nama Lengkap :</td>
				<td width="65%"><font class="datafield"><?=$nama;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Telepon Rumah :</td>
				<td width="65%"><font class="datafield"><?=$tlp_rumah;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Nomor HP :</td>
				<td width="65%"><font class="datafield"><?=$tlp_mobile;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Alamat :</td>
				<td width="65%"><font class="datafield"><?=$alamat;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Catatan Tambahan :</td>
				<td width="65%"><font class="datafield"><?=$catatan;?></font></td>
			</tr>
		 </table>
		 </td>
	  </tr>
	 </table>
   </td>
  </tr>
<tr><td></tr>
<tr><td>&nbsp;</td></tr>
<tr><td><h3>Data Tugas Pegawai</h3></td></tr>
<tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
<table width="100%">
   <tr align=center>
      <td><b>No</td>
      <td>Tanggal</td>
      <td>Acara</td>
      <td>Tempat</td>
      <td>Pekerjaan</td>
   </tr>
<?
$sql="select date_format(a.tanggal,'%d-%M-%Y') tgl, b.acara, c.tempat, d.layanan from pegawai_tugas a, p_acara b, acara c, p_layanan d
where a.id_pegawai='$id' and a.id_acara=b.id_acara and a.id_acara=c.id_acara and b.id_acara=c.id_acara
and a.tanggal=c.tanggal and a.id_pekerjaan=d.id_layanan";
//echo $sql;
$res=mysql_query($sql);
for($a=0;$a<@mysql_num_rows($res);$a++){
	$n=$a+1;
	$tgl=mysql_result($res,$a,"tgl");
	$acara=mysql_result($res,$a,"acara");
	$tempat=mysql_result($res,$a,"tempat");
	$pekerjaan=mysql_result($res,$a,"layanan");
echo "
   <tr align=center>
      <td align=right>$n</td>
      <td>$tgl</td>
      <td>$acara</td>
      <td>$tempat</td>
      <td>$pekerjaan</td>
   </tr>
";
}
?>
</table>
</td></tr>
</table>