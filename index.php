<?php 
 
include_once("include.php");

 $uid = $_SESSION['id_pegawai'];

$logged = 0;
$runSQL = "select count(*) logged from sys_visitor where id_session='$uid'";
$result = mysql_query($runSQL, $connDB);
if ($row = mysql_fetch_array ($result)) { $logged=$row[logged]; };
if (($logged < 1) and ($page <> "home") and ($page <> "")){ 
	die("<script> window.parent.location='?menu=$menu&uid=$uid&page=home&haruslogin=1'; </script>");
};//if

$pageAuth = 0;
$REMOTE_ADDR = getenv("REMOTE_ADDR"); 
$QUERY_STRING = getenv("QUERY_STRING");
$HTTP_USER_AGENT = getenv("HTTP_USER_AGENT");


if (strpos(" ".strtolower($QUERY_STRING),"_del") > 0){ $pageAuth = 1; };
if (strpos(" ".strtolower($QUERY_STRING),"_upload") > 0){ $pageAuth = 1; };
if (strpos(" ".strtolower($QUERY_STRING),"_add") > 0){ $pageAuth = 1; };

if ($pageAuth == 1){
	$runSQL = "select count(*) logged from sys_visitor a, sys_username b, sys_group c where a.id_user=b.id_user and b.id_group=c.id_group and c.kode_group='ADMIN' and a.id_session='$uid'";
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) { $logged=$row[logged]; }
	if ($logged < 1){ 
		$page = str_replace("_del", "", $page);
		$page = str_replace("_upload", "", $page);
		$page = str_replace("_add", "", $page);
		die("<script> window.parent.location='?menu=$menu&uid=$uid&page=$page&unauthorized=1'; </script>");
	};//if
};//if



//login reset after 2 hours
$result = mysql_query("select count(*) expired from sys_visitor where (unix_timestamp(now())-unix_timestamp(last_active)) > 7200");
if ($row = mysql_fetch_array($result)) { $expired = $row[expired]; }
if ($expired > 0) {
	mysql_query("insert into sys_visitor_history select * from sys_visitor where (unix_timestamp(now())-unix_timestamp(last_active)) > 7200");
	mysql_query("delete from sys_visitor where (unix_timestamp(now())-unix_timestamp(last_active)) > 7200");
};//if
if ($uid <> ""){
	$runSQL = "update sys_visitor set status='OPEN', last_active=now(), last_page='$QUERY_STRING', ipaddress='$REMOTE_ADDR' where id_session='$uid'";
	$result = mysql_query($runSQL, $connDB);
};//if

//generate uniq code for session
if ($uid == ""){ $uid = uniqid(rand()); }
if ($uid != ""){
	$runSQL = "select a.id_user, a.id_group, a.username, a.password, a.fullname, a.email, a.telepon, a.created, a.login_count, a.login_access, a.login_ip, b.last_active, b.last_page from sys_username a, sys_visitor b where a.id_user=b.id_user and b.id_session = '$uid'";
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array($result)) {
		$SAH[id_session]  = $uid;
		$SAH[id_user]  = $row[id_user];
		$SAH[id_group] = $row[id_group];
		$SAH[username] = $row[username];
		$SAH[fullname] = $row[fullname];
		$SAH[email]    = $row[email];
		$SAH[telepon]  = $row[telepon];
	};//if

	//update last_active setiap akses
	$runSQL = "update sys_visitor set last_active=now(), last_page='$PAGE_STRING', ipaddress='$REMOTE_ADDR' where id_session='$uid'";
	mysql_query($runSQL, $connDB);
};//if

//========//


if ($page == ""){ $page="home"; };
if ($menu == ""){ $menu="1"; }
$INCLUDE_PAGE = $page . ".php";

//halaman menu
unset($htmlMenu, $htmlSubmenu, $i);
$runSQL = "select id_menu, menu, link_menu from sys_menu order by urutan";
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) {
   $i++;
	unset($i2, $loadPage);
	$runSQL = "select id_submenu, id_menu, submenu, link_submenu from sys_submenu where id_menu='$row[id_menu]' order by id_submenu";
	$result2 = mysql_query($runSQL, $connDB);
	while ($row2 = mysql_fetch_array ($result2)) {
		$i2++;
		if ($i2 == 1){ $loadPage = $row2[link_submenu]; }
		if ($menu == $row[id_menu]){
			if ($linkSubmenu <> ""){ $garis = "<font color='#00CCCC'></b> | </font>"; }else{ $garis = ""; };
			$linkSubmenu .= "$garis <a href='?menu=$row[id_menu]&uid=$uid&$row2[link_submenu]'>$row2[submenu]</a>";
		};//if
	};//end-while

	if ($htmlMenu <> ""){ $space="<font class='smallgraytext'> &nbsp; | &nbsp; </font>"; }else{ $space=""; };
	$htmlMenu .= $space . "<a href='?menu=$row[id_menu]&uid=$uid&$loadPage'><b>$row[menu]<b></a>";
};//end-while

if ($linkSubmenu == ""){ $linkSubmenu = "<font color='#003300'>Submenu $row[menu] tidak ada items</font>"; }
if (($menu == 1)&&($logged > 0)){ $linkSubmenu .= " | <a href='?menu=$row[id_menu]&uid=$uid&page=home&cmd=logout'>Logout</a>"; }
?>

<html>
<head>
  <meta name="Generator" content="EditPlus">
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
  <meta name="Author" content="iyok642@yahoo.com">
  <title><?=$web_meta_title?></title>
  <link rel="stylesheet" href="images/style.css" type="text/css">
	<link rel="stylesheet" href="calendar.css" type="text/css">

  <!--<link rel="stylesheet" href="style.css" type="text/css">-->
</head>
<body bgcolor="#FFFFFF">
<div id="page" align="center">
	<div id="content" style="width:900px">
		<div id="logo">
			<div style="margin-top:70px" class="whitetitle"></div>
		</div>
		<div id="topheader">
			<div align="left" class="titleinfo">
				<br>
				<strong>Sanggar Liza</strong><br>
				Jl. J No. 7 & 29 Kebon Baru Tebet, Jakarta Selatan, Indonesia.<br>
				Ph. : +62.21.8299280; +62.21.70886588<br>
				Fax. : +62.21.83794263<br>
				sanggarliza@gmail.com
			</div>
			<div id="toplinks" class="smallgraytext">
				<a href="#">Home</a> | <a href="#">Sitemap</a> | <a href="#">Contact Us</a>
                                <?php 
					$qnotif 	= "SELECT p.id_user, q.id_user, q.status, q.id_notif_cs FROM sys_username p, tb_notif_cs q WHERE p.id_user = q.id_user AND q.status='1'";
					$sqlnotif 	= mysql_query($qnotif);
				
					if($logged > 0){

						while ($data_notif	= mysql_fetch_array($sqlnotif)) {
						
						if($SAH[id_user] == $data_notif['id_user']) {
						?>

							| <a href="<?="?menu=$menu&uid=$uid&page=list_mc";?>">Notif [<b style="color:red;" id="pesan"><span id="notifikasi"></span></b>]</a>
					
						<?php } else {

							echo "&nbsp;";
						}
						}
					} else {

						echo "&nbsp;";
					}
				?>
			</div>
		</div>
		<div id="menu">
			<div align="right" class="smallwhitetext" style="padding:9px;">
			<?=$htmlMenu;?>
			</div>
		</div>
		<div id="submenu">
			<div align="right" class="smallgraytext" style="padding:9px;">
			<?=$linkSubmenu;?>
			</div>
		</div>
	</div>
	<div id="contentweb" align="center">
    <table border="0" cellpadding="0" cellspacing="0" style="border-collapse:collapse">
     <tr>
	    <td vAlign="top">
		  <? if ($haruslogin == 1){ echo "<div align='center'><font color='#FF0000'><b>Silakan Login...</b></font></div>"; }?>
		  <? if ($unauthorized == 1){ echo "<div align='center'><font color='#FF0000'><b>Akses Tidak Diperbolehkan. Hanya Group Administrator</b></font></div>"; }?>
	    <? include($INCLUDE_PAGE); ?>
	    </td>
     </tr>
    </table>
		<p>&nbsp;</p>
		<div id="footer" class="smallgraytext">
			<?=$web_footer_title?>
		</div>
	</div>
</div>

</body>
</html>
<? @mysql_close($connDB); ?>