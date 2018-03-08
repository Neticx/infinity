<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$pdf->SetMargins(20, 15, 20);
    $title = 'Cetak Form Lembur Karyawan';
    $pdf->SetTitle($title);
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetFont('Arial','UB',18);
    $w = $pdf->GetStringWidth("FORM LEMBUR KARYAWAN");
    $pdf->SetX(($pdf->w -$w)/2);
    $pdf->Cell($w,9,"FORM LEMBUR KARYAWAN",0,0,'C');
    $pdf->Ln(15);
    $pdf->Cell(10);
    $pdf->SetFont('Arial','',11);
    $pdf->Cell(1,6,"Nama",0,0,'L');
    $pdf->Cell(48);
    $pdf->Cell(2,6," : Alif Bintoro",0,1,'L');
    $pdf->Cell(10);
    $pdf->Cell(1,6,"Posisi",0,0,'L');
    $pdf->Cell(48);
    $pdf->Cell(2,6," : Staff IT",0,1,'L');
    $pdf->Cell(10);
    $pdf->Cell(1,6,"Divisi",0,0,'L');
    $pdf->Cell(48);
    $pdf->Cell(2,6," : IT",0,1,'L');
    $pdf->Ln(10);
    $pdf->SetFont('Arial','B',11);
    $pdf->SetX(($pdf->w - 168)/2);
    $pdf->Cell(32,6,"Tanggal",1,0,'C');
	$pdf->Cell(38,6,"Jam Mulai Lembur",1,0,'C');
	$pdf->Cell(38,6,"Jam Selesai Lembur",1,0,'C');
	$pdf->Cell(60,6,"Alasan Terjadi Kerja Lembur",1,1,'C');
    $pdf->SetFont('Arial','',11);
    $pdf->SetX(($pdf->w - 168)/2);
    $pdf->SetWidths(array(32,38,38,60));
    $pdf->Row(array(
    			array("27 Nov 2017",'C'),
    			array("06:00",'C'),
    			array("09:00",'C'),
    			array("Alasan Terjadi Kerja Lembur Alasan Terjadi Kerja Lembur Alasan Terjadi Kerja Lembur ",'J'),
    		));
    $pdf->Ln(15);
    $pdf->line($pdf->GetX(), $pdf->GetY(), $pdf->GetX()+($pdf->w-40), $pdf->GetY());
    $pdf->Ln(10);
    $pdf->Cell(0,6,"Yang bertandatangan dibawah ini : ",0,1,'C');
    $pdf->Cell(0,6,"Atasan Karyawan :",0,0,'L');
    $pdf->Cell(0,6,"Karyawan :",0,1,'R');
    $pdf->ln(20);
    $pdf->Cell(0,6,"(Alif Bintoro)",0,0,'L');
    $pdf->Cell(0,6,"(Alif Bintoro)",0,1,'R');
    $pdf->Output("FormLembur_Alif_Bintoro_25112017.pdf","I");