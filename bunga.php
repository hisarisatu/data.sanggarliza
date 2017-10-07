<?
include_once "include.php";
if (($SAH[id_group]==1))
{
if($act=="input_jenis_proses"){
	$sql = " insert into p_bunga values(null,'$jenis_bunga')";
	mysql_query($sql);
	$act=null;
}

if($act=="input_proses"){
	$newdate=explode("/",$tgl_pesanan);
	$tgl_pesanan=$newdate[2]."-".$newdate[0]."-".$newdate[1];
if($id!=""){
$sql="update bunga set id_acara='$id_acara',tanggal='$tgl_pesanan',id_gaya='$id_gaya',id_bunga='$id_bunga',nama='$nama',keterangan='$keterangan',input_date=now() where id_bunga_pesanan='$id'";
}else{
$sql="insert into bunga values(null,'$id_acara','$tgl_pesanan','$id_gaya','$id_bunga','$nama','$keterangan',now())";
}
//echo $sql;
    mysql_query($sql);
    //echo "Input selesai";
    $act=null;
}

if($act=="delete"){
	$sql="delete from bunga where id_bunga_pesanan='$id'";
	mysql_query($sql);
	$act=null;
}

if(!$act){
	$id=null;$act=null;
?>
<table width='600' cellspacing='1' cellpadding='3'>
<tr align=center height='25'>
	<td colspan=15 align=right><a href="?menu=<?=$menu?>&uid=<?=$uid?>&page=<?=$page?>&act=input"><img src="images/add.gif" border=0 width=16 height=16> Pesanan</a> | <a href="?menu=<?=$menu?>&uid=<?=$uid?>&page=<?=$page?>&act=input_jenis"><img src="images/add.gif" border=0 width=16 height=16> Jenis</a></td>
</tr>
<tr bgcolor='#A7A7A7' height="25" align=center>
	<td><b>No</td>
	<td><b>Nama</td>
	<td><b>Acara</td>
	<td><b>Tanggal</td>
	<td><b>Gaya</td>
	<td><b>Jenis</td>
	<td><b>Edit</td>
</tr>
<?
$sql="select a.nama,a.id_bunga_pesanan, b.acara,date_format(tanggal,'%d-%m-%Y') tanggal,c.gaya,d.keterangan from bunga a,p_acara b,p_gaya c,p_bunga d where a.id_acara=b.id_acara and a.id_gaya=c.id_gaya and a.id_bunga=d.id_bunga order by a.id_bunga_pesanan";
$result=mysql_query($sql);
for($a=0;$a<@mysql_num_rows($result);$a++){
	$id=mysql_result($result,$a,"id_bunga_pesanan");
	$ccc++;
    if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
echo "
<tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
    <td align='center'>".($ccc)."</td>";?>
	<td><?=mysql_result($result,$a,"nama")?></td>
	<td><?=mysql_result($result,$a,"acara")?></td>
	<td><?=mysql_result($result,$a,"tanggal")?></td>
	<td><?=mysql_result($result,$a,"gaya")?></td>
	<td><?=mysql_result($result,$a,"keterangan")?></td>
	<td align=center><a href="?menu=<?=$menu?>&uid=<?=$uid?>&page=<?=$page?>&act=input&id=<?=$id?>"><img src="images/edit.gif" border=0></a> | <a href="?menu=<?=$menu?>&uid=<?=$uid?>&page=<?=$page?>&act=delete&id=<?=$id?>"><img src="images/del.gif" border=0></a></td>
</tr>
<? } ?>
</table>
<?
}

if($act=="input_jenis"){
$act=null;
?>
<form method=post action="?menu=<?=$menu?>&uid=<?=$uid?>&page=<?=$page?>">
<input type="hidden" name="act" value="input_jenis_proses">
<table>
	<tr>
		<td>Jenis</td>
		<td><input type="text" name="jenis_bunga"></td>
		<td><input type="submit" value="input"><input type="reset" value="reset"></td>
	</tr>
	</table>	
</form>
<?
}

if($act=="input"){
?>
<form method=post action="?menu=<?=$menu?>&uid=<?=$uid?>&page=<?=$page?>" name="form">
<?	$act=null;
	if($id!=""){
		$sql="select * from bunga where id_bunga_pesanan='$id'";
		$rs=mysql_query($sql);
		while ($row = mysql_fetch_array($rs, MYSQL_ASSOC)) {
			$id_acara=$row['id_acara'];
			$tgl=$row['tanggal'];
				$newdate=explode("-",$tgl);
				$tgl=$newdate[1]."/".$newdate[2]."/".$newdate[0];
			$id_gaya=$row['id_gaya'];
			$id_jenis=$row['id_bunga'];
			$nama=$row['nama'];
			$keterangan=htmlentities($row['keterangan']);
		}
	echo "<input type='hidden' value='$id' name='id'>";
	}else{
		$tgl=date("m/d/Y");
	}
?>
<input type="hidden" name="act" value="input_proses">
	<table>
	<tr>
		<td>Nama</td>
		<td><input type="text" name="nama" value="<?=$nama?>" size="50"></td>
	</tr>
	<tr>
		<td>Acara</td>
		<td>
		<select name="id_acara" class='edyellow'>
			<option value="0">--pilih satu--</option>
			<?
			$r2=mysql_query("select * from p_acara");
			for($a2=0;$a2<@mysql_num_rows($r2);$a2++){
			?>
			<option <? if($id_acara==mysql_result($r2,$a2,"id_acara"))echo " selected ";?> value="<?=mysql_result($r2,$a2,"id_acara")?>"><?=mysql_result($r2,$a2,"acara")?></option>
			<? } ?>
		</select>
		</td>
	</tr>
	<script language="JavaScript" src="calendar_us.js"></script>
	<tr>
		<td>Tanggal</td>
		<td><input type='text' name='tgl_pesanan' size='11' value='<?=$tgl?>'>
			<script language='JavaScript'> new tcal ({'formname': 'form','controlname': 'tgl_pesanan'}); </script></td>
	</tr>
	<tr>
		<td>Gaya</td>
		<td><select size=1 name='id_gaya' class='edyellow'>
		<?
		echo "<option value=''>-- Pilih Gaya --</option>\n"; 
		$runSQL2 = "select id_gaya, gaya from p_gaya order by id_gaya asc";
		$result2 = mysql_query($runSQL2, $connDB);
		while ($row2 = mysql_fetch_array ($result2)) {
			if($row2[id_gaya]==$id_gaya){$cek="selected";}else{$cek=null;}
			echo "<option value='".$row2[id_gaya]."' $cek>$row2[gaya]</option>\n"; 
		};//while
		?>
		</select>
		</td>
	</tr>
	<tr>
		<td>Jenis</td>
		<td><select name="id_bunga" class='edyellow'>
			<option value="0">--pilih satu--</option>
			<?
			$r2=mysql_query("select * from p_bunga");
			for($a2=0;$a2<@mysql_num_rows($r2);$a2++){
			?>
			<option <? if($id_jenis==mysql_result($r2,$a2,"id_bunga"))echo " selected ";?> value="<?=mysql_result($r2,$a2,"id_bunga")?>"><?=mysql_result($r2,$a2,"keterangan")?></option>
			<? } ?>
		</select></td>
	</tr>
	<tr>
		<td>Keterangan</td>
		<td><textarea name="keterangan" rows="3" cols="50"><?=$keterangan?></textarea></td>
	</tr>
	<tr>
		<td colspan=2 align=center><input type="submit" value="Input">&nbsp;<input type="reset"></td>
	</tr>
	</table>
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