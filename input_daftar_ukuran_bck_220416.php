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
        /*
        if (!$default) {
                echo "<option value=0>-- Pilih --</option>\n";
        }*/
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


$sql="select date_format(a.tanggal,'%d-%m-%Y') tgl_acara,a.tanggal,b.acara,c.nama_cpw,c.nama_cpp,
waktu,tempat 
from acara a, p_acara b, client c 
where a.id_client='$id_client' 
and a.id_acara='$id_acara'
and a.id_acara=b.id_acara 
and a.id_client=c.id_client";
//echo $sql;
$rs=mysql_query($sql);
$tgl_acara=mysql_result($rs,0,"tgl_acara");
$tgl=mysql_result($rs,0,"tanggal");
?>
<table cellpadding=3 cellspacing=0 style="border-width: 4px;  border-style: double;">
<tr><td>Client</td><td colspan=3>: <?=mysql_result($rs,0,"nama_cpw")?> / <?=mysql_result($rs,0,"nama_cpp")?></td></tr>
<? for($a=0;$a<@mysql_num_rows($rs);$a++){?>
<tr><td>Tanggal</td><td>: <?=mysql_result($rs,$a,"tgl_acara");?> &nbspJam: <?=mysql_result($rs,$a,"waktu")?></td></tr>
<tr><td>Acara</td><td>: <?=mysql_result($rs,$a,"acara");?></td></tr>
<tr><td>lokasi</td><td>: <?=mysql_result($rs,$a,"tempat");?></td></tr>
<tr><td>Busana</td><td>: <?=$detail_layanan;?>&nbsp<?=$jml_busana;?>&nbsp Set</td></tr>
<? } ?>
</table><br>
<form method="post" action="<?="?menu=$menu&uid=$uid&page=input_daftar_ukuran&act=proses&detail_layanan=$detail_layanan&jml_busana=$jml_busana&id_acara=$id_acara&id_client=$id_client&id_paket=$id_paket&id_sublayanan=$id_sublayanan&jenis_daftar=$jenis_daftar";?>">
<table>
<tr><td>Jenis Daftar Ukuran </td><td>:	<?
			$sqljenis="select 1,'Pria' from dual union select 2,'Wanita' from Dual union select 0,'--Pilih Jenis Daftar---' from dual";
			generate_select_event("jenis_daftar",$sqljenis,$jenis_daftar,"submit_form()");
			?></td></tr>
