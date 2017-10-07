<?php 
// Penerimaan Siswa Baru
// Author (c) 2009 http://iyok642.blogspot.com/
// Written by Priyo Setiawan (iyok642@yahoo.com;031-70920002)
// 07 April 2009, lastupdate 07 April 2009
include_once("include.php");

if ((strlen($run) < 1) and ($id <> "")){ 
	$runSQL = "select id_user, id_group, username, password, fullname, email, telepon, active  from sys_username where id_user='$id'";
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id_group = $row[id_group];
		$username = $row[username];
		$fullname = $row[fullname];
		$email    = $row[email];
		$telepon  = $row[telepon];
		$active   = $row[active];
		$readOnly = "readOnly";
	};//if
};//if-id

if (strlen($run) > 1){ 
	$ok = 1;
	$ip_address = getenv("REMOTE_ADDR");
	$username = strtolower($username);
	if ($id == ""){
		$runSQL = "select count(*) terpakai from sys_username where username='$username'";
		$result = mysql_query($runSQL, $connDB);
		if ($row = mysql_fetch_array ($result)) { $terpakai = $row[terpakai]; }
		if (strlen($password) < 2){ $ipassword = "<br><font color='#FF0000' size='1'><i>* Password tidak valid"; $ok=0; }
	};
	if (strlen($username) < 2){ $iusername = "<br><font color='#FF0000' size='1'><i>* Username tidak valid"; $ok=0; }
	if ($terpakai > 0){ $iusername = "<br><font color='#FF0000' size='1'><i>* Username telah terpakai"; $ok=0; }
	if (strlen($fullname) < 3){ $ifullname = "<br><font color='#FF0000' size='1'><i>* Fullname tidak valid"; $ok=0; }
	//if (strlen($email) < 5){ $iemail = "<br><font color='#FF0000' size='1'><i>* Alamat Email tidak valid"; $ok=0; }
	if ((($telepon*1) < 111111111) or (($telepon*1) > 99999999999) or (substr($telepon,0,1)<>"0")){ $itelepon = "<br><font color='#FF0000' size='1'><i>* Telepon tidak valid"; $ok=0; }
	if ($password <> $password2){ $ipassword = "<br><font color='#FF0000' size='1'><i>* Password dan Password Lagi tidak cocok"; $ok=0; }

	if (($ok == 1) and ($id == "")){
		$registerInvalid = 1;
		$password = md5($password);
		$runSQL = "insert into sys_username (id_group, username, password, fullname, email, telepon, created, login_count, login_access, login_ip, active) VALUES ('$id_group', '$username', '$password', '$fullname', '$email', '$telepon', now(), 0, NULL, NULL, 1)";
		//echo $runSQL;
		$insert = mysql_query($runSQL, $connDB);
	} else if (($ok == 1) and ($id <> "")){
		$registerInvalid = 1;
		if ($password <> ""){ $updatePassword = "password='".md5($password)."', "; };
		$runSQL = "update sys_username set id_group='$id_group', username='$username', $updatePassword fullname='$fullname', email='$email', telepon='$telepon', active='$active' where id_user='$id'";
		//echo $runSQL;
		$update = mysql_query($runSQL, $connDB);
	};//if
};//end-if-submit

unset($ii);
$runSQL = "select id_group, nama_group, keterangan from sys_group";
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) {
   $ii++; if ((($ii == 1) and ($id_group=="")) or ($id_group==$row[id_group])) { $cek="selected"; $id_group=$row[id_group]; }else{ unset($cek); }
	$selectgroup .= "<option value='".$row[id_group]."' $cek>$row[nama_group]</option>\n"; 
};//while
$selectgroup = "<select size=1 name='id_group' class='edyellow'> $selectgroup </select>";

if ($active == ""){ $active = 1; }
$arr_status = array("Disable", "Active");
for ($i=0; $i<count($arr_status); $i++){ 
  if ($active == $i) { $cek="selected"; $active=$i; }else{ unset($cek); }
  $selectstatus .= "<option value='$i' $cek>".$arr_status[$i]."</option>\n"; 
};
$selectstatus = "<select size=1 name='active' class='edyellow'> $selectstatus </select>";

if ($registerInvalid <> 1){
?>
<table border="0" width="100%" height="100%" cellspacing="0" cellpadding="0" align="center" vAlign="middle">
  <tr>
    <td width="100%"  height="100%" align="center" vAlign="middle">
    <form method="POST" name="form" action="<?="?menu=$menu&uid=$uid&page=$page";?>">
    <table border="0" cellpadding="5" cellspacing="0" width="650">
      <tr>
        <td width="100%" colspan="3" align="center"><b>Input Username</td>
      </tr>
      <tr><td width="100%" colspan="2"><hr size="1" color="#0000FF"></td></tr>
      <tr>
        <td width="40%" align="right">Username</td>
        <td width="60%"><input <?=$readOnly;?> type="text" name="username" size="20" value="<?=htmlentities(stripslashes($username));?>"><?=$iusername;?></td>
      </tr>
      <tr>
        <td width="40%" align="right">Password</td>
        <td width="60%"><input type="password" name="password" size="30" value="<?=htmlentities(stripslashes($password));?>"><?=$ipassword;?></td>
      </tr>
      <tr>
        <td width="40%" align="right">Password Lagi</td>
        <td width="60%"><input type="password" name="password2" size="30" value="<?=htmlentities(stripslashes($password2));?>"></td>
      </tr>
      <tr>
        <td width="40%" align="right"></td>
        <td width="60%">Biarkan kolom password kosong iika tidak ingin merubah. 
		  <br>Untuk input username baru kolom password harus diisi.</td>
      </tr>
      <tr>
        <td width="40%" align="right">Fullname</td>
        <td width="60%"><input type="text" name="fullname" size="45" value="<?=htmlentities(stripslashes($fullname));?>"><?=$ifullname;?></td>
      </tr>
      <tr>
        <td width="40%" align="right">Email</td>
        <td width="60%"><input type="text" name="email" size="45" value="<?=htmlentities(stripslashes($email));?>"><?=$iemail;?></td>
      </tr>
      <tr>
        <td width="40%" align="right">Telepon</td>
        <td width="60%"><input type="text" name="telepon" size="20" value="<?=htmlentities(stripslashes($telepon));?>"><?=$itelepon;?></td>
      </tr>
      <tr>
        <td width="40%" align="right">Group</td>
        <td width="60%"><?=$selectgroup;?></td>
      </tr>
      <tr>
        <td width="40%" align="right">Status</td>
        <td width="60%"><?=$selectstatus;?></td>
      </tr>
      <tr><td width="100%" colspan="2"><hr size="1" color="#0000FF"></td></tr>
      <tr>
        <td width="100%" colspan="2" align="center">
			<input type="hidden" name="id" value="<?=$id;?>"><br><br>
			<input type="submit" value="Simpan" name="run" class="button"><br><br>
	     </td>
      </tr>
    </table>
   </form>
	[ <a href="<?="?menu=$menu&uid=$uid&page=username";?>">Lihat Data</a> ]
   </td>
  </tr>
</table>
<?

} else {
//registerInvalid
?>

<table border="0" width="100%" height="100%" cellspacing="0" cellpadding="0" align="center" vAlign="middle">
  <tr>
   <td width="100%"  height="100%" align="center" vAlign="middle">
   <table border="0" cellpadding="3" cellspacing="0" width="500">
     <tr><td width="100%" colspan="3" align="center"><b>Telah Disimpan</td></tr>
     <tr><td width="100%" colspan="3"><hr size="1" color="#0000FF"></td></tr>
     <tr>
	     <td width="100%" height='30' colspan="3" align='center'>
	     Input/Edit Data Telah Disimpan<br><br>
	     [ <a href="<?="?menu=$menu&uid=$uid&page=username_input";?>">Input Lagi</a> | <a href="<?="?menu=$menu&uid=$uid&page=username";?>">Lihat Data</a> ]
	     <br><br><br><br>
	     </td>
	  </tr>
    </table>
   </td>
  </tr>
</table>

<? };//registerInvalid ?>