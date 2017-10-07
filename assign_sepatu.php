<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 09 oktober 2010, lastupdate 09 oktober 2010



include_once("include.php");

$n=mysql_query("select id_tipe_acc,id_acc,jml_acc,jml_kain,id_client,id_acara,id_paket,id_paket from client_busana where id_client='$id_client' and id_acara='$id_acara' and id_paket='$id_paket' and id_plus='$id_plus'");
$jml=mysql_num_rows($n);
echo $jml;

//============================================================================================================================================================
if ($run != "")
{
	if ($jml == 0){
			$registerInvalid = 1;
			$sql_u="select ukuran from p_sepatu where id_layanan='$id_sepatu'";
			$rsu=mysql_query($sql_u);
			for($a=0;$a<mysql_num_rows($rsu);$a++)
			{
			$ukuran=mysql_result($rsu,$a,"ukuran");
			}; 
			$runSQL = "insert into client_busana (id_client,id_acara,id_paket,id_plus,id_tipe_sepatu,id_sepatu,jml_sepatu,ukuran)
			values('$id_client','$id_acara','$id_paket','$id_plus','$id_tipe_sepatu','$id_sepatu','$jml_sepatu','$ukuran')";
			//echo $runSQL;
			$insert = mysql_query($runSQL, $connDB);
			$id = mysql_insert_id($connDB);
		} 
	else if ($jml != 0){
			$registerInvalid = 1;
			$sql_u="select ukuran from p_sepatu where id_layanan='$id_sepatu'";
			$rsu=mysql_query($sql_u);
			for($a=0;$a<mysql_num_rows($rsu);$a++)
			{
			$ukuran=mysql_result($rsu,$a,"ukuran");
			}; 
			$runSQL = "update client_busana set id_sepatu='$id_sepatu',id_tipe_sepatu='$id_tipe_sepatu',jml_sepatu='$jml_sepatu',ukuran='$ukuran' where id_client='$id_client' and id_acara='$id_acara' and id_paket='$id_paket' and id_plus='$id_plus' ";
			//echo $runSQL;
			$update = mysql_query($runSQL, $connDB);
		};//if
};
//============================================================================================================================================================

if ($run == ""){ 
	if ($jml != 0)
	{
		if($id_tipe_sepatu!="")
		{
			$id_tipe_sepatu=$id_tipe_sepatu;
		}
		else
		{
			$id_tipe_sepatu=mysql_result($n,0,"id_tipe_sepatu");
			$id_sepatu=mysql_result($n,0,"id_sepatu");
			$jml_sepatu=mysql_result($n,0,"jml_sepatu");
		}
	}

?>
<form method="POST" name="form" action="<?="?id_client=$id_client&id_acara=$id_acara&id_paket=$id_paket&id_plus=$id_plus";?>">
  <table border="0" cellspacing="0" cellpadding="0" align=left width="100%">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Update sepatu</b></font>
	 <table border="0" cellpadding="5" cellspacing="0" width="650">
        <tr>
            <td width="35%" align="right">Kategori</td>
            <td width="65%"><select name="id_tipe_sepatu" onchange="javascript:this.form.submit();">
<?
$sql="select id_tipe_sepatu,keterangan from p_sepatu_tipe order by keterangan asc";
$rs=mysql_query($sql);
for($a=0;$a<mysql_num_rows($rs);$a++){
echo "<option ";
$idp=mysql_result($rs,$a,"id_tipe_sepatu");
if ($idp==$id_tipe_sepatu)echo " selected ";
echo " value=\"$idp\">";
echo mysql_result($rs,$a,"keterangan");
echo "</option>";
} ?>
</select></td>
        </tr>
	<tr>
			<td width="35%" align="right">Jenis sepatu</td>
			<td width="65%"><select name="id_sepatu">
<?
if(!isset($id_tipe_sepatu))$id_tipe_sepatu=1;
$sql="select id_layanan,concat(layanan,'-',ukuran) layanan from p_sepatu where id_tipe_sepatu='$id_tipe_sepatu'";
$rs=mysql_query($sql);
for($a=0;$a<mysql_num_rows($rs);$a++){
echo "<option ";
$idl=mysql_result($rs,$a,"id_layanan");
if ($idl==$id_sepatu)echo " selected ";
echo " value=\"$idl\">";
echo mysql_result($rs,$a,"layanan");
echo "</option>";
} ?>
</select></td>
</tr>
	<tr>
			<td width="35%" align="right">Jml sepatu</td>
            <td width="65%"><input type="text" name="jml_sepatu" value="<?=$jml_sepatu;?>" size="10"> <font color="#FF0000"><b>*</b></font></td>
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
	 <font class="titledata"><b>Update Data sepatu</b><br></font>
	 <font color="#FF0000"><b>-- Data telah berhasil disimpan --</b><br><br></font>

	 <p>&nbsp;</p>
	 <a href="javascript:window.close();"><b>Tutup</b></a>
   </td>
  </tr>
</table>
<? } ?>