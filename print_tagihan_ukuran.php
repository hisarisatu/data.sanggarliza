<?
include_once("include.php");
$sql="select nama_cpw,nama_cpp,date_format(min(tanggal),'%d-%m-%Y') tgl_mulai,date_format(max(tanggal),'%d-%m-%Y') tgl_selesai from client a, acara b where a.id_client=$id and a.id_client=b.id_client group by nama_cpp,nama_cpw";
$res=mysql_query($sql);
?>


<table width="100%">

<tr align=center>
	<td><font color="red" size="5"><b><?=strtoupper(mysql_result($res,0,"nama_cpw"))?> DAN <?=strtoupper(mysql_result($res,0,"nama_cpp"))?></b></font></td>
</tr>
<tr align=center>
	<td><font color="red" size="5"><b><?=strtoupper(mysql_result($res,0,"tgl_mulai"))?> s/d <?=strtoupper(mysql_result($res,0,"tgl_selesai"))?></b></font></td>
</tr>
</table><?
include_once("konversi.php");
if(!$act)$act="tampil_diskon";
//echo "$menu - $page - $id - $act ";

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
<?
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
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
    
		</tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	  <tr>
     <td colspan="2" valign="top" align="center">
<table cellspacing='0' cellpadding='5' align=left>
<?
$sql = "select distinct a.acara, a.id_acara, 
date_format(b.tanggal,'%d-%m-%Y') tgl_prosesi, 
b.waktu, b.tempat,b.catatan,c.gaya,d.model_sanggul,
date_format(b.tanggal,'%Y') thn_rencana,
date_format(b.tanggal,'%m') bln_rencana 
from p_acara a, acara b,p_gaya c,p_model_sanggul d
where a.id_acara=b.id_acara 
and b.id_gaya=c.id_gaya
and ifnull(b.id_sanggul,0)=d.id_sanggul
and b.id_client='$id'";//echo $sql;
$res = mysql_query($sql);
for($n1=0;$n1<mysql_num_rows($res);$n1++){
 $id_acara=mysql_result($res,$n1,"id_acara");
 echo "<tr><td colspan=2 style='border-width: 1px; border-style: outset;'><b>Acara : ";
 echo mysql_result($res,$n1,"acara");
 echo ", tanggal : ";
 echo mysql_result($res,$n1,"tgl_prosesi");
 echo " jam : ";
 echo mysql_result($res,$n1,"waktu");
 echo "<br>Gaya : ";
 echo mysql_result($res,$n1,"gaya");
 echo "<br>Model Sanggul : ";
 echo mysql_result($res,$n1,"model_sanggul");
 echo "<br>Tempat : ";
 echo mysql_result($res,$n1,"tempat");
 echo "<br>Catatan : ";
 echo mysql_result($res,$n1,"catatan");
 echo "</b></td></tr>";
 
 $thn_rencana=mysql_result($res,$n1,"thn_rencana");
 $bln_rencana=mysql_result($res,$n1,"bln_rencana");


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
		//echo "</td><td align=right>Rp. ";
		//echo number_format(mysql_result($np,0,"harga_paket"),0);
		echo "</tr><tr><td nowrap>";
		$sql="select a.id_layanan,a.id_sublayanan,a.detail_layanan,b.jml_orang,b.satuan,c.keterangan from p_sublayanan a,paket_sub_paket b left join p_satuan c on (b.satuan=c.id_satuan) where a.id_sublayanan=b.id_sublayanan and b.id_paket='$id_paket' order by a.detail_layanan,a.id_layanan";//echo $sql;
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
	//echo "</td><td align=right>Rp. ";
	//echo number_format(mysql_result($rpp,$p,"harga"),0);
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
</td></tr>

</table>
		 </td>
		</tr>
	 </table>
<script type="text/javascript">
    window.print();
    window.onfocus = function() { window.close(); }
</script>