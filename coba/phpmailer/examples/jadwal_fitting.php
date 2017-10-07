<?php
include('include.php');

date_default_timezone_get('Asia/Jakarta');
 $tanggal_hari_ini = date('Y-m-d');
 $tambah_tanggal   = mktime(0,0,0,date('m'),date('d')+2,date('Y')); 
 $tanggal_reminder = date('d',$tambah_tanggal);

$today  = date("Y-m-$tanggal_reminder");
$runSQL2 = mysql_query("select a.id_client, a.nama_cpw, a.tlp_mobile_cpw, a.nama_cpp, a.tlp_mobile_cpp, a.tgl_rencana, b.tgl_janjiawal, b.tgl_janjiakhir, b.barang, b.keterangan, ifnull(c.nama,'-')nama
 from client a 
 left join jadwal_fitting_new b on a.id_client=b.id_client 
 left join pegawai c on a.id_pegawai=c.id_pegawai
 where a.id_client=b.id_client and tgl_janjiakhir between'$tanggal_hari_ini' and '$today'");

?>
<!DOCTYPE html>
<head>
   <meta charset="UTF-8">
   <title>Belajar PHP MySQL</title>
   <style>
   body {
   margin-left:50px;
   margin-right:50px; }
   h3{
      text-align:center; }
   table { 
      border-collapse:collapse;
      border-spacing:0;     
      font-family:Arial, sans-serif;
      font-size:16px;
      padding-left:300px;
      margin:auto; }
   table th {
      font-weight:bold;
      padding:10px;
      color:#fff;
      background-color:#2A72BA;
      border-top:1px black solid;
      border-bottom:1px black solid;
      border-left:1px green solid;
      border-right:1px green solid;}
   table td {
      padding:10px;
      border-top:1px black solid;
      border-bottom:1px black solid;
      text-align:center; 
      border-left:1px green solid;
      border-right:1px green solid;}         
   tr:nth-child(even) {
     background-color: #DFEBF8; }
   </style>
</head>
<body>
   <h3>daftar pengantin yang akan fitting 2 hari kedepan</h3>
<table>
<tr>
   <th>NO</th>
   <th>ID_Client</th>
   <th>Nama</th>
   <th>Tanggal Janji awal</th>
   <th>Tanggal Janji Deal </th>
   <th>Tanggal Rencana </th>
   <th>Barang</th>
   <th>Keterangan</th>
   <th>petugas CS</th>
</tr>
<?php


while ($row=mysql_fetch_array($runSQL2))
{$no++;
?>
   <tr>
   <td><?php echo $no; ?></td>
   <td><?php echo $row['id_client'];?></td>
   <td><?php echo $row['nama_cpw'];?></td>
   <td><b><?php echo $row['tgl_rencana'];?></b></td>
   <td><?php echo $row['tgl_janjiawal'];?></td>
   <td><font color="red"<b><?php echo $row['tgl_janjiakhir'];?></b></td>
   <td><?php echo $row['barang'];?></td>
   <td><?php echo $row['keterangan'];?></td>
   <td><?php echo $row['nama'];?></td>   

   </tr>
<?php

}
?>
</table>



<center><a href="http://data.sanggarliza.com/?menu=5&uid=420798778594342ec38775&page=report_jadwal_fitting">
<img src="http://data.sanggarliza.com/images/goo.png"></img></a></center> 
</body>
</html>
