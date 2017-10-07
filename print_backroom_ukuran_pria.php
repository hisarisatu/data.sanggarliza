<? 
// Sisten Informasi Sanggar LIZA
// Written by iyok642@yahoo.com; 031-70920002
// 23 Agustus 2010, lastupdate 10/30/2010 by agusari@gmail.com

include_once("include.php");
include_once("konversi.php");

		$runSQLxx = "select distinct id_group from sys_username where id_user='$SAH[id_user]'";
		$resultxx = mysql_query($runSQLxx, $connDB);
		if ($rowxx = mysql_fetch_array ($resultxx)) 
		{$id_group=$rowxx[id_group];}
		echo $id_group;		


if(!$act)$act="tampil_diskon";
//echo "$menu - $page - $id - $act ";

	$runSQL = "SELECT distinct a.id_client, a.nama_cpw, a.nama_ortu_cpw, a.tlp_rumah_cpw, a.tlp_mobile_cpw, a.alamat_cpw, a.nama_cpp, a.nama_ortu_cpp, a.tlp_rumah_cpp, a.tlp_mobile_cpp, a.alamat_cpp, a.tgl_rencana, a.catatan, a.id_user, a.login_ip, a.created, a.user_update, a.ip_update, a.last_update ,ifnull(a.id_pegawai,'-')id_pegawai, ifnull(b.nama,'-')nama
FROM client a
left join pegawai b on a.id_pegawai = b.id_pegawai 
where id_client='$id'";
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
		$nama = $row[nama];
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
<?
include_once("include.php");
$sql="select nama_cpw,nama_cpp,date_format(min(tanggal),'%d-%m-%Y') tgl_mulai,date_format(max(tanggal),'%d-%m-%Y') tgl_selesai from client a, acara b where a.id_client=$id and a.id_client=b.id_client group by nama_cpp,nama_cpw";
$res=mysql_query($sql);
?>


<table width="100%">
<tr align=center>
	<td><font color="red" size="5"><b>PERINCIAN NAMA &amp; BUSANA PRIA</b></font></td>
</tr>
<tr align=center>
	<td><font color="red" size="5"><b>KELUARGA DARI PIHAK</b></font></td>
</tr>
<tr align=center>
	<td><font color="red" size="5"><b><?=strtoupper(mysql_result($res,0,"nama_cpw"))?> DAN <?=strtoupper(mysql_result($res,0,"nama_cpp"))?></b></font></td>
</tr>
<tr align=center>
	<td><font color="red" size="5"><b><?=strtoupper(mysql_result($res,0,"tgl_mulai"))?> s/d <?=strtoupper(mysql_result($res,0,"tgl_selesai"))?></b></font></td>
</tr>
</table>
<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <form method="POST" name="form" action="<?="";?>">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 
	 <table width="100%" border="0" cellpadding="0" cellspacing="0">


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
	 <tr><td></td></tr>
<table width = 850 border="0" cellpadding="3" cellspacing="0">
	  <tr >
     <td width="50%" valign="bottom" align="left"> &nbsp; 
	     <font class="titledata" color="#009900"><b>Rincian Ukuran Busana</b></font>
		 </td>
     <td width="50%" valign="bottom" align="right">
       
         </td>
		</tr>
	  <tr><td colspan="10"> <hr size="1" color="#4B4B4B"> </td></tr>
	  <tr>
     <td colspan="10" valign="top" align="left">
<table width="850" border="1" cellspacing='0' cellpadding='5' align=left>

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
 echo "<tr><td colspan=12 style='border-width: 1px; border-style: outset;'><b>Acara : ";
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


 //$rp=mysql_query("select id_paket from acara where id_client='$id_client' and id_acara='$id_acara'");
 $rp=mysql_query("select id_baju, id_sepatu, id_acc, id_blangkon, id_kain, jml_baju, jml_kain, jml_acc, jml_sepatu, jml_blangkon,id_plus from client_busana where id_client='$id_client' 
and id_acara='$id_acara'");

//$rc=mysql_query("select id_sepatu, id_tipe_sepatu from client_busana where id_client='$id_client' and id_acara='$id_acara'");
//$rd=mysql_query("select id_acc, id_tipe_acc from client_busana where id_client='$id_client' 
/*and id_acara='$id_acara'");*/

echo "<tr ><td><b>No</b></td>";
echo "<td><b>Nama</b></td>";
echo "<td><b>Jabatan</b>";
echo "</td><td><b>Baju</b>";
echo "</td><td > <b>Selop</b>";
echo "</td><td ><b>Kain</b>";
echo "</td><td ><b>Celana</b>";
echo "</td><td align='center'><b>Ukuran Baju</b>";
echo "</td><td align='center'> <b>Ukuran Sepatu</b>";

echo "</td><td align='center'><b>Ukuran Blangkon</b>";
echo "</td><td align='center'><b>Ukuran Celana</b>";
//echo "</td><td > <b>Jml</b>";

//echo "</td><td ><b>Acc</b>";
//echo "</td><td > <b>Jml</b>";
//echo "</td></tr>";

	echo "</tr><tr><td>";
$no=0;
 for($p=0;$p<@mysql_num_rows($rp);$p++){
	$id_baju=mysql_result($rp,$p,"id_baju");
	//$id_tipe_baju=mysql_result($rp,$p,"id_tipe_baju");
	$id_sepatu=mysql_result($rp,$p,"id_sepatu");
	//$id_tipe_sepatu=mysql_result($rc,$p,"id_tipe_sepatu");
	$id_acc=mysql_result($rp,$p,"id_acc");
	//$id_tipe_acc=mysql_result($rd,$p,"id_tipe_acc");
	$id_kain=mysql_result($rp,$p,"id_kain");
	$id_blangkon=mysql_result($rp,$p,"id_blangkon");
	
	$jml_baju=mysql_result($rp,$p,"jml_baju");
	$jml_kain=mysql_result($rp,$p,"jml_kain");
	$jml_acc=mysql_result($rp,$p,"jml_acc");
	$jml_sepatu=mysql_result($rp,$p,"jml_sepatu");
	$jml_blangkon=mysql_result($rp,$p,"jml_blangkon");
	$id_plus=mysql_result($rp,$p,"id_plus");
	
	
	
/*$np=mysql_query("select j.nama, k.nama_jabatan, b.layanan as baju, d.layanan as sepatu, f.layanan as kain, l.nama_ukuran_baju as u_baju, m.nama_ukuran_baju as u_sepatu, n.nama_ukuran_baju as u_blangkon 
				
				from  p_baju b, client_busana c, p_sepatu d, v_kain f, daftar_ukuran_pria j, p_jabatan k, p_jenis_ukuran_baju l, v_ukuran_sepatu m, v_ukuran_blangkon n
				
				where  b.id_layanan='$id_baju' and d.id_layanan='$id_sepatu' and f.id_layanan='$id_kain' and j.id_client='$id_client' and j.id_acara='$id_acara' and c.id_acara=j.id_acara and j.id_client=c.id_client and j.id_jabatan=k.id_jabatan and j.ukuran_beskap=l.id_ukuran_baju and j.ukuran_selop=m.id_ukuran_baju and j.ukuran_blangkon=n.id_ukuran_baju 
	and	j.id_sublayanan='$id_plus' group by j.nama");*/
	
$np=mysql_query("select nama, nama_jabatan, baju, sepatu, kain, acc, blangkon,celana, u_baju, u_sepatu, u_blangkon,u_celana
from v_ukuran_orang_pria where id_client='$id_client' and id_acara='$id_acara' and id_sublayanan='$id_plus' ");

	//$np=mysql_query("select  b.layanan as baju, d.layanan as sepatu, e.layanan as acc, c.jml_baju, c.jml_kain, c.jml_sepatu, c.jml_acc, c.jml_blangkon from p_baju_tipe a, p_baju b, client_busana c, p_sepatu d, p_acc e where  b.id_layanan='$id_baju' and d.id_layanan='$id_sepatu and e.id_layanan='$id_acc' ");
	
	
	while($wow = mysql_fetch_assoc($np)){
$no++;
echo $no.". ";
echo "</td><td >";
echo $wow['nama'];
		echo "</td><td >";
		echo $wow['nama_jabatan'];
		echo "</td><td >";
		echo $wow['baju'];
		echo "</td><td >";
		echo $wow['sepatu'];
		echo "</td><td >";
		echo $wow['kain'];
		echo "</td><td >";
		echo $wow['celana'];
		echo "</td><td align='center'>";
		
		echo $wow['u_baju'];
		echo "</td><td align='center'>";
		echo $wow['u_sepatu'];
		echo "</td><td align='center'>";
		echo $wow['u_blangkon'];
		echo "</td><td align='center'>";
		echo $wow['u_celana'];
		
		//echo mysql_result($np,0,"jml_sepatu");
		//echo "</td><td >";
		//echo mysql_result($np,0,"acc");
		//echo "</td><td >";
		//echo mysql_result($np,0,"jml_acc");
		//echo "</td><td >";
		
		
		echo "</td></tr><td nowarp >";
		

	}
}


/*
$rp=mysql_query("select id_kain, id_tipe_kain from client_busana where id_client='$id_client' 
and id_acara='$id_acara'");

//$no=0;
 for($p=0;$p<@mysql_num_rows($rp);$p++){
	$id_kain=mysql_result($rp,$p,"id_kain");
	$id_tipe_kain=mysql_result($rp,$p,"id_tipe_kain");
	$np=mysql_query("select a.keterangan, b.layanan, c.jml_kain from p_baju_tipe a, p_baju b, client_busana c where a.id_tipe_baju='$id_tipe_kain' and b.id_layanan='$id_kain'");
	

	echo "<tr><td>";
	if(mysql_num_rows($np)!=0){
$no++;
echo $no.". ";

		echo mysql_result($np,0,"keterangan");
		echo "</td><td >";
		echo mysql_result($np,0,"layanan");
		echo "</td><td >";
		echo mysql_result($np,0,"jml_kain");
		echo "</tr><tr><td nowrap>";

	}
}

$rp=mysql_query("select id_sepatu, id_tipe_sepatu from client_busana where id_client='$id_client' 
and id_acara='$id_acara'");
//$no=0;
 for($p=0;$p<@mysql_num_rows($rp);$p++){
	$id_sepatu=mysql_result($rp,$p,"id_sepatu");
	$id_tipe_sepatu=mysql_result($rp,$p,"id_tipe_sepatu");
	$np=mysql_query("select a.keterangan, b.layanan, c.jml_sepatu from p_sepatu_tipe a, p_sepatu b, client_busana c where a.id_tipe_sepatu='$id_tipe_sepatu' and b.id_layanan='$id_sepatu'");
	
	
	echo "<tr><td>";
	if(mysql_num_rows($np)!=0){
$no++;
echo $no.". ";

		echo mysql_result($np,0,"keterangan");
		echo "</td><td >";
		echo mysql_result($np,0,"layanan");
		echo "</td><td >";
		echo mysql_result($np,0,"jml_sepatu");
		echo "</tr><tr><td nowrap>";

	}
}

$rp=mysql_query("select id_acc, id_tipe_acc from client_busana where id_client='$id_client' 
and id_acara='$id_acara'");
//$no=0;
 for($p=0;$p<@mysql_num_rows($rp);$p++){
	$id_acc=mysql_result($rp,$p,"id_acc");
	$id_tipe_acc=mysql_result($rp,$p,"id_tipe_acc");
	$np=mysql_query("select a.keterangan, b.layanan, c.jml_acc from p_acc_tipe a, p_acc b, client_busana c where a.id_tipe_acc='$id_tipe_acc' and b.id_layanan='$id_acc'");
	

	echo "<tr><td>";
	if(mysql_num_rows($np)!=0){
$no++;
echo $no.". ";

		echo mysql_result($np,0,"keterangan");
		echo "</td><td >";
		echo mysql_result($np,0,"layanan");
		echo "</td><td >";
		echo mysql_result($np,0,"jml_acc");
		echo "</tr><tr><td nowrap>";

	}
}

$rp=mysql_query("select id_blangkon, id_tipe_blangkon from client_busana where id_client='$id_client' 
and id_acara='$id_acara'");
//$no=0;
 for($p=0;$p<@mysql_num_rows($rp);$p++){
	$id_blangkon=mysql_result($rp,$p,"id_blangkon");
	$id_tipe_blangkon=mysql_result($rp,$p,"id_tipe_blangkon");
	$np=mysql_query("select a.keterangan, b.layanan, c.jml_blangkon from p_baju_tipe a, p_baju b, client_busana c where a.id_tipe_baju='$id_tipe_blangkon' and b.id_layanan='$id_blangkon'");
	
	
	echo "<tr><td>";
	if(mysql_num_rows($np)!=0){
$no++;
echo $no.". ";

		echo mysql_result($np,0,"keterangan");
		echo "</td><td >";
		echo mysql_result($np,0,"layanan");
		echo "</td><td >";
		echo mysql_result($np,0,"jml_blangkon");
		echo "</tr><tr><td nowrap>";

	}
}
*/
echo "</td></tr>";
}

?>


</table>
<table width='100%' cellspacing='0' cellpadding='3'>
<tr><td> <hr size="1" color="#4B4B4B"> </td></tr>
</table>
</td>
		</tr>
	 </table>

   </td>
  </tr>
  </form>
</table>

<br />
<br />
<br />
<br />

</table>
<table width='100%' cellspacing='0' cellpadding='3'>
<tr><td> <hr size="1" color="#4B4B4B"> </td></tr>
</table>
</td>
		</tr>
	 </table>
<p>&nbsp;</p>
	 <center><img src="images/arrow2.gif" border="0">
	 <a href="<?="?menu=$menu&uid=$uid&page=pesanan&thn_rencana=$thn_rencana&bulan_rencana=$bln_rencana";?>"><b>Back Data Client</b></a>
</center>
   </td>
  </tr>
  </form>
</table>


<script type="text/javascript">
    window.print();
    window.onfocus = function() { window.close(); }
</script>