<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$maintitle = $data['jenis_permohonan'];
	$name = $data['nama'];
	$job = $data['jabatan'];
	$reason = $data['alasan'];
	$date = $data['hari']."/".$data['tanggal'];

	$pdf->SetMargins(20, 15, 20);
	$title = 'Cetak Surat '.$maintitle;
	$pdf->SetTitle($title);
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','UB',16);
	$w = $pdf->GetStringWidth("PEMBERIAN IZIN");
	$pdf->SetX(($pdf->w -$w)/2);
	$pdf->Cell($w,9,"PEMBERIAN IZIN",0,0,'C');
	$pdf->Ln(7);
	$w = $pdf->GetStringWidth("Nomor: ..../FC-HR/..../2017");
	$pdf->SetX(($pdf->w -$w)/2);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell($w,9,"No. ..../FC-HR/..../2017",0,0,'C');
	$pdf->Ln(15);
	$pdf->Cell(0,6,"Bahwa yang bersangkutan:",0,1,"L");
	$pdf->Ln(5);
	$pdf->Cell(10);
	$pdf->Cell(1,6,"Nama",0,0,"L");
	$pdf->Cell(20);
	$pdf->Cell(2,6,": ".$name,0,1,"L");
	$pdf->Cell(10);
	$pdf->Cell(1,6,"Jabatan",0,0,"L");
	$pdf->Cell(20);
	$pdf->Cell(2,6,": ".$job,0,1,"L");
	$pdf->Ln(5);
	$pdf->MultiCell(0,6,"Dengan ini menerangkan bahwa Kami telah menyetujui permohonan Saudara untuk izin ".$maintitle." Pada hari/tanggal ".$date." dikarenakan ".$reason,0,"J");
	$pdf->Ln(5);
	$pdf->Cell(0,6,"Surakarta, 28 November 2017",0,1,"R");
	$pdf->Cell(0,6,"Manager HRO,",0,1,"R");
	$pdf->Ln(20);
	$pdf->Cell(0,6,"Alif Bintoro",0,1,"R");
	$pdf->Output("IzinTerlambatMasuk_Alif_Bintoro_25112017.pdf","I");