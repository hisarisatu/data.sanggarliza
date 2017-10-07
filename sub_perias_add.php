<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 09 oktober 2010, lastupdate 09 oktober 2010

include_once("include.php");

if ((strlen($run) < 1) and ($id <> "")){ 
	$runSQL = "select id_subperias, id_perias, harga_dasar, detail_perias, date_format(tgl_habis,'%m/%d/%Y') expire from p_subperias where id_subperias='$id'";
        //echo $runSQL;
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id_subperias = $row[id_subperias];
		$id_perias = $row[id_perias];
		$harga_paket = $row[harga_dasar];
		$detail_layanan = $row[detail_perias];
		$expire=$row[expire];
	};//if
};//if-id

if (strlen($run) > 1){ 

	$detail_layanan = ucwords($detail_layanan);
	$newdate = explode("/",$expire);
        $expire = $newdate[2]."-".$newdate[0]."-".$newdate[1];

	$ok = 1;
	if ($harga_paket < 0){ $iharga_paket = "<br><font color='#FF0000' size='1'><i>* Harga Paket tidak valid"; $ok=0; }
	//if (strlen($uraian_paket) < 20){ $iuraian_paket = "<br><font color='#FF0000' size='1'><i>* Uraian Paket tidak lengkap"; $ok=0; }

	if (($ok == 1) and ($id == "")){
		$registerInvalid = 1;
		$runSQL = "insert into p_subperias(id_perias,detail_perias,harga_dasar,tgl_habis) VALUES ('$id_perias','$detail_layanan', '$harga_paket','$expire')";
		//echo $runSQL;
		$insert = mysql_query($runSQL, $connDB);
		$id = mysql_insert_id($connDB);
	} else if (($ok == 1) and ($id <> "")){
		$registerInvalid = 1;
		$runSQL = "update p_subperias set id_perias='$id_layanan',harga_dasar='$harga_paket', detail_perias='$detail_layanan',int_ext='$sumberdaya',tgl_habis='$expire' where id_sublayanan='$id'";
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
	 <font class="titledata"><b>Input/Edit Data Perias</b></font>

	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
     <td valign="bottom">
		 </td>
     <td valign="bottom" align="right">
			 <img src="images/arrow2.gif" border="0">
			 <a href="<?="?menu=$menu&uid=$uid&page=sub_paket";?>"><b>Back Data Layanan</b></a>
		 </td>
	  </tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	 </table>

	 <script language="JavaScript" src="calendar_us.js"></script>
	 <table border="0" cellpadding="5" cellspacing="0" width="650">
	<tr>
			<td width="100%" align="right">Group Perias</td>
			<td width="65%"><select name="id_perias">
<?
$sql="select id_perias,nama_perias from p_perias";
$rs=mysql_query($sql);
for($a=0;$a<mysql_num_rows($rs);$a++){
echo "<option ";
$idl=mysql_result($rs,$a,"id_perias");
if ($idl==$id_perias)echo " selected ";
echo " value=\"$idl\">";
echo mysql_result($rs,$a,"nama_perias");
echo "</option>";
} ?>
</select> <font color="#FF0000"><b>*</b></font> <?=$iid_perias;?></td>
		</tr>
		<tr>
            <td width="100%" align="right">Detail Perias</td>
            <td width="65%"><textarea name="detail_layanan" cols="50" rows="3"><?=htmlentities(stripslashes($detail_layanan));?></textarea> <font color="#FF0000"><b>*</b></font> <?=$idetail_layanan;?></td>
        </tr>
        <tr>
			<td width="100%" align="right">Harga Dasar</td>
			<td width="65%"><input type="text" name="harga_paket" size="15" value="<?=htmlentities(stripslashes($harga_paket));?>"><font color="#FF0000"><b>*</b></font> <?=$iharga_paket;?></td>
		</tr>
<tr><td colspan="2" width="100%" align="center"> <br><b>Expire Date</b> </td></tr>
        <tr>
                     <td width="100%" align="right"> Tanggal </td><td> <input type='text' name='expire' size='11' value='<?=$expire?>'>
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

	$runSQL = "select id_subperias, id_perias, harga_dasar, detail_perias from p_subperias where id_subperias='$id'";
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id_subperias = $row[id_subperias];
		$id_perias = $row[id_perias];
		$harga_dasar = $row[harga_dasar];
		$detail_layanan = $row[detail_perias];
             
	};
?>

<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Input/Edit Data Perias</b><br></font>
	 <font color="#FF0000"><b>-- Data telah berhasil disimpan --</b><br><br></font>

	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr><td colspan="2" align="right"><!--<a href='<?="?menu=$menu&uid=$uid&page=client_input&id=$id";?>'><img border='0' src='images/edit.gif' title='Edit Data'></a>--> &nbsp; &nbsp; </td></tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	  <tr>
     <td width="100%" valign="top" align="center">
	 <table border="0" cellpadding="5" cellspacing="0" width="650">
		<tr>
			<td width="35%" align="right">Group Perias : </td>
			<td width="65%"><font class="datafield">
<?
$sl="select nama_perias from p_perias where id_perias='$id_perias'";
$rl=mysql_query($sl);
echo mysql_result($rl,0,"nama_perias");
?></font></td>
		</tr>
        <tr valign=top>
            <td width="35%" align="right">Uraian Perias : </td>
            <td width="65%"><font class="datafield"><?=$detail_layanan?></font></td>
        </tr>
<tr>
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
	 <a href="<?="?menu=$menu&uid=$uid&page=sub_perias";?>"><b>Back Data Perias</b></a>
   </td>
  </tr>
  </form>
</table>
<? };//registerInvalid ?>