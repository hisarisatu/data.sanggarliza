<? 
// Sisten Informasi Sanggar LIZA
// Written 11/3/2010 by agusari@gmail.com

include_once("include.php");
include_once("konversi.php");

if(!$act)$act="tampil_diskon";
//echo "$menu - $page - $id - $act ";
?>
<link rel="stylesheet" href="images/style.css" type="text/css">
<?
	$runSQL = "select id_client, nama_cpw, nama_ortu_cpw, tlp_rumah_cpw, tlp_mobile_cpw, alamat_cpw, nama_cpp, nama_ortu_cpp, tlp_rumah_cpp, tlp_mobile_cpp, alamat_cpp, catatan, id_user, login_ip, created, user_update, ip_update, last_update from client where id_client='$id'";
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id_client = $row[id_client];
		$nama_cpw = $row[nama_cpw];
		$nama_ortu_cpw = $row[nama_ortu_cpw];
		$tlp_rumah_cpw = $row[tlp_rumah_cpw];
		$tlp_mobile_cpw = $row[tlp_mobile_cpw];
		$alamat_cpw = $row[alamat_cpw];
		$nama_cpp = $row[nama_cpp];
		$nama_ortu_cpp = $row[nama_ortu_cpp];
		$tlp_rumah_cpp = $row[tlp_rumah_cpp];
		$tlp_mobile_cpp = $row[tlp_mobile_cpp];
		$alamat_cpp = $row[alamat_cpp];
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
	 <font class="titledata"><b>Rincian Pesanan</b><br></font>

	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
     <td width="50%" valign="bottom" align="left"> &nbsp; 
	     <font class="titledata" color="#009900"><b>Data Client</b></font>
		 </td>
     <td width="50%" valign="bottom" align="right">
		<!-- <a href="javascript:void(window.open('print.php?id=<?=$id?>','','toolbar=no,menubar=no,scrollbars=yes,status=no'))"><img border=0 src='images/Printer.png' title='Cetak Rincian'></a>&nbsp;&nbsp;
	    <a href='<?="?menu=$menu&uid=$uid&page=client_input&id=$id";?>'><img border='0' src='images/edit.gif' title='Edit Data'></a> &nbsp; &nbsp;  -->
		 </td>
		</tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	  <tr>
     <td width="50%" valign="top" align="center">
		 <table border="0" cellpadding="5" cellspacing="0" width="100%">
			<tr><td colspan="2" width="100%" align="center"> <b>Data Calon Pengantin Wanita (CPW)</b> </td></tr>
			<tr>
				<td width="35%" align="right">Nama Lengkap CPW :</td>
				<td width="65%"><font class="datafield"><?=$nama_cpw;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Nama Orang Tua CPW :</td>
				<td width="65%"><font class="datafield"><?=$nama_ortu_cpw;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Telepon Rumah CPW :</td>
				<td width="65%"><font class="datafield"><?=$tlp_rumah_cpw;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Nomor HP CPW :</td>
				<td width="65%"><font class="datafield"><?=$tlp_mobile_cpw;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Alamat CPW :</td>
				<td width="65%"><font class="datafield"><?=$alamat_cpw;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Catatan Tambahan :</td>
				<td width="65%"><font class="datafield"><?=$catatan;?></font></td>
			</tr>
		 </table>
		 </td>
     <td width="50%" valign="top" align="center">
		 <table border="0" cellpadding="5" cellspacing="0" width="100%">
			<tr><td colspan="2" width="100%" align="center"> <b>Data Calon Pengantin Pria (CPP)</b> </td></tr>
			<tr>
				<td width="35%" align="right">Nama Lengkap CPP :</td>
				<td width="65%"><font class="datafield"><?=$nama_cpp;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Nama Orang Tua CPP :</td>
				<td width="65%"><font class="datafield"><?=$nama_ortu_cpp;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Telepon Rumah CPP :</td>
				<td width="65%"><font class="datafield"><?=$tlp_rumah_cpp;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Nomor HP CPP :</td>
				<td width="65%"><font class="datafield"><?=$tlp_mobile_cpp;?></font></td>
			</tr>
			<tr>
				<td width="35%" align="right">Alamat CPP :</td>
				<td width="65%"><font class="datafield"><?=$alamat_cpp;?></font></td>
			</tr>
		 </table>
		 <div align="right">
			 <hr size="1" color="#252525" style="border-top:1px dashed #252525;" width="250" align="right">
			 <font size='1'><?=$inforecord;?></font>
		 </div>
		 </td>
	  </tr>
	 </table>

