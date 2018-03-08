<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$pdf->SetMargins(20, 15, 20);
	$title = 'Cetak Surat Pemberian Virtual Account';
	$pdf->SetTitle($title);
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1,6,"Nomor",0,0,"L");
	$pdf->Cell(20);
	$pdf->Cell(2,6,":",0,0,"L");
	$pdf->Cell(2);
	$pdf->Cell(3,6,"0001/PEM_VA/XI/2017",0,1,"L");
	$pdf->Cell(1,6,"Perihal",0,0,"L");
	$pdf->Cell(20);
	$pdf->Cell(2,6,":",0,0,"L");
	$pdf->Cell(2);
	$pdf->Cell(3,6,"Pemberian Nomor Virtual Account",0,1,"L");
	$pdf->Cell(1,6,"Tanggal",0,0,"L");
	$pdf->Cell(20);
	$pdf->Cell(2,6,":",0,0,"L");
	$pdf->Cell(2);
	$pdf->Cell(3,6,"27 November 2017",0,1,"L");
	$pdf->Cell(1,6,"Kepada",0,0,"L");
	$pdf->Cell(20);
	$pdf->Cell(2,6,":",0,1,"L");
	$pdf->Cell(0,6,"Yth. Kepala Cabang Surakarta",0,1,"L");
	$pdf->Cell(0,6,"di tempat",0,1,"L");
	$pdf->Ln(10);
	$pdf->Cell(0,6,"Dengan hormat,",0,1,'L');
	$pdf->MultiCell(0,6,"Sesuai surat permohonan Bapak/Ibu Kepala Cabang ........ Perihal permohonan pembuatan virtual account untuk siswa Cabang ......... Kami telah mengaktifkan semua nomor Virtual Account seperti yang Bapak/Ibu mohonkan, yaitu:",0,'J');
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
	$pdf->MultiCell(0,6,"Demikian disampaikan, atas perhatian Bapak/Ibu kami sampaikan terima kasih.",0,'J');
	$pdf->Ln(8);
	$pdf->Cell(0,6,"Salam,",0,1,"R");
	$pdf->Cell(0,6,"<<jabatan pengirim>>",0,1,"R");
	$pdf->Ln(20);
	$pdf->Cell(0,6,"Alif Bintoro",0,1,"R");
	$pdf->Output("SuratPemberianVirtualAccount_0001_27112017.pdf","I");