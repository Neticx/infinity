<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$pdf->SetMargins(20, 15, 20);
	$title = 'Cetak Surat Pengingat Pembayaran Siswa';
	$pdf->SetTitle($title);
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','',11);
	$pdf->Cell(1,6,"Perihal",0,0,"L");
	$pdf->Cell(20);
	$pdf->Cell(2,6,":",0,0,"L");
	$pdf->Cell(2);
	$pdf->Cell(3,6,"Pembayaran Siswa",0,1,"L");
	$pdf->Cell(1,6,"Kepada",0,0,"L");
	$pdf->Cell(20);
	$pdf->Cell(2,6,":",0,1,"L");
	$pdf->Cell(0,6,"Yth. Bapa/Ibu Wali Siswa",0,1,"L");
	$pdf->Cell(0,6,$siswa['nama'],0,1,"L");
	$pdf->Cell(0,6,$nama_cabang,0,1,"L");
	$pdf->Cell(0,6,"di tempat",0,1,"L");
	$pdf->Ln(7);
	$pdf->Cell(0,6,"Dengan hormat,",0,1,"L");
	$pdf->MultiCell(0,6,"Terima kasih atas kepercayaan Bapak/Ibu telah memilih InfinitySTAN sebagai tempat untuk belajar dalam rangka persiapan masuk PKN STAN. Kami mendoakan semoga putra/putri Bapak/Ibu lulus dan menjadi Mahasiswa PKN STAN.",0,"J");
	$pdf->MultiCell(0,6,"Untuk memastikan pelayanan berjalan dengan optimal serta memberikan kwalitas pengajaran kepada seluruh siswa InfinitySTAN kami mohon kebijaksanaan Bapak/Ibu untuk segera menyelesaikan kewajiban pembayaran Bimbingan Belajar:",0,"J");
	$pdf->Ln(3);
	$pdf->Cell(10);
	$pdf->Cell(1,6,"Nama Siswa",0,0,"L");
	$pdf->Cell(30);
	$pdf->Cell(2,6,":",0,0,"L");
	$pdf->Cell(2);
	$pdf->Cell(3,6,$siswa['nama'],0,1,"L");
	$pdf->Cell(10);
	$pdf->Cell(1,6,"Program",0,0,"L");
	$pdf->Cell(30);
	$pdf->Cell(2,6,":",0,0,"L");
	$pdf->Cell(2);
	$pdf->Cell(3,6,$siswa['nama_program'],0,1,"L");
	$pdf->Ln(3);
	$pdf->Cell(0,6,"dengan rincian pembayaran sebagai berikut :",0,1,"L");
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',11);
    $pdf->SetX(($pdf->w - 120)/2);
    $pdf->Cell(80,6,"Uraian",1,0,'C');
	$pdf->Cell(40,6,"Jumlah",1,1,'C');
    $pdf->SetFont('Arial','',11);
    $pdf->SetWidths(array(80,40));
    $pdf->SetX(($pdf->w - 120)/2);
    $pdf->Row(array(
    			array("Biaya Pendaftaran",'L'),
    			array(formatRP($biaya_pendaftaran),'L'),
    		));
    $pdf->SetX(($pdf->w - 120)/2);
    $pdf->Row(array(
    			array("Biaya Program yang harus dibayar",'L'),
    			array(formatRP($biaya_program),'L'),
    		));
    $pdf->SetX(($pdf->w - 120)/2);
    $pdf->SetFont('Arial','B',11);
    $pdf->Row(array(
    			array("Total yang sudah dibayarkan",'L'),
    			array(formatRP($total_bayar),'L'),
    		));
    $pdf->SetX(($pdf->w - 120)/2);
    $pdf->SetFont('Arial','IB',11);
    $pdf->Row(array(
    			array("Kekurangan Pembayaran",'L'),
    			array(formatRP($kekurangan),'L'),
    		));
	$pdf->Ln(5);
    $pdf->SetFont('Arial','',11);
	$pdf->MultiCell(0,6,"Dari data tersebut diketahui bahwa masih terdapat kekurangan Pembayaran. Mohon segera dilakukan pencicilan atau pelunasan. Paling lambat tanggal ".$tanggal.". Pembayaran hanya dapat dilakukan melalui Rekening PT. Infinity Global Inspiratif ( Bank BNI 0909012346 a/n Pt.Infinity global Inspiratif ). Jika Bapak/Ibu sudah melakukan pembayaran, namun belum tercatat pada sistem kami, mohon untuk bisa memberikan klarifikasi disertai dengan bukti transfer terkait.",0,"J");
	$pdf->MultiCell(0,6,"Demikian disampaikan, terima kasih atas perhatian dan kerjasamanya.",0,"J");
	$pdf->Cell(0,6,"Salam,",0,1,"R");
	$pdf->Cell(0,6,"Kepala Cabang",0,1,"R");
	$pdf->Ln(20);
	$pdf->Cell(0,6,$nama_kc,0,1,"R");
	$pdf->Output("PengingatPembayaranSiswa_".$siswa['nama']."_".date('dmY').".pdf","I");