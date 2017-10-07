<?
	require "fpdf/fpdf.php";
	include_once "include.php";
	include_once "terbilang.php";
	include_once("p_bulan.php");


$sekarang = date('Y-m-d H:i:s');

$add_print = "insert into print_kwitansi_workshop values ('','$id_siswa','$id_bayar','$id_user','$login_ip','$created','$no_kw','$sekarang')";
mysql_query ($add_print);

$sql_filter_printed=mysql_query("select * from print_kwitansi where printed = '$sekarang'");
    $filter_printed=mysql_num_rows($sql_filter_printed);
 if ($filter_printed > 1){     
      $A = $filter_printed - 1;         
//      $B = $filter_printed ;
//      $C = $A - $B;        
      $sql_delete_print = "delete from print_kwitansi where printed like '%$sekarang%' limit $A";
      mysql_query($sql_delete_print);
      } else {}


$sql_filter=mysql_query("select * from print_kwitansi_workshop where no_kw = '$no_kw' and id_bayar ='$id_bayar'");

$filter_no_kw=mysql_num_rows($sql_filter);


if($filter_no_kw <= 3){
    $kurang="";
} else {
    $kurang=3; 
}



if ($filter_no_kw == 1){
    $status="ORIGINAL (SISWA)";
} else if ($filter_no_kw == 2){
    $status="Accounting";
} else if($filter_no_kw == 3){
    $status="Cashier";

} else {
    $status="REPRINT ke : ";
    $no_reprint = $filter_no_kw - $kurang;
}

$sql_nama = "select id_user, fullname  from sys_username where id_user='$id_user'";
$nama = mysql_query($sql_nama);
$petugas = mysql_fetch_array($nama); 

$sql="Select * from tb_siswa_bayar where id_siswa='$id_siswa' AND id_bayar='$id_bayar' ";
$rk=mysql_query($sql);
$row=mysql_fetch_array($rk);
$terbilang = toTerbilang($row['nilai']);

$sql_total="select sum(jumlah) total
from 
(
SELECT SUM( harga_paket ) jumlah
FROM tb_acara_workshop a, paket b
WHERE id_siswa ='$id_siswa'
AND a.id_paket = b.id_paket
union all
select sum(harga) jumlah from tb_pesanan_workshop where id_siswa='$id_siswa'
and id_acara in (select id_acara from tb_acara_workshop where id_siswa='$id_siswa')
) a";
$rt=mysql_query($sql_total);

$total=@mysql_result($rt,0,"total");

$data = mysql_fetch_array($rt);

$id_acara = $data['id_acara'];

$sql="select sum(jumlah) total, sum(diskon) diskon
	from 
	(
	SELECT SUM( harga_paket ) jumlah,'0' diskon
	FROM tb_acara_workshop a, paket b
	WHERE id_siswa ='$id_siswa'
	AND a.id_paket = b.id_paket
	union all
	select sum(harga) jumlah,'0' diskon from tb_pesanan_workshop where id_siswa='$id_siswa'
	and id_acara in (select id_acara from tb_acara_workshop where id_siswa='$id_siswa')
    union all
	select '0' total,diskon from tb_siswa_diskon where id_siswa='$id_siswa'
	) a";
$rt=mysql_query($sql);
$total=@mysql_result($rt,0,"total");
$diskon=@mysql_result($rt,0,"diskon");

$rb=mysql_query(" select distinct date_format(created,'%m') bulan from tb_siswa_bayar where id_siswa='$id_siswa' AND id_bayar='$id_bayar' ");
for($bl=0;$bl<@mysql_num_rows($rb);$bl++) {
$bulan2=mysql_result($rb,$bl,"bulan");
$bulan=nama_bulan($bulan2);
}
$rb=mysql_query(" select distinct date_format(created,'%d')hari from tb_siswa_bayar where id_siswa='$id_siswa' AND id_bayar='$id_bayar' ");
for($bl=0;$bl<@mysql_num_rows($rb);$bl++) {
$hari=mysql_result($rb,$bl,"hari");
}


$rb=mysql_query(" select distinct date_format(created,'%Y') Tahun from tb_siswa_bayar where id_siswa='$id_siswa' AND id_bayar='$id_bayar' ");
for($bl=0;$bl<@mysql_num_rows($rb);$bl++) {
$tahun=mysql_result($rb,$bl,"Tahun");
}




class PDF extends FPDF
{
}
$pdf=new PDF("P");
	$pdf->AliasNbPages();
	$pdf->AddPage();
	

	//LOGO
	$pdf->Image('images/logo_liza2.jpg',35,10,60,25);
	
	//Set Font
	$pdf->SetFont('Arial','UB',24);
	$pdf->SetMargins(3.18,2.54);
	//Move to Right
	$pdf->Cell(130);
	$pdf->Cell(20,15,'KWITANSI');
	$pdf->SetFont('Times','B',10);
	$pdf->Ln(7);
	$pdf->Cell(143);
        //$pdf->Cell(30,10,);
	$pdf->Cell(5,15,'NO : ' .$no_kw.'');

        $pdf->SetFont('Times','B',10);
	$pdf->Ln(5);
	$pdf->Cell(145);
        //$pdf->Cell(30,10,);
	$pdf->Cell(5,15,'ID-Siswa : ' .$row['id_siswa']);

        $pdf->Ln(4);
	$pdf->Cell(145);
	$pdf->Cell(5,15,''. $status.''. $no_reprint );


	$pdf->SetFont('Arial','B',8);
	$pdf->Ln(15);
	$pdf->Cell(30);
	$pdf->Cell(10,10,'Jl. AsemBaris Raya No A11 Tebet Jakarta Selatan Telp. (021) 8299280, 708806588, Fax (021) 83794263');
	//Buat Garis
	$pdf->Line(30,40,190,40);
	$pdf->Line(30,41,190,41);


	
	$pdf->SetFont('Times','',10);
	$pdf->Ln(10);
	$pdf->Cell(30);
	$pdf->Cell(30,7,'Sudah Terima dari            : ');
        $pdf->SetFont('Times','B',10);
	$pdf->Cell(12);
	$pdf->Multicell(150,7,strtoupper($row['pembayar']),'','L');
        	
	//====$pdf->SetFont('Times','',10);
	//$pdf->Ln(5);
	//$pdf->Cell(30);
	//$pdf->Cell(30,7,'Uang Sejumlah    : ');
	//$pdf->Cell(47);
        //$pdf->SetFont('Times','B',10);
	//$pdf->Cell(50,7,strtoupper($terbilang).' RUPIAH');
	
	//$pdf->SetFont('Times','',11);
	//$pdf->Ln(10);
	//$pdf->Cell(20);
	//$pdf->Cell(10,7,'Sudah Terima dari');
	//$pdf->Cell(47);
	//$pdf->Cell(30,60,$row['keterangan']);
	
	
	$pdf->SetFont('Times','',11);
	$pdf->Ln(5);
	//$pdf->Cell(20);
	//$pdf->Cell(10,7,'Sudah Terima dari');
	//$pdf->Cell(47);
	//$pdf->Cell(30,60,number_format($row['nilai'],'2',',','.'));
	//$pdf->Cell(60);
	//$pdf->Cell(30,60,$hari. ' - '.$bulan. ' - '.$tahun);
	//$pdf->Ln(10);
	$pdf->Cell(30);
	$pdf->Cell(30,7,'Uang Sejumlah             :');
	$pdf->Cell(13);
	$pdf->SetTextColor(0);
	$pdf->SetFillColor(224,235,255);
	$pdf->MultiCell(110,7,''. strtoupper($terbilang).' RUPIAH','1','1','L');
	
	$pdf->SetTextColor(00,00,00);
	$pdf->Ln(3);
	$pdf->Cell(30);
	$pdf->Cell(30,7,'Untuk Pembayaran       :');
	$pdf->Cell(12);
	$pdf->SetFont('Arial','B',10);
	$pdf->MultiCell(118,7,''. strtoupper($row['keterangan']),'','L');
	

	$pdf->SetFont('Arial','B',10);
	$pdf->Ln(5);
	$pdf->Cell(30);
	$pdf->Cell(15,7,'Terbilang');
	$pdf->Cell(10);
	$pdf->SetFont('Times','IB',16);
	$pdf->Cell(10,7,'RP.   ');
	$pdf->SetTextColor(0);
	$pdf->SetFillColor(224,235,255);
	$pdf->MultiCell(50,7,''. number_format($row['nilai']),'1','1','C');
	
	$pdf->Ln(3);

	/* if ($id_acara == "25") {

	$pdf->SetFont('Arial','B',10);
	$pdf->Ln(1);
	$pdf->Cell(30);
	$pdf->Cell(15,7,'Total Biaya');
	$pdf->Cell(10);
	$pdf->SetFont('Times','IB',16);
	$pdf->Cell(10,7,'RP.   ');
	$pdf->SetTextColor(0);
	$pdf->SetFillColor(224,235,255);
	$pdf->MultiCell(50,7,''. number_format((($total - $diskon) * 0.10) + ($total-$diskon),0),'1','1','C');

	} else {

	$pdf->SetFont('Arial','B',10);
	$pdf->Ln(1);
	$pdf->Cell(30);
	$pdf->Cell(15,7,'Total Biaya');
	$pdf->Cell(10);
	$pdf->SetFont('Times','IB',16);
	$pdf->Cell(10,7,'RP.   ');
	$pdf->SetTextColor(0);
	$pdf->SetFillColor(224,235,255);
	$pdf->MultiCell(50,7,''. number_format($total - $diskon,0),'1','1','C');	

	} */

	$pdf->SetFont('Arial','B',10);
	$pdf->SetTextColor(00,00,00);
	$pdf->Cell(130);
	$pdf->Cell(10,7,'Jakarta, '.$hari. ' - '.$bulan. ' - '.$tahun);

        	if($row['catatan']!='')
{

		$pdf->Ln(8);
		$pdf->Cell(30);
		$pdf->MultiCell(90,5,'Catatan :'. $row['catatan']);
}		
                 $pdf->Ln(4);
		
                $pdf->SetFont('Arial','B',10);
         	$pdf->SetTextColor(00,00,00);
	        $pdf->Cell(148);
	        $pdf->Cell(10,7,''.$petugas['fullname'].'');
                $pdf->Ln(1);
                $pdf->SetFont('Arial','I',8);
                $pdf->Cell(30);
		$pdf->MultiCell(110,5,'1. Booking Fee / DP tidak dapat dikembalikan apabila terjadi cancel dari pihak client     2. Pembayaran dengan Cheque/Bilyet Giro Belum dianggap Lunas apabila belum di Clearing oleh Bank yang Bersangkutan','1','L');

                
                $pdf->SetFont('Arial','I',6);
                $pdf->Ln(1);
		$pdf->Cell(30);
                $pdf->MultiCell(120,5,'Terakhir diinput tanggal : '. $row['created'].'  & Dicetak tanggal : '.$sekarang.  ' Jumlah cetak : '. $filter_no_kw. ' Kali'  );
                
	


	$pdf->Output();

?>