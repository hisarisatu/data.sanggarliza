<?php 
#exit('132');
// Penerimaan Siswa Baru
// Author (c) 2009 http://iyok642.blogspot.com/
// Written by Priyo Setiawan (iyok642@yahoo.com;031-70920002)
// 07 April 2009, lastupdate 07 April 2009
include_once("include.php");

if ($cmd == "logout"){
	$runSQL1 = "insert into sys_visitor_history select * from sys_visitor where id_session='$uid'";
	$runSQL2 = "delete from sys_visitor where id_session='$uid'";
	mysql_query($runSQL1, $connDB);
	mysql_query($runSQL2, $connDB);
	//header("Location:?menu=$menu&uid=&page=$page");
	die("<script> window.parent.location='?menu=$menu&uid=&page=$page'; </script>");
};//if

if ( ($run != '') && ($username != '') && ($password != '')){
    $username = strtolower($username);
    $password = md5($password);
    $runSQL = "select id_user, id_group, username, password, fullname, email, telepon, created, login_count, login_access, login_ip, active from sys_username where username in ('$username') and password in ('$password') and active='1'";
	 $result = mysql_query($runSQL, $connDB);
    if ($row = mysql_fetch_array($result)) {
       $uid = uniqid(rand());
       $runSQL1 = "insert into sys_visitor (id_session, id_user, ipaddress, status, login_time, last_active, last_page, expired) values ('$uid','$row[id_user]','$REMOTE_ADDR','LOGON',NOW(),NOW(),'$QUERY_STRING','0')";
       $runSQL2 = "update sys_username set login_count = login_count + 1, login_access = now(), login_ip = '$REMOTE_ADDR' where id_user = '$row[id_user]'";
		 mysql_query($runSQL1, $connDB);
		 mysql_query($runSQL2, $connDB);
		 mysql_close();
		 //header("Location:?menu=$menu&uid=$uid&page=$page");
		 die("<script> window.parent.location='?menu=$menu&uid=$uid&page=$page'; </script>");
    };//if
};//if

if (($uid == "")or($logged <= 0)){
    $htmlTable = "
    <form method='POST' name='form' action='?menu=$menu&uid=$uid&page=$page'>
    <table border='0' cellpadding='3' cellspacing='0' width='100%'>
      <tr>
        <td width='40%' align='right'><font class='smallgraytext'>Username :</td>
        <td width='60%'><input type='text' name='username' size='20'></td>
      </tr>
      <tr>
        <td width='40%' align='right'><font class='smallgraytext'>Password :</td>
        <td width='60%'><input type='password' name='password' size='20'></td>
      </tr>
      <tr>
        <td width='40%' align='right'>&nbsp;</td>
        <td width='60%'><input type='submit' value=' Login ' name='run' class='button'></td>
      </tr>
    </table>
    </form>
    ";//-htmlTable
} else {

    $runSQL = "select a.id_user, a.id_group, a.username, a.password, a.fullname, a.email, a.telepon, a.created, a.login_count, a.login_access, a.login_ip, b.last_active, b.last_page from sys_username a, sys_visitor b where a.id_user=b.id_user and b.id_session = '$uid'";
	 $result = mysql_query($runSQL, $connDB);
    if ($row = mysql_fetch_array($result)) { }

    $htmlTable = "
    <table border='0' cellpadding='2' cellspacing='0' width='100%'>
      <tr>
        <td width='40%' align='right'><font class='bodytext'>Username :</td>
        <td width='60%'><font class='smallgraytext'>$row[username]</td>
      </tr>
      <tr>
        <td width='40%' align='right'><font class='bodytext'>Fullname :</td>
        <td width='60%'><font class='smallgraytext'>$row[fullname]</td>
      </tr>
      <tr>
        <td width='40%' align='right'><font class='bodytext'>Email :</td>
        <td width='60%'><font class='smallgraytext'>$row[email]</td>
      </tr>
      <tr>
        <td width='40%' align='right'><font class='bodytext'>Telepon :</td>
        <td width='60%'><font class='smallgraytext'>$row[telepon]</td>
      </tr>
      <tr>
        <td width='40%' align='right'><font class='bodytext'>Login Count :</td>
        <td width='60%'><font class='smallgraytext'>$row[login_count]</td>
      </tr>
      <tr>
        <td width='40%' align='right'><font class='bodytext'>Created :</td>
        <td width='60%'><font class='smallgraytext'>$row[created]</td>
      </tr>
      <tr>
        <td width='40%' align='right'><font class='bodytext'>Last Active :</td>
        <td width='60%'><font class='smallgraytext'>$row[last_active]</td>
      </tr>
      <tr>
        <td width='40%' align='right'>&nbsp;</td>
        <td width='60%'><font class='smallgraytext'><a href='?menu=$row[id_menu]&uid=$uid&page=home&cmd=logout' style='text-decoration:none'><b>Logout</b></a></td>
      </tr>
    </table>
		<br>
    ";//-htmlTable
}

?>
<table width="850" border="0" cellspacing="0" cellpadding="0" align="center" vAlign="middle">
  <tr>
   <td width="100%" align="center" vAlign="middle">
	<table border="0" width="100%" border="0" cellspacing="0" cellpadding="10">
	<tr>
		<td width="30%" align="center"> 
			<div id="leftpanel">
				<div align="justify" class="graypanel">
					<span class="smalltitle">Login</span><br><br>
		      <?=$htmlTable;?>
					<span class="smallredtext"><?=getDay($tgl,$bln,$thn).', '.date('d M Y - H:i:s');?></span><br>
					<span class="bodytext">Untuk dapat mengakses halaman ini anda terlebih dulu memasukan username dan password anda dengan benar.</span><br><br>

					<span class="smallredtext">User Terminal</span><br>
					<span class="bodytext">IP Address : <?=$_SERVER["REMOTE_ADDR"];?>,<br> Browser : <?=$_SERVER["HTTP_USER_AGENT"];?></span><br><br>

				</div>
			</div>

		</td>
		<td width="70%" align="center" vAlign="top">
		<?=$web_home_info;?>
	   </td>
	</tr>
	</table>
   </td>
  </tr>
</table>
<p>&nbsp;</p>