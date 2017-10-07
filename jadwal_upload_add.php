<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 09 oktober 2010, lastupdate 09 oktober 2010

include_once("include.php");
include('action_upload.php');


?>
<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
 <form method="post" enctype="multipart/form-data" action="">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Upload Foto Jadwal</b></font>

	 <table width="100%" border="0" cellpadding="0" cellspacing="0">
	  <tr>
     <td valign="bottom">
		 </td>
     <td valign="bottom" align="right">
			 <img src="images/arrow2.gif" border="0">
			 <a href="<?="?menu=$menu&uid=$uid&page=jadwal_upload";?>"><b>List Foto Jadwal</b></a>
		 </td>
	  </tr>
	  <tr><td colspan="2"> <hr size="1" color="#4B4B4B"> </td></tr>
	 </table>
	 <table border="0" cellpadding="5" cellspacing="0" width="650">
	<tr>
			<td width="35%" align="right">File Foto Jadwal 1</td>
            <td width="65%"><input type="file" name="data_upload" /></td>
        </tr>
        <tr>
			<td width="35%" align="right">File Foto Jadwal 2</td>
            <td width="65%"><input type="file" name="data_upload1" /></td>
        </tr>
        <tr>
			<td width="35%" align="right">File Foto Jadwal 3</td>
            <td width="65%"><input type="file" name="data_upload2" /></td>
        </tr>
        <tr>
			<td width="35%" align="right">File Foto Jadwal 4</td>
            <td width="65%"><input type="file" name="data_upload3" /></td>
        </tr>
        <tr>
			<td width="35%" align="right">File Foto Jadwal 5</td>
            <td width="65%"><input type="file" name="data_upload4" /></td>
        </tr>
        <tr>
			<td width="35%" align="right">File Foto Jadwal 6</td>
            <td width="65%"><input type="file" name="data_upload5" /></td>
        </tr>
<tr>
			<td width="35%" align="right">Keterangn</td>
			<td width="65%">
			<textarea name="keterangan" cols="33
    
   " rows="3"></textarea><br></td>
		</tr>
		<tr>
        <tr>
			<td width="35%" align="right">&nbsp;</td>
			<td width="65%"><input type="submit" name="btnUpload" value="Upload" />			  <br></td>
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
<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
 </table>