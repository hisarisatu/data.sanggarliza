<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 09 oktober 2010, lastupdate 09 oktober 2010

include_once("include.php");

if ((strlen($run) < 1) and ($id <> "")){ 
	$runSQL = "select id_produk,id_pekerjaan,pekerjaan,uraian_pekerjaan from p_pekerjaan where id_pekerjaan='$id'";
//        echo $runSQL;
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id_pekerjaan = $row[id_pekerjaan];
		$pekerjaan = $row[pekerjaan];
		$uraian = $row[uraian_pekerjaan];
	};//if
};//if-id

if (strlen($run) > 1){ 

	$pekerjaan = ucwords($pekerjaan);
	
	$ok = 1;

	if (($ok == 1) and ($id == "")){
		$registerInvalid = 1;
		$runSQL = "insert into p_pekerjaan(id_produk,pekerjaan,uraian_pekerjaan) VALUES ('$id_produk','$pekerjaan','$uraian')";
		//echo $runSQL;
		$insert = mysql_query($runSQL, $connDB);
		$id = mysql_insert_id($connDB);
	} else if (($ok == 1) and ($id <> "")){
		$registerInvalid = 1;
		$runSQL = "update p_pekerjaan set id_produk='$id_produk',pekerjaan='$pekerjaan',uraian_pekerjaan='$uraian' where id_pekerjaan='$id'";
		//echo $runSQL;
		$update = mysql_query($runSQL, $connDB);
	};//if
};//end-if-submit

if ($registerInvalid <> 1){
?>

<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Input/Edit Pekerjaan</b></font>

	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
     <td valign="bottom">
		 </td>
     <td valign="bottom" align="right">
			 <img src="images/arrow2.gif" border="0">
			 <a href="<?="?menu=$menu&uid=$uid&page=p_pekerjaan";?>"><b>List Pekerjaan</b></a>
		 </td>
	  </tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	 </table>
	 <table border="0" cellpadding="5" cellspacing="0" width="650">
        <tr>
            <td width="35%" align="right">Kategori</td>
            <td width="65%"><select name="id_produk">
<?
$sql="select id_produk,produk from p_produk";
$rs=mysql_query($sql);
for($a=0;$a<mysql_num_rows($rs);$a++){
echo "<option ";
$idp=mysql_result($rs,$a,"id_produk");
if ($idp==$id_produk)echo " selected ";
echo " value=\"$idp\">";
echo mysql_result($rs,$a,"produk");
echo "</option>";
} ?>
</select> <font color="#FF0000"><b>*</b></font> <?=$iid_produk;?></td>
        </tr>
	<tr>
			<td width="35%" align="right">Pekerjaan</td>
            <td width="65%"><textarea name="pekerjaan" cols="50" rows="3"><?=htmlentities(stripslashes($pekerjaan));?></textarea> <font color="#FF0000"><b>*</b></font> <?=$ipekerjaan;?></td>
        </tr>
	<tr>
			<td width="35%" align="right">Uraian Pekerjaan</td>
            <td width="65%"><textarea name="uraian" cols="50" rows="3"><?=htmlentities(stripslashes($uraian));?></textarea> <font color="#FF0000"><b>*</b></font> <?=$iuraian;?></td>
        </tr>
		
<tr>
			<td width="35%" align="right">&nbsp;</td>
			<td width="65%">
			<input type="hidden" name="id" value="<?=$id;?>"><br>
			<input type="submit" value="Simpan" name="run" class="button">
      </td>
		</tr>
		<tr>
			<td width="100%" colspan="2" align="left">
			Keterangan : <br>
      - Pastikan anda telah memasukan data isian dengan lengkap dan benar!<br>
			- Tanda <font color="#FF0000"><b>*</b></font> wajib diisi tidak boleh kosong.
		  </td>
		</tr>
	 </table>

   </td>
  </tr>
  </form>
</table>
<?

} else {
//registerInvalid

	$runSQL = "select id_produk,id_pekerjaan, id_pekerjaan,pekerjaan,uraian_pekerjaan from p_pekerjaan where id_pekerjaan='$id'";
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id_pekerjaan = $row[id_pekerjaan];
		$id_produk = $row[id_produk];
		$pekerjaan = $row[pekerjaan];
		$uraian = $row[uraian_pekerjaan];
	};
?>

<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Input/Edit Baju</b><br></font>
	 <font color="#FF0000"><b>-- Data telah berhasil disimpan --</b><br><br></font>

	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr><td colspan="2" align="right"><!--<a href='<?="?menu=$menu&uid=$uid&page=client_input&id=$id";?>'><img border='0' src='images/edit.gif' title='Edit Data'></a>--> &nbsp; &nbsp; </td></tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	  <tr>
     <td width="100%" valign="top" align="center">
	 <table border="0" cellpadding="5" cellspacing="0" width="650">
		<tr>
			<td width="35%" align="right">Kategori : </td>
			<td width="65%"><font class="datafield">
<?
$sl="select produk from p_produk where id_produk='$id_produk'";
$rl=mysql_query($sl);
echo mysql_result($rl,0,"produk");
?></font></td>
		</tr>
        <tr valign=top>
            <td width="35%" align="right">Pekerjaan : </td>
            <td width="65%"><font class="datafield"><?=$pekerjaan?></font></td>
        </tr>
        <tr valign=top>
            <td width="35%" align="right">Uraian Pekerjaan : </td>
            <td width="65%"><font class="datafield"><?=$uraian?></font></td>
        </tr>
		
	 </table>

		 <div align="right">
		 <hr size="1" color="#252525" style="border-top:1px dashed #252525;" width="220" align="right">
		 <font size='1'><?=$inforecord;?></font>
		 </div>

		 </td>
	  </tr>
	 </table>

	 <p>&nbsp;</p>
	 <img src="images/arrow2.gif" border="0">
	 <a href="<?="?menu=$menu&uid=$uid&page=p_pekerjaan";?>"><b>List Pekerjaan</b></a>
   </td>
  </tr>
  </form>
</table>
<? };//registerInvalid ?>