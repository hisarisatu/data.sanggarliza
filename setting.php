<? 
// Penerimaan Siswa Baru
// Author (c) 2009 http://iyok642.blogspot.com/
// Written by Priyo Setiawan (iyok642@yahoo.com;031-70920002)
// 07 April 2009, lastupdate 07 April 2009
include_once("include.php");

unset($ii);
$runSQL = "select variable, value from sys_settings";
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) { 
  $variabel = $row[variable];
  $value = $row[value];
	$ccc++;
	if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
	$htmlData .= "
	  <tr bgcolor='$color' onmouseover='bgColor=\"#E8DD5E\"' onmouseout='bgColor=\"$color\"'>
		  <td align='center'>$ccc</td>
	 <td width='25%' valign='top'><a href='?menu=$menu&uid=$uid&page=setting_input&&var=$variabel'>$variabel</a></td>
	 <td width='65%'>$value</td>
  </tr>";//echo
};//while

$htmlData = "
 <table width='800' cellspacing='1' cellpadding='3'>
 <tr bgcolor='#6666CC'>
	<td align='center'>NO</td>
	<td align='center'>PARAMETER</td>
	<td align='center'>NILAI</td>
 </tr>
 $htmlData
 </table>";//htmlData
?>
<p>&nbsp;</p>
<table border="0" width="100%" height="80%" cellspacing="0" cellpadding="0">
  <tr>
   <td width="100%" align="center" vAlign="middle">
	<table border="0" cellpadding="3" cellspacing="0">
	  <tr><td width="100%" colspan="3" align="center"><font size="3"><b>Web Setting</td></tr>
     <tr><td width="100%" colspan="3"><hr size="1" color="#0000FF"></td></tr>
     <tr>
       <td width="100%" colspan="3" align="center">
       <?=$htmlData;?>
		 </td>
	  </tr>
    </table>
   </td>
  </tr>
</table>
