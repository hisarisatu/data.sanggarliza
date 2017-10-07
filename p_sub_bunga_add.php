<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 09 oktober 2010, lastupdate 09 oktober 2010

include_once("include.php");

if ((strlen($run) < 1) and ($id <> "")){ 
	$runSQL = "select id_bunga, detail_layanan,tgl_habis  from bunga_detail where id_bunga='$id'";
        //echo $runSQL;
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id_bunga = $row[id_bunga];
		$detail_layanan = $row[detail_layanan];
		
		$expire=$row[tgl_habis];
	};//if
};//if-id

if (strlen($run) > 1){ 

	$detail_bunga = ucwords($detail_bunga);
	$newdate = explode("/",$expire);
        $expire = $newdate[2]."-".$newdate[0]."-".$newdate[1];

	$ok = 1;
	

	if (($ok == 1) and ($id == "")){
		$registerInvalid = 1;
		$runSQL = "insert into bunga_detail(detail_layanan,tgl_habis) VALUES ('$detail_layanan', '$expire')";
		//echo $runSQL;
		$insert = mysql_query($runSQL, $connDB);
		$id = mysql_insert_id($connDB);
	} else if (($ok == 1) and ($id <> "")){
		$registerInvalid = 1;
		$runSQL = "update bunga_detail set detail_layanan='$detail_layanan',tgl_habis='$expire' where id_bunga='$id'";
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
			 <a href="<?="?menu=$menu&uid=$uid&page=p_sub_bunga";?>"><b>Back Data Layanan</b></a>
		 </td>
	  </tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	 </table>

	 <script language="JavaScript" src="calendar_us.js"></script>
	 <table border="0" cellpadding="5" cellspacing="0" width="650">
		<tr>
            <td width="100%" align="right">Detail Bunga</td>
            <td width="65%"><textarea name="detail_layanan" cols="50" rows="3"><?=htmlentities(stripslashes($detail_layanan));?></textarea> <font color="#FF0000"><b>*</b></font> <?=$idetail_layanan;?></td>
        </tr>
<tr><td colspan="2" width="100%" align="center"> <br><b>Expire Date</b> </td></tr>
        <tr>
                     <td width="100%" align="right"> Tanggal Habis</td><td> <input type='text' name='expire' size='11' value='<?=$expire?>'>
                     <script language='JavaScript'> new tcal ({'formname': 'form','controlname': 'expire'}); </script>
                     </td>
                    </tr><tr>
			<td width="100%" align="right">&nbsp;</td>
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

	$runSQL = "select id_bunga, detail_layanan,tgl_habis  from bunga_detail where id_bunga='$id'";
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id_bunga = $row[id_bunga];
		$detail_layanan = $row[detail_layanan];
                $tgl_habis=$row[tgl_habis];
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
            <td width="35%" align="right">Detail Bunga: </td>
            <td width="65%"><font class="datafield"><?=$detail_layanan;?></font></td>
        </tr>
       <tr>
            <td width="35%" align="right">Tanggal: </td>
            <td width="65%"><font class="datafield"><?=$tgl_habis;?></font></td>
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
	 <a href="<?="?menu=$menu&uid=$uid&page=p_sub_bunga";?>"><b>Back Data Layanan</b></a>
   </td>
  </tr>
  </form>
</table>
<? };//registerInvalid ?>