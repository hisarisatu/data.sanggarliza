<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 11 oktober 2010, lastupdate 11 oktober 2010

include_once("include.php");
include_once("konversi.php");

if($id_client=="")$id_client=$id;

if($act=="add_acara_proses"){
//print_r($_POST);
$newdate = explode("/",$tanggal);
$tanggal = $newdate[2]."-".$newdate[0]."-".$newdate[1];
$sql="insert into acara values('$id_client','$id_acara','$id_gaya','$id_paket','$tanggal','$waktu','$tempat','$catatan','$SAH[id_user]','$REMOTE_ADDR',now(),'$SAH[id_user]','$REMOTE_ADDR',now())";//echo $sql;
mysql_query($sql);
$act=null;
}

if($act=="add_extra_proses"){
	$hd=mysql_query("select harga_dasar from p_sublayanan where id_sublayanan='$subpesanan'");
	$hrg_dsr=mysql_result($hd,0,"harga_dasar");
	$harga=($hrg_dsr*$jml_orang);
	$input_harga=$harga-(($diskon/100)*$harga);
	$sql="insert into pesanan_plus(id_client,id_acara,id_sublayanan,jml_orang,harga,satuan) values('$id_client','$id_acara','$subpesanan','$jml_orang','$input_harga','$satuan')";
	//echo $sql;
	mysql_query($sql);
	$act=null;
}

if($act=="add_paket_proses"){
	$hd=mysql_query("select tanggal,waktu,tempat from acara where id_client='$id_client' and id_acara='$id_acara'");
	$tgl = mysql_result($hd,0,"tanggal");
	$waktu = mysql_result($hd,0,"waktu");
	$tempat= mysql_result($hd,0,"tempat");
	$sql="insert into acara values('$id_client','$id_acara','$sel_gaya','$sel_paket','$tgl','$waktu','$tempat','-','$SAH[id_user]', '$REMOTE_ADDR', now(),null,null,null)";
	mysql_query($sql);//echo $sql;
	$sql="delete from acara where id_client='$id_client' and id_acara='$id_acara' and id_paket='0'";
	mysql_query($sql);
	$act=null;
}

if($act=="del_extra"){
	$sql="delete from pesanan_plus where id_client='$id_client' and id_acara='$id_acara' and id_plus='$id_plus'";
	mysql_query($sql);
	$act=null;
}

if($act=="del_paket"){
	$n=mysql_query("select count(*) jml from acara where id_client='$id_client' and id_acara='$idc' and id_paket=0");
	$m=@mysql_result($n,0,"jml");echo $m;
	if($m>0)mysql_query("delete from acara where id_client='$id_client' and id_acara='$idc' and id_paket=0");
	$sql="update acara set id_paket=0 where id_client='$id_client' and id_acara='$idc' and id_paket='$id_paket'";//echo $sql;
	$d=mysql_query($sql);
	$act=null;$id_acara=$idc;
}

if($act=="del_acara"){
	$sql="delete from acara where id_client='$id_client' and id_acara='$id_acara'";
	mysql_query($sql);
	$sql="delete from pesanan_plus where id_client='$id_client' and id_acara='$id_acara'";
	mysql_query($sql);
	$act=null;
}

?>
<div align=right><a href="<?="?menu=$menu&uid=$uid&page=view&id=$id_client"?>">Selesai</a></div>
<table cellpadding=5 cellspacing=0 border=0 width="850">
<tr>
	<td colspan=2 style='border:1px solid #000000'><b>Acara&nbsp;<a href="<?="?menu=$menu&uid=$uid&page=$page&act=add_acara&id_client=$id_client"?>"><img src='images/add.gif' height='16' width='16' border=0></a></td>
	<td style='border:1px solid #000000'><b>Tanggal</td>
	<td style='border:1px solid #000000'><b>Tempat</td>
	<td style='border:1px solid #000000'><b>Harga</td>
	<td style='border:1px solid #000000'><b>Acara</td>
	<td style='border:1px solid #000000'><b>Paket</td>
	<td style='border:1px solid #000000'><b>Extra</td>
