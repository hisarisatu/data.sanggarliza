<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 09 oktober 2010, lastupdate 09 oktober 2010

include_once("include.php");
if (($SAH[id_group]==1)or($SAH[id_group]==9))
{
if ((strlen($run) < 1) and ($id <> "")){ 
	$runSQL = "select id_program, nama_program, kode from tb_program where id_program='$id'";
        //echo $runSQL;
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id_program 	= $row[id_program];
		$nama_program	= $row[nama_program];
		$kode 			= $row[kode];
	};//if
};//if-id

/*if (strlen($run) > 1){ 

	$gaya = ucwords($gaya);
	$newdate = explode("/",$tgl_habis);
        $tgl_habis = $newdate[2]."-".$newdate[0]."-".$newdate[1];

	$ok = 1;} */

	
	
if (strlen($run) > 1){ 

	$nama_program = ucwords($nama_program);
	
	$ok = 1;

	if (($ok == 1) and ($id == "")){
		$registerInvalid = 1;
		$runSQL = "insert into tb_program VALUES ('','$nama_program','$kode')";
		//echo $runSQL;
		$insert = mysql_query($runSQL, $connDB);
		$id = mysql_insert_id($connDB);
	} else if (($ok == 1) and ($id <> "")){
		$registerInvalid = 1;
		$runSQL = "update tb_program set nama_program='$nama_program',kode='$kode'  where id_program='$id'";
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
	 <font class="titledata"><b>Input/Edit Program</b></font>

	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
     <td valign="bottom">
		 </td>
     <td valign="bottom" align="right">
			 <img src="images/arrow2.gif" border="0">
			 <a href="<?="?menu=$menu&uid=$uid&page=p_program";?>"><b>List Satuan</b></a>
		 </td>
	  </tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	 </table>
     <script language="JavaScript" src="calendar_us.js"></script>
	 <table border="0" cellpadding="5" cellspacing="0" width="650">
     
	<tr>
			<td width="35%" align="right">Nama Program</td>
			<td width="65%"><input type="text" name="nama_program" size="40" value="<?=htmlentities(stripslashes($nama_program));?>"> <?=$inama_program;?></td>
		</tr>
		<tr>
			<td width="35%" align="right">Kode</td>
			<td width="65%"><input type="text" name="kode" size="40" value="<?=htmlentities(stripslashes($kode));?>"></td>
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

	$runSQL = "select id_program,nama_program, kode from tb_program where id_program='$id'";
	$result = mysql_query($runSQL, $connDB);
	if ($row = @mysql_fetch_array ($result)) {
		$id_program 	= $row[id_program];
		$nama_program 	= $row[nama_program];
		$kode 			= $row[kode];
	};
?>

<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Input/Edit Program</b><br></font>
	 <font color="#FF0000"><b>-- Data telah berhasil disimpan --</b><br><br></font>

	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr><td colspan="2" align="right"><!--<a href='<?="?menu=$menu&uid=$uid&page=p_program_plus&id=$id";?>'><img border='0' src='images/edit.gif' title='Edit Data'></a>--> &nbsp; &nbsp; </td></tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	  <tr>
     <td width="100%" valign="top" align="center">
	 <table border="0" cellpadding="5" cellspacing="0" width="650">
	 	 <tr valign=top>
            <td width="35%" align="right">Kode : </td>
            <td width="65%"><font class="datafield"><?=$kode?></font></td>
        </tr>
        <tr valign=top>
            <td width="35%" align="right">Nama Program : </td>
            <td width="65%"><font class="datafield"><?=$nama_program?></font></td>
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
	 <a href="<?="?menu=$menu&uid=$uid&page=p_program";?>"><b>List Program</b></a>
   </td>
  </tr>
  </form>
</table>
<? };//registerInvalid ?>
<?
}
else
{echo"</br>";
echo"</br>";
echo "<div align='center'><font color='#FF0000'><b>Akses Tidak Diperbolehkan. Hanya Group Administrator dan Beauty Course</b></font></div>"; }
?>