<?
$runSQL1 = "select min(created) created from acara where id_client='$id'";
$result1 = mysql_query($runSQL1, $connDB);
if ($row1 = mysql_fetch_array ($result1)) {
	$runSQL2 = "select id_user, login_ip, created from acara where id_client='$id' and created='$row1[created]'";
	$result2 = mysql_query($runSQL2, $connDB);
	if ($row2 = mysql_fetch_array ($result2)) {
		if ($row2[id_user] > 0){
			$runSQL3 = "select id_user, fullname from sys_username where id_user='$row2[id_user]'";
			$result3 = mysql_query($runSQL3, $connDB);
			$CRE = mysql_fetch_array ($result3);
			$acararecord = "Input: $CRE[fullname], $row2[created]";
		};
	};
};

$runSQL1 = "select max(last_update) last_update from acara where id_client='$id'";
$result1 = mysql_query($runSQL1, $connDB);
if ($row1 = mysql_fetch_array ($result1)) {
	$runSQL2 = "select user_update, ip_update, last_update from acara where id_client='$id' and last_update='$row1[last_update]'";
	$result2 = mysql_query($runSQL2, $connDB);
	if ($row2 = mysql_fetch_array ($result2)) {
		if ($row2[user_update] > 0){
			$runSQL2 = "select id_user, fullname from sys_username where id_user='$row2[user_update]'";
			$result2 = mysql_query($runSQL2, $connDB);
			$UPD = mysql_fetch_array ($result2);
			$acararecord .= "<br>Update: $UPD[fullname], $row2[last_update]";
		};//if
	};//if
};//if

$runSQL = "select id_acara, acara from p_acara order by id_acara asc";
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) { $arr_acara[$row[id_acara]]=$row[acara]; }

$runSQL = "select id_gaya, gaya from p_gaya order by id_gaya asc";
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) { $arr_gaya[$row[id_gaya]]=$row[gaya]; }


$runSQL = "select id_paket, nama_paket, harga_paket from paket order by id_paket asc";
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) {
	if($row[harga_paket] > 0){ $infoharga = " - Rp. ".number_format($row[harga_paket],0); }else{ unset($infoharga); }
	$arr_paket[$row[id_paket]]=$row[nama_paket].$infoharga;
};//while


unset($ccc);
$runSQL = "select distinct id_client, id_acara, tanggal, waktu, tempat, catatan from acara where id_client='$id' order by id_acara asc";
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) {
	$ccc++;
	$row[acara] = $arr_acara[$row[id_acara]];
	$row[gaya]  = $arr_gaya[$row[id_gaya]];
	$row[paket] = $arr_paket[$row[id_paket]];

	$htmlAcara .= "
		<tr>
			<td width='15%' nowrap> &nbsp; <b>$ccc. &nbsp; $row[acara]</b> </td>
			<td width='85%'>
			 <table width='100%' border='0' cellpadding='2' cellspacing='0'>
				<tr>
				 <td width='5%'> Tanggal </td><td> : </td><td width='95%'> <font class='datafield'>$row[tanggal]</font>
				 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Jam : <font class='datafield'>$row[waktu]</font>
				 </td>
				</tr>
				<tr>
				 <td width='5%'> Lokasi </td><td> : </td><td width='95%'> <font class='datafield'>$row[tempat]</font></td>
				</tr>";
	$sql = "select id_paket,id_gaya from acara where id_client='$id' and id_acara='$row[id_acara]'";//echo $sql;
	$res2=mysql_query($sql);
	while($row2 = mysql_fetch_array($res2)){
		$sp="select nama_paket from paket where id_paket='$row2[id_paket]'";//echo $sp;
	$pa=mysql_query($sp);
		$sg="select gaya from p_gaya where id_gaya='$row2[id_gaya]'";//echo $sg;
	$ga=mysql_query($sg);
	$htmlAcara.="<tr>
				 <td width='5%'> Paket </td><td> : </td><td width='95%'> <font class='datafield'>".@mysql_result($pa,0,"nama_paket")."&nbsp;&nbsp;&nbsp;&nbsp;Gaya : ".@mysql_result($ga,0,"gaya")."</font></td>
				</tr>
				<tr>
				 <td width='5%'> Ket </td><td> : </td><td width='95%'> <font class='datafield'>$row[catatan]</font>
				 </td>
				</tr>
				";
	}

	$htmlAcara.="</table>
			</td>
		</tr>
	";//htmlAcara
};//while

