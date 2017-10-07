<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 09 oktober 2010, lastupdate 09 oktober 2010

include_once("include.php");

function js_submit()
{
        echo "<script language=javascript>\n";
        echo "function submit_form() {\n";
        echo "  document.forms[0].submit();\n";
        echo "}\n";
        echo "</script>\n";

}
function generate_select_event($name,$sql,$default,$onchange)
{
		$result = mysql_query($sql);
        $nrows=0;
        while ($row = mysql_fetch_array ($result))
        {
                $nrows++;
                $key = $row[0];
                $value = $row[1];
                $arr["$key"] = $value;
        }
        echo "<select name=$name onchange=\"$onchange;\">\n";
        if (!$default) {
                echo "<option value=0>-- Pilih --</option>\n";
        }
        while (list($key,$val) = each($arr))
        {
                if ($default==$key) {
                        echo "<option value=$key selected>$val</option>\n";
                } else {
                        echo "<option value=$key>$val</option>\n";
                }
        }
        echo "</select>";
}

function generate_select($name,$sql,$default)
{

		$result = mysql_query($sql);
        $nrows=0;
        while ($row = mysql_fetch_array ($result))
        {
                $nrows++;
                $key = $row[0];
                $value = $row[1];
                $arr["$key"] = $value;
        }

        echo "<select name=$name>\n";
        while (list($key,$val) = each($arr))
        {
                if ($default==$key) {
                        echo "<option value=$key selected>$val</option>\n";
                } else {
                        echo "<option value=$key>$val</option>\n";
                }
        }
        echo "</select>";
}



if ((strlen($run) < 1) and ($id <> "")){ 
	$runSQL = "select id_pengumuman, pengumuman, tgl_habis, nama from p_pengumuman where id_pengumuman='$id'";
        //echo $runSQL;
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id_pegawai = $row[nama];
		$id_pengumuman = $row[id_pengumuman];
		$pengumuman = $row[pengumuman];
		$tgl_habis = $row[tgl_habis];
	};//if
};//if-id

if (strlen($run) > 1){ 

	$pengumuman = ucwords($pengumuman);
	$newdate = explode("/",$tgl_habis);
        $tgl_habis = $newdate[2]."-".$newdate[0]."-".$newdate[1];

	$ok = 1;}

	
	
if (strlen($run) > 1){ 

	$pengumuman = ucwords($pengumuman);
	
	$ok = 1;

	if (($ok == 1) and ($id == "")){
		$registerInvalid = 1;
		$runSQL = "insert into p_pengumuman VALUES (null,'$pengumuman','$tgl_habis','$id_pegawai')";
		//echo $runSQL;
		$insert = mysql_query($runSQL, $connDB);
		$id = mysql_insert_id($connDB);
	} else if (($ok == 1) and ($id <> "")){
		$registerInvalid = 1;
		$runSQL = "update p_pengumuman set pengumuman='$pengumuman', tgl_habis='$tgl_habis', nama='$id_pegawai' where id_pengumuman='$id'";
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
			 <a href="<?="?menu=$menu&uid=$uid&page=p_pengumuman";?>"><b>List Pengumuman</b></a>
		 </td>
	  </tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	 </table>
     <script language="JavaScript" src="calendar_us.js"></script>
	 <table border="0" cellpadding="5" cellspacing="0" width="650">
     <tr>
			<td width="35%" align="right">Nama Perias</td>
			<td width="65%">
			<?
			$sqlpetugas="select distinct a.id_pegawai,a.nama from pegawai a,pegawai_pekerjaan b
			where a.id_pegawai=b.id_pegawai and b.id_pekerjaan=17 union select 0,'--Pilih Perias--' from dual";
			generate_select("id_pegawai",$sqlpetugas,$id_pegawai);
			?><font color="#FF0000"><b> *</b></font>
			</td>
		</tr>
     
	<tr>
			<td width="35%" align="right">Detail Pengumuman</td>
            <td width="65%"><textarea name="pengumuman" cols="50" rows="4"><?=$pengumuman;?></textarea> <font color="#FF0000"><b>*</b></font> </td>
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

	$runSQL = "select id_pengumuman, pengumuman, tgl_habis, nama from p_pengumuman where id_pengumuman='$id'";
	$result = mysql_query($runSQL, $connDB);
	if ($row = @mysql_fetch_array ($result)) {
		$id_pegawai = $row[nama];
		$id_pengumuman = $row[id_pengumuman];
		$pengumuman = $row[pengumuman];
		$tgl_habis = $row[tgl_habis];
	};
?>

<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Input/Edit Pengumuman</b><br></font>
	 <font color="#FF0000"><b>-- Data telah berhasil disimpan --</b><br><br></font>

	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr><td colspan="2" align="right"><!--<a href='<?="?menu=$menu&uid=$uid&page=client_input&id=$id";?>'><img border='0' src='images/edit.gif' title='Edit Data'></a>--> &nbsp; &nbsp; </td></tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	  
      
      <tr>
     <td width="100%" valign="top" align="center">
	 <table border="0" cellpadding="5" cellspacing="0" width="650">
     <tr valign=top>
            <td width="35%" align="right">nama : </td>
            <td width="65%"><font class="datafield"><?=$id_pegawai?></font></td>
        </tr>
        <tr valign=top>
            <td width="35%" align="right">pengumuman : </td>
            <td width="65%"><font class="datafield"><?=$pengumuman?></font></td>
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
	 <a href="<?="?menu=$menu&uid=$uid&page=p_pengumuman";?>"><b>List Pengumuman</b></a>
      <img src="images/arrow2.gif" border="0">
	 <a href="<?="?menu=$menu&uid=$uid&page=p_pengumuman_add";?>"><b>Tambah Lagi</b></a>
   </td>
  </tr>
  </form>
</table>
<? };//registerInvalid ?>