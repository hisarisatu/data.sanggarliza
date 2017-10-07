<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 09 oktober 2010, lastupdate 09 oktober 2010

include_once("include.php");

if ((strlen($run) < 1) and ($id <> "")){ 
	$runSQL = "select id_sublayanan, id_layanan, harga_dasar, detail_layanan, jml_orang from p_sublayanan where id_sublayanan='$id'";
        //echo $runSQL;
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id_sublayanan = $row[id_sublayanan];
		$id_layanan = $row[id_layanan];
		$harga_paket = $row[harga_dasar];
		$detail_layanan = $row[detail_layanan];
                $jml_orang=$row[jml_orang];
	};//if
};//if-id

if (strlen($run) > 1){ 

	$detail_layanan = ucwords($detail_layanan);
	
	$ok = 1;
	if ($harga_paket < 1000){ $iharga_paket = "<br><font color='#FF0000' size='1'><i>* Harga Paket tidak valid"; $ok=0; }
	//if (strlen($uraian_paket) < 20){ $iuraian_paket = "<br><font color='#FF0000' size='1'><i>* Uraian Paket tidak lengkap"; $ok=0; }

	if (($ok == 1) and ($id == "")){
		$registerInvalid = 1;
		$runSQL = "insert into p_sublayanan(id_layanan,detail_layanan,harga_dasar,jml_orang) VALUES ('$id_layanan','$detail_layanan', '$harga_paket','$jml_orang')";
		//echo $runSQL;
		$insert = mysql_query($runSQL, $connDB);
		$id = mysql_insert_id($connDB);
	} else if (($ok == 1) and ($id <> "")){
		$registerInvalid = 1;
		$runSQL = "update p_sublayanan set id_layanan='$id_layanan',harga_dasar='$harga_paket', detail_layanan='$detail_layanan',jml_orang='$jml_orang' where id_sublayanan='$id'";
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
	 <font class="titledata"><b>Input/Edit Data Layanan</b></font>

	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
     <td valign="bottom">
		 </td>
     <td valign="bottom" align="right">
			 <img src="images/arrow2.gif" border="0">
			 <a href="<?="?menu=$menu&uid=$uid&page=sub_paket";?>"><b>Back Data Layanan</b></a>
		   <?if ($id <> ""){?> | <a href="<?="?menu=$menu&uid=$uid&page=paketview&id=$id";?>"><b>Goto Rincian</b></a><?}?>
		 </td>
	  </tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	 </table>

	 <script language="JavaScript" src="calendar_us.js"></script>
	 <table border="0" cellpadding="5" cellspacing="0" width="650">
		<tr>
			<td width="35%" align="right">Group Layanan</td>
			<td width="65%"><select name="id_layanan">
<?
$sql="select id_layanan,layanan from p_layanan";
$rs=mysql_query($sql);
for($a=0;$a<mysql_num_rows($rs);$a++){
echo "<option ";
$idl=mysql_result($rs,$a,"id_layanan");
if ($idl==$id_layanan)echo " selected ";
echo " value=\"$idl\">";
echo mysql_result($rs,$a,"layanan");
echo "</option>";
} ?>
</select> <font color="#FF0000"><b>*</b></font> <?=$iid_layanan;?></td>
		</tr>
		<tr>
            <td width="35%" align="right">Detail Layanan</td>
            <td width="65%"><textarea name="detail_layanan" cols="50" rows="3"><?=htmlentities(stripslashes($detail_layanan));?></textarea> <font color="#FF0000"><b>*</b></font> <?=$idetail_layanan;?></td>
        </tr>
        <tr>
            <td width="35%" align="right">Jumlah Orang</td>
            <td width="65%"><input type="text" name="jml_orang" size="15" value="<?=htmlentities(stripslashes($jml_orang));?>"><font color="#FF0000"><b>*</b></font> <?=$ijml_orang;?></td>
        </tr><tr>
			<td width="35%" align="right">Harga Dasar</td>
			<td width="65%"><input type="text" name="harga_paket" size="15" value="<?=htmlentities(stripslashes($harga_paket));?>"><font color="#FF0000"><b>*</b></font> <?=$iharga_paket;?></td>
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

	$runSQL = "select id_sublayanan, id_layanan, harga_dasar, detail_layanan, jml_orang from p_sublayanan where id_sublayanan='$id'";
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id_sublayanan = $row[id_sublayanan];
		$id_layanan = $row[id_layanan];
		$harga_dasar = $row[harga_dasar];
		$uraian_paket = nl2br($row[uraian_paket]);
		$detail_layanan = $row[detail_layanan];
                $jml_orang=$row[jml_orang];
	};
?>

<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Input/Edit Data Layanan</b><br></font>
	 <font color="#FF0000"><b>-- Data telah berhasil disimpan --</b><br><br></font>

	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr><td colspan="2" align="right"><!--<a href='<?="?menu=$menu&uid=$uid&page=client_input&id=$id";?>'><img border='0' src='images/edit.gif' title='Edit Data'></a>--> &nbsp; &nbsp; </td></tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	  <tr>
     <td width="100%" valign="top" align="center">
	 <table border="0" cellpadding="5" cellspacing="0" width="650">
		<tr>
			<td width="35%" align="right">Group Layanan : </td>
			<td width="65%"><font class="datafield">
<?
$sl="select layanan from p_layanan where id_layanan='$id_layanan'";
$rl=mysql_query($sl);
echo mysql_result($rl,0,"layanan");
?></font></td>
		</tr>
        <tr valign=top>
            <td width="35%" align="right">Uraian Paket : </td>
            <td width="65%"><font class="datafield"><?=$detail_layanan?></font></td>
        </tr>
		<tr>
			<td width="35%" align="right">Jumlah Orang: </td>
			<td width="65%"><font class="datafield"><?=$jml_orang;?></font></td>
		</tr><tr>
            <td width="35%" align="right">Harga Dasar: </td>
            <td width="65%"><font class="datafield"><?=$harga_dasar;?></font></td>
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
	 <a href="<?="?menu=$menu&uid=$uid&page=sub_paket";?>"><b>Back Data Layanan</b></a>
   </td>
  </tr>
  </form>
</table>
<? };//registerInvalid ?>