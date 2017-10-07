<?
	require "fpdf/fpdf.php";
	include_once "include.php";
	include_once "terbilang.php";
	include_once("p_bulan_sertifikat.php");

$id_siswa = $_GET['id_siswa'];

$sql_siswa="SELECT p.*, q.*, r.* FROM tb_siswa p, tb_program q, tb_narasumber r WHERE p.id_program = q.id_program AND p.id_narasumber= r.id_narasumber AND p.id_siswa = '$id_siswa'";
$rt=mysql_query($sql_siswa);
$data = mysql_fetch_array($rt);

$rb=mysql_query(" select distinct date_format(tgl_mulai,'%m') bulan from tb_siswa where id_siswa='$id_siswa'");
for($bl=0;$bl<@mysql_num_rows($rb);$bl++) {
$bulan2=mysql_result($rb,$bl,"bulan");
$bulan=nama_bulan($bulan2);
}

$rb=mysql_query(" select distinct date_format(tgl_mulai,'%Y') Tahun from tb_siswa where id_siswa='$id_siswa'");
for($bl=0;$bl<@mysql_num_rows($rb);$bl++) {
$tahun=mysql_result($rb,$bl,"Tahun");
}

$rb=mysql_query(" select distinct date_format(tgl_mulai,'%D') hari from tb_siswa where id_siswa='$id_siswa'");
for($bl=0;$bl<@mysql_num_rows($rb);$bl++) {
$hari1=mysql_result($rb,$bl,"hari");
}

$rb=mysql_query(" select distinct date_format(tgl_selesai,'%D') hari from tb_siswa where id_siswa='$id_siswa'");
for($bl=0;$bl<@mysql_num_rows($rb);$bl++) {
$hari2=mysql_result($rb,$bl,"hari");
}

$tgl = mysql_query("SELECT tgl_mulai, tgl_selesai FROM tb_siswa WHERE id_siswa='$id_siswa'");
$tgl_tampil=mysql_fetch_array($tgl);
$tgl1 = $tgl_tampil['tgl_mulai'];
$tgl2 = $tgl_tampil['tgl_selesai'];

$thn = substr($tahun,2,2);

class PDF extends FPDF
{
}

$pdf=new PDF("P", "mm", "A4");
	$pdf->AliasNbPages();
	$pdf->AddPage();
	
	//Set Font
	$pdf->SetFont('times','UB',24);
	$pdf->SetMargins(3.18,2.54);
	//Move to Right
	$pdf->Cell(130);
	$pdf->SetFont('Times','B',10);
	$pdf->Ln(7);
	$pdf->Cell(143);


	$pdf->SetFont('Arial','B',12);
	$pdf->Ln(45);
	$pdf->SetTextColor(184,134,11);
	$pdf->Cell(90);
	$pdf->Cell(20,10,'NOMOR : LBC/'.$data[24].'/'.$bulan2.''.$thn.'/'.$data[21].''.$data[1].'',10,10,'C');

	$pdf->SetFont('arial','',14);
	$pdf->Ln(15);
	$pdf->Cell(90);
	$pdf->Cell(20,10,'this document certifies that',10,10,'C');

	//Buat Garis
	$pdf->Line(50,117,160,117);

	$pdf->SetFont('Arial','B',22);
	$pdf->Ln(10);
	$pdf->SetTextColor(184,134,11);
	$pdf->Cell(90);
	$pdf->Cell(20,10,''.$data[2].'',10,10,'C');

	$pdf->SetFont('Arial','',16);
	$pdf->Ln(1);
	$pdf->Cell(90);
	$pdf->Cell(20,10,'For having participated in',10,10,'C');

	$pdf->SetFont('Arial','B',24); 
	$pdf->Ln(2);
	$pdf->SetTextColor(184,134,11);
	$pdf->Cell(90);
	$pdf->Cell(20,10,''.$data[20].'',10,10,'C');

	if($tgl1 == $tgl2) {

	$pdf->SetFont('Arial','B',18);
	$pdf->Ln(2);
	$pdf->Cell(90);
	$pdf->Cell(20,10,''.$bulan.', '.$hari1.' '.$tahun.' at GRAHA LIZA JAKARTA',10,10,'C');

	} else {

	$pdf->SetFont('Arial','B',18);
	$pdf->Ln(2);
	$pdf->Cell(90);
	$pdf->Cell(20,10,''.$bulan.', '.$hari1.'-'.$hari2.' '.$tahun.' at GRAHA LIZA JAKARTA',10,10,'C');
	
	}
        	
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

	$pdf->SetFont('times','B',20);
	$pdf->SetTextColor(00,00,00);
	$pdf->Ln(95);
	$pdf->SetTextColor(184,134,11);
	$pdf->Cell(95);
	$pdf->Cell(10,10,''.$data[25].'',10,10,'C');

	$pdf->Output();

?>