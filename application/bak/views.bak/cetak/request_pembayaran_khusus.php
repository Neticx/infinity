<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$pdf->SetMargins(20, 15, 20);
	$title = 'Cetak Request Pembayaran Khusus';
	$pdf->SetTitle($title);
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1,6,"Nomor",0,0,"L");
	$pdf->Cell(20);
	$pdf->Cell(2,6,":",0,0,"L");
	$pdf->Cell(2);
	$pdf->Cell(3,6,"0001/CAB0001/REQ_PEM/XI/2017",0,1,"L");
	$pdf->Cell(1,6,"Perihal",0,0,"L");
	$pdf->Cell(20);
	$pdf->Cell(2,6,":",0,0,"L");
	$pdf->Cell(2);
	$pdf->Cell(3,6,"Request Pembayaran Khusus",0,1,"L");
	$pdf->Cell(1,6,"Kepada",0,0,"L");
	$pdf->Cell(20);
	$pdf->Cell(2,6,":",0,1,"L");
	$pdf->Cell(0,6,"Yth. Manajer Keuangan dan Produk",0,1,"L");
	$pdf->Cell(0,6,"Infinity STAN",0,1,"L");
	$pdf->Cell(0,6,"di tempat",0,1,"L");
	$pdf->Ln(10);
	$pdf->Cell(0,6,"Dengan hormat,",0,1,"L");
	$pdf->Cell(0,6,"Yang bertanda tangan dibawah ini, saya Konsultan :",0,1,"L");
	$pdf->Cell(10);
	$pdf->Cell(1,6,"Nama",0,0,"L");
	$pdf->Cell(20);
	$pdf->Cell(2,6,":",0,0,"L");
	$pdf->Cell(2);
	$pdf->Cell(3,6,"Alif Bintoro",0,1,"L");
	$pdf->Cell(10);
	$pdf->Cell(1,6,"Cabang",0,0,"L");
	$pdf->Cell(20);
	$pdf->Cell(2,6,":",0,0,"L");
	$pdf->Cell(2);
	$pdf->Cell(3,6,"Bimbel Infinity Surakarta",0,1,"L");
	$pdf->Ln(5);
	$pdf->Cell(0,6,"Mengajukan usulan untuk Calon Siswa :",0,1,"L");
	$pdf->SetWidths(array(20,5,$pdf->w - 75));
	$pdf->SetX(30);
	$pdf->RowNoBorder(array(
				array("Nama","L"),
				array(":","C"),
				array("Alif Bintoro","L"),
			));
	$pdf->Ln(1);
	$pdf->SetX(30);
	$pdf->RowNoBorder(array(
				array("Alamat","J"),
				array(":","C"),
				array("Alif Bintoro","L"),
			));
	$pdf->Ln(1);
	$pdf->SetX(30);
	$pdf->RowNoBorder(array(
				array("Program","L"),
				array(":","C"),
				array("Alif Bintoro","L"),
			));
	$pdf->Ln(5);
	$pdf->MultiCell(0,6,"Untuk melakukan pembayaran program belajarnya secara cicilan dengan ketentuan sebagai berikut:",0,"J");
	$pdf->Ln(5);
	$pdf->SetWidths(array(30,50));
	$pdf->SetX(30);
	$pdf->Row(array(
				array("Cicilan 1","L"),
				array("","L")
			));
	$pdf->SetX(30);
	$pdf->Row(array(
				array("Cicilan 2","L"),
				array("","L")
			));
	$pdf->SetX(30);
	$pdf->Row(array(
				array("Cicilan 3","L"),
				array("","L")
			));
	$pdf->SetX(30);
	$pdf->Row(array(
				array("Cicilan 4","L"),
				array("","L")
			));
	$pdf->Ln(7);
	$pdf->MultiCell(0,6,"Demikian surat permohonan ini kami sampaikan kepada Bapak/Ibu Manajer Keuangan dan Produk Kantor Pusat InfinitySTAN berkenan mengabulkannya.",0,"J");
	$pdf->Ln(7);
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
	$pdf->Output("ReqPembayaran_0001_CAB0001.pdf","I");