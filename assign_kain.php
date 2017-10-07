<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 09 oktober 2010, lastupdate 09 oktober 2010



include_once("include.php");

$n=mysql_query("select id_tipe_kain,id_kain,jml_kain,jml_baju,id_client,id_acara,id_paket,id_paket from client_busana 
where id_client='$id_client' and id_acara='$id_acara' and id_paket='$id_paket' and id_plus='$id_plus'");
$jml=mysql_num_rows($n);

//============================================================================================================================================================
if ($run != "")
{ 
	if ($jml == 0){
			$registerInvalid = 1;
			$runSQL = "insert into client_busana (id_client,id_acara,id_paket,id_plus,id_tipe_kain,id_kain,jml_kain,jml_baju)
			values('$id_client','$id_acara','$id_paket','$id_plus','$id_tipe_baju','$id_baju','$jml_kain','$jml_kain')";
			//echo $runSQL;
			$insert = mysql_query($runSQL, $connDB);
			$id = mysql_insert_id($connDB);
		} 
	else if ($jml != 0){
			$registerInvalid = 1;
			$runSQL = "update client_busana set id_kain='$id_baju',id_tipe_kain='$id_tipe_baju',jml_kain='$jml_kain' 
			where id_client='$id_client' and id_acara='$id_acara' and id_paket='$id_paket' and id_plus='$id_plus' ";
			//echo $runSQL;
			$update = mysql_query($runSQL, $connDB);
		};//if
};
//============================================================================================================================================================

if ($run == ""){ 
	if ($jml != 0)
	{
		if($id_tipe_kain!="")
		{
			$id_tipe_kain=$id_tipe_kain;
		}
		else
		{
			$id_tipe_kain=mysql_result($n,0,"id_tipe_kain");
			$id_kain=mysql_result($n,0,"id_kain");
			$jml_kain=mysql_result($n,0,"jml_kain");
			$jml_baju=mysql_result($n,0,"jml_baju");
		}
	}

?>
<form method="POST" name="form" action="<?="?id_client=$id_client&id_acara=$id_acara&id_paket=$id_paket&id_plus=$id_plus";?>">
  <table border="0" cellspacing="0" cellpadding="0" align=left width="100%">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Update Kain</b></font>
	 <table border="0" cellpadding="5" cellspacing="0" width="650">
        <tr>
            <td width="35%" align="right">Kategori</td>
            <td width="65%"><select name="id_tipe_baju" onchange="javascript:this.form.submit();">
<?
$sql="select id_tipe_baju,keterangan from p_baju_tipe where upper(keterangan) like '%KAIN%' order by keterangan asc";
$rs=mysql_query($sql);
for($a=0;$a<mysql_num_rows($rs);$a++){
echo "<option ";
$idp=mysql_result($rs,$a,"id_tipe_baju");
if ($idp==$id_tipe_baju)echo " selected ";
echo " value=\"$idp\">";
echo mysql_result($rs,$a,"keterangan");
echo "</option>";
} ?>
</select></td>
        </tr>
	<tr>
			<td width="35%" align="right">Jenis Baju</td>
			<td width="65%"><select name="id_baju">
<?
if(!isset($id_tipe_baju))$id_tipe_baju=18;
$sql="select id_layanan,layanan from p_baju where id_tipe_baju='$id_tipe_baju'";
$rs=mysql_query($sql);
for($a=0;$a<mysql_num_rows($rs);$a++){
echo "<option ";
$idl=mysql_result($rs,$a,"id_layanan");
if ($idl==$id_baju)echo " selected ";
echo " value=\"$idl\">";
echo mysql_result($rs,$a,"layanan");
echo "</option>";
} ?>
</select></td>
</tr>
	<tr>
			<td width="35%" align="right">Jml Kain</td>
            <td width="65%"><input type="text" name="jml_kain" value="<?=$jml_kain;?>" size="10"> <font color="#FF0000"><b>*</b></font></td>
        </tr>

<tr>
			<td width="35%" align="right">&nbsp;</td>
			<td width="65%">
			<input type="hidden" name="id" value="<?=$id;?>"><br>
			<input type="submit" value="Simpan" name="run" class="button">
      </td>
		</tr> </table>

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
	 <font class="titledata"><b>Update Data Busana</b><br></font>
	 <font color="#FF0000"><b>-- Data telah berhasil disimpan --</b><br><br></font>

	 <p>&nbsp;</p>
	 <a href="javascript:window.close();"><b>Tutup</b></a>
   </td>
  </tr>
</table>
<? } ?>