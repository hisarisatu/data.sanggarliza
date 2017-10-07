<link rel="stylesheet" href="./src/lib/jquery-ui-1.11.1/jquery-ui.css">    
<script src="./src/lib/jquery-1.9.1.js" type="text/javascript"></script>
<script src="./src/lib/jquery-ui-1.11.1/jquery-ui.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="src/css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="src/css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="src/css/steel/steel.css" />


<?php
//Last update : 10/30/2010
// by agusari@gmail.com
  
include_once("include.php");
include_once("p_bulan.php");
  
function js_submit() 
{
    echo "<script language=javascript>\n";
    echo "function submit_form() {\n";
    echo "  document.forms[0].submit();\n";
    echo "}\n";
    echo "</script>\n";
}

function generate_select_event($name, $sql, $default, $onchange) {
    $result = mysql_query($sql);
    $nrows = 0;
    while ($row = mysql_fetch_array($result)) {
        $nrows++;
        $key = $row[0];
        $value = $row[1];
        $arr["$key"] = $value;
    }
    echo "<select name=$name onchange=\"$onchange;\">\n";
    if (!$default) {
        echo "<option value=0>-- Pilih --</option>\n";
    }
    while (list($key, $val) = each($arr)) {
        if ($default == $key) {
            echo "<option value=$key selected>$val</option>\n";
        } else {
            echo "<option value=$key>$val</option>\n";
        }
    }
    echo "</select>";
}

function generate_select($name, $sql, $default) {

    $result = mysql_query($sql);
    $nrows = 0;
    while ($row = mysql_fetch_array($result)) {
        $nrows++;
        $key = $row[0];
        $value = $row[1];
        $arr["$key"] = $value;
    }

    echo "<select name=$name>\n";
    while (list($key, $val) = each($arr)) {
        if ($default == $key) {
            echo "<option value=$key selected>$val</option>\n";
        } else {
            echo "<option value=$key>$val</option>\n";
        }
    }
    echo "</select>";
}
/*
?>
<script language="JavaScript" src="calendar_us.js"></script>


<?php*/
#$tanggal
#$tanggal2

$pageFilter = "&tanggal=$tanggal&tanggal2=$tanggal2&id_layanan=$id_layanan&id_pegawai=$id_pegawai";

//if (!$tanggal) {$tanggal=date_format(current_date(),'%Y-%m-1');}
//if (!$tanggal2) {$tanggal2=date_format(current_date(),'%Y-%m-%d');}
if ($id_pegawai == 0) {
    $id_pegawai = '%';
}  
if ($id_layanan == 0) {
    $id_layanan = '17';
}
  
if ($id_pegawai != "") {
    $filterSQL = " and id_pegawai like '$id_pegawai' ";
}

if ($tanggal != "" && tanggal2 != "") {
    $filterSQL .= " and tanggal BETWEEN '$tanggal' AND '$tanggal2' ";
}else{
    $filterSQL .= " and DATE_FORMAT(tanggal, '%Y') BETWEEN '2017' AND '2030' ";
}
if ($id_layanan != "") {
    $filterSQL .= " and id_layanan like '$id_layanan' ";
}

if ($tanggal != "" && tanggal2 != "") {
    $filterSQL1 = " and tanggal BETWEEN '$tanggal' AND '$tanggal2' ";
}else{
    $filterSQL1 .= " and DATE_FORMAT(tanggal, '%Y') BETWEEN '2017' AND '2030' ";
}
if ($id_layanan != "") {
    $filterSQL1 .= " and id_layanan like '$id_layanan' ";
}

