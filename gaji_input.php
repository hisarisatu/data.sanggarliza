<?php
include_once ("include.php");
include_once ("p_bulan.php");
if (($SAH[id_group]==1))
{
?>

INPUT DATA GAJI			
<form method=post action="">
<table>
	<tr>
		<td>Bulan</td>
		<td><select name="id_bulan">
				<option value="%">-All-</option>
				<?
				for($bl=1;$bl<13;$bl++){
					if($bl<10)$bl="0".$bl;
				echo "<option ";
				if($bl==$id_bulan)echo " selected ";
				echo "value='$bulan'>".nama_bulan($bl)."</option>";
				}
				?>
			</select></td>
	</tr>
	<tr>
		<td colspan=2><b>Pegawai</b></td>
	</tr>
	<tr>
		<td>Nama Pegawai</td>
		<td><select name="id_pegawai" onchange="javascript:this.form.submit();">
		<?
		$sql="select id_pegawai,nama,gaji_dasar,transport,uang_makan from pegawai order by nama";
		$rs=mysql_query($sql);
		while($ro=mysql_fetch_array($rs)){
			echo "<option value='$ro[id_pegawai]'>$ro[nama]</option>";
		}
		?></select>
		</td>
	</tr>
	<?
	$sql="select id_pegawai,gaji_dasar,transport,uang_makan from pegawai where id_pegawai='$id_pegawai'";
	$rs2=mysql_query($sql);
	$row=mysql_fetch_array($rs2);
	?>
	<tr>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td colspan=2><b>Pendapatan</b></td>
	</tr>
	<tr>
		<td>Gaji Dasar</td>
		<td><?=$row[gaji_dasar]?></td>
	</tr>
	<tr>
		<td>Transportasi</td>
		<td><?=$row[transport]?></td>
	</tr>
	<tr>
		<td>Uang Makan</td>
		<td><?=$row[uang_makan]?></td>
	</tr>
	<tr>
		<td nowrap>Tunjangan Prestasi</td>
		<td><input type="text" name="tupres"></td>
	</tr>
	<tr>
		<td nowrap>Bonus</td>
		<td><input type="text" name="bonus"></td>
	</tr>
	<tr>
		<td nowrap>Borongan</td>
		<td><input type="text" name="borongan"></td>
	</tr>
	<tr>
		<td nowrap>Lembur</td>
		<td><input type="text" name="lembur"></td>
	</tr>
	<tr>
		<td nowrap>THR</td>
		<td><input type="text" name="thr"></td>
	</tr>
	<tr>
		<td colspan=2><b>Potongan</b></td>
	</tr>
	<tr>
		<td nowrap>Absen</td>
		<td><input type="text" name="absen"></td>
	</tr>
	<tr>
		<td nowrap>Kasbon</td>
		<td><input type="text" name="kasbon"></td>
	</tr>
	<tr>
		<td nowrap>Tabungan</td>
		<td><input type="text" name="tabungan"></td>
	</tr>
	<tr>
		<td colspan=2 align=center><input type="submit" value="input"></td>
	</tr>
</table>			
			
Total Pendapatan			<Total Pendapatan - Total Potongan>

</form>

<?
}
else
{echo"</br>";
echo"</br>";
echo "<div align='center'><font color='#FF0000'><b>Akses Tidak Diperbolehkan. Hanya Group Administrator</b></font></div>"; }
?>