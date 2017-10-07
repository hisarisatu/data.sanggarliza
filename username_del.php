<? 
// Penerimaan Siswa Baru
// Author (c) 2009 http://iyok642.blogspot.com/
// Written by Priyo Setiawan (iyok642@yahoo.com;031-70920002)
// 07 April 2009, lastupdate 07 April 2009
include_once("include.php");

if (strlen($run) > 1){ 
	$registerInvalid = 1;
	$runSQL = "delete from sys_username where id_user='$id_user'";
	$delete = mysql_query($runSQL, $connDB);
};//end-if-submit

if ($registerInvalid <> 1){
?>
<table border="0" width="100%" height="100%" cellspacing="0" cellpadding="0" align="center" vAlign="middle">
  <tr>
    <td width="100%"  height="100%" align="center" vAlign="middle">
    <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
    <table border="0" cellpadding="5" cellspacing="0" width="550">
      <tr>
        <td width="100%" colspan="3" align="center"><b>Konfirmasi</td>
      </tr>
      <tr><td width="100%" colspan="2"><hr size="1" color="#0000FF"></td></tr>
      <tr>
        <td width="100%" colspan="3" align="center"><b>Anda yakin akan menghapus satu record data Username?</td>
      </tr>
      <tr>
        <td width="100%" colspan="2" align="center">
			<input type="hidden" name="id_user" value="<?=$id;?>"><br><br>
			<input type="submit" value="  Ya  " name="run" class="button"><br><br>
	     </td>
      </tr>
    </table>
   </form>
	[ <a href="<?="?menu=$menu&uid=$uid&page=username";?>">Lihat Data</a> ]
   </td>
  </tr>
</table>

<? } else { //registerInvalid ?>

<table border="0" width="100%" height="100%" cellspacing="0" cellpadding="0" align="center" vAlign="middle">
  <tr>
   <td width="100%"  height="100%" align="center" vAlign="middle">
   <table border="0" cellpadding="3" cellspacing="0" width="500">
     <tr><td width="100%" colspan="3" align="center"><b>Telah Dihapus</td></tr>
     <tr><td width="100%" colspan="3"><hr size="1" color="#0000FF"></td></tr>
     <tr>
	     <td width="100%" height='30' colspan="3" align='center'>
	     Satu Record Telah Dihapus<br><br>
	     [ <a href="<?="?menu=$menu&uid=$uid&page=username";?>">Lihat Data</a> ]
	     <br><br><br><br>
	     </td>
	  </tr>
    </table>
   </td>
  </tr>
</table>

<? };//registerInvalid ?>