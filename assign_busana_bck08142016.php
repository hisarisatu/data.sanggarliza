<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 09 oktober 2010, lastupdate 09 oktober 2010



include_once("include.php");

$n=mysql_query("select id_tipe_baju, id_baju, jml_baju, id_tipe_kain, id_kain, jml_kain,id_tipe_acc,id_acc,jml_acc, id_tipe_sepatu, id_sepatu, jml_sepatu, id_blangkon, id_tipe_blangkon, jml_blangkon, id_client,id_acara,id_paket,id_paket 
from client_busana where id_client='$id_client' 
and id_acara='$id_acara' and id_paket='$id_paket' and id_plus='$id_plus'");
$jml=mysql_num_rows($n);
echo $jml;


	
//============================================================================================================================================================
if ($run != "")
{ 
	if ($jml == 0){
			$registerInvalid = 1;
			$runSQL = "insert into client_busana (
			id_client,id_acara,id_paket,id_plus,
			id_tipe_baju,id_baju,jml_baju,
			id_tipe_kain,id_kain,jml_kain,
			id_tipe_acc,id_acc,jml_acc,
			id_tipe_blangkon,id_blangkon,jml_blangkon,			
			id_tipe_sepatu,id_sepatu,jml_sepatu
			)
			values(
			'$id_client','$id_acara','$id_paket','$id_plus',
			'$id_tipe_baju','$id_baju','$jml_baju',
			'$id_tipe_kain','$id_kain','$jml_kain',
			'$id_tipe_acc','$id_acc','$jml_acc',
			'$id_tipe_blangkon','$id_blangkon','$jml_blangkon',			
			'$id_tipe_sepatu','$id_sepatu','$jml_sepatu'						
			)";
			//echo $runSQL;
			$insert = mysql_query($runSQL, $connDB);
			$id = mysql_insert_id($connDB);
			
		} 
	else if ($jml != 0){
			$registerInvalid = 1;
			$runSQL = "update client_busana set
			id_tipe_baju='$id_tipe_baju',id_baju='$id_baju',jml_baju='$jml_baju',
			id_tipe_kain='$id_tipe_kain',id_kain='$id_kain',jml_kain='$jml_kain',
			id_acc='$id_acc',id_tipe_acc='$id_tipe_acc',jml_acc='$jml_acc', 
			id_tipe_blangkon='$id_tipe_blangkon',id_blangkon='$id_blangkon',jml_blangkon='$jml_blangkon',			
			id_tipe_sepatu='$id_tipe_sepatu',id_sepatu='$id_sepatu',jml_sepatu='$jml_sepatu'
			where id_client='$id_client' and id_acara='$id_acara' and id_paket='$id_paket' and id_plus='$id_plus' ";
			echo $runSQL;
			$update = mysql_query($runSQL, $connDB);
		};//if
};
//============================================================================================================================================================

if ($run == ""){ 
	if ($jml != 0)
	{
		if($id_tipe_baju!="" and $id_tipe_acc!="" and $id_tipe_kain!="" and $id_tipe_sepatu!="" and $id_tipe_blangkon!="")
		{
			$id_tipe_acc=$id_tipe_acc;
			$id_tipe_baju=$id_tipe_baju;
			$id_tipe_kain=$id_tipe_kain;
			$id_tipe_sepatu=$id_tipe_sepatu;
			$id_tipe_balngkon=$id_tipe_blangkon;
		}
		else
		{
			$id_tipe_acc=mysql_result($n,0,"id_tipe_acc");
			$id_tipe_baju=mysql_result($n,0,"id_tipe_baju");
			$id_tipe_kain=mysql_result($n,0,"id_tipe_kain");
			$id_tipe_sepatu=mysql_result($n,0,"id_tipe_sepatu");
			$id_tipe_blangkon=mysql_result($n,0,"id_tipe_blangkon");
			
			$id_acc=mysql_result($n,0,"id_acc");
			$id_kain=mysql_result($n,0,"id_kain");
			$id_baju=mysql_result($n,0,"id_baju");
			$id_blangkon=mysql_result($n,0,"id_blangkon");
			$id_sepatu=mysql_result($n,0,"id_sepatu");

			$jml_acc=mysql_result($n,0,"jml_acc");
			$jml_baju=mysql_result($n,0,"jml_baju");
			$jml_kain=mysql_result($n,0,"jml_kain");
			
			$jml_sepatu=mysql_result($n,0,"jml_sepatu");
			$jml_blangkon=mysql_result($n,0,"jml_blangkon");
		}
	
	
	}
	

?>
<form method="POST" name="form" action="<?="?id_client=$id_client&id_acara=$id_acara&id_paket=$id_paket&id_plus=$id_plus";?>">
<table border="0" cellspacing="0" cellpadding="5" align=left width="100%">
<tr><td width="100%" align="center" vAlign="center"><font class="titledata"><b>Update Busana</b></font>
	<table border="1" cellpadding="5" cellspacing="0" width="1000">
	    <tr><td width="25%" align="Center">Keterangan Busana</td>
	    <td width="25%" align="center">Katagori Busana</td>
	    <td width="25%" align="center">Jenis Busana</td>
	    <td width="25%" align="center">Jumlah Busana</td></tr>
		<tr><td width="25%" align="left">Update Baju</td>
            <td width="25%" align="left">
            <select name="id_tipe_baju" onchange="javascript:this.form.submit();">
			<?
				$sql="select id_tipe_baju,keterangan from p_baju_tipe 
				where (upper(keterangan) not like '%KAIN%' and upper(keterangan) not like '%BLANGKON%' and upper(keterangan) not like '%ROK%' and upper(keterangan) not like '%CELANA%' and upper(keterangan) not like '%KOPIAH%' and upper(keterangan) not like '%SELOP%') order by keterangan asc";
				$rs=mysql_query($sql);
				for($a=0;$a<mysql_num_rows($rs);$a++){
				echo "<option ";
				$idp=mysql_result($rs,$a,"id_tipe_baju");
				if ($idp==$id_tipe_baju)echo " selected ";
				echo " value=\"$idp\">";
				echo mysql_result($rs,$a,"keterangan");
				echo "</option>";
				} 
			?>
			</select></td>
			<td width="25%" align="left"><select name="id_baju" value="<?=$id_baju;?>">
				<?
				if(!isset($id_tipe_baju))$id_tipe_baju=1;
				$sql="select id_layanan,layanan from p_baju where id_tipe_baju='$id_tipe_baju' order by layanan asc";
				$rs=mysql_query($sql);
				for($a=0;$a<mysql_num_rows($rs);$a++){
				echo "<option ";
				$idl=mysql_result($rs,$a,"id_layanan");
				if ($idl==$id_baju)echo " selected ";
				echo " value=\"$idl\">";
				echo mysql_result($rs,$a,"layanan");
				echo "</option>";
				} 
			?>
			</select></td>
            <td width="25%" align="center"><input type="text" name="jml_baju" value="<?=$jml_baju;?>" size="5"> 
            <font color="#FF0000"><b>*</b></font></td>
        </tr>

		<tr><td width="25%" align="left">Update Kain</td>
            <td width="25%" align="left">
            <select name="id_tipe_kain" onchange="javascript:this.form.submit();">
			<?
				$sql="select id_tipe_baju id_tipe_kain,keterangan from p_baju_tipe where upper(keterangan) like '%KAIN%' 
UNION ALL
select id_tipe_baju id_tipe_kain,keterangan from p_baju_tipe where upper(keterangan) like '%CELANA%' 
UNION ALL
select id_tipe_baju id_tipe_kain,keterangan from p_baju_tipe where upper(keterangan) like '%ROK%' 
UNION ALL
select id_tipe_baju id_tipe_kain,keterangan from p_baju_tipe where upper(keterangan) like '%DODOT%'
UNION ALL
select id_tipe_baju id_tipe_kain,keterangan from p_baju_tipe where upper(keterangan) like '%SONGKET%'";
				$rs=mysql_query($sql);
				for($a=0;$a<mysql_num_rows($rs);$a++){
				echo "<option ";
				$idp=mysql_result($rs,$a,"id_tipe_kain");
				if ($idp==$id_tipe_kain)echo " selected ";
				echo " value=\"$idp\">";
				echo mysql_result($rs,$a,"keterangan");
				echo "</option>";
				} 
			?>
			</select></td>
			<td width="25%" align="left"><select name="id_kain" value="<?=$id_kain;?>">
			<?
				if(!isset($id_tipe_kain))$id_tipe_kain=1;
				$sql="select id_layanan,layanan from p_baju where id_tipe_baju='$id_tipe_kain' order by layanan asc";
				$rs=mysql_query($sql);
				for($a=0;$a<mysql_num_rows($rs);$a++){
				echo "<option ";
				$idl=mysql_result($rs,$a,"id_layanan");
				if ($idl==$id_kain)echo " selected ";
				echo " value=\"$idl\">";
				echo mysql_result($rs,$a,"layanan");
				echo "</option>";
				} 
			?>
			</select></td>
            <td width="25%" align="center"><input type="text" name="jml_kain" value="<?=$jml_kain;?>" size="5"> 
            <font color="#FF0000"><b>*</b></font></td>
        </tr>

		<tr><td width="25%" align="left">Update Asesoris</td>
            <td width="25%" align="left">
            <select name="id_tipe_acc" onchange="javascript:this.form.submit();">
			<?
				$sql="select id_tipe_acc,keterangan from p_acc_tipe 
				where upper(keterangan) not like '%KAIN%' order by keterangan asc";
				$rs=mysql_query($sql);
				for($a=0;$a<mysql_num_rows($rs);$a++){
				echo "<option ";
				$idp=mysql_result($rs,$a,"id_tipe_acc");
				if ($idp==$id_tipe_acc)echo " selected ";
				echo " value=\"$idp\">";
				echo mysql_result($rs,$a,"keterangan");
				echo "</option>";
				} 
			?>
			</select></td>
			<td width="25%" align="left"><select name="id_acc" value="<?=$id_acc?>">
			<?
				if(!isset($id_tipe_acc))$id_tipe_acc=1;
				$sql="select id_layanan,layanan from p_acc where id_tipe_acc='$id_tipe_acc' order by layanan asc";
				$rs=mysql_query($sql);
				for($a=0;$a<mysql_num_rows($rs);$a++){
				echo "<option ";
				$idl=mysql_result($rs,$a,"id_layanan");
				if ($idl==$id_acc)echo " selected ";
				echo " value=\"$idl\">";
				echo mysql_result($rs,$a,"layanan");
				echo "</option>";
				} 
			?>
			</select></td>
            <td width="25%" align="center"><input type="text" name="jml_acc" value="<?=$jml_acc;?>" size="5"> 
            <font color="#FF0000"><b>*</b></font></td>
        </tr>
        
		<tr><td width="25%" align="left">Update Blangkon</td>
            <td width="25%" align="left">
            <select name="id_tipe_blangkon" onchange="javascript:this.form.submit();">
			<?
				$sql="select id_tipe_baju,keterangan from p_baju_tipe 
where upper(keterangan) like '%BLANGKON%'
UNION ALL
select id_tipe_baju,keterangan from p_baju_tipe 
where upper(keterangan) like '%KOPIAH%' 
";
				$rs=mysql_query($sql);
				for($a=0;$a<mysql_num_rows($rs);$a++){
				echo "<option ";
				$idp=mysql_result($rs,$a,"id_tipe_baju");
				if ($idp==$id_tipe_blangkon)echo " selected ";
				echo " value=\"$idp\">";
				echo mysql_result($rs,$a,"keterangan");
				echo "</option>";
				} 
			?>
			</select></td>
			<td width="25%" align="left"><select name="id_blangkon" value="<?=$id_blangkon;?>">
			<?
				if(!isset($id_tipe_blangkon))$id_tipe_blangkon=1;
				$sql="select id_layanan,layanan from p_baju where id_tipe_baju='$id_tipe_blangkon' order by layanan asc";
				$rs=mysql_query($sql);
				for($a=0;$a<mysql_num_rows($rs);$a++){
				echo "<option ";
				$idl=mysql_result($rs,$a,"id_layanan");
				if ($idl==$id_blangkon)echo " selected ";
				echo " value=\"$idl\">";
				echo mysql_result($rs,$a,"layanan");
				echo "</option>";
				} 
			?>
			</select></td>
            <td width="25%" align="center"><input type="text" name="jml_blangkon" value="<?=$jml_blangkon;?>" size="5"> 
            <font color="#FF0000"><b>*</b></font></td>
        </tr>
        

		<tr><td width="25%" align="left">Update Selop</td>
            <td width="25%" align="left">
            <select name="id_tipe_sepatu" onchange="javascript:this.form.submit();">
			<?
				$sql="select id_tipe_sepatu,keterangan from p_sepatu_tipe order by keterangan asc";
				$rs=mysql_query($sql);
				for($a=0;$a<mysql_num_rows($rs);$a++){
				echo "<option ";
				$idp=mysql_result($rs,$a,"id_tipe_sepatu");
				if ($idp==$id_tipe_sepatu)echo " selected ";
				echo " value=\"$idp\">";
				echo mysql_result($rs,$a,"keterangan");
				echo "</option>";				} 
			?>
			</select></td>
			<td width="25%" align="left"><select name="id_sepatu" value="<?=$id_sepatu;?>">
			<?
				if(!isset($id_tipe_sepatu))$id_tipe_sepatu=1;
				$sql="select id_layanan, layanan from p_sepatu where id_tipe_sepatu='$id_tipe_sepatu' order by layanan asc";
				$rs=mysql_query($sql);
				for($a=0;$a<mysql_num_rows($rs);$a++){
				echo "<option ";
				$idl=mysql_result($rs,$a,"id_layanan");
				if ($idl==$id_sepatu)echo " selected ";
				echo " value=\"$idl\">";
				echo mysql_result($rs,$a,"layanan");
				echo "</option>";
				} 
			?>
			</select></td>
            <td width="25%" align="center"><input type="text" name="jml_sepatu" value="<?=$jml_sepatu;?>" size="5"> 
            <font color="#FF0000"><b>*</b></font></td>
        </tr>
		</table>

		<table border="0" cellspacing="0" cellpadding="5" align=Center width="1000">    
		<tr>
			<td width="25%">
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
else 
{
//registerInvalid
?>

<table border="0" cellspacing="0" cellpadding="0" align="left" width="100%">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Update Data Accecoris</b><br></font>
	 <font color="#FF0000"><b>-- Data telah berhasil disimpan --</b><br><br></font>

	 <p>&nbsp;</p>
	 <a href="javascript:window.close();"><b>Tutup</b></a>
   </td>
  </tr>
</table>
<? } ?>