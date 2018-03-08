<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$pdf->SetMargins(20, 15, 20);
	$title = 'Cetak Rollover Kas Kecil';
	$pdf->SetTitle($title);
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','UB',16);
	$w = $pdf->GetStringWidth("Permintaan Pengisian kembali Kas Kecil");
	$pdf->SetX(($pdf->w -$w)/2);
	$pdf->Cell($w,9,"Permintaan Pengisian kembali Kas Kecil",0,0,'C');
	$pdf->SetFont('Arial','',11);
	$pdf->Ln(15);
	$pdf->Cell(0,6,"Dengan ini saya Kepala cabang ".$cabang['nama'],0,1,'L');
	$pdf->ln(5);
	$pdf->Cell(0,6,"Mengajukan untuk pengisian kembali kas kecil di cabang ".$cabang['nama'],0,1,'L');
	$pdf->Cell(15);
	$pdf->Cell(1,6,"Sebesar",0,0,'L');
	$pdf->Cell(20);
	$pdf->Cell(2,6," : ".formatRP($surat['nominal']),0,1,'L');
    $pdf->Ln(10);
	$pdf->MultiCell(0,6,"Lampiran pengajuan permintaan pengisian kembali kas kecil kami sertakan dalam attachment surat ini.",0,'J');
	$pdf->Ln(8);
	$pdf->SetWidths(array(50,10,50,10,50));
	$pdf->SetX(($pdf->w - 170)/2);
	$pdf->RowNoBorder(array(
				array(",","C"),
				array(""),
				array("","C"),
				array(""),
				array("Salam","C")
			));
	$pdf->SetX(($pdf->w - 170)/2);
	$pdf->RowNoBorder(array(
				array("","C"),
				array(""),
				array("","C"),
				array(""),
				array("Kepala Cabang,","C")
			));
	$pdf->Ln(20);
	$pdf->SetX(($pdf->w - 170)/2);
	$pdf->RowNoBorder(array(
				array("","C"),
				array(""),
				array("","C"),
				array(""),
				array($surat['nama'],"C")
			));
	$pdf->Output("SuratRolloverKas_".date('Y-m-d H:i:s').".pdf","I");