//echo $filterSQL;
#echo $filterSQL1;
#exit; 
if ($id_pegawai != "") {  

    $runSQL = "select count(*) total from 
            (select * from ( 
            select distinct a.id_client,a.id_acara,a.tanggal,b.acara,a.tempat,c.nama_cpw,c.nama_cpp,f.layanan,f.id_layanan,d.jml_orang, g.id_pegawai, h.nama 
            from acara a,p_acara b,client c,paket_sub_paket d, p_sublayanan e,p_layanan f, pegawai_tugas g, pegawai h 
            where a.id_acara=b.id_acara and a.id_client=c.id_client and a.id_paket=d.id_paket and d.id_sublayanan=e.id_sublayanan and e.id_layanan=f.id_layanan  and e.id_sublayanan=g.id_tugas and a.id_client=g.id_client and h.id_pegawai=g.id_pegawai
            union
            select distinct a.id_client,a.id_acara,a.tanggal,b.acara,a.tempat,c.nama_cpw,c.nama_cpp,f.layanan,f.id_layanan,d.jml_orang, g.id_pegawai, h.nama  
            from acara a,p_acara b,client c,pesanan_plus d,p_sublayanan e,p_layanan f, pegawai_tugas g, pegawai h   
            where a.id_acara=b.id_acara and a.id_client=c.id_client and a.id_client=d.id_client and a.id_acara=d.id_acara and d.id_sublayanan=e.id_sublayanan and e.id_layanan=f.id_layanan and e.id_sublayanan=g.id_tugas and a.id_client=g.id_client and h.id_pegawai=g.id_pegawai ) a 
            where 1=1 $filterSQL 
            group by id_client, id_acara, tanggal,acara, tempat, nama_cpw, nama_cpp, layanan, id_layanan
            union
            select * from ( 
            select distinct a.id_client,a.id_acara,a.tanggal,b.acara,a.tempat,c.nama_cpw,c.nama_cpp,f.layanan,f.id_layanan,d.jml_orang,0,'' nama 
            from acara a,p_acara b,client c,paket_sub_paket d, p_sublayanan e,p_layanan f 
            where a.id_acara=b.id_acara and a.id_client=c.id_client and a.id_paket=d.id_paket and d.id_sublayanan=e.id_sublayanan and e.id_layanan=f.id_layanan and a.id_client not in (select id_client from pegawai_tugas) 
            union
            select distinct a.id_client,a.id_acara,a.tanggal,b.acara,a.tempat,c.nama_cpw,c.nama_cpp,f.layanan,f.id_layanan,d.jml_orang,0,'' nama
            from acara a,p_acara b,client c,pesanan_plus d,p_sublayanan e,p_layanan f   
            where a.id_acara=b.id_acara and a.id_client=c.id_client and a.id_client=d.id_client and a.id_acara=d.id_acara and d.id_sublayanan=e.id_sublayanan and e.id_layanan=f.id_layanan and a.id_client not in (select id_client from pegawai_tugas) ) a 
            where 1=1 $filterSQL1
            group by id_client, id_acara, tanggal,acara, tempat, nama_cpw, nama_cpp, layanan, id_layanan) b order by tanggal asc";
    }
#echo "<pre>".print_r($runSQL,true)."</pre>";
#exit;

$result = mysql_query($runSQL, $connDB);
if ($row = mysql_fetch_array($result)) {
    $totalRecord = $row[total]; 
};
$listRecord = 30;
$pageLink = "?menu=$menu&uid=$uid&page=$page$pageFilter$cari&pnum=";
pageViewRecord($pnum, $totalRecord, $pageLink, $listRecord);

//echo $runSQL;
//order by nama waktu id clien asc di hapus tgl 28 agustus 
if ($id_pegawai != "") {
   # exit($id_pegawai);
    $runSQL = "select distinct id_client, waktu, created, id_acara, tanggal,acara, tempat, nama_cpw, nama_cpp, layanan, id_layanan,jml, nama from
(select id_client, waktu, created, id_acara, tanggal,acara, tempat, nama_cpw, nama_cpp, layanan, id_layanan, sum(jml_orang) jml, nama
from ( 
select distinct a.id_client,a.id_acara,a.tanggal, a.waktu, a.created, b.acara,a.tempat,c.nama_cpw,c.nama_cpp,f.layanan,f.id_layanan,d.jml_orang, g.id_pegawai, h.nama  
from acara a,p_acara b,client c,paket_sub_paket d, p_sublayanan e,p_layanan f, pegawai_tugas g, pegawai h
where a.id_acara=b.id_acara and a.id_client=c.id_client and a.id_paket=d.id_paket and d.id_sublayanan=e.id_sublayanan 
and e.id_layanan=f.id_layanan  and g.id_tugas=e.id_sublayanan and a.id_client=g.id_client 
and a.id_acara=g.id_acara and h.id_pegawai=g.id_pegawai
union
select distinct a.id_client,a.id_acara,a.tanggal, a.waktu, a.created, b.acara,a.tempat,c.nama_cpw,c.nama_cpp,f.layanan,f.id_layanan,d.jml_orang, g.id_pegawai ,h.nama  
from acara a,p_acara b,client c,pesanan_plus d,p_sublayanan e,p_layanan f, pegawai_tugas g, pegawai h
where a.id_acara=b.id_acara and a.id_client=c.id_client and a.id_client=d.id_client and a.id_acara=d.id_acara 
and d.id_sublayanan=e.id_sublayanan and e.id_layanan=f.id_layanan and g.id_tugas=e.id_sublayanan and a.id_client=g.id_client 
and a.id_acara=g.id_acara and h.id_pegawai=g.id_pegawai) a 
where 1=1 $filterSQL
group by id_client, id_acara, tanggal,acara, tempat, nama_cpw, nama_cpp, layanan, id_layanan
union
select id_client, waktu, created, id_acara, tanggal,acara, tempat, nama_cpw, nama_cpp, layanan, id_layanan, sum(jml_orang) jml, nama
from ( 
select distinct a.id_client,a.id_acara,a.tanggal, a.waktu, a.created, b.acara,a.tempat,c.nama_cpw,c.nama_cpp,f.layanan,f.id_layanan,d.jml_orang,0,'' nama  
from acara a,p_acara b,client c,paket_sub_paket d, p_sublayanan e,p_layanan f   
where a.id_acara=b.id_acara and a.id_client=c.id_client and a.id_paket=d.id_paket and d.id_sublayanan=e.id_sublayanan and e.id_layanan=f.id_layanan
and (a.id_client,a.id_acara) not in (select id_client,id_acara from pegawai_tugas)
union
select distinct a.id_client,a.id_acara,a.tanggal, a.waktu, a.created, b.acara,a.tempat,c.nama_cpw,c.nama_cpp,f.layanan,f.id_layanan,d.jml_orang,0,'' nama 
from acara a,p_acara b,client c,pesanan_plus d,p_sublayanan e,p_layanan f  
where a.id_acara=b.id_acara and a.id_client=c.id_client and a.id_client=d.id_client and a.id_acara=d.id_acara and d.id_sublayanan=e.id_sublayanan and e.id_layanan=f.id_layanan
and (a.id_client,a.id_acara) not in (select id_client,id_acara from pegawai_tugas)) a 
where 1=1 $filterSQL1
group by id_client, id_acara, tanggal,acara, tempat, nama_cpw, nama_cpp, layanan, id_layanan) b
order by   tanggal asc  
LIMIT $offsetRecord, $listRecord";
    
}
#echo "<pre>".print_r($runSQL)."</pre>";exit;
?>


