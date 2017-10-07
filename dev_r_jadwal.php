<script src="src/js/jscal2.js"></script>
<script src="src/js/lang/en.js"></script>
<link rel="stylesheet" type="text/css" href="src/css/jscal2.css" />
<link rel="stylesheet" type="text/css" href="src/css/border-radius.css" />
<link rel="stylesheet" type="text/css" href="src/css/steel/steel.css" />
<?php
include_once("include.php");
include_once("p_bulan.php");
#exit('123');
$sql = " select * from ( 
			select distinct a.id_client,a.id_acara,a.tanggal,b.acara,a.tempat,c.nama_cpw,c.nama_cpp,f.layanan,f.id_layanan,d.jml_orang, g.id_pegawai, h.nama 
			from acara a,p_acara b,client c,paket_sub_paket d, p_sublayanan e,p_layanan f, pegawai_tugas g, pegawai h 
			where a.id_acara=b.id_acara and a.id_client=c.id_client and a.id_paket=d.id_paket and d.id_sublayanan=e.id_sublayanan and e.id_layanan=f.id_layanan  and e.id_sublayanan=g.id_tugas and a.id_client=g.id_client and h.id_pegawai=g.id_pegawai
			union
			select distinct a.id_client,a.id_acara,a.tanggal,b.acara,a.tempat,c.nama_cpw,c.nama_cpp,f.layanan,f.id_layanan,d.jml_orang, g.id_pegawai, h.nama  
			from acara a,p_acara b,client c,pesanan_plus d,p_sublayanan e,p_layanan f, pegawai_tugas g, pegawai h   
			where a.id_acara=b.id_acara and a.id_client=c.id_client and a.id_client=d.id_client and a.id_acara=d.id_acara and d.id_sublayanan=e.id_sublayanan and e.id_layanan=f.id_layanan and e.id_sublayanan=g.id_tugas and a.id_client=g.id_client and h.id_pegawai=g.id_pegawai ) a 
			where 1=1  
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
			where 1=1 
			group by id_client, id_acara, tanggal,acara, tempat, nama_cpw, nama_cpp, layanan, id_layanan  "; 
$result = mysql_query($sql, $connDB);
?>
<table width='850' cellspacing='1' cellpadding='3'>
    <tr bgcolor='#A7A7A7' height="25" align="center">
        <td>No</td>
        <td>Tanggal Acara</td>
        <td>Waktu</td>
        <td>Jenis Layanan</td>
        <td>Nama Pengantin</td>
        <td>Acara</td>
        <td>Tempat</td>
        <td>Pelaksana</td>
        <td>Status</td> 
        <td>Tgl </td>
    </tr>
  <?php $x=1; while($row = mysql_fetch_assoc($result)) { $style=$x%2>0 ?'#EBEFFA' : 'D7E0F4';  ?>
    <tr style="background-color: <?=$style?>">
        <td><?=$x?></td>
        <td><?=$row['tanggal']?></td>
        <td><?=$row['waktu']?></td>
        <td><?=$row['layanan']?></td>
        <td><?=$row['nama_cpp']?>&nbsp;/&nbsp;<?=$row['nama_cpw']?></td>
        <td><?=$row['acara']?></td>
        <td><?=$row['tempat']?></td>
        <td><?=$row['']?></td> 
        <td><?=$row['']?></td>
         <td><?=$row['created']?></td>
    </tr>
  <?php $x++; } ?> 
</table>