if ($htmlAcara == ""){
	$htmlAcara .= "
		<tr>
			<td width='100%' align='center'>
		  <font color='#FF0000'>-- Tidak ada Jenis Acara yang dipilih --</font><br>
			<img src='images/arrow2.gif' border='0'>
			<a href=\"?menu=$menu&uid=$uid&page=pesanan_input&id=$id\"><b>Input Acara</b></a>
      </td>
		</tr>
	";//htmlAcara
};//if
?>
	 <p>&nbsp;</p>
	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
     <td width="50%" valign="bottom" align="left"> &nbsp; 
	     <font class="titledata" color="#009900"><b>Rincian Pesanan</b></font>
		 </td>
     <td width="50%" valign="bottom" align="right">
         <!-- <a href='<?="?menu=$menu&uid=$uid&page=pesanan_input&id=$id";?>'><img border='0' src='images/edit.gif' title='Edit Data'></a> &nbsp; &nbsp;  -->
         </td>
		</tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	  <tr>
     <td colspan="2" valign="top" align="center">
<table cellspacing='0' cellpadding='5' align=left>
<?
$sql = "select distinct a.acara, a.id_acara, date_format(b.tanggal,'%d-%m-%Y') tgl_prosesi, b.waktu, b.tempat from p_acara a, acara b where a.id_acara=b.id_acara and b.id_client='$id'";//echo $sql;
$res = mysql_query($sql);
for($n1=0;$n1<mysql_num_rows($res);$n1++){
 $id_acara=mysql_result($res,$n1,"id_acara");
 echo "<tr><td colspan=2 style='border-width: 1px; border-style: outset;'><b>Acara : ";
 echo mysql_result($res,$n1,"acara");
 echo ", tanggal : ";
 echo mysql_result($res,$n1,"tgl_prosesi");
 echo " jam : ";
 echo mysql_result($res,$n1,"waktu");
 echo "<br>Tempat : ";
 echo mysql_result($res,$n1,"tempat");
 echo "</b></td></tr>";
 

 $rp=mysql_query("select id_paket from acara where id_client='$id_client' and id_acara='$id_acara'");
//$no=0;
 for($p=0;$p<@mysql_num_rows($rp);$p++){
	$id_paket=mysql_result($rp,$p,"id_paket");
	$np=mysql_query("select nama_paket,harga_paket from paket where id_paket='$id_paket'");
	echo "<tr><td>";
	if(mysql_num_rows($np)!=0){
$no++;
echo $no.". ";
		echo mysql_result($np,0,"nama_paket");
		echo "</td><td align=right>Rp. ";
		echo number_format(mysql_result($np,0,"harga_paket"),0);
		echo "</tr><tr><td nowrap>";
		$sql="select a.id_layanan,a.id_sublayanan,a.detail_layanan,b.jml_orang,b.satuan,c.keterangan from p_sublayanan a,paket_sub_paket b,p_satuan c where a.id_sublayanan=b.id_sublayanan and b.id_paket='$id_paket' and b.satuan=c.id_satuan order by a.detail_layanan,a.id_layanan";
		$rs=mysql_query($sql);
		$n=mysql_num_rows($rs);
		for($a=0;$a<$n;$a++){
		$id_layanan=mysql_result($rs,$a,"id_layanan");
		$id_sublayanan=mysql_result($rs,$a,"id_sublayanan");
		echo "&nbsp;&nbsp;&raquo;&nbsp;";
		echo mysql_result($rs,$a,"detail_layanan");
		echo "&nbsp;[";
		echo mysql_result($rs,$a,"jml_orang");
		echo "&nbsp;";
		echo mysql_result($rs,$a,"keterangan");
		echo "]";
		echo "<br>";
	 }
	}
}

$sql="select b.detail_layanan,a.jml_orang,a.harga,b.id_layanan,a.id_plus,a.satuan,c.keterangan 
from pesanan_plus a, p_sublayanan b, p_satuan c 
where a.id_sublayanan=b.id_sublayanan 
and a.id_client='$id_client' and id_acara='$id_acara' and a.satuan=c.id_satuan
union all
select detail_layanan,jml_orang,harga,0,id_bebas,satuan,keterangan from
pesanan_bebas a,p_satuan b
where a.satuan=b.id_satuan
and a.id_client='$id_client' and id_acara='$id_acara'";
//echo $sql;
$rpp=mysql_query($sql);
$jpp=@mysql_num_rows($rpp);
if($jpp!=0) Echo "<tr><td colspan=2><b>Tambahan</td></tr>";
for($p=0;$p<$jpp;$p++){
	$id_layanan=mysql_result($rpp,$p,"id_layanan");
	$id_plus=mysql_result($rpp,$p,"id_plus");
	echo "<tr><td>";
	echo "&nbsp;&nbsp;";
	$no++;
	echo $no.". ";
	echo mysql_result($rpp,$p,"detail_layanan");
	echo "&nbsp;[";
	echo mysql_result($rpp,$p,"jml_orang");
	echo "&nbsp;";
	echo mysql_result($rpp,$p,"keterangan");
	echo "]";
	echo "</td><td align=right>Rp. ";
	echo number_format(mysql_result($rpp,$p,"harga"),0);
	echo "</td></tr>";
}
echo "<tr><td colspan=2>&nbsp;</td></tr>";
}
$sql="select sum(jumlah) total
from 
(
SELECT SUM( harga_paket ) jumlah
FROM acara a, paket b
WHERE id_client ='$id_client'
AND a.id_paket = b.id_paket
union all
select sum(harga) jumlah from pesanan_plus where id_client='$id_client'
and id_acara in (select id_acara from acara where id_client='$id_client')
union all
select sum(harga) jumlah from pesanan_bebas where id_client='$id_client'
and id_acara in (select id_acara from acara where id_client='$id_client')
) a";
$rt=mysql_query($sql);
$total=@mysql_result($rt,0,"total");
?>
<tr>
<td><b>Total Biaya</b></td>
<td align=right style="border-width: 1px; border-style: double;" nowrap><font style="font-size:larger;"><u>Rp. <?=number_format($total,0)?></td>
</tr>
<?
//echo "<tr><td><a href=\"?menu=$menu&uid=$uid&page=$page&id=$id&act=add_diskon\"><img border='0' src='images/add.gif' title='Diskon' width=15 height=15> Diskon </a>";
echo "<tr><td>Diskon";
if($act=="add_diskon"){
$sql="select * from client_diskon where id_client='$id'";
$rd=mysql_query($sql);
?></td><td>
<form action="?menu=<?=$menu?>&uid=<?=$uid?>&page=view">
<input type="text" name="diskon" value="<?=@mysql_result($rd,0,"diskon")?>"><input type="submit" name="dsk" value="add">
<input type="hidden" name="id" value="<?=$id?>">
<input type="hidden" name="act" value="proses_diskon">
</form>
<?
}