<form method="POST" name="form" action="<?= "?menu=$menu&uid=$uid&page=$page"; ?>">
    <div align="center" style="width:100%">
        <fieldset style="width:400"><legend><strong>Search</strong></legend>
            <table>
                <tr>
                    <td><b>Range Waktu Acara</b></td>
                    <td><b>:</b></td> 
                    <td>   
                        <input type='text' name='tanggal' id="tanggal" size='11' value='<?= $tanggal ?>'>
                        - 
                        <input type='text' name='tanggal2' id="tanggal2" size='11' value='<?= $tanggal2 ?>'>
                    </td>       
                </tr>

                <tr>
                    <td><b>Jenis Layanan </b></td>
                    <td><b>:</b></td>
                    <td>    <?php
                        js_submit();
                        $sql="select distinct id_layanan,layanan from p_layanan where id_layanan='17' ";
                        generate_select_event("id_layanan",$sql,$id_layanan,"submit_form()");
                        ?>
                </td>
            </tr>

            <tr>
                <td><b>Petugas </b></td>
                <td><b>:</b></td>
                <td>
                    <?php
                     $id_layanan='17';
                    $sql="select distinct a.id_pegawai,nama from pegawai a,pegawai_pekerjaan b 
                    where id_pekerjaan like '$id_layanan'
                    and b.id_pegawai=a.id_pegawai
                    union select 0,'--All Pegawai--' from dual";
                    generate_select("id_pegawai",$sql,$id_pegawai);

                    if ($id_pegawai==0) {$id_pegawai='%';}

                    //echo $id_pegawai;

                    ?>
                </td>
            </tr>


            <tr>
                <td colspan="3">
                    <input type="submit" name="run" value="  Go  " class="button">
                </td>
            </tr>
        </table>
    </fieldset>
</div>
</form>
<form>
<div align="center" style="width:100%" title="Pengumuman">
 <fieldset style="width:400">
     <?php
     echo "<center><font color='#FF0000'><b>CATATAN</b> </font></center>";
     echo "<center><font color='#FF0000'><b>BAGI NAMA PERIAS YANG BERADA DIBAWAH INI</b> </font></center> ";
      echo "<center><font color='#FF0000'><b>MOHON UNTUK TIDAK DIJADWALKAN PADA TANGGAL TERSEBUT</b> </font></center> ";
      echo "<hr>";

include_once("include.php");
$runSQL1 = "select a.pengumuman, a.tgl_habis, b.nama from p_pengumuman a, pegawai b where b.id_pegawai=a.nama and (tgl_habis BETWEEN '$tanggal' AND '$tanggal2') group by nama  order by id_pengumuman asc";
//group by nama dihapus
$result1 = mysql_query($runSQL1, $connDB);
while ($row1 = mysql_fetch_array ($result1))
{ 
$ccc++;

echo "<font color='#FF0000'> <table width = 500 border =0>
<tr>
<td width='50' <font color='#FF0000'> <b> ".($offsetRecord+$ccc)." </b> </font> </td>
<td width='136' > <font color='#FF0000'><b>{$row1['nama']} </font> </td>
<td width='136' > <font color='#FF0000'><b>{$row1['tgl_habis']} </font> </td>
<td width='277' > <font color='#FF0000'><b>{$row1['pengumuman']} </font> </td>
<tr>
</table>
 </font>  
 ";} 

?>

 </fieldset>
 </div>
 </form>
<script type="text/javascript">//<![CDATA[
    $(document).ready(function(){
       $('#tanggal').datepicker({ dateFormat: 'yy-mm-dd',changeMonth : true,
                changeYear : true }); 
       $('#tanggal2').datepicker({ dateFormat: 'yy-mm-dd',changeMonth : true,
                changeYear : true }); 
    });
     //]]></script>
<!--
<script type="text/javascript">//<![CDATA[

    var cal = Calendar.setup({
        onSelect: function (cal) {
            cal.hide()
        }
    });
    cal.manageFields("tanggal", "tanggal", "%Y-%m-%d");
    cal.manageFields("tanggal2", "tanggal2", "%Y-%m-%d");
    //]]></script>-->
<div align="center"><font class="titledata"><b>Laporan Penjadwalan Acara</b></font></div>

<div align="right">
    <a href="cetak_report.php?tanggal=<?= $tanggal ?>&tanggal2=<?= $tanggal2 ?>&id_layanan=<?= $id_layanan ?>&id_pegawai=<?= $id_pegawai ?>" target="_blank"><img border="0" src="images/excel2007.jpg" height="25" width="25" alt="Print to Excel" title="Save to Excel" /></a>
    <img src="images/arrow2.gif" border="0">
    <b><a href="<?= "?menu=5&uid=$uid&page=r_jadwal"; ?>">List All</a></b>
</div>

<hr size="1" color="#4B4B4B">

Halaman : <?= $pnumlink; ?> &nbsp; Total : <b><?= $totalPage; ?></b> halaman, <?= $totalRecord ?> record.

<table width='850' cellspacing='1' cellpadding='3'>
    <tr bgcolor='#A7A7A7' height="25" align="center">
        <td>No</td>
        <td>Tanggal Acara</td>
        <td>Waktu</td>
        <td>Jenis Layanan</td>
        <td>Nama Pengantin</td>
        <td>Acara</td>
         <td>Gaya </td>
         <td>Sanggul </td>
        <td>Tempat</td>
        <td>Pelaksana</td>
        <td>Petugas CS</td>
        <td>Status</td>
        <td>Tgl Booking</td>
    </tr>
    <?php



    $res=mysql_query($runSQL);

    if($id_pegawai=="")
    {
    for($a=0;$a<@mysql_num_rows($res);$a++)
    {
    $id_acara=mysql_result($res,$a,"id_acara");
    $id_client=mysql_result($res,$a,"id_client");
    $id_layanan=mysql_result($res,$a,"id_layanan");

    $ccc++;
    $sl=mysql_query("select a.id_pegawai, a.nama from pegawai a, pegawai_tugas b where b.id_acara='$id_acara' and b.id_client='$id_client' and b.id_pekerjaan='$id_layanan' and a.id_pegawai=b.id_pegawai ");

$sq=mysql_query("select a.id_gaya, b.gaya from acara a, p_gaya b where a.id_acara='$id_acara' and a.id_client='$id_client' and  a.id_gaya=b.id_gaya 
group by id_client, id_acara");
 
  $se=mysql_query("select a.id_sanggul, b.model_sanggul from acara a, p_model_sanggul b where a.id_acara='$id_acara' and a.id_client='$id_client' and a.id_sanggul=b.id_sanggul group by id_client, id_acara ");
  
  
    if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
    echo "
    <tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
    <td align='center'>".($offsetRecord+$ccc)."</td>";?>
    <td><?= mysql_result($res, $a, "tanggal") ?></td>
    <td><?= mysql_result($res, $a, "waktu") ?></td>
    
    <td><?= mysql_result($res, $a, "layanan") ?></td>
    <td><?= mysql_result($res, $a, "nama_cpw") ?>/<?= mysql_result($res, $a, "nama_cpp") ?></td>
    <td><?= mysql_result($res, $a, "acara") ?></td>
    <td>
        <?php
        while($gaya=mysql_fetch_array($sq))
        {
        echo $gaya['gaya'];
        echo "<br>";
        }
        ?>

    </td>
    <td>
        <?php
        while($model_sanggul=mysql_fetch_array($se))
        {
        echo $model_sanggul['model_sanggul'];
        echo "<br>";
        }
        ?>

    </td>
    <td><?= mysql_result($res, $a, "tempat") ?></td>
    <td>
        <?php
        while($nama=mysql_fetch_array($sl))
        {
        echo $nama['nama'];
        echo "<br>";
        }
        ?>

    </td>
    <td></td>
    <td><?= mysql_result($res, $a, "created") ?></td>
</td>
</tr>
<?php }} ?>

<?php
if($id_pegawai!="")
{
while($rec=mysql_fetch_array($res))
{
  #echo $rec['id_client']."<br/>" ; 
  $sql_nama_cs="select distinct b.nama,id_client from client a
  inner join pegawai b on a.id_pegawai=b.id_pegawai and id_client=".$rec['id_client']."
  inner join pegawai_pekerjaan c on b.id_pegawai=c.id_pegawai AND c.id_pekerjaan=23 ";
  $data_cs=  mysql_query($sql_nama_cs);
  $data_cs= mysql_fetch_assoc($data_cs);
  
  $sql_gaya="select distinct b.gaya,a.id_gaya from acara a
  inner join p_gaya b on a.id_gaya=b.id_gaya and id_client=".$rec['id_client']." and id_acara=".$rec['id_acara']."";

  $data_gaya=  mysql_query($sql_gaya);
  $data_gaya= mysql_fetch_assoc($data_gaya);
  
  $sql_sanggul="select distinct b.model_sanggul,a.id_sanggul from acara a
  inner join p_model_sanggul b on a.id_sanggul=b.id_sanggul and id_client=".$rec['id_client']." and id_acara=".$rec['id_acara']."";

  $data_sanggul=  mysql_query($sql_sanggul);
  $data_sanggul= mysql_fetch_assoc($data_sanggul);
  #echo "<pre>".print_r($data_cs,true)."</pre>";
  
  $sql_status="select distinct b.nilai,a.id_client from acara a
  inner join client_bayar b on a.id_client=b.id_client and a.id_client=".$rec['id_client']." and a.id_acara=".$rec['id_acara']."";

  $data_status=  mysql_query($sql_status);
  $data_status= mysql_fetch_assoc($data_status);
  #echo "<pre>".print_r($data_cs,true)."</pre>";
  
$ccc++;
if ($ccc%2 > 0){ $color="#EBEFFA"; }else{ $color="#D7E0F4"; };
echo "
<tr bgcolor='$color' onmouseover='bgColor=\"#FDD0D8\"' onmouseout='bgColor=\"$color\"' valign=top>
<td align='center'>".($offsetRecord+$ccc)."</td>";?>
<td><?= $rec['tanggal']; ?></td>
<td><?= $rec['waktu']; ?></td>
<td><?= $rec['layanan']; ?></td>
    
<td><?php
    if($data_status['nilai'] == 0 and $rec['id_client'] == 4539 ) {
    ?> 
    <?= $rec['nama_cpw']; ?>/<?= $rec['nama_cpp']; ?>
    <?php 
    } 
else if ($data_status['nilai'] == 0 and $rec['id_client'] != 4539){
  ?>
    <b style="color:red;"><?= $rec['nama_cpw']; ?>/<?= $rec['nama_cpp']; ?></b>
    <?php 
}
else {
    ?>
    <?= $rec['nama_cpw']; ?>/<?= $rec['nama_cpp']; ?>
    <?php } ?></td>


<td><?= $rec['acara']; ?></td>
<td><?= $data_gaya['gaya']; ?></td>
<td><?= $data_sanggul['model_sanggul']; ?></td>
<td><?= $rec['tempat']; ?></td>
<td><?= $rec['nama']; ?></td>
<td><?= $data_cs['nama']; ?></td>
<td><?php
    if($data_status['nilai'] == 0 and $rec['id_client'] == 4539 ) {
    ?> 
    &nbsp;
    <?php 
    } 
else if ($data_status['nilai'] == 0 and $rec['id_client'] != 4539){
  ?>
    <b style="color:red;">BELUM DP</b>
    <?php 
}
else {
    ?>
    &nbsp;
    <?php } ?></td>
<td><?= $rec['created']; ?></td>
</td>
</tr>
<?php 
//echo $runSQL;
}
} 
//echo $runSQL;
?>
</table>
Halaman : <?= $pnumlink; ?> &nbsp; Total : <b><?= $totalPage; ?></b> halaman, <?= $totalRecord ?> record.