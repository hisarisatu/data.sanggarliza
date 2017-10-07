<?
	require "fpdf/fpdf.php";
	include_once "include.php";
	include_once "terbilang.php";
	include_once("p_bulan.php");

$sql="Select a.id_non_client, a.nama, ifnull(b.keterangan,'-')divisi, a.detail, a.tanggal, a.jumlah, ifnull(c.keterangan,'-')jenis_bayar
, ifnull(d.keterangan,'-')bank,a.kwitansi
from non_client a
left join p_pengeluaran b on a.divisi=b.id_jenis_bagian
left join p_pembayaran c on a.jenis_bayar=c.id_jenis_bayar
left join p_bank d on a.bank=d.id_bank 
where id_non_client='$id_non_client'
order by created desc";
$rk=mysql_query($sql);
$row=mysql_fetch_array($rk);
$terbilang = toTerbilang($row['jumlah']);

$rb=mysql_query(" select distinct date_format(tanggal,'%m') bulan from non_client where id_non_client='$id_non_client' ");
for($bl=0;$bl<@mysql_num_rows($rb);$bl++) {
$bulan2=mysql_result($rb,$bl,"bulan");
$bulan=nama_bulan($bulan2);
}
$rb=mysql_query(" select distinct date_format(tanggal,'%d')hari from non_client where id_non_client='$id_non_client' ");
for($bl=0;$bl<@mysql_num_rows($rb);$bl++) {
$hari=mysql_result($rb,$bl,"hari");
}


$rb=mysql_query(" select distinct date_format(tanggal,'%Y') Tahun from non_client where id_non_client='$id_non_client' ");
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
	$pdf->Cell(138);
        //$pdf->Cell(30,10,);
	$pdf->Cell(5,15,'NO : ' .$tahun.'' .$bulan2.' - ' .$row['kwitansi']);
	$pdf->SetFont('Arial','B',8);
	$pdf->Ln(15);
	$pdf->Cell(30);
	$pdf->Cell(10,10,'Jl. Asem Baris Raya No. 11A Kebon Baru Tebet Jakarta Selatan Telp. (021) 8299280, 708806588, Fax (021) 83794263');
	//Buat Garis
	$pdf->Line(30,40,190,40);
	$pdf->Line(30,41,190,41);


	
	$pdf->SetFont('Times','',10);
	$pdf->Ln(10);
	$pdf->Cell(30);
	$pdf->Cell(30,7,'Sudah Terima dari            : ');
        $pdf->SetFont('Times','B',10);
	$pdf->Cell(12);
	$pdf->Cell(150,7,strtoupper($row['nama']));
	
	//====$pdf->SetFont('Times','',10);
	//$pdf->Ln(6);
	//$pdf->Cell(30);
	//$pdf->Cell(30,7,'Uang Sejumlah    : ');
	//$pdf->Cell(47);
        //$pdf->SetFont('Times','B',10);
	//$pdf->Cell(50,7,strtoupper($terbilang).' RUPIAH');
	
	//$pdf->SetFont('Times','',11);
	//$pdf->Ln(14);
	//$pdf->Cell(20);
	//$pdf->Cell(10,7,'Sudah Terima dari');
	//$pdf->Cell(47);
	//$pdf->Cell(30,60,$row['keterangan']);
	
	
	$pdf->SetFont('Times','',11);
	$pdf->Ln(8);
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
	$pdf->MultiCell(118,7,''. strtoupper($row['detail']),'','L');
	

	$pdf->SetFont('Arial','B',10);
	$pdf->Ln(5);
	$pdf->Cell(30);
	$pdf->Cell(10,7,'Terbilang');
	$pdf->Cell(10);
	$pdf->SetFont('Times','IB',16);
	$pdf->Cell(10,7,'RP.   ');
	$pdf->SetTextColor(0);
	$pdf->SetFillColor(224,235,255);
	$pdf->MultiCell(50,7,''. number_format($row['jumlah']),'1','1','C');

	$pdf->SetFont('Arial','B',10);
	$pdf->SetTextColor(00,00,00);
	$pdf->Cell(135);
	$pdf->Cell(10,7,'Jakarta, '.$hari. ' - '.$bulan. ' - '.$tahun);

        	if($row['jenis_bayar']!='')
{

		$pdf->Ln(15);
		$pdf->Cell(30);
		$pdf->MultiCell(95,5,'Catatan :'. $row['jenis_bayar']. ' - ' . $row['bank']);
		
}		
                $pdf->Ln(15);
		$pdf->Cell(30);
		$pdf->MultiCell(110,5,'Pembayaran dengan Cheque/Bilyet Giro Belum dianggap Lunas apabila belum di Clearing oleh Bank yang Bersangkutan','1','L');
	
	$pdf->Output();

?>
<script>
  window.print();
</script>