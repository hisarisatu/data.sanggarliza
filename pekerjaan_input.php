<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 09 oktober 2010, lastupdate 09 oktober 2010

include_once("include.php");

if ((strlen($run) < 1) and ($id <> "")){ 
	$runSQL = "select * from p_pekerjaan where id_pekerjaan='$id'";
        //echo $runSQL;
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id_pekerjaan = $row[id_pekerjaan];
		$code_job = $row[code_job];
		$tarif_dasar = $row[tarif_dasar];
		$uraian_tugas = $row[uraian_tugas];
	};//if
};//if-id

if (strlen($run) > 1){ 

	$uraian_tugas = ucwords($uraian_tugas);
	
	$ok = 1;

	if (($ok == 1) and ($id == "")){
		$registerInvalid = 1;
		$runSQL = "insert into p_pekerjaan VALUES (null,'$code_job','$uraian_tugas', '$tarif_dasar')";
		//echo $runSQL;
		$insert = mysql_query($runSQL, $connDB);
		$id = mysql_insert_id($connDB);
	} else if (($ok == 1) and ($id <> "")){
		$registerInvalid = 1;
		$runSQL = "update p_pekerjaan set tarif_dasar='$tarif_dasar', uraian_tugas='$uraian_tugas',code_job='$code_job' where id_pekerjaan='$id'";
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
	 <font class="titledata"><b>Input/Edit Data Pekerjaan</b></font>

	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
     <td valign="bottom">
		 </td>
     <td valign="bottom" align="right">
			 <img src="images/arrow2.gif" border="0">
			 <a href="<?="?menu=$menu&uid=$uid&page=pekerjaan";?>"><b>Back Data Pekerjaan</b></a>
		 </td>
	  </tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	 </table>

	 <script language="JavaScript" src="calendar_us.js"></script>
	 <table border="0" cellpadding="5" cellspacing="0" width="650">
        <tr>
            <td width="35%" align="right">Code JOB</td>
            <td width="65%"><input type="text" name="code_job" size="15" value="<?=htmlentities(stripslashes($code_job));?>"><font color="#FF0000"><b>*</b></font> <?=$icode_job;?></td>
        </tr>
	<tr>
            <td width="35%" align="right">Detail Tugas</td>
            <td width="65%"><textarea name="uraian_tugas" cols="50" rows="3"><?=htmlentities(stripslashes($uraian_tugas));?></textarea> <font color="#FF0000"><b>*</b></font> <?=$iuraian_tugas;?></td>
        </tr>
        <tr>
			<td width="35%" align="right">Tarif Dasar</td>
			<td width="65%"><input type="text" name="tarif_dasar" size="15" value="<?=htmlentities(stripslashes($tarif_dasar));?>"><font color="#FF0000"><b>*</b></font> <?=$itarif_dasar;?></td>
		</tr><tr>
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

	$runSQL = "select * from p_pekerjaan where id_pekerjaan='$id'";
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id_pekerjaan = $row[id_pekerjaan];
		$tarif_dasar = $row[tarif_dasar];
		$uraian_tugas = nl2br($row[uraian_tugas]);
		$code_job = $row[code_job];
 	};
?>

<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Input/Edit Data Pekerjaan</b><br></font>
	 <font color="#FF0000"><b>-- Data telah berhasil disimpan --</b><br><br></font>

	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr><td colspan="2" align="right"><!--<a href='<?="?menu=$menu&uid=$uid&page=pekerjaan_input&id=$id";?>'><img border='0' src='images/edit.gif' title='Edit Data'></a>--> &nbsp; &nbsp; </td></tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	  <tr>
     <td width="100%" valign="top" align="center">
	 <table border="0" cellpadding="5" cellspacing="0" width="650">
		<tr>
			<td width="35%" align="right">CODE JOB : </td>
			<td width="65%"><font class="datafield"><?=$code_job?></font></td>
		</tr>
        <tr valign=top>
            <td width="35%" align="right">Uraian Paket : </td>
            <td width="65%"><font class="datafield"><?=$uraian_tugas?></font></td>
        </tr>
<tr>
            <td width="35%" align="right">Harga Dasar: </td>
            <td width="65%"><font class="datafield"><?=$tarif_dasar;?></font></td>
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
	 <a href="<?="?menu=$menu&uid=$uid&page=pekerjaan";?>"><b>Back Data Pekerjaan</b></a>
   </td>
  </tr>
  </form>
</table>
<? };//registerInvalid ?>