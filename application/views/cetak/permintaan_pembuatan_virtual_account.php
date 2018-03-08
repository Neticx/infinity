<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$pdf->SetMargins(20, 15, 20);
	$title = 'Cetak Surat Permohonan Pembuatan Virtual Account';
	$pdf->SetTitle($title);
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','UB',16);
	$w = $pdf->GetStringWidth("PERMOHONAN PEMBUATAN VIRTUAL ACCOUNT");
	$pdf->SetX(($pdf->w -$w)/2);
	$pdf->Cell($w,9,"PERMOHONAN PEMBUATAN VIRTUAL ACCOUNT",0,0,'C');
	$pdf->Ln(7);
	$w = $pdf->GetStringWidth("No. ..../FC-HR/..../2017");
	$pdf->SetX(($pdf->w -$w)/2);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell($w,9,"No. ..../FC-HR/..../2017",0,0,'C');
	$pdf->Ln(15);
	$pdf->Cell(0,6,"Yang bertanda tangan dibawah ini, Saya Konsultan:",0,1,'L');
	$pdf->Cell(10);
	$pdf->Cell(1,6,"Nama",0,0,'L');
	$pdf->Cell(20);
	$pdf->Cell(2,6," : Alif Bintoro",0,1,'L');
	$pdf->Cell(10);
	$pdf->Cell(1,6,"Cabang",0,0,'L');
	$pdf->Cell(20);
	$pdf->Cell(2,6," : Staff IT",0,1,'L');
	$pdf->ln(5);
	$pdf->Cell(0,6,"Mengajukan permohonan pembuatan virtual account untuk siswa kami berikut ini:",0,1,'L');
    $pdf->Ln(2);
	$pdf->SetFont('Arial','B',11);
    $pdf->SetX(($pdf->w - 145)/2);
    $pdf->Cell(7,6,"No",1,0,'C');
	$pdf->Cell(50,6,"Nama",1,0,'C');
	$pdf->Cell(38,6,"Program",1,0,'C');
	$pdf->Cell(50,6,"No Virtual Account",1,1,'C');
    $pdf->SetFont('Arial','',11);
    $pdf->SetX(($pdf->w - 145)/2);
    $pdf->SetWidths(array(7,50,38,50));
    $pdf->Row(array(
    			array("1",'C'),
    			array("Alif Bintoro",'C'),
    			array("DIAMOND",'C'),
    			array("1923798172937",'C'),
    		));
	$pdf->ln(8);
	$pdf->MultiCell(0,6,"Demikian surat permohonan ini kami sampaikan. Atas perhatian dan kerjasamanya kami sampaikan terima kasih.",0,'J');
	$pdf->Ln(8);
	$pdf->SetWidths(array(50,10,50,10,50));
	$pdf->SetX(($pdf->w - 170)/2);
	$pdf->RowNoBorder(array(
				array("Salam,","C"),
				array(""),
				array("Mengetahui","C"),
				array(""),
				array("Menyetujui","C")
			));
	$pdf->SetX(($pdf->w - 170)/2);
	$pdf->RowNoBorder(array(
				array("Konsultan","C"),
				array(""),
				array("Kepala Cabang","C"),
				array(""),
				array("Manajer Keuangan dan Produk","C")
			));
	$pdf->Ln(20);
	$pdf->SetX(($pdf->w - 170)/2);
	$pdf->RowNoBorder(array(
				array("Alif Bintoro","C"),
				array(""),
				array("Alif Bintoro","C"),
				array(""),
				array("Alif Bintoro","C")
			));
	$pdf->Output("SuratPermohonanPembuatanVirtualAccount_CAB0001_27112017.pdf","I");