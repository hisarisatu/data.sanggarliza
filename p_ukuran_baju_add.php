<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 09 oktober 2010, lastupdate 09 oktober 2010

include_once("include.php");

if ((strlen($run) < 1) and ($id <> "")){ 
	$runSQL = "select id_ukuran_baju, nama_ukuran_baju from p_jenis_ukuran_baju where id_ukuran_baju='$id'";
        //echo $runSQL;
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id_ukuran_baju = $row[id_ukuran_baju];
		$nama_ukuran_baju = $row[nama_ukuran_baju];
	};//if
};//if-id

if (strlen($run) > 1){ 

	$nama_ukuran_baju = ucwords($nama_ukuran_baju);
	
	$ok = 1;

	if (($ok == 1) and ($id == "")){
		$registerInvalid = 1;
		$runSQL = "insert into p_jenis_ukuran_baju VALUES (null,'$nama_ukuran_baju')";
		//echo $runSQL;
		$insert = mysql_query($runSQL, $connDB);
		$id = mysql_insert_id($connDB);
	} else if (($ok == 1) and ($id <> "")){
		$registerInvalid = 1;
		$runSQL = "update p_jenis_ukuran_baju set nama_ukuran_baju='$nama_ukuran_baju' where id_ukuran_baju='$id'";
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
	 <font class="titledata"><b>Input/Edit Satuan</b></font>

	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
     <td valign="bottom">
		 </td>
     <td valign="bottom" align="right">
			 <img src="images/arrow2.gif" border="0">
			 <a href="<?="?menu=$menu&uid=$uid&page=p_ukuran_baju";?>"><b>List Ukuran Baju</b></a>
		 </td>
	  </tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	 </table>
	 <table border="0" cellpadding="5" cellspacing="0" width="650">
	<tr>
			<td width="35%" align="right">Detail Ukuran Baju</td>
            <td width="65%"><textarea name="nama_ukuran_baju" cols="50" rows="2"><?=htmlentities(stripslashes($nama_ukuran_baju));?></textarea> <font color="#FF0000"><b>*</b></font> <?=$inama_ukuran_baju;?></td>
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

	$runSQL = "select id_ukuran,nama_ukuran_baju from p_jeni_ukuran_baju where id_ukuran_baju='$id'";
	$result = mysql_query($runSQL, $connDB);
	if ($row = @mysql_fetch_array ($result)) {
		$id_ukuran_baju = $row[id_ukuran_baju];
		$nama_ukuran_baju = $row[nama_ukuran_baju];
	};
?>

<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Input/Edit Warna</b><br></font>
	 <font color="#FF0000"><b>-- Data telah berhasil disimpan --</b><br><br></font>

	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr><td colspan="2" align="right"><!--<a href='<?="?menu=$menu&uid=$uid&page=client_input&id=$id";?>'><img border='0' src='images/edit.gif' title='Edit Data'></a>--> &nbsp; &nbsp; </td></tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	  <tr>
     <td width="100%" valign="top" align="center">
	 <table border="0" cellpadding="5" cellspacing="0" width="650">
        <tr valign=top>
            <td width="35%" align="right">Ukuran Baju : </td>
            <td width="65%"><font class="datafield"><?=$nama_ukuran_baju?></font></td>
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
	 <a href="<?="?menu=$menu&uid=$uid&page=p_ukuran_baju_add";?>"><b>Input Ukuran Baju Lagi</b></a>
     <img src="images/arrow2.gif" border="0">
     <a href="<?="?menu=$menu&uid=$uid&page=p_ukuran_baju";?>"><b>List Ukuran Baju</b></a>
   </td>
  </tr>
  </form>
</table>
<? };//registerInvalid ?>