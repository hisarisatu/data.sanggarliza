<? 
// Penerimaan Siswa Baru
// Author (c) 2009 http://iyok642.blogspot.com/
// Written by Priyo Setiawan (iyok642@yahoo.com;031-70920002)
// 07 April 2009, lastupdate 07 April 2009
include_once("include.php");

if (($SAH[id_group]==1))
{

if ($cari <> ""){ 
	$cariSQL = strtoupper($cari);
	$filterSQL = "where upper(username) like '%$cariSQL%' or upper(fullname) like '%$cariSQL%' or upper(email) like '%$cariSQL%' or upper(telepon) like '%$cariSQL%'";
};//if

unset($ii);
$arr_id_group = array(); $arr_kode_group = array();
$runSQL = "select id_group, kode_group, nama_group, keterangan from sys_group";
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) {
	array_push($arr_id_group, $row[id_group]);
	array_push($arr_kode_group, $row[kode_group]);
};//while

$runSQL = "select count(*) total from sys_username $filterSQL";
$result = mysql_query($runSQL, $connDB);
if ($row = mysql_fetch_array ($result)) { $totalRecord = $row[total]; };
$listRecord = 20;
$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter&cari=$cari&pnum=";
pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord);

unset($ii);
$runSQL = "select id_user, id_group, username, password, fullname, email, telepon, date_format(created,'%d/%m/%y') created, login_count, date_format(login_access,'%d/%m/%y') login_access, login_ip, active  from sys_username $filterSQL order by active desc LIMIT $offsetRecord, $listRecord";
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) {
	if ($row[active] == 1){ $row[active]="Active"; $fontColor=""; }else{ $row[active]="Disable"; $fontColor="<font color='#9999FF'>"; }
	$row[kode_group] = "";
	for ($ii=0; $ii<count($arr_id_group); $ii++){
		if ($row[id_group] == $arr_id_group[$ii]){
			$row[kode_group] = $arr_kode_group[$ii];
			$ii = count($arr_id_group);
		};//if
	};//for

	$ccc++;
	if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
	$htmlData .= "
	  <tr bgcolor='$color' onmouseover='bgColor=\"#E8DD5E\"' onmouseout='bgColor=\"$color\"'>
		  <td align='center'>".($offsetRecord+$ccc)."</td>
		  <td>$fontColor $row[username]</td>
		  <td>$fontColor $row[kode_group]</td>
		  <td>$fontColor $row[fullname]</td>
		  <td>$fontColor $row[email]</td>
		  <td>$fontColor $row[telepon]</td>
		  <td>$fontColor $row[created]</td>
		  <td align='center'>$fontColor $row[login_count]</td>
		  <td>$fontColor $row[login_access]</td>
		  <td>$fontColor $row[login_ip]</td>
		  <td>$fontColor $row[active]</td>
		  <td align='center'>
		    <a href='?menu=$menu&uid=$uid&page=username_input&id=$row[id_user]'><img border='0' src='images/edit.gif' alt='Edit Data'></a>
          <a href='?menu=$menu&uid=$uid&page=username_del&id=$row[id_user]'><img border='0' src='images/del.gif' alt='Hapus Data'></a>
		  </td>
	  </tr>
	";//htmlData
};//end-while

$htmlData = "
 <table width='880' cellspacing='1' cellpadding='3'>
 <tr bgcolor='#6666CC'>
	<td align='center'>NO</td>
	<td align='center'>USERNAMES</td>
	<td align='center'>GROUP</td>
	<td align='center'>FULLNAME</td>
	<td align='center'>EMAIL</td>
	<td align='center'>TELEPON</td>
	<td align='center'>CREATED</td>
	<td align='center'>JUMLAH LOGIN</td>
	<td align='center'>LAST AKSES</td>
	<td align='center'>TERMINAL AKSES</td>
	<td align='center'>STATUS</td>
	<td align='center'>EDIT<br>HAPUS</td>
 </tr>
 $htmlData
 </table>
";//htmlData
?>
<p>&nbsp;</p>
<table border="0" width="880" cellspacing="0" cellpadding="0" align="center">
  <tr>
   <td width="100%" align="center" vAlign="top">
	<table width="100%" border="0" cellpadding="3" cellspacing="0">
	  <tr><td width="100%" colspan="3" align="center"><font size="3"><b>Data Username</td></tr>
	  <tr>
       <td width="50%">
		 </td>
       <td valign="bottom"></td>
		 <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
       <td width="45%" valign="bottom" align="right">
		    <img src="images/arrow2.gif" border="0">
		    <a href="<?="?menu=$menu&uid=$uid&page=username";?>"><b>List Username</b></a>
			 &nbsp; &nbsp; <br>
		    <img src="images/arrow2.gif" border="0">
		    <a href="<?="?menu=$menu&uid=$uid&page=username_input";?>"><b>Input Username Baru</b></a>
			 &nbsp; &nbsp; 
			 <br><br><br>
			 <b>Cari : <input type="text" name="cari" value="<?=$cari;?>">
			 <input type="submit" name="run" value="  Go  " class="button">
			 &nbsp; &nbsp;
		 </td>
		 </form>
	  </tr>
	  </form>
     <tr><td width="100%" colspan="3"><hr size="1" color="#0000FF"></td></tr>
     <tr>
       <td width="100%" colspan="3">
		 Halaman : <?=$pnumlink;?> &nbsp; Total : <b><?=$totalPage;?></b> halaman, <?=$totalRecord?> record.
		 </td>
	  </tr>
     <tr>
       <td width="100%" colspan="3" align="center">
       <?=$htmlData;?>
		 </td>
	  </tr>
     <tr>
       <td width="100%" colspan="3">
		 Halaman : <?=$pnumlink;?> &nbsp; Total : <b><?=$totalPage;?></b> halaman, <?=$totalRecord?> record.
		 </td>
	  </tr>
    </table>
   </td>
  </tr>
</table>

<?
}
else
{echo"</br>";
echo"</br>";
echo "<div align='center'><font color='#FF0000'><b>Akses Tidak Diperbolehkan. Hanya Group Administrator</b></font></div>"; }
?>