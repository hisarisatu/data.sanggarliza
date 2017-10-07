<? 
// Sisten Informasi Sanggar LIZA
// Written by agusari@gmail.com
// 10 Oktober 2010, lastupdate 10 Oktober 2010

include_once("include.php");

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

<form method="post" action="<?="?menu=$menu&uid=$uid&page=client_konsultasi&act=proses&id_client=$id_client";?>" enctype="multipart/form-data">
<table>
<tr><td>Client Hadir :</td><td><input type="text" name="client_hadir" value="<?=$hadir;?>"></td></tr>
<tr><td>Isi Konsultasi :</td><td><textarea rows=3 cols=50 name="konsultasi" ><?=$isi_konsul;?></textarea></td></tr>
<tr><td>Petugas :</td><td>	<?
			$sqlpetugas="select distinct a.id_pegawai,a.nama from pegawai a,pegawai_pekerjaan b
			where a.id_pegawai=b.id_pegawai and b.id_pekerjaan=23 union select 0,'--Pilih Petugas CS--' from dual";
			generate_select("id_pegawai",$sqlpetugas,$id_pegawai);
			?></td></tr>
<tr><td>Attachment :</td><td><input type="file" name="gambar"></td></tr>
<tr><td>&nbsp;</td>
<td>
<? if ($gambar <> "") { ?>
    <img src="konsulimg/<?php echo $gambar; ?>" width="200" height="180"></td>
<? } else { ?>
    <p>&nbsp;</p>
<? } ?>
</tr>

<tr><td><input type="submit" value="simpan" name="tombol"></td></tr>
</table>
</form>
<?

if($act=="proses"){
$konsultasi = str_replace("'","''",$konsultasi);
$konsultasi = stripslashes($konsultasi);
$konsultasi = nl2br($konsultasi);
$gambar     = $_FILES['gambar']['name'];

if(strlen($gambar)>0){

    $errors= array();
    $file_size = $_FILES['gambar']['size'];
    $file_tmp  = $_FILES['gambar']['tmp_name'];
    $file_type = $_FILES['gambar']['type'];
    $file_ext  = strtolower(end(explode('.',$_FILES['gambar']['name'])));
      
    $expensions    = array("jpeg","jpg","png");
      
    if(in_array($file_ext,$expensions)=== false) {

        $errors[]="extension not allowed, please choose a JPEG or PNG file.";
    }
      
    if($file_size > 4097152){

        $errors[]='File size must be excately 2 MB';
    }
      
    if(empty($errors)==true){
        move_uploaded_file($file_tmp,"konsulimg/".$gambar);

    } else{
              
        print_r($errors);
    }

    $sql="insert into konsultasi 
(id_client,id_konsultasi,tanggal,isi,gambar,id_user,login_ip,created,Client_hadir,Petugas)
values ('$id_client',null,now(),'$konsultasi','$gambar','$SAH[id_user]', '$REMOTE_ADDR', now(),'$client_hadir','$id_pegawai')";
//echo "<br>$sql";
mysql_query($sql);
echo "<meta http-equiv='refresh' content='0; URL=?menu=$menu&uid=$uid&page=client_konsultasi&id_client=$id_client'>";

} else {

    $sql="insert into konsultasi 
(id_client,id_konsultasi,tanggal,isi,id_user,login_ip,created,Client_hadir,Petugas)
values ('$id_client',null,now(),'$konsultasi','$SAH[id_user]', '$REMOTE_ADDR', now(),'$client_hadir','$id_pegawai')";  

mysql_query($sql);
echo "<meta http-equiv='refresh' content='0; URL=?menu=$menu&uid=$uid&page=client_konsultasi&id_client=$id_client'>";

} 

//echo "<script type=\"text/javascript\">alert(\"Sudah menugaskan $c pegawai\");</script>";
$act=null;
}

if($act=="hapus"){
//print_r($pegawai);
for($c=0;$c<count($pegawai);$c++){
$sql="delete from pegawai_tugas where id_pegawai='$pegawai[$c]' and id_pekerjaan='$pekerjaan'";
//echo "<br>$sql";

mysql_query($sql);
}
echo "<script type=\"text/javascript\">alert(\"Sudah mengurangi $c pegawai dari tugas\");</script>";
$act="cari";
}

if(!$act){

if (!$id_konsul){$id_konsul='%';}

$sql = "select tanggal tgl_konsul,id_konsultasi, isi,gambar,
client_hadir,petugas,nama,id_client
from konsultasi a,pegawai b
WHERE a.petugas = b.id_pegawai 
AND id_client='$id_client'
and id_konsultasi like '$id_konsul'
order by id_konsultasi desc";
$rk = mysql_query($sql);
echo "<table width='100%' cellspacing='1' cellpadding='3'>";
echo "<tr bgcolor='#A7A7A7' height='25'>";
echo "<td><b>No</td><td><b>Tanggal</td><td>Client Hadir</td><td>Isi Konsultasi</td><td>Petugas CS</td><td>Update</td></tr>";
for ($k=0;$k<@mysql_num_rows($rk);$k++){
$ccc++;
    if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
    echo "
      <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
          <td align='center'>".($offsetRecord+$ccc)."</td>";?>
<td><?=mysql_result($rk,$k,"tgl_konsul")?></td>
<td><?=mysql_result($rk,$k,"client_hadir")?></td>
<td><?=mysql_result($rk,$k,"isi")?></td>
<td><?=mysql_result($rk,$k,"nama")?></td>
<td><a href='?menu=$menu&uid=<?=$uid?>&page=client_konsultasi&id_client=<?=mysql_result($rk,$k,"id_client")?>
&id_konsul=<?=mysql_result($rk,$k,"id_konsultasi")?>
&hadir=<?=mysql_result($rk,$k,"client_hadir")?>
&isi_konsul=<?=mysql_result($rk,$k,"isi") ?>
&gambar=<?=mysql_result($rk,$k,"gambar")?>
&id_pegawai=<?=mysql_result($rk,$k,"petugas")?>
'>
<img border='0' src='images/edit.gif' title='Edit Data'></a></td>
</tr>
<?
}
echo "</table>";
}
?>