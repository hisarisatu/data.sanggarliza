<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 09 oktober 2010, lastupdate 09 oktober 2010

include_once("include.php");

if ((strlen($run) < 1) and ($id <> "")){ 
	$runSQL = "select id_gaya, gaya from p_gaya where id_gaya='$id'";
        //echo $runSQL;
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id_gaya = $row[id_gaya];
		$gaya = $row[gaya];
		$tgl_habis=$row[tgl_habis];
	};//if
};//if-id

if (strlen($run) > 1){ 

	$gaya = ucwords($gaya);
	$newdate = explode("/",$tgl_habis);
        $tgl_habis = $newdate[2]."-".$newdate[0]."-".$newdate[1];

	$ok = 1;}

	
	
if (strlen($run) > 1){ 

	$gaya = ucwords($gaya);
	
	$ok = 1;

	if (($ok == 1) and ($id == "")){
		$registerInvalid = 1;
		$runSQL = "insert into p_gaya VALUES (null,'$gaya','$tgl_habis')";
		//echo $runSQL;
		$insert = mysql_query($runSQL, $connDB);
		$id = mysql_insert_id($connDB);
	} else if (($ok == 1) and ($id <> "")){
		$registerInvalid = 1;
		$runSQL = "update p_gaya set gaya='$gaya',tgl_habis='$tgl_habis'  where id_gaya='$id'";
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
			 <a href="<?="?menu=$menu&uid=$uid&page=p_gaya";?>"><b>List Satuan</b></a>
		 </td>
	  </tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	 </table>
     <script language="JavaScript" src="calendar_us.js"></script>
	 <table border="0" cellpadding="5" cellspacing="0" width="650">
     
	<tr>
			<td width="35%" align="right">Detail Gaya</td>
            <td width="65%"><textarea name="gaya" cols="50" rows="2"><?=htmlentities(stripslashes($gaya));?></textarea> <font color="#FF0000"><b>*</b></font> <?=$igaya;?></td>
        </tr>
        
        <tr>
                     <td width="35%" align="right"> Tanggal </td><td> <input type='text' name='tgl_habis' size='11' value='<?=$tgl_habis?>'>
                     <script language='JavaScript'> new tcal ({'formname': 'form','controlname': 'tgl_habis'}); </script>
                     </td>
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

	$runSQL = "select id_gaya,gaya from p_gaya where id_gaya='$id'";
	$result = mysql_query($runSQL, $connDB);
	if ($row = @mysql_fetch_array ($result)) {
		$id_gaya = $row[id_gaya];
		$gaya = $row[gaya];
		$tgl_habis = $row[tgl_habis];
	};
?>

<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Input/Edit Tipe Gaya</b><br></font>
	 <font color="#FF0000"><b>-- Data telah berhasil disimpan --</b><br><br></font>

	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr><td colspan="2" align="right"><!--<a href='<?="?menu=$menu&uid=$uid&page=client_input&id=$id";?>'><img border='0' src='images/edit.gif' title='Edit Data'></a>--> &nbsp; &nbsp; </td></tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	  <tr>
     <td width="100%" valign="top" align="center">
	 <table border="0" cellpadding="5" cellspacing="0" width="650">
        <tr valign=top>
            <td width="35%" align="right">Jenis Gaya : </td>
            <td width="65%"><font class="datafield"><?=$gaya?></font></td>
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
	 <a href="<?="?menu=$menu&uid=$uid&page=p_gaya";?>"><b>List Jenis Gaya</b></a>
   </td>
  </tr>
  </form>
</table>
<? };//registerInvalid ?>