<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 09 oktober 2010, lastupdate 09 oktober 2010

include_once("include.php");

if ($cari <> ""){ 
	$cariSQL = strtoupper($cari);
	$filterSQL = "where upper(nama_paket) like '%$cariSQL%' or upper(harga_paket) like '%$cariSQL%' or upper(uraian_paket) like '%$cariSQL%'";
};//if

$runSQL = "select count(*) total from paket $filterSQL";
$result = mysql_query($runSQL, $connDB);
if ($row = mysql_fetch_array ($result)) { $totalRecord = $row[total]; };
$listRecord = 20;
$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter&cari=$cari&pnum=";
pageViewRecord ($pnum, $totalRecord, $pageLink, $listRecord);

unset($ii);
$runSQL = "select id_paket, nama_paket, harga_paket, uraian_paket, tgl_inisial, tgl_expire, id_user, login_ip, created, user_update, ip_update, last_update from paket $filterSQL order by id_paket desc LIMIT $offsetRecord, $listRecord";
//echo "$runSQL<br>";
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) {
	$ccc++;
	if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
	$htmlData .= "
	  <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"'>
		  <td align='center'>".($offsetRecord+$ccc)."</td>
		  <td> $row[nama_paket] </td>
		  <td> $row[harga_paket] </td>
		  <td> ";

$sql="select detail_layanan from p_sublayanan where id_sublayanan in (select id_sublayanan from paket_sub_paket where id_paket='$row[id_paket]')";
//echo $sql;//developer
$rs=mysql_query($sql);
$n=mysql_num_rows($rs);
if($n>3){$maxrow=3;}else{$maxrow=$n;}
for($a=0;$a<$maxrow;$a++){
$htmlData .= "&raquo;&nbsp;";
$htmlData .= mysql_result($rs,$a,"detail_layanan");
$htmlData .= "<br>";
}
if($n>3)$htmlData .= "&raquo;........";

        $htmlData .= " </td>
		  <td> $row[tgl_inisial] </td>
		  <td> $row[tgl_expire] </td>
		  <td align='center' nowrap>
		  <a href='?menu=$menu&uid=$uid&page=paketview&id=$row[id_paket]'><img border='0' src='images/view.png' title='Lihat Data'></a>
		  </td>
	  </tr>
	";//htmlData
};//end-while

?>
<table border="0" width="850" cellspacing="0" cellpadding="0" align="center">
  <tr>
   <td width="100%" align="center" vAlign="top">
	 <font class="titledata"><b>Data Paket</b></font>

	 <table width="100%" border="0" cellpadding="5" cellspacing="0">
	  <tr>
		 <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
     <td valign="bottom">
			 <b>Cari : <input type="text" name="cari" value="<?=$cari;?>" size="30">
			 <input type="submit" name="run" value="  Go  " class="button">
		 </td>
     <td valign="bottom" align="right">
			 <img src="images/arrow2.gif" border="0">
			 <b><a href="<?="?menu=$menu&uid=$uid&page=tamu_paket";?>">List All</a>
		 </td>
		 </form>
	  </tr>
		<tr><td colspan="2"><hr size="1" color="#4B4B4B"></td></tr>
	 </table>

	 <table width='700' cellspacing='1' cellpadding='3'>
		<tr>
		  <td colspan="12" align="left">
			Halaman : <?=$pnumlink;?> &nbsp; Total : <b><?=$totalPage;?></b> halaman, <?=$totalRecord?> record.
			</td>
		</tr>
		<tr bgcolor='#A7A7A7' height="25">
			<td align='center'>NO</td>
			<td align='center'>NAMA PAKET</td>
			<td align='center'>HARGA</td>
			<td align='center'>URAIAN</td>
			<td align='center'>CREATED</td>
			<td align='center'>EXPIRED</td>
			<td align='center'>LIHAT</td>
		</tr>
		<?=$htmlData;?>
		<tr>
		  <td colspan="12" align="left">
			Halaman : <?=$pnumlink;?> &nbsp; Total : <b><?=$totalPage;?></b> halaman, <?=$totalRecord?> record.
			</td>
		</tr>
	 </table>

   </td>
  </tr>
</table>
