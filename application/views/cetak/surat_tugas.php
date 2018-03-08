<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$pdf->SetMargins(20, 15, 20);
	$title = 'Cetak Surat Tugas';
	$pdf->SetTitle($title);
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','UB',18);
	$w = $pdf->GetStringWidth("SURAT TUGAS");
	$pdf->SetX(($pdf->w -$w)/2);
	$pdf->Cell($w,9,"SURAT TUGAS",0,0,'C');
	$pdf->Ln(7);
	$w = $pdf->GetStringWidth("No. ..../FC-HR/..../2017");
	$pdf->SetX(($pdf->w -$w)/2);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell($w,9,"No. ..../FC-HR/..../2017",0,0,'C');
	$pdf->Ln(15);
	$pdf->Cell(0,6,"Yang bertanda tangan dibawah ini, Saya :",0,1,'L');
	$pdf->Cell(10);
	$pdf->Cell(1,6,"Nama",0,0,'L');
	$pdf->Cell(20);
	$pdf->Cell(2,6," : Alif Bintoro",0,1,'L');
	$pdf->Cell(10);
	$pdf->Cell(1,6,"Posisi",0,0,'L');
	$pdf->Cell(20);
	$pdf->Cell(2,6," : Staff IT",0,1,'L');
	$pdf->ln(10);
	$pdf->Cell(0,6,"Menugaskan kepada karyawan dibawah ini :",0,1,'L');
	$pdf->SetFont('Arial','B',11);
	$pdf->ln(8);
	$pdf->SetFont('Arial','B',11);
    $pdf->SetX(($pdf->w - 160)/2);
    $pdf->Cell(10,6,"No",1,0,'C');
	$pdf->Cell(75,6,"Nama",1,0,'C');
	$pdf->Cell(75,6,"Jabatan",1,1,'C');
    $pdf->SetFont('Arial','',11);
    $pdf->SetWidths(array(10,75,75));
    $pdf->SetX(($pdf->w - 160)/2);
    $pdf->Row(array(
    			array("1",'C'),
    			array("Alif Bintoro",'L'),
    			array("Staff IT",'L'),
    		));
    $pdf->SetX(($pdf->w - 160)/2);
    $pdf->Row(array(
    			array("2",'C'),
    			array("Kania Ajeng Mei Riani",'L'),
    			array("Staff IT",'L'),
    		));
	$pdf->ln(8);
	$pdf->SetFont('Arial','',11);
	$pdf->MultiCell(0,6,"Untuk..........................................................................................................................................................................................................................................................................................................................................................................................Pada Tanggal........s.d....................");
	$pdf->ln(8);
	$pdf->MultiCell(0,6,"Surat Tugas ini dibuat dengan sebenar-benarnya dan dapat dipergunakan sebagaimana mestinya.");
	$pdf->ln(8);
	$pdf->Cell(0,6,"Surakarta, 25 April 2017",0,1,'R');
	$pdf->Cell(0,6,"Pemberi Tugas",0,1,'R');
	$pdf->ln(20);
	$pdf->Cell(0,6,"(Alif Bintoro)",0,1,'R');
	$pdf->Cell(0,6,"Tembusan :",0,1,'L');
	$pdf->Cell(0,6,"1. File",0,1,'L');
	$pdf->Output("SuratTugas_0001_112017.pdf","I");