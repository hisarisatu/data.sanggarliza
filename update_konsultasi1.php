<?
 
include_once("include.php");
$id_client=$_POST['id_client'];
$id_konsultasi1=$_POST['id_konsultasi1'];
$client_hadir=$_POST['client_hadir'];
$isi=$_POST['isi'];
$id_pegawai=$_POST['id_pegawai'];
$status=$_POST['status'];
	$acara=$_POST['acara'];

		$update= "update konsultasi_fiting set client_hadir='$client_hadir', isi='$isi', acara='$acara',  petugas='$id_pegawai', status='$status' where id_client='$id_client' and id_konsultasi1='$id_konsultasi1'";
		$hasil = mysql_query ($update);
	
if ($hasil) {
 echo "data telah tersimpan";   
} else {
    echo "gagal mengupdate data";
}
?>