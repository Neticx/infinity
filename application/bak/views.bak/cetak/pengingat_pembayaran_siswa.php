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
	$pdf->Cell(0,6,"Alif Bintoro",0,1,"L");
	$pdf->Cell(0,6,"Cabang Surakarta Infinity STAN",0,1,"L");
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
	$pdf->Cell(3,6,"Alif Bintoro",0,1,"L");
	$pdf->Cell(10);
	$pdf->Cell(1,6,"Program",0,0,"L");
	$pdf->Cell(30);
	$pdf->Cell(2,6,":",0,0,"L");
	$pdf->Cell(2);
	$pdf->Cell(3,6,"Alif Bintoro",0,1,"L");
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
    			array("Rp. 295.000",'L'),
    		));
    $pdf->SetX(($pdf->w - 120)/2);
    $pdf->Row(array(
    			array("Biaya Program yang harus dibayar",'L'),
    			array("Rp. 15.000.000",'L'),
    		));
    $pdf->SetX(($pdf->w - 120)/2);
    $pdf->SetFont('Arial','B',11);
    $pdf->Row(array(
    			array("Total yang sudah dibayarkan",'L'),
    			array("Rp. 15.295.000",'L'),
    		));
    $pdf->SetX(($pdf->w - 120)/2);
    $pdf->SetFont('Arial','IB',11);
    $pdf->Row(array(
    			array("Kekurangan Pembayaran",'L'),
    			array("Rp. 2.300.000",'L'),
    		));
	$pdf->Ln(5);
    $pdf->SetFont('Arial','',11);
	$pdf->MultiCell(0,6,"Dari data tersebut diketahui bahwa masih terdapat kekurangan Pembayaran. Mohon segera dilakukan pencicilan atau pelunasan. Paling lambat tanggal <b>.........2017</b>. Pembayaran hanya dapat dilakukan melalui Rekening <b>PT. Infinity Global Inspiratif ( Bank BNI 0909012346 a/n Pt.Infinity global Inspiratif )</b>. Jika Bapak/Ibu sudah melakukan pembayaran, namun belum tercatat pada sistem kami, mohon untuk bisa memberikan klarifikasi disertai dengan bukti transfer terkait.",0,"J");
	$pdf->MultiCell(0,6,"Demikian disampaikan, terima kasih atas perhatian dan kerjasamanya.",0,"J");
	$pdf->Cell(0,6,"Salam,",0,1,"R");
	$pdf->Cell(0,6,"Kepala Cabang",0,1,"R");
	$pdf->Ln(20);
	$pdf->Cell(0,6,"Alif Bintoro",0,1,"R");
	$pdf->Output("PengingatPembayaranSiswa_Alif_Bintoro_27112017.pdf","I");