<? js_submit();
if ($jenis_daftar==1) { ?>			
<tr><td>Nama </td><td>:&nbsp<input type="text" name="nama" size="60" value="<?=$nama;?>"></td></tr>
<tr><td>Jabatan </td><td>:	<?
			$sqljabatan="select id_jabatan,nama_jabatan from p_jabatan union select 0,'--Pilih Jabatan--' from dual";
			generate_select("id_jabatan",$sqljabatan,$id_jabatan);
			?></td></tr>
<tr><td>Asal Pihak Keluarga </td><td>:	<?
			$sqlpihak="select 1,'CPP' from dual 
			union select 2,'CPW' from Dual 
			union select 3,'ALL' from Dual 
			union select 0,'--Pilih Pihak Keluarga--' from dual";
			generate_select("asal_pihak",$sqlpihak,$asal_pihak);
			?></td></tr>
<tr><td>Ukuran Beskap </td><td>:	<?
			$sqlbeskap="select 1,'L1' from dual 
			union select 2,'L2' from dual
			union select 3,'L3' from dual
			union select 4,'L4' from dual
			union select 5,'L5' from dual
			union select 6,'L6' from dual
			union select 7,'L7' from dual
			union select 8,'L8' from dual
			union select 25,'L9' from dual
			union select 9,'S' from dual
			union select 10,'M' from dual
			union select 11,'L' from dual
			union select 12,'XL' from dual
			union select 13,'XLL' from dual
			union select 55,'--Pilih Ukuran Beskap--' from dual";
			generate_select("ukuran_beskap",$sqlbeskap,$ukuran_beskap);
			?></td></tr>
<tr><td>Ukuran Blangkon </td><td>:	<?
			$sqlblangkon="select 14,'55' from dual 
			union select 15,'56' from dual
			union select 16,'57' from dual
			union select 17,'58' from dual
			union select 18,'59' from dual
			union select 19,'60' from dual
			union select 20,'61' from dual
			union select 21,'62' from dual
			union select 22,'63' from dual
			union select 23,'64' from dual
			union select 55,'-Pilih Ukuran Blangkon-' from dual";
			generate_select("ukuran_blangkon",$sqlblangkon,$ukuran_blangkon);
			?></td></tr>
<tr><td>Ukuran Selop </td><td>:	<?
			$sqlselop="select 32,'26' from dual 
			union select 33,'27' from dual
			union select 34,'28' from dual
			union select 35,'29' from dual
			union select 36,'30' from dual
			union select 37,'31' from dual
			union select 38,'32' from dual
			union select 39,'33' from dual
			union select 40,'34' from dual
			union select 41,'35' from dual
			union select 42,'36' from dual
			union select 43,'37' from dual
			union select 44,'38' from dual
			union select 45,'39' from dual
			union select 46,'40' from dual
			union select 47,'41' from dual
			union select 48,'42' from dual
			union select 49,'43' from dual
			union select 50,'44' from dual
			union select 51,'45' from dual
			union select 52,'46' from dual
			union select 53,'47' from dual
			union select 54,'48' from dual
			union select 55,'--Pilih Ukuran Selop---' from dual";
			generate_select("ukuran_selop",$sqlselop,$ukuran_selop);
			?></td></tr>							
<? }
else if ($jenis_daftar==2) { ?>
<tr><td>Nama </td><td>:&nbsp<input type="text" name="nama" size="60" value="<?=$nama;?>"></td></tr>
<tr><td>Jabatan </td><td>:	<?
			$sqljabatan="select id_jabatan,nama_jabatan from p_jabatan union select 0,'--Pilih Jabatan--' from dual";
			generate_select("id_jabatan",$sqljabatan,$id_jabatan);
			?></td></tr>
<tr><td>Asal Pihak Keluarga </td><td>:	<?
			$sqlpihak="select 1,'CPP' from dual 
			union select 2,'CPW' from Dual 
			union select 3,'ALL' from Dual 
			union select 0,'--Pilih Pihak Keluarga--' from dual";
			generate_select("asal_pihak",$sqlpihak,$asal_pihak);
			?></td></tr>
<tr><td>Hair Do </td><td>:	<?
			$sqlhair="select id_sanggul,model_sanggul from p_model_sanggul
			union select 0,'--Pilih Model sanggul--' from dual";
			generate_select("id_sanggul",$sqlhair,$id_sanggul);
			?></td></tr>
<tr><td>Status Rias </td><td>:	<?
			$sqljenisrias="select 1,'Rias STD' from dual 
			union select 2,'Rias SP' from dual
			union select 3,'Tidak Rias' from dual
			union select 0,'--Pilih Jenis Rias--' from dual";
			generate_select("jenis_rias",$sqljenisrias,$jenis_rias);
			?></td></tr>	
<tr><td>Pakai Kain </td><td>:	<?
			$sqlpakaikain="select 1,'Ya' from dual 
			union select 2,'Tidak' from dual
			union select 0,'--Pilih Pakai Kain--' from dual";
			generate_select("pakai_kain",$sqlpakaikain,$pakai_kain);
			?></td></tr>		
<tr><td>Pakai kebaya </td><td>:	<?
			$sqlpakaikebaya="select 1,'Ya' from dual 
			union select 2,'Tidak' from dual
			union select 0,'--Pilih Pakai Kebaya--' from dual";
			generate_select("pakai_kebaya",$sqlpakaikebaya,$pakai_kebaya);
			?></td></tr>										
<tr><td>Pakai Assesoris </td><td>:	<?
			$sqlpakaiacc="select 1,'Ya' from dual 
			union select 2,'Tidak' from dual
			union select 0,'--Pilih Pakai Assesoris--' from dual";
			generate_select("pakai_acc",$sqlpakaiacc,$pakai_acc);
			?></td></tr>		
<tr><td>Ukuran Kebaya </td><td>:	<?
			$sqlkebaya="select 1,'L1' from dual 
			union select 2,'L2' from dual
			union select 3,'L3' from dual
			union select 4,'L4' from dual
			union select 5,'L5' from dual
			union select 6,'L6' from dual
			union select 7,'L7' from dual
			union select 8,'L8' from dual
			union select 25,'L9' from dual
			union select 9,'S' from dual
			union select 10,'M' from dual
			union select 11,'L' from dual
			union select 12,'XL' from dual
			union select 13,'XLL' from dual
			union select 0,'--Pilih Ukuran Kebaya--' from dual";
			generate_select("ukuran_kebaya",$sqlkebaya,$ukuran_kebaya);
			?></td></tr>									
											
<? }; ?>			
<tr><td><input type="submit" value="simpan" name="tombol"></td></tr>
<input type="hidden" name="id_ukur" value="<?=$id_ukur;?>">
<input type="hidden" name="act" value="<?=$act;?>">
</table>
</form>
<?