$sql="select * from client_diskon where id_client='$id'";
$rd=mysql_query($sql);

if($act=="proses_diskon"){
$nd=mysql_num_rows($rd);
 if($nd!=0){
  $sql="update client_diskon set diskon='$diskon', tanggal=now() where id_client='$id'";
 }else{
  $sql="insert into client_diskon values('$id','$diskon',now())";
 }
//echo $sql;
mysql_query($sql);
$act="tampil_diskon";
}

if($act=="tampil_diskon"){
echo "</td><td align=right>Rp. ";
$diskon=@mysql_result($rd,0,"diskon");
echo number_format($diskon,0);
$total=$total-$diskon;
$act=null;
}
?>
</td></tr>
<tr>
<td><b>Total Biaya</b></td>
<td align=right style="border-width: 1px; border-style: double;" nowrap><font style="font-size:larger;"><u>Rp. <?=number_format($total,0)?></td>
</tr>

<?
	$sql_acara = "SELECT p.id_acara, p.id_client, q.id_client, r.id_acara FROM acara p, client q, p_acara r WHERE p.id_acara = r.id_acara AND p.id_client = q.id_client AND p.id_client = '$id'";
  $query_acara = mysql_query($sql_acara);
  $data_acara = mysql_fetch_array($query_acara);

