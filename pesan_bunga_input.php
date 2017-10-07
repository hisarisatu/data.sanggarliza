<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 11 oktober 2010, lastupdate 11 oktober 2010

include_once("include.php");
include_once("konversi.php");

if($id_client=="")$id_client=$id;

if($act=="add_extra_proses"){
	$sql="insert into pesan_bunga(id_client,id_acara,id_bunga,jml_pesan,satuan) values('$id_client','$id_acara','$id_bunga','$jml_orang','$satuan')";
	//echo $sql;
	mysql_query($sql);
	$act=null;
}

if($act=="del_extra"){
	$sql="delete from pesan_bunga where id_client='$id_client' and id_acara='$id_acara' and id_plus='$id_plus'";
	mysql_query($sql);
	$act=null;
}

?>
<div align=right><a href="<?="?menu=$menu&uid=$uid&page=view_bunga&id=$id_client"?>">Selesai</a></div>
<table cellpadding=5 cellspacing=0 border=0 width="100%">
<tr align=center>
	<td colspan=2 style='border:1px solid #000000'><b>Acara&nbsp;</td>
	<td style='border:1px solid #000000'><b>Tanggal</td>
	<td style='border:1px solid #000000'><b>Tempat</td>
	<td style='border:1px solid #000000'><b>Edit Bunga</td>
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
		echo "</td><td align=center>&nbsp;";
		echo mysql_result($res,$a,"tanggal");
		echo "</td><td>&nbsp;";
		echo mysql_result($res,$a,"tempat");
		echo "&nbsp;</td>";
		echo "<td align=center><a href=\"?menu=$menu&uid=$uid&page=$page&act=add_extra&id_client=$id_client&idc=$id_acara\"><img src='images/add.gif' width=16 height=16 border=0 title='Tambah Extra'></a>";		
		echo "</tr>";
		$sql="select a.id_pesan,b.nama,a.jml_pesan,c.keterangan from pesan_bunga a, bunga b,p_satuan c where a.id_bunga=b.id_bunga_pesanan and a.id_client='$id_client' and a.id_acara='$id_acara' and a.id_acara=b.id_acara and a.satuan=c.id_satuan";// echo $sql;
		$rs3=mysql_query($sql);
		for($c=0;$c<@mysql_num_rows($rs3);$c++){
			$id_plus=mysql_result($rs3,$c,"id_pesan");
			echo "<tr><td>&raquo;</td><td>";
			echo mysql_result($rs3,$c,"nama");
			echo "&nbsp;[";
			echo mysql_result($rs3,$c,"jml_pesan");
			echo "&nbsp;";
			echo mysql_result($rs3,$c,"keterangan");
			echo "]</td><td colspan=2 align=right>&nbsp;</td>";
			/*
			echo "<td align=right>Rp. ";
			echo number_format(mysql_result($rs3,$c,"harga"),0);
			echo "</td>";
			
			echo "<td>&nbsp;</td>";
			*/
			echo "<td align=center><a href=\"?menu=$menu&uid=$uid&page=$page&act=del_extra&id_client=$id_client&id_acara=$id_acara&id_plus=$id_plus\"><img src='images/del.gif' border=0 title='Hapus Extra'></a></td></tr>";
		}
	}
?>
<tr>
	<td colspan=8 align=center><hr></td>
</tr>
</table>
<?
if($act=="add_extra"){
	?>
	<form method="post" action="<?="?menu=$menu&uid=$uid&page=$page&act=add_extra_proses&id_client=$id_client&id_acara=$idc"?>">
		<table>
		<tr valign=top>
			<td><SELECT NAME="id_bunga">
				<OPTION selected label="none" value="none">None</OPTION>
				<?
				$sql="select id_bunga_pesanan,nama from bunga";
				$r=mysql_query($sql);
				for($b=0;$b<mysql_num_rows($r);$b++){
				$sa=mysql_result($r,$b,"id_bunga_pesanan");
				$sb=mysql_result($r,$b,"nama");
				echo "<option value='$sa'>$sb";
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
?>