</tr>
	<?
	if($id_client=="")$id_client=$id;
	$sql="select distinct a.id_acara,b.acara,a.tanggal,a.tempat from acara a, p_acara b where a.id_client='$id_client' and a.id_acara=b.id_acara";
	//echo $sql;
	$res=mysql_query($sql);
	for($a=0;$a<mysql_num_rows($res);$a++){
		$id_acara=mysql_result($res,$a,"id_acara");
		echo "<tr>";
		echo "<td colspan=2>";
		echo mysql_result($res,$a,"acara");
		echo "</td><td>&nbsp;";
		echo mysql_result($res,$a,"tanggal");
		echo "</td><td>&nbsp;";
		echo mysql_result($res,$a,"tempat");
		echo "&nbsp;</td><td>&nbsp;</td>";
		echo "<td align=center><a href=\"?menu=$menu&uid=$uid&page=$page&act=del_acara&id_client=$id_client&id_acara=$id_acara\"><img src='images/del.gif' border=0 title='Hapus Acara'></a></td><td align=center>";
			echo " <a href=\"?menu=$menu&uid=$uid&page=$page&act=add_paket&id_client=$id_client&idc=$id_acara\"><img src='images/add.gif' width=16 height=16 border=0 title='Tambah Paket'></a>";			
		echo "<td align=center>";
			echo " <a href=\"?menu=$menu&uid=$uid&page=$page&act=add_extra&id_client=$id_client&idc=$id_acara\"><img src='images/add.gif' width=16 height=16 border=0 title='Tambah Extra'></a>";
		echo "</tr>";
		$sql="select a.id_paket,b.nama_paket,b.harga_paket from acara a, paket b where a.id_acara='$id_acara' and a.id_client='$id_client' and a.id_paket=b.id_paket";
		$rs2=mysql_query($sql);
		for($b=0;$b<mysql_num_rows($rs2);$b++){
			$id_paket=mysql_result($rs2,$b,"id_paket");
			echo "<tr><td>&raquo;</td><td nowrap>";
			echo mysql_result($rs2,$b,"nama_paket");
			echo "</td><td colspan=2 align=right>&nbsp;</td><td align=right>Rp. ";
			echo number_format(mysql_result($rs2,$b,"harga_paket"),0);
			echo "</td><td>&nbsp;</td>";
			echo "<td align=center><a href=\"?menu=$menu&uid=$uid&page=$page&act=del_paket&id_client=$id_client&idc=$id_acara&id_paket=$id_paket\"><img src='images/del.gif' border=0 title='Hapus Paket'></a></td></tr>";
		}
		$sql="select a.id_plus,b.detail_layanan,a.jml_orang,a.harga from pesanan_plus a, p_sublayanan b where a.id_sublayanan=b.id_sublayanan and a.id_client='$id_client' and id_acara='$id_acara'"; //echo $sql;
		$rs3=mysql_query($sql);
		for($c=0;$c<mysql_num_rows($rs3);$c++){
			$id_plus=mysql_result($rs3,$c,"id_plus");
			echo "<tr><td>&raquo;</td><td>";
			echo mysql_result($rs3,$c,"detail_layanan");
			echo "</td><td colspan=2 align=right>&nbsp;</td><td align=right>Rp. ";
			echo number_format(mysql_result($rs3,$c,"harga"),0);
			echo "</td><td>&nbsp;</td><td>&nbsp;</td>";
			echo "<td align=center><a href=\"?menu=$menu&uid=$uid&page=$page&act=del_extra&id_client=$id_client&id_acara=$id_acara&id_plus=$id_plus\"><img src='images/del.gif' border=0 title='Hapus Extra'></a></td></tr>";
		}	
		echo "<td colspan=2>&nbsp;";
		echo "</td><td>&nbsp;";
		//echo mysql_result($res,$a,"tanggal");
		echo "</td><td>&nbsp;";
		//echo mysql_result($res,$a,"tempat");
		echo "</td>";
		echo "<td>&nbsp;</td>";
	}
$sql="select sum(jumlah) total
from 
(
select sum(harga_paket) jumlah from paket where id_paket in (select id_paket from acara where id_client='$id_client')
union
select sum(harga) jumlah from pesanan_plus where id_client='$id_client'
) a";
$rt=mysql_query($sql);
$total=@mysql_result($rt,0,"total");
?>
<tr>
	<td colspan=4 style='border:1px solid #000000' align=right><b>Total</td>
	<td colspan=4 style='border:1px solid #000000' align=right><b><font style="font-size:larger;"><u>Rp. <?=number_format($total,0)?></td>
</tr>
<tr>
	<td colspan=8 style='border:1px solid #000000' align=center><b><?=katakan($total)?></td>
</tr>
</table>
<?
if($act=="add_extra"){
	?>
	<form method="post" action="<?="?menu=$menu&uid=$uid&page=$page&act=add_extra_proses&id_client=$id_client&id_acara=$idc"?>">
		<table>
		<tr valign=top>
			<td><SELECT NAME="subpesanan">
				<OPTION selected label="none" value="none">None</OPTION>
				<?
				$sql="select id_layanan,layanan from p_layanan";
				$r=mysql_query($sql);
				for($b=0;$b<mysql_num_rows($r);$b++){
				$sa=mysql_result($r,$b,"id_layanan");
				$sb=mysql_result($r,$b,"layanan");
				echo "<optgroup label='$sb'>";
				$sql="select id_sublayanan,detail_layanan from p_sublayanan where id_layanan='$sa' and id_sublayanan not in (select id_sublayanan from paket_sub_paket where id_paket='$id_paket') and id_sublayanan not in (select id_sublayanan from pesanan_plus where id_client='$id_client' and id_acara='$idc') order by detail_layanan";
				//echo $sql;//developer
				$rs=mysql_query($sql);
				for($a=0;$a<mysql_num_rows($rs);$a++){
                    $il=mysql_result($rs,$a,"id_sublayanan");
                    $vl=mysql_result($rs,$a,"detail_layanan");
                    $sz=strlen($vl);
                    if($sz>95){
                        $tz=str_split($vl,95);
                        for($z=0;$z<count($tz);$z++){
                            echo "<option value='$il'>&nbsp;&nbsp;";
                            if($z!=0)echo "&raquo;&nbsp;";
                            echo "$tz[$z]</option>";
                        }
                    }else{
                        echo "<option value=\"$il\">&nbsp;&nbsp;$vl</option>";
                    }
                }
				echo "</optgroup>";
				}
				?>
				</SELECT><?//=$sql?></td>
			<td><input type="text" name="jml_orang" size=4 value=1></td>
			<td><select name="satuan">
			<?
			$rsat=mysql_query("select id_satuan,keterangan from p_satuan");
			for($sat=0;$sat<@mysql_num_rows($rsat);$sat++){
				echo "<option value=\"";
				echo mysql_result($rsat,$sat,"id_satuan");
				echo "\">";
				echo mysql_result($rsat,$sat,"keterangan");
				echo "</option>";
			}
			?>
			</select>
			</td>
			<td><INPUT TYPE="submit" SRC="images/add.gif" BORDER="0" ALT="Tambah Layanan" name="gambar" style="border-color:#FFFFFF;" value="Add"></td>
		</tr>
		</table>
	</form>
	<?
}

if($act=="add_paket"){
	?>
	<form method="post" action="<?="?menu=$menu&uid=$uid&page=$page&act=add_paket_proses&id_client=$id_client&id_acara=$idc"?>">
		<table>
		<tr valign=top>
			<td><SELECT NAME="sel_paket">
				<OPTION selected label="none" value="none">None</OPTION>
				<?
				$sql="select id_paket,nama_paket from paket where id_paket not in (select id_paket from acara where id_acara='$idc' and id_client='$id_client')";
				$r=mysql_query($sql);
				for($b=0;$b<mysql_num_rows($r);$b++){
				$sa=mysql_result($r,$b,"id_paket");
				$sb=mysql_result($r,$b,"nama_paket");
					echo "<option value=\"$sa\">$sb</option>";
				}
				?>
				</SELECT><?//=$sql?></td>
			<td><SELECT NAME="sel_gaya">
				<?
				$sql="select id_gaya,gaya from p_gaya ";
				$r=mysql_query($sql);
				for($b=0;$b<mysql_num_rows($r);$b++){
				$sa=mysql_result($r,$b,"id_gaya");
				$sb=mysql_result($r,$b,"gaya");
					echo "<option value=\"$sa\">$sb</option>";
				}
				?>
				</SELECT><?//=$sql?></td>
			<td><INPUT TYPE="submit" SRC="images/add.gif" BORDER="0" ALT="Tambah Layanan" name="gambar" style="border-color:#FFFFFF;" value="Add"></td>
		</tr>
		</table>
	</form>
	<?
}

if($act=="add_acara"){
?>
<?
		$vrb_acara = "id_acara";
		$vlu_acara = $$vrb_acara;
		$vrb_gaya = "id_gaya";
		$vlu_gaya = $$vrb_gaya;
		$vrb_paket = "id_paket";
		$vlu_paket = $$vrb_paket;
		$vrb_tanggal = "tanggal";
		$vlu_tanggal = $$vrb_tanggal;
		$vrb_waktu = "waktu";
		$vlu_waktu = $$vrb_waktu;
		$vrb_tempat = "tempat";
		$vlu_tempat = $$vrb_tempat;
		$vlu_tempat = ucwords($vlu_tempat);
		$vrb_catatan = "catatan";
		$vlu_catatan = $$vrb_catatan;
		$vlu_catatan = ucwords($vlu_catatan);

		unset($selectacara);
		$selectacara = "<option value=''>-- Pilih Acara --</option>\n"; 
		$runSQL2 = "select id_acara,acara from p_acara where id_acara not in (select distinct id_acara from acara where id_client='$id_client')";
		$result2 = mysql_query($runSQL2, $connDB);
		while ($row2 = mysql_fetch_array ($result2)) {
			$selectacara .= "<option value='".$row2[id_acara]."'>$row2[acara]</option>\n"; 
		};//while
		$selectacara = "<select size=1 name='$vrb_acara' class='edyellow'> $selectacara </select>";
		
		unset($selectgaya);
		$selectgaya = "<option value=''>-- Pilih Gaya --</option>\n"; 
		$runSQL2 = "select id_gaya, gaya from p_gaya order by id_gaya asc";
		$result2 = mysql_query($runSQL2, $connDB);
		while ($row2 = mysql_fetch_array ($result2)) {
			$selectgaya .= "<option value='".$row2[id_gaya]."'>$row2[gaya]</option>\n"; 
		};//while
		$selectgaya = "<select size=1 name='$vrb_gaya' class='edyellow'> $selectgaya </select>";

		unset($ii,$selectpaket);
		$selectpaket = "<option value=''>-- Pilih Paket --</option>\n"; 
		$runSQL2 = "select id_paket, nama_paket, harga_paket from paket order by id_paket asc";
		$result2 = mysql_query($runSQL2, $connDB);
		while ($row2 = mysql_fetch_array ($result2)) {
			$ii++;
			if ($row2[harga_paket] > 0){ $infoharga=" - Rp.".number_format($row2[harga_paket],0); }else{ unset($infoharga); }
			$selectpaket .= "<option value='".$row2[id_paket]."' >$ii. $row2[nama_paket]$infoharga</option>\n"; 
		};//while
		$selectpaket = "<select size=1 name='$vrb_paket' class='edyellow'> $selectpaket </select>";

		$ccc++;
		if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
		$htmlData .= "
			<tr bgcolor='$color'>
				<td>
				 <table width='100%' border='0' cellpadding='2' cellspacing='0'>
					<tr>
					 <td> Acara </td><td> : </td><td> $selectacara
					 </td>
					</tr>
					<tr>
					 <td> Tanggal </td><td> : </td><td> <input type='text' name='$vrb_tanggal' size='11' value='$vlu_tanggal'>
					 <script language='JavaScript'> new tcal ({'formname': 'form','controlname': '$vrb_tanggal'}); </script>
					 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Jam : <input type='text' name='$vrb_waktu' size='10' value=\"".htmlentities(stripslashes($vlu_waktu))."\">
					 </td>
					</tr>
					<tr>
					 <td> Gaya </td><td> : </td><td> $selectgaya
					 &nbsp; &nbsp; &nbsp; Ket : <input type='text' name='$vrb_catatan' size='35' value='$vlu_catatan'>
					 </td>
					</tr>
					<tr>
					 <td> Paket </td><td> : </td><td> $selectpaket </td>
					</tr>
					<tr>
					 <td> Lokasi </td><td> : </td><td> <input type='text' name='$vrb_tempat' size='70' value=\"".htmlentities(stripslashes($vlu_tempat))."\"></td>
					</tr>
				 </table>
				</td>
			</tr>
		";//htmlData
//	};//end-while
?>

   <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page&act=add_acara_proses&id_client=$id_client";?>">
	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
     <td colspan="2" valign="top" align="center">
		 <script language="JavaScript" src="calendar_us.js"></script>
			 <table width='600' cellspacing='1' cellpadding='3'>
			  <?=$htmlData;?>
				<tr>
					<td width="100%" colspan="2" align="center">
					 <input type="hidden" name="id" value="<?=$id;?>"><br>
					 <input type="submit" value="Simpan" name="run" class="button">
					</td>
				</tr>
			 </table>
		 </td>
		</tr>
	 </table>
   </form>
<?
}
?>