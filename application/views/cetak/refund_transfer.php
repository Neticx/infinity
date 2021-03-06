<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$pdf->SetMargins(20, 15, 20);
	$title = 'Surat Teguran';
	$pdf->SetTitle($title);
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','UB',16);
	$w = $pdf->GetStringWidth("Form Refund");
	$pdf->SetX(($pdf->w -$w)/2);
	$pdf->Cell($w,9,"Form Refund",0,0,'C');
	$pdf->Ln(7);
	$w = $pdf->GetStringWidth("Nomor. ".$surat['nomor_surat']);
	$pdf->SetX(($pdf->w -$w)/2);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell($w,9,"Nomor. ".$surat['nomor_surat'],0,0,'C');
	$pdf->Ln(15);
	$pdf->Cell(5);
	$pdf->Cell(1,6,"Nama",0,0,'L');
	$pdf->Cell(48);
	$pdf->Cell(2,6," : ".$surat['nama_siswa'],0,1,'L');
	$pdf->Cell(5);
	$pdf->Cell(1,6,"Program Bimbel",0,0,'L');
	$pdf->Cell(48);
	$pdf->Cell(2,6," : ".$surat['nama_program'],0,1,'L');
	$pdf->Cell(5);
	$pdf->Cell(1,6,"Harga Program",0,0,'L');
	$pdf->Cell(48);
	$pdf->Cell(2,6," : ".formatRP($surat['harga_program']),0,1,'L');
	$pdf->Cell(5);
	$pdf->Cell(1,6,"Diskon",0,0,'L');
	$pdf->Cell(48);
	$pdf->Cell(2,6," : ".formatRP($surat['diskon']),0,1,'L');
	$pdf->Cell(5);
	$pdf->Cell(1,6,"Yang Harus Dibayarkan",0,0,'L');
	$pdf->Cell(48);
	$pdf->Cell(2,6," : ".formatRP($surat['harus_bayar']),0,1,'L');
	$pdf->Cell(5);
	$pdf->Cell(1,6,"Jumlah Pembayaran",0,0,'L');
	$pdf->Cell(48);
	$pdf->Cell(2,6," : ".formatRP($surat['total_bayar']),0,1,'L');
	$pdf->Cell(5);
	$pdf->Cell(1,6,"Sisa Pembayaran",0,0,'L');
	$pdf->Cell(48);
	$pdf->Cell(2,6," : ".formatRP($surat['sisa_bayar']),0,1,'L');
	$pdf->Cell(5);
	$pdf->Cell(1,6,"Alasan Refund",0,0,'L');
	$pdf->Cell(48);
	$pdf->MultiCell(0,6," : ".$surat['alasan_refund']);
	$pdf->Ln(8);
	$pdf->Ln(10);
	$pdf->Cell(0,6,"Hormat Kami,",0,1,"R");
	$pdf->Cell(0,6,"Konsultan",0,1,"R");
	$pdf->Ln(20);
	$pdf->Cell(0,6,$surat['konsultan'],0,1,"R");
	$pdf->Output("SuratPeringatan_.pdf","I");