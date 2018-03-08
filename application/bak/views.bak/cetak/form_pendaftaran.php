<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	$pdf->SetMargins(20, 15, 20);
	$title = 'Cetak Form Pendaftaran';
	$pdf->SetTitle($title);
	$pdf->AliasNbPages();
	$pdf->AddPage();
	$pdf->SetFont('Arial','UB',18);
	$w = $pdf->GetStringWidth("FORMULIR PENDAFTARAN");
	$pdf->SetX(($pdf->w -$w)/2);
	$pdf->Cell($w,9,"FORMULIR PENDAFTARAN",0,0,'C');
	$pdf->Ln(10);
	$noSurat = "No. ".$siswa['no_pendaftaran']."/PENDAFTARAN/".$romawi[date('m', strtotime($siswa['tanggal_input']))]."/".$siswa['tahun'];
	$w = $pdf->GetStringWidth($noSurat);
	$pdf->SetX(($pdf->w -$w)/2);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell($w,9,$noSurat,0,0,'C');
	$pdf->Ln(5);
	$tanggalDaftar = date('j', strtotime($siswa['tanggal_input'])) . " " . $seBulan[date('m', strtotime($siswa['tanggal_input']))] . " " . date('Y', strtotime($siswa['tanggal_input']));
	$w = $pdf->GetStringWidth("Tanggal : " . $tanggalDaftar);
	$pdf->SetX(($pdf->w -$w)/2);
	$pdf->SetFont('Arial','',11);
	$pdf->Cell($w,9,"Tanggal : " . $tanggalDaftar,0,0,'C');
	$pdf->Ln(5);
    $pdf->SetWidths(array(42,5,$pdf->w - 105));
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(1,6,"DATA SISWA",0,1,'L');
	$pdf->ln(5);
	$pdf->SetFont('Arial','',11);
    $pdf->RowNoBorder(array(
    			array("Nama Lengkap"),
    			array(":","C"),
    			array(strtoupper($siswa['nama']))
    		));
	$pdf->line($pdf->GetX()+47, $pdf->GetY(), $pdf->GetX()+($pdf->w-40), $pdf->GetY());
	$pdf->Ln(3);
	$tglLahir = date('j', strtotime($siswa['tgl_lahir'])) . " " . $seBulan[date('m', strtotime($siswa['tgl_lahir']))] . " " . date('Y', strtotime($siswa['tgl_lahir']));
    $pdf->RowNoBorder(array(
    			array("Tempat, Tanggal Lahir"),
    			array(":","C"),
    			array(strtoupper($siswa['tmpt_lahir']).", ".$tglLahir)
    		));
	$pdf->line($pdf->GetX()+47, $pdf->GetY(), $pdf->GetX()+($pdf->w-40), $pdf->GetY());
	$pdf->Ln(3);
	$pdf->RowNoBorder(array(
    			array("Jenis Kelamin"),
    			array(":","C"),
    			array(($siswa['jk']=='m')?"LAKI-LAKI":"PEREMPUAN")
    		));
	$pdf->line($pdf->GetX()+47, $pdf->GetY(), $pdf->GetX()+($pdf->w-40), $pdf->GetY());
	$pdf->Ln(3);
	$pdf->RowNoBorder(array(
    			array("Alamat"),
    			array(":","C"),
    			array($siswa['alamat'].', '.$siswa['kecsis'].', '.$siswa['kabsis'].', '.$siswa['provsis'])
    		));
	$pdf->line($pdf->GetX()+47, $pdf->GetY(), $pdf->GetX()+($pdf->w-40), $pdf->GetY());
	$pdf->Ln(3);
	$pdf->RowNoBorder(array(
    			array("Nomor Handphone"),
    			array(":","C"),
    			array($siswa['no_hp'])
    		));
	$pdf->line($pdf->GetX()+47, $pdf->GetY(), $pdf->GetX()+($pdf->w-40), $pdf->GetY());
	$pdf->Ln(3);
	$pdf->RowNoBorder(array(
    			array("Email"),
    			array(":","C"),
    			array($siswa['email'])
    		));
	$pdf->line($pdf->GetX()+47, $pdf->GetY(), $pdf->GetX()+($pdf->w-40), $pdf->GetY());
	$pdf->Ln(3);
	$pdf->RowNoBorder(array(
    			array("Asal Sekolah"),
    			array(":","C"),
    			array(strtoupper($siswa['asal_sekolah']))
    		));
	$pdf->line($pdf->GetX()+47, $pdf->GetY(), $pdf->GetX()+($pdf->w-40), $pdf->GetY());
	$pdf->Ln(3);
	$pdf->RowNoBorder(array(
    			array("Tahun Kelulusan"),
    			array(":","C"),
    			array($siswa['tahun_lulus'])
    		));
	$pdf->line($pdf->GetX()+47, $pdf->GetY(), $pdf->GetX()+($pdf->w-40), $pdf->GetY());
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(1,6,"DATA WALI",0,1,'L');
	$pdf->ln(5);
	$pdf->SetFont('Arial','',11);
	$pdf->RowNoBorder(array(
    			array("Nama Wali"),
    			array(":","C"),
    			array(strtoupper($siswa['nama_wali']))
    		));
	$pdf->line($pdf->GetX()+47, $pdf->GetY(), $pdf->GetX()+($pdf->w-40), $pdf->GetY());
	$pdf->Ln(3);
	$pdf->RowNoBorder(array(
    			array("Alamat"),
    			array(":","C"),
    			array($siswa['alamat_wali'].', '.$siswa['kecwali'].', '.$siswa['kabwali'].', '.$siswa['provwali'])
    		));
	$pdf->line($pdf->GetX()+47, $pdf->GetY(), $pdf->GetX()+($pdf->w-40), $pdf->GetY());
	$pdf->Ln(3);
	$pdf->RowNoBorder(array(
    			array("Nomor Handphone"),
    			array(":","C"),
    			array($siswa['no_hp_wali'])
    		));
	$pdf->line($pdf->GetX()+47, $pdf->GetY(), $pdf->GetX()+($pdf->w-40), $pdf->GetY());
	$pdf->Ln(3);
	$pdf->RowNoBorder(array(
    			array("Email"),
    			array(":","C"),
    			array($siswa['email_wali'])
    		));
	$pdf->line($pdf->GetX()+47, $pdf->GetY(), $pdf->GetX()+($pdf->w-40), $pdf->GetY());
	$pdf->Ln(5);
	$pdf->SetFont('Arial','B',14);
	$pdf->Cell(1,6,"PROGRAM BIMBEL",0,1,'L');
	$pdf->ln(5);
	$pdf->SetFont('Arial','',11);
	$pdf->RowNoBorder(array(
    			array("Program yang dipilih"),
    			array(":","C"),
    			array($siswa['nama_program'])
    		));
	$pdf->line($pdf->GetX()+47, $pdf->GetY(), $pdf->GetX()+($pdf->w-40), $pdf->GetY());
	$pdf->Ln(3);
	$pdf->RowNoBorder(array(
    			array("Harga Program"),
    			array(":","C"),
    			array(formatRP($siswa['harga']))
    		));
	$pdf->line($pdf->GetX()+47, $pdf->GetY(), $pdf->GetX()+($pdf->w-40), $pdf->GetY());
	$pdf->Ln(3);
	$pdf->RowNoBorder(array(
    			array("Biaya Pendaftaran"),
    			array(":","C"),
    			array(formatRP($siswa['pendaftaran']))
    		));
	$pdf->line($pdf->GetX()+47, $pdf->GetY(), $pdf->GetX()+($pdf->w-40), $pdf->GetY());
	$pdf->Ln(7);
	$pdf->SetX(($pdf->w - 154)/2);
    $pdf->SetWidths(array(42,70,42));
    $pdf->RowNoBorder(array(
    			array("Penerima Pendaftaran","C"),
    			array(""),
    			array("Pendaftar","C"),
    		));
	$pdf->Ln(20);
	$pdf->SetX(($pdf->w - 154)/2);
	$pdf->RowNoBorder(array(
    			array(strtoupper($this->session->userdata("nama_user")),"C"),
    			array(""),
    			array(strtoupper($siswa['nama']),"C"),
    		));
	$pdf->Output("FormPendaftaran_Alif_Bintoro_27112017.pdf","I");