if($data_acara['id_acara'] == '25') { ?>
<tr>
<td><b>PPN 10%</b></td>
<td align=right style="border-width: 1px; border-style: double;" nowrap><font style="font-size:larger;"><u>Rp. <?=number_format($total * 0.10,0)?></td>
</tr>
<tr>
<td><b>Total</b></td>
<td align=right style="border-width: 1px; border-style: double;" nowrap><font style="font-size:larger;"><u>Rp. <?=number_format(($total * 0.10) + $total ,0)?></td>
</tr>
<? } else { echo "&nbsp;"; } ?>
<tr>
<td align=right colspan=2><b><?=katakan($total)?> Rupiah</td>
</tr>
</table>

<table width='100%' cellspacing='0' cellpadding='3'>
<tr><td> <hr size="1" color="#4B4B4B"> </td></tr>
</table>
<table align=left>
<tr>
	<td colspan=3><u><b>Catatan :</b></u></td>
</tr>
<tr>
	<td align=right>1.</td>
	<td></td>
	<td>Pelunasan Pembayaran setidaknya sudah dilakukan selambat-lambatnya 1 minggu sebelum acara</td>
</tr>
<tr>
	<td align=right>2.</td>
	<td></td>
	<td>Bila terdapat tambahan pada saat acara berlangsung, dapat dibayar paling lambat 3 hari setelah acara.</td>
</tr>
<tr>
	<td align=right>3.</td>
	<td></td>
	<td>Untuk dapat memudahkan pembayaran dapat dilakukan melalui tunai, cek atau transfer ke rekening kami di</td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td><b><i>Bank BCA Cab. Gudang Peluru atas nama Lilis Purmasih dengan no. rek. 272-3010241  atau </i></b></td>
</tr>
<tr>
	<td></td>
	<td></td>
	<td><b><i>Bank Mandiri Cab. Lapangan Ros atas Nama Sanggar Liza dengan No. Rek. 124-0066699969</i></b></td>
</tr>
<tr>
	<td align=right>4.</td>
	<td></td>
	<td>Pembatalan Upacara Adat yang dilakukan + 3 minggu sebelum acara akan dikenakan <b>charge 50%</b></td>
</tr>
<tr>
	<td align=right>5.</td>
	<td>a.</td>
	<td>Bila terjadi pembatalan sewa (pakaian, kain) 1 hari sebelum acara akan dikenakan charge 50%</td>
</tr>
<tr>
	<td></td>
	<td>b.</td>
	<td>Bila terjadi pembatalan sewa (pakaian, kain) pada saat acara berlangsung maka dikenakan charge 100%</td>
</tr>
</table>
		 </td>
		</tr>
	 </table>
	 <p>&nbsp;</p>
	 <a href="javascript:window.close()"><b>Close</b></a>

   </td>
  </tr>
  </form>
</table>