if($tombol){

if ($jenis_daftar==1) 
{
$sqlcek="select count(*) jumlah from daftar_ukuran_pria 
where id_client='$id_client'
and id_acara='$id_acara'
and id_sublayanan='$id_sublayanan' ";
$rx=mysql_query($sqlcek);
$jumlah=mysql_result($rx,0,"jumlah");

if($act=="update")
{ 
$sqlupd="update daftar_ukuran_pria set
nama='$nama',id_jabatan=$id_jabatan,asal_keluarga=$asal_pihak,ukuran_beskap=$ukuran_beskap,ukuran_blangkon=$ukuran_blangkon,ukuran_selop=$ukuran_selop
where id_ukur=$id_ukur";
mysql_query($sqlupd);
$act=null;
//echo "<br>$sqlupd";
} else {
if ($jumlah<$jml_busana)
{
$sql="insert into daftar_ukuran_pria 
(id_client,id_acara,id_paket,id_sublayanan,nama,id_jabatan,asal_keluarga,ukuran_beskap,ukuran_blangkon,ukuran_selop)
values ($id_client,$id_acara,$id_paket,$id_sublayanan,'$nama',$id_jabatan,$asal_pihak,$ukuran_beskap,$ukuran_blangkon,$ukuran_selop)";
} else 
{echo "Maaf Jumlah Daftar Ukuran Sdh lengkap dengan Jumlah Pesanan, Gunakan menu Update untuk memasukan ukuran Baru.... ";}
};
} 
else if ($jenis_daftar==2) 
{
$sqlcek="select count(*) jumlah from daftar_ukuran_wanita 
where id_client='$id_client'
and id_acara='$id_acara'
and id_sublayanan='$id_sublayanan' ";
$rx=mysql_query($sqlcek);
$jumlah=mysql_result($rx,0,"jumlah");

if($act=="update")
{ 
$sqlupd="update daftar_ukuran_wanita set
nama='$nama',id_jabatan=$id_jabatan,asal_keluarga=$asal_pihak,
id_sanggul=$id_sanggul,jenis_rias=$jenis_rias,pakai_kain=$pakai_kain,
pakai_kebaya=$pakai_kebaya,pakai_acc=pakai_acc,ukuran_kebaya=$ukuran_kebaya
where id_ukur=$id_ukur";
mysql_query($sqlupd);
//echo "<br>$sqlupd";
$act=null;
} else {
if ($jumlah<$jml_busana)
{
$sql="insert into daftar_ukuran_wanita 
(id_client,id_acara,id_paket,id_sublayanan,nama,id_jabatan,asal_keluarga,id_sanggul,jenis_rias,pakai_kain,pakai_kebaya,pakai_acc,ukuran_kebaya)
values ($id_client,$id_acara,$id_paket,$id_sublayanan,'$nama',$id_jabatan,$asal_pihak,$id_sanggul,$jenis_rias,$pakai_kain,$pakai_kebaya,$pakai_acc,$ukuran_kebaya)";
} else 
{echo "<br>Maaf Jumlah Daftar Ukuran Sdh lengkap dengan Jumlah Pesanan, Gunakan menu Update untuk memasukan ukuran Baru....";}
};
}
//echo "<br>$sql";
mysql_query($sql);
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



if ($jenis_daftar==1) 
{
if (!$id_ukur){$id_ukur='%';}

$sql = "
select id_client,id_acara,id_sublayanan,a.id_jabatan as id_jabatan,id_ukur,nama,nama_jabatan,
case 
when asal_keluarga=1 then 'CPP'
when asal_keluarga=2 then 'CPW'
when asal_keluarga=1 then 'Non CPP/CPW'
end as asal_keluarga,asal_keluarga as asal_keluarga1,
case 
when ukuran_beskap=1 then 'L1'
when ukuran_beskap=2 then 'L2'
when ukuran_beskap=3 then 'L3'
when ukuran_beskap=4 then 'L4'
when ukuran_beskap=5 then 'L5'
when ukuran_beskap=6 then 'L6'
when ukuran_beskap=7 then 'L7'
when ukuran_beskap=8 then 'L8'
when ukuran_beskap=25 then 'L9'
when ukuran_beskap=9 then 'S'
when ukuran_beskap=10 then 'M'
when ukuran_beskap=11 then 'L'
when ukuran_beskap=12 then 'XL'
when ukuran_beskap=13 then 'XXL'
when ukuran_beskap=55 then '-'
end as ukuran_beskap,ukuran_beskap as ukuran_beskap1,
case
when ukuran_blangkon = 14 then 55
when ukuran_blangkon = 15 then 56
when ukuran_blangkon = 16 then 57
when ukuran_blangkon = 17 then 58
when ukuran_blangkon = 18 then 59
when ukuran_blangkon = 19 then 60
when ukuran_blangkon = 20 then 61
when ukuran_blangkon = 21 then 62
when ukuran_blangkon = 22 then 63
when ukuran_blangkon = 23 then 64
when ukuran_blangkon = 55 then '-'
end as ukuran_blangkon
,
case
when ukuran_selop =32 then 26
when ukuran_selop =33 then 27
when ukuran_selop =34 then 28
when ukuran_selop =35 then 29
when ukuran_selop =36 then 30
when ukuran_selop =37 then 31
when ukuran_selop =38 then 32
when ukuran_selop =39 then 33
when ukuran_selop =40 then 34
when ukuran_selop =41 then 35
when ukuran_selop =42 then 36
when ukuran_selop =43 then 37
when ukuran_selop =44 then 38
when ukuran_selop =45 then 39
when ukuran_selop =46 then 40
when ukuran_selop =47 then 41
when ukuran_selop =48 then 42
when ukuran_selop =49 then 43
when ukuran_selop =50 then 44
when ukuran_selop =51 then 45
when ukuran_selop =52 then 46
when ukuran_selop =53 then 47
when ukuran_selop =54 then 48
when ukuran_selop =55 then '-'
end as ukuran_selop
from daftar_ukuran_pria a,p_jabatan b
where a.id_jabatan=b.id_jabatan
and id_client='$id_client'
and id_acara='$id_acara'
and id_ukur like '$id_ukur'
and id_sublayanan='$id_sublayanan'";
$rk = mysql_query($sql);
echo "<br>";
echo "<table width='100%' cellspacing='1' cellpadding='3'>";
echo "<tr bgcolor='#A7A7A7' height='25'>";
echo "<td><b>No</td><td><b>Nama</td><td>Jabatan</td><td>Asal Keluarga</td><td>Ukuran Beskap</td><td>Ukuran Blangkon</td><td>Ukuran Selop</td><td>Update</td></tr>";
for ($k=0;$k<@mysql_num_rows($rk);$k++){
$ccc++;
    if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
    echo "
      <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
          <td align='center'>".($offsetRecord+$ccc)."</td>";?>
<td><?=mysql_result($rk,$k,"nama")?></td>
<td><?=mysql_result($rk,$k,"nama_jabatan")?></td>
<td><?=mysql_result($rk,$k,"asal_keluarga")?></td>
<td><?=mysql_result($rk,$k,"ukuran_beskap")?></td>
<td><?=mysql_result($rk,$k,"ukuran_blangkon")?></td>
<td><?=mysql_result($rk,$k,"ukuran_selop")?></td>
<td><a href='?menu=$menu&uid=<?=$uid?>&page=input_daftar_ukuran
&id_client=<?=mysql_result($rk,$k,"id_client")?>
&id_acara=<?=mysql_result($rk,$k,"id_acara")?>
&id_sublayanan=<?=mysql_result($rk,$k,"id_sublayanan")?>
&nama=<?=mysql_result($rk,$k,"nama")?>
&id_jabatan=<?=mysql_result($rk,$k,"id_jabatan")?>
&asal_pihak=<?=mysql_result($rk,$k,"asal_keluarga1")?>
&ukuran_beskap=<?=mysql_result($rk,$k,"ukuran_beskap1")?>
&ukuran_blangkon=<?=mysql_result($rk,$k,"ukuran_blangkon")?>
&ukuran_selop=<?=mysql_result($rk,$k,"ukuran_selop")?>
&id_ukur=<?=mysql_result($rk,$k,"id_ukur")?>
&jenis_daftar=<?=$jenis_daftar;?>
&detail_layanan=<?=$detail_layanan;?>
&jml_busana=<?=$jml_busana;?>
&act=update
'>
<img border='0' src='images/edit.gif' title='Edit Data'></a></td>
</tr>
<?
}
echo "</table>";
} else if ($jenis_daftar==2) 

{
if (!$id_ukur){$id_ukur='%';}

$sql = "
select id_client,id_acara,id_sublayanan,nama,a.id_jabatan as id_jabatan,id_ukur,a.id_sanggul as id_sanggul,nama_jabatan,
case 
when asal_keluarga=1 then 'CPP'
when asal_keluarga=2 then 'CPW'
when asal_keluarga=1 then 'Non CPP/CPW'
end as asal_keluarga,asal_keluarga as asal_keluarga1,
model_sanggul,
case when Jenis_rias=1 then 'Rias STD'
when jenis_rias=2 then 'Rias SP'
when jenis_rias=3 then'Tidak Rias'
end as jenis_rias,jenis_rias as jenis_rias1,
case when pakai_kain=1 then 'YA'
when pakai_kain=2 then 'TIDAK'
end as pakai_kain,pakai_kain as pakai_kain1,
case when pakai_kebaya=1 then 'YA'
when pakai_kebaya=2 then 'TIDAK'
end as pakai_kebaya,pakai_kebaya as pakai_kebaya1,
case when pakai_acc=1 then 'YA'
when pakai_acc=2 then 'TIDAK'
end as pakai_acc,pakai_acc as pakai_acc1,
case 
when ukuran_kebaya=1 then 'L1'
when ukuran_kebaya=2 then 'L2'
when ukuran_kebaya=3 then 'L3'
when ukuran_kebaya=4 then 'L4'
when ukuran_kebaya=5 then 'L5'
when ukuran_kebaya=6 then 'L6'
when ukuran_kebaya=7 then 'L7'
when ukuran_kebaya=8 then 'L8'
when ukuran_kebaya=25 then 'L9'
when ukuran_kebaya=9 then 'S'
when ukuran_kebaya=10 then 'M'
when ukuran_kebaya=11 then 'L'
when ukuran_kebaya=12 then 'XL'
when ukuran_kebaya=13 then 'XXL'
end as ukuran_kebaya
from daftar_ukuran_wanita a,p_jabatan b,p_model_sanggul c
where a.id_jabatan=b.id_jabatan
and a.id_sanggul=c.id_sanggul
and id_client='$id_client'
and id_acara='$id_acara'
and id_ukur like '$id_ukur'
and id_sublayanan='$id_sublayanan'";
$rk = mysql_query($sql);
//echo "<br>$sql";
echo "<br>";
echo "<table width='100%' cellspacing='1' cellpadding='3'>";
echo "<tr bgcolor='#A7A7A7' height='25'>";
echo "<td><b>No</td><td><b>Nama</td><td>Jabatan</td><td>Asal Keluarga</td><td>Model Sanggul</td><td>Jenis Rias</td><td>Pakai Kain</td><td>Pakai Kebaya</td><td>Pakai Accesoris</td><td>Ukuran Kebaya</td><td>Update</td></tr>";
for ($k=0;$k<@mysql_num_rows($rk);$k++){
$ccc++;
    if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
    echo "
      <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
          <td align='center'>".($offsetRecord+$ccc)."</td>";?>
<td><?=mysql_result($rk,$k,"nama")?></td>
<td><?=mysql_result($rk,$k,"nama_jabatan")?></td>
<td><?=mysql_result($rk,$k,"asal_keluarga")?></td>
<td><?=mysql_result($rk,$k,"model_sanggul")?></td>
<td><?=mysql_result($rk,$k,"jenis_rias")?></td>
<td><?=mysql_result($rk,$k,"pakai_kain")?></td>
<td><?=mysql_result($rk,$k,"pakai_kebaya")?></td>
<td><?=mysql_result($rk,$k,"pakai_acc")?></td>
<td><?=mysql_result($rk,$k,"ukuran_kebaya")?></td>
<td><a href='?menu=$menu&uid=<?=$uid?>&page=input_daftar_ukuran
&id_client=<?=mysql_result($rk,$k,"id_client")?>
&id_acara=<?=mysql_result($rk,$k,"id_acara")?>
&id_sublayanan=<?=mysql_result($rk,$k,"id_sublayanan")?>
&nama=<?=mysql_result($rk,$k,"nama")?>
&id_jabatan=<?=mysql_result($rk,$k,"id_jabatan")?>
&asal_pihak=<?=mysql_result($rk,$k,"asal_keluarga1")?>
&id_sanggul=<?=mysql_result($rk,$k,"id_sanggul")?>
&jenis_rias=<?=mysql_result($rk,$k,"jenis_rias1")?>
&pakai_kain=<?=mysql_result($rk,$k,"Pakai_kain1")?>
&pakai_kebaya=<?=mysql_result($rk,$k,"Pakai_kebaya1")?>
&pakai_acc=<?=mysql_result($rk,$k,"Pakai_acc1")?>
&ukuran_kebaya=<?=mysql_result($rk,$k,"ukuran_kebaya")?>
&id_ukur=<?=mysql_result($rk,$k,"id_ukur")?>
&jenis_daftar=<?=$jenis_daftar;?>
&detail_layanan=<?=$detail_layanan;?>
&jml_busana=<?=$jml_busana;?>
&act=update
'>
<img border='0' src='images/edit.gif' title='Edit Data'></a></td>
</tr>
<?
}
echo "</table>";
};
?>