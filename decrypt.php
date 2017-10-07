<?php 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 10 Oktober 2010, lastupdate 10 Oktober 2010

include_once("include.php");

$test = "select password FROM sys_username where password = DECODE('eee4238e5340a6866d4707e7c4249337')";
$go=mysql_query($test);

$row = mysql_fetch_array($go);

echo $row['password'];

?>

