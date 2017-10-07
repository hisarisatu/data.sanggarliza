<?
	require "fpdf/fpdf.php";
	include_once "include.php";
	include_once "terbilang.php";
	include_once("p_bulan.php");

$sql="Select * from client_bayar where id_client='$id_client' AND id_bayar='$id_bayar' ";
$rk=mysql_query($sql);
$row=mysql_fetch_array($rk);
$terbilang = toTerbilang($row['nilai']);

$rb=mysql_query(" select distinct date_format(tanggal,'%m') bulan from client_bayar where id_client='$id_client' AND id_bayar='$id_bayar' ");
for($bl=0;$bl<@mysql_num_rows($rb);$bl++) {
$bulan2=mysql_result($rb,$bl,"bulan");
$bulan=nama_bulan($bulan2);
}
$rb=mysql_query(" select distinct date_format(tanggal,'%d')hari from client_bayar where id_client='$id_client' AND id_bayar='$id_bayar' ");
for($bl=0;$bl<@mysql_num_rows($rb);$bl++) {
$hari=mysql_result($rb,$bl,"hari");
}


$rb=mysql_query(" select distinct date_format(tanggal,'%Y') Tahun from client_bayar where id_client='$id_client' AND id_bayar='$id_bayar' ");
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
	//$pdf->Image('images/logo.jpg',35,10,60,25);
	
	//Set Font
	//$pdf->SetFont('Arial','UB',24);
	//$pdf->SetMargins(3.18,2.54);
	//Move to Right
	//$pdf->Cell(250);
	//$pdf->Cell(30,10,'KWITANSI');
	$pdf->SetFont('Times','B',14);	
	$pdf->Ln(1);
	$pdf->Cell(160);
	$pdf->Cell(5,60,'' .$tahun.'' .$bulan2.'' .$row['id_bayar'].' - ' .$row['no_urut']);
	//$pdf->SetFont('Arial','B',8);
	//$pdf->Ln(17);
	//$pdf->Cell(20);
	//$pdf->Cell(10,10,'Jl. J. No. 7 dan 29 Kebon Baru Tebet Jakarta Selatan Telp. (021) 8299280, 708806588, Fax (021) 83794263');
	//Buat Garis
	//$pdf->Line(30,45,210,45);
	//$pdf->Line(30,46,210,46);


	
	$pdf->SetFont('ARIAL','B',12);
	$pdf->Ln(28);
	//$pdf->Cell(20);
	//$pdf->Cell(10,7,'Sudah Terima dari');
	$pdf->Cell(47);
	$pdf->Cell(30,60,strtoupper($row['pembayar']));
	
	
	$pdf->Ln(19);
	//$pdf->Cell(20);
	//$pdf->Cell(10,7,'Sudah Terima dari');
	$pdf->Cell(47);
	$pdf->Cell(30,60,strtoupper($terbilang).' RUPIAH');
	
	$pdf->SetFont('ARIAL','B',12);
	$pdf->Ln(14);
	//$pdf->Cell(20);
	//$pdf->Cell(10,7,'Sudah Terima dari');
	$pdf->Cell(47);
	$pdf->Cell(30,60,$row['keterangan']);
	
	
	$pdf->SetFont('ARIAL','B',14);
	$pdf->Ln(27);
	//$pdf->Cell(20);
	//$pdf->Cell(10,7,'Sudah Terima dari');
	$pdf->Cell(39);
	$pdf->Cell(30,60,number_format($row['nilai'],'2',',','.'));
	$pdf->SetFont('ARIAL','B',10);
	$pdf->Cell(73);
	$pdf->Cell(30,60,$hari. ' - '.$bulan. ' - '.$tahun);
	//$pdf->Ln(10);
//	$pdf->Cell(20);
//	$pdf->Cell(10,7,'Uang Sejumlah                                   :');
//	$pdf->Cell(53);
//	$pdf->SetTextColor(255,255,255);
//	$pdf->SetFillColor(99,99,99);
//	$pdf->MultiCell(118,7,''. strtoupper($terbilang).' RUPIAH','1','1','L');
//	
//	$pdf->SetTextColor(00,00,00);
//	$pdf->Ln(3);
//	$pdf->Cell(20);
//	$pdf->Cell(10,7,'Untuk Pembayaran                            :');
//	$pdf->Cell(53);
//	$pdf->SetFont('Arial','UB',10);
//	$pdf->MultiCell(118,7,''. strtoupper($row['keterangan']),'','L');
//	
//
//	$pdf->SetFont('Arial','B',10);
//	$pdf->Ln(5);
//	$pdf->Cell(20);
//	$pdf->Cell(10,7,'Terbilang');
//	$pdf->Cell(10);
//	$pdf->SetFont('Times','IB',16);
//	$pdf->Cell(10,7,'RP.   ');
//	$pdf->SetTextColor(255,255,255);
//	$pdf->SetFillColor(99,99,99);
//	$pdf->MultiCell(50,7,''. number_format($row['nilai']),'1','1','C');

	//$pdf->SetFont('Arial','B',10);
//	$pdf->SetTextColor(00,00,00);
//	$pdf->Cell(150);
//	$pdf->Cell(10,7,'Jakarta, '.$hari. ' - '.$bulan. ' - '.$tahun);
//
//	if($row['catatan']!='')
//	{
//		$pdf->Ln(15);
//		$pdf->Cell(20);
//		$pdf->MultiCell(110,5,''. $row['catatan'],'1','L');
//	}
//	else
//	{
//		$pdf->Ln(15);
//		$pdf->Cell(20);
//		$pdf->MultiCell(110,5,'Pemabayaran dengan Cheque/Bilyet Giro Belum dianggap Lunas apabila belum di Clearing oleh Bank yang Bersangkutan','1','L');
//	}
	$pdf->Output();

?>