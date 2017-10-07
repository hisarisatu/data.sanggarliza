<?
 
include_once("include.php");
$id_client=$_POST['id_client'];
$id_konsultasi=$_POST['id_konsultasi'];
$client_hadir=$_POST['client_hadir'];
$isi=$_POST['isi'];
$id_pegawai=$_POST['id_pegawai'];
$status=$_POST['status'];
	
		$update= "update konsultasi set client_hadir='$client_hadir', isi='$isi', petugas='$id_pegawai', status='$status' where id_client='$id_client' and id_konsultasi='$id_konsultasi'";
		$hasil = mysql_query ($update);
	
if ($hasil) {
 echo "data telah tersimpan";   
} else {
    echo "gagal mengupdate data";
}
?>