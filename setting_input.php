<? 
// Penerimaan Siswa Baru
// Author (c) 2009 http://iyok642.blogspot.com/
// Written by Priyo Setiawan (iyok642@yahoo.com;031-70920002)
// 07 April 2009, lastupdate 07 April 2009
include_once("include.php");

if ($run == ""){
	$result = mysql_query("select variable,value from sys_settings where variable='$var'");
	while ($row = mysql_fetch_array ($result)) { 
	  $variabel = $row[variable];
	  $value = $row[value];
	};//while
} else {
	$registerInvalid = 1;
	$save = mysql_query("update sys_settings set value='$value' where variable='$var'");
};//if

if ($registerInvalid <> 1){
?>
<p>&nbsp;</p>
<table border="0" width="100%" cellspacing="0" cellpadding="0" align="center" vAlign="middle">
  <tr>
   <td width="100%" align="center" vAlign="middle">
	<br>
   <table border="0" cellpadding="3" cellspacing="0" width="500">
     <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
     <tr><td width="100%" colspan="3" align="center"><b>EDIT WEB SETING</td></tr>
     <tr><td width="100%" colspan="3"><hr size="1" color="#0000FF"></td></tr>
	  <tr>
		 <td width='25%' valign='top'><b><?=$variabel;?></b></td>
		 <td width='5%' valign='top'>:</td>
		 <td width='65%'>
			<textarea rows="8" cols="50" name="value"><?=htmlentities(stripslashes($value));?></textarea><?=$ivalue;?>
		 </td>
	  </tr>
	  <tr>
		 <td width='25%' valign='top'></td>
		 <td width='5%' valign='top'></td>
		 <td width='65%'>
			<input type="hidden" value="<?=$variabel;?>" name="var">
			<input type="submit" value="Simpan" name="run" class="button2"><br><br>
		 </td>
	  </tr>
	  </form>
    </table>
   </td>
  </tr>
</table>

<? } else { ?>

<p>&nbsp;</p>
<table border="0" width="100%" cellspacing="0" cellpadding="0" align="center" vAlign="middle">
  <tr>
   <td width="100%" align="center" vAlign="middle">
   <table border="0" cellpadding="3" cellspacing="0" width="500">
     <tr><td width="100%" colspan="3" align="center"><b>SAVE WEB SETING</td></tr>
     <tr><td width="100%" colspan="3"><hr size="1" color="#0000FF"></td></tr>
     <tr><td width="100%" colspan="3" align="center"> Data Telah Disimpan </td></tr>
     <tr>
       <td width="100%" align="center" colspan="3"><br>[ <a href="<?="?menu=$menu&uid=$uid&page=setting";?>">Web Settting</a> ]</td>
     </tr>
    </table>
   </td>
  </tr>
</table>
<? } ?>

<? @mysql_close($connDB); ?>