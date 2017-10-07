<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 10 Oktober 2010, lastupdate 10 Oktober 2010

// UPDATE ARIETA ADITYA TIMUR

function js_submit()
{
        echo "<script language=javascript>\n";
        echo "function submit_form() {\n";
        echo "  document.forms[0].submit();\n";
        echo "}\n";
        echo "</script>\n";

}
function generate_select_event($name,$sql,$default,$onchange)
{
		$result = mysql_query($sql);
        $nrows=0;
        while ($row = mysql_fetch_array ($result))
        {
                $nrows++;
                $key = $row[0];
                $value = $row[1];
                $arr["$key"] = $value;
        }
        echo "<select name=$name onchange=\"$onchange;\">\n";
        if (!$default) {
                echo "<option value=0>-- Pilih --</option>\n";
        }
        while (list($key,$val) = each($arr))
        {
                if ($default==$key) {
                        echo "<option value=$key selected>$val</option>\n";
                } else {
                        echo "<option value=$key>$val</option>\n";
                }
        }
        echo "</select>";
}

function generate_select($name,$sql,$default)
{

		$result = mysql_query($sql);
        $nrows=0;
        while ($row = mysql_fetch_array ($result))
        {
                $nrows++;
                $key = $row[0];
                $value = $row[1];
                $arr["$key"] = $value;
        }

        echo "<select name=$name>\n";
        while (list($key,$val) = each($arr))
        {
                if ($default==$key) {
                        echo "<option value=$key selected>$val</option>\n";
                } else {
                        echo "<option value=$key>$val</option>\n";
                }
        }
        echo "</select>";
}




$htmlData .= "</td></tr>";//htmlData

include_once("include.php");
$sql="select date_format(a.tanggal,'%d-%m-%Y') tgl_acara,a.tanggal,b.acara,c.nama_cpw,c.nama_cpp from acara a, p_acara b, client c where a.id_client='$id_client' and a.id_acara=b.id_acara and a.id_client=c.id_client";
//echo $sql;
$rs=mysql_query($sql);
$tgl_acara=mysql_result($rs,0,"tgl_acara");
$tgl=mysql_result($rs,0,"tanggal");
?>
<table cellpadding=3 cellspacing=0 style="border-width: 4px;  border-style: double;">
<tr><td>Client</td><td colspan=3>: <?=mysql_result($rs,0,"nama_cpw")?> / <?=mysql_result($rs,0,"nama_cpp")?></td></tr>
<? for($a=0;$a<@mysql_num_rows($rs);$a++){?>
<tr><td>Tanggal</td><td>: <?=mysql_result($rs,$a,"tgl_acara");?></td><td>: <?=mysql_result($rs,$a,"acara")?></td></tr>
<? } ?>
</table><br>

<br/>
<br/>
<br/>
<?

if($act=="proses"){
$konsultasi = str_replace("'","''",$konsultasi);
$konsultasi = stripslashes($konsultasi);
$konsultasi = nl2br($konsultasi);

$sql="insert into konsultasi values ('$id_client',null,now(),'$konsultasi','$SAH[id_user]', '$REMOTE_ADDR', now(),'$client_hadir','$id_pegawai','$status')";
//echo "<br>$sql";
mysql_query($sql);

/*echo "<script type=\"text/javascript\">alert(\"Sudah menugaskan $c pegawai\");</script>";*/
$act=null;
}

if($act=="edit"){
	$runSQL = "SELECT id_konsultasi, tanggal, isi, client_hadir, nama, status FROM konsultasi
        WHERE  id_client='$id_client' and id_konsultasi='$id_konsultasi'";
	$result = mysql_query($runSQL, $connDB);
	if ($row = mysql_fetch_array ($result)) {
		$id_client = $row[id_client];
		$id_konsultasi = $row[id_konsultasi];
		$client_hadir = $row[client_hadir];
		$konsultasi = $row[isi];
		$petugas = $row[petugas];
		$status = $row[status];
		
	};
	
};

$runSQL = "update konsultasi set client_hadir='$client_hadir', isi='$konsultasi', petugas='$sqlpetugas', status='$status' where id_client='$id_client' and id_konsultasi='$id_konsultasi'";
		//echo $runSQL;
		$update = mysql_query($runSQL, $connDB);
	


/*if($act=="hapus"){
//print_r($pegawai);
for($c=0;$c<count($pegawai);$c++){
$sql="delete from pegawai_tugas where id_pegawai='$pegawai[$c]' and id_pekerjaan='$pekerjaan'";
//echo "<br>$sql";
mysql_query($sql);
}
echo "<script type=\"text/javascript\">alert(\"Sudah mengurangi $c pegawai dari tugas\");</script>";
$act="cari";
}*/

if(!$act){

$sql = "SELECT a.tanggal, a.isi, a.client_hadir, b.nama, a.status FROM konsultasi a, pegawai b 
        WHERE a.petugas = b.id_pegawai AND id_client='$id_client' and a.status='Fix' ORDER BY STATUS DESC ";
$rk = mysql_query($sql);
echo "<table width='100%' cellspacing='1' cellpadding='3'>";
echo "<tr bgcolor='#A7A7A7' height='25'>";
echo "<td><b>No</td><td><b>Tanggal</td><td>Client Hadir</td><td>Isi Konsultasi</td><td>Petugas</td><td>Status</td></tr>";
for ($k=0;$k<@mysql_num_rows($rk);$k++){
$ccc++;
    if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
    echo "
      <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
          <td align='center'>".($offsetRecord+$ccc)."</td>";?>
<td><?=mysql_result($rk,$k,"a.tanggal")?></td>
<td><?=mysql_result($rk,$k,"a.client_hadir")?></td>
<td><?=mysql_result($rk,$k,"a.isi")?></td>
<td><?=mysql_result($rk,$k,"b.nama")?></td>
<td><?=mysql_result($rk,$k,"a.status")?></td>

<?
}
echo "</table>";
}
?>

<br/>
<br/>

<form method="post" action="<?="?menu=$menu&uid=$uid&page=$page&act=proses&id_client=$id_client";?>">

<table>
<tr><td>Client Hadir :</td><td><input type="text" name="client_hadir" value="<?=$client_hadir;?>"></td></tr>
<tr><td>Isi Konsultasi :</td><td><textarea rows=3 cols=50 name="konsultasi" value="<?=$nama_cpw;?>"></textarea></td></tr>
<tr><td>Petugas :</td><td>	<?
			$sqlpetugas="select distinct a.id_pegawai,a.nama from pegawai a,pegawai_pekerjaan b
			where a.id_pegawai=b.id_pegawai and b.id_pekerjaan=23 union select 0,'--Pilih Petugas CS--' from dual";
			generate_select("id_pegawai",$sqlpetugas,$id_pegawai);
			?>
<tr><td>Status  :</td><td><select name="status" style="margin:0px;"><option value="Fix"<?php if($status=='Fix'){echo ' selected';};?>>Fix</option><option value="Batal"<?php if($status=='Batal'){echo ' selected';};?>>Batal</option></select>
<tr><td><input type="submit" value="simpan" name="tombol"></td></tr>
</table>
</form>
<br/>
<br/>

<?

$runSQL = "SELECT a.tanggal, a.isi, a.client_hadir, b.nama, a.status FROM konsultasi a, pegawai b 
        WHERE a.petugas = b.id_pegawai AND id_client='$id_client' ORDER BY a.tanggal asc";


//echo $runSQL;


unset($ii);
$runSQL = "SELECT a.id_konsultasi, a.tanggal, a.isi, a.client_hadir, b.nama, a.status FROM konsultasi a, pegawai b 
        WHERE a.petugas = b.id_pegawai AND id_client='$id_client' ORDER BY a.tanggal asc";//echo $runSQL;
$result = mysql_query($runSQL, $connDB);
while ($row = mysql_fetch_array ($result)) {
	$ccc++;
	if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
	$htmlData .= "
	  <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
		  <td align='center'>".($offsetRecord+$ccc)."</td>
		  <td nowrap> $row[tanggal] </td>
		  <td> $row[client_hadir] </td>
		  <td> $row[isi] </td>
		  <td> $row[nama] </td>
		  <td nowrap> $row[status] </td>
		 ";
/*
$rch=mysql_query("select tanggal from acara where id_client='$row[id_client]' order by created desc");
$nc=@mysql_num_rows($rch);
if($nc!=0){
  $tg=mysql_result($rch,0,"tanggal");    
} else {
  $tg=$row[tgl_rencana];
}*/
if($SAH[id_group]==1){
$htmlData .= "</td><td align='center' nowrap>";
$htmlData .= "


<a href=\"javascript:void(window.open('assign_konsultasi.php?id_client=$id_client&id_konsultasi=$row[id_konsultasi]','operator','toolbar=0,width=500,height=400,top=0, left=60'));\"><img border='0' src='images/edit.gif' title='Edit Data'></a>";
		  
}
$htmlData .= "</td></tr>";//htmlData
};//end-while

?>		



<table width='100%' cellspacing='1' cellpadding='3'>

		<tr bgcolor='#A7A7A7' height="25">
			<td align='center'>NO</td>
			<td align='center'>TANGGAL</td>
			<td align='center'>CLIENT HADIR</td>
			<td align='center'>ISI KONSULTASI</td>
			<td align='center'>PETUGAS</td>
			<td align='center'>STATUS</td>
			<? if($SAH[id_group]==1){ ?>
			<td align='center'>EDIT</td>
			<? } ?>
		</tr>
		<?	if($act!="cari"){
				echo $htmlData;
			}?>
		
	 </table>