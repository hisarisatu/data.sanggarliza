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
			$runSQL = "insert into client_busana (id_client,id_acara,id_paket,id_plus,id_tipe_acc,id_acc,jml_acc,jml_kain)
			values('$id_client','$id_acara','$id_paket','$id_plus','$id_tipe_acc','$id_acc','$jml_acc','$jml_acc')";
			//echo $runSQL;
			$insert = mysql_query($runSQL, $connDB);
			$id = mysql_insert_id($connDB);
		} 
	else if ($jml != 0){
			$registerInvalid = 1;
			$runSQL = "update client_busana set id_acc='$id_acc',id_tipe_acc='$id_tipe_acc',jml_acc='$jml_acc' where id_client='$id_client' and id_acara='$id_acara' and id_paket='$id_paket' and id_plus='$id_plus' ";
			//echo $runSQL;
			$update = mysql_query($runSQL, $connDB);
		};//if
};
//============================================================================================================================================================

if ($run == ""){ 
	if ($jml != 0)
	{
		if($id_tipe_acc!="")
		{
			$id_tipe_acc=$id_tipe_acc;
		}
		else
		{
			$id_tipe_acc=mysql_result($n,0,"id_tipe_acc");
			$id_acc=mysql_result($n,0,"id_acc");
			$jml_acc=mysql_result($n,0,"jml_acc");
			$jml_kain=mysql_result($n,0,"jml_kain");
		}
	}

?>
<form method="POST" name="form" action="<?="?id_client=$id_client&id_acara=$id_acara&id_paket=$id_paket&id_plus=$id_plus";?>">
  <table border="0" cellspacing="0" cellpadding="0" align=left width="100%">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Update Accecoris</b></font>
	 <table border="0" cellpadding="5" cellspacing="0" width="650">
        <tr>
            <td width="35%" align="right">Kategori</td>
            <td width="65%"><select name="id_tipe_acc" onchange="javascript:this.form.submit();">
<?
$sql="select id_tipe_acc,keterangan from p_acc_tipe where upper(keterangan) not like '%KAIN%' order by keterangan asc";
$rs=mysql_query($sql);
for($a=0;$a<mysql_num_rows($rs);$a++){
echo "<option ";
$idp=mysql_result($rs,$a,"id_tipe_acc");
if ($idp==$id_tipe_acc)echo " selected ";
echo " value=\"$idp\">";
echo mysql_result($rs,$a,"keterangan");
echo "</option>";
} ?>
</select></td>
        </tr>
	<tr>
			<td width="35%" align="right">Jenis Accecoris</td>
			<td width="65%"><select name="id_acc">
<?
if(!isset($id_tipe_acc))$id_tipe_acc=1;
$sql="select id_layanan,layanan from p_acc where id_tipe_acc='$id_tipe_acc'";
$rs=mysql_query($sql);
for($a=0;$a<mysql_num_rows($rs);$a++){
echo "<option ";
$idl=mysql_result($rs,$a,"id_layanan");
if ($idl==$id_acc)echo " selected ";
echo " value=\"$idl\">";
echo mysql_result($rs,$a,"layanan");
echo "</option>";
} ?>
</select></td>
</tr>
	<tr>
			<td width="35%" align="right">Jml Accecoris</td>
            <td width="65%"><input type="text" name="jml_acc" value="<?=$jml_acc;?>" size="10"> <font color="#FF0000"><b>*</b></font></td>
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
	 <font class="titledata"><b>Update Data Accecoris</b><br></font>
	 <font color="#FF0000"><b>-- Data telah berhasil disimpan --</b><br><br></font>

	 <p>&nbsp;</p>
	 <a href="javascript:window.close();"><b>Tutup</b></a>
   </td>
  </tr>
</table>
<? } ?>