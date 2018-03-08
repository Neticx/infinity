<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cetak extends MY_Controller {

	private $romawi = array(
					'01' => 'I',
					'02' => 'II',
					'03' => 'III',
					'04' => 'IV',
					'05' => 'V',
					'06' => 'VI',
					'07' => 'VII',
					'08' => 'VIII',
					'09' => 'IX',
					'10' => 'X',
					'11' => 'XI',
					'12' => 'XII',
				);
	private $seBulan = array(
					'01' => 'Januari',
					'02' => 'Februari',
					'03' => 'Maret',
					'04' => 'April',
					'05' => 'Mei',
					'06' => 'Juni',
					'07' => 'Juli',
					'08' => 'Agustus',
					'09' => 'September',
					'10' => 'Oktober',
					'11' => 'November',
					'12' => 'Desember',
				);

	public function __construct()
	{
		parent::__construct();
		$this->load->library('pdf');
		$this->load->helper('formatting');
		$this->load->model('Cetak_model','cetak',true);
	}

	public function form_pendaftaran()
	{
		$id = $this->input->get("cabangID",true);
		$nis = $this->input->get("NIS",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->cetak->cekIdCabang($id) && $this->cetak->cekIdSiswa($nis)){
			$cb = $this->cetak->getDataCabang();
			$siswa = $this->cetak->getDataSiswa();
			$dataPDF = array(
					'judul' => 'BIMBEL INFINITY',
					'alamat' => $cb['alamat'],
					'region' => $cb['nama_kec'].', '.$cb['nama_kab'].', '.$cb['nama_prov'].' - '.$cb['kode_pos'],
					'telp' => $cb['no_telp'],
					'email' => $cb['email'],
				);
			$data = array(
				'pdf' => new pdf('P','mm','A4',$dataPDF),
				'siswa' => $siswa,
				'romawi' => $this->romawi,
				'seBulan' => $this->seBulan,
			);
		    $this->load->view('cetak/form_pendaftaran',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function form_cuti()
	{
		$dataPDF = array(
				'judul' => 'BIMBEL INFINITY',
				'alamat' => 'Jalan Pisok I Blok EA 15 No.1. Bintaro Sektor 5 Jurangmangu',
				'region' => 'Pondok Aren, Kota Tangerang Selatan, Banten - 15222',
				'telp' => '021-7358675',
				'email' => 'admin@bimbelinfinity.co.id',
			);
		$data = array('pdf' => new pdf('P','mm','A4',$dataPDF));
	    $this->load->view('cetak/form_cuti',$data);
	}

	public function form_izin()
	{
		$dataPDF = array(
				'judul' => 'BIMBEL INFINITY',
				'alamat' => 'Jalan Pisok I Blok EA 15 No.1. Bintaro Sektor 5 Jurangmangu',
				'region' => 'Pondok Aren, Kota Tangerang Selatan, Banten - 15222',
				'telp' => '021-7358675',
				'email' => 'admin@bimbelinfinity.co.id',
			);
	    $data = array('pdf' => new pdf('P','mm','A4',$dataPDF));
	    $this->load->view('cetak/form_izin', $data);
	}

	public function form_lembur()
	{
		$dataPDF = array(
				'judul' => 'BIMBEL INFINITY',
				'alamat' => 'Jalan Pisok I Blok EA 15 No.1. Bintaro Sektor 5 Jurangmangu',
				'region' => 'Pondok Aren, Kota Tangerang Selatan, Banten - 15222',
				'telp' => '021-7358675',
				'email' => 'admin@bimbelinfinity.co.id',
			);
	    $data = array(pdf => new pdf('P','mm','A4',$dataPDF));
	    $this->load->view('cetak/form_lembur', $data);
	}

	public function surat_tugas()
	{
		$dataPDF = array(
				'judul' => 'BIMBEL INFINITY',
				'alamat' => 'Jalan Pisok I Blok EA 15 No.1. Bintaro Sektor 5 Jurangmangu',
				'region' => 'Pondok Aren, Kota Tangerang Selatan, Banten - 15222',
				'telp' => '021-7358675',
				'email' => 'admin@bimbelinfinity.co.id',
			);
		$data = array('pdf' => new pdf('P','mm','A4',$dataPDF));
	    $this->load->view('cetak/surat_tugas',$data);
	}

	public function surat_perintah_lembur()
	{
		$dataPDF = array(
				'judul' => 'BIMBEL INFINITY',
				'alamat' => 'Jalan Pisok I Blok EA 15 No.1. Bintaro Sektor 5 Jurangmangu',
				'region' => 'Pondok Aren, Kota Tangerang Selatan, Banten - 15222',
				'telp' => '021-7358675',
				'email' => 'admin@bimbelinfinity.co.id',
			);
		$data = array('pdf' => new pdf('P','mm','A4',$dataPDF));
	    $this->load->view('cetak/surat_perintah_lembur',$data);
	}

	public function request_pembayaran_khusus()
	{
		$dataPDF = array(
				'judul' => 'BIMBEL INFINITY',
				'alamat' => 'Jalan Pisok I Blok EA 15 No.1. Bintaro Sektor 5 Jurangmangu',
				'region' => 'Pondok Aren, Kota Tangerang Selatan, Banten - 15222',
				'telp' => '021-7358675',
				'email' => 'admin@bimbelinfinity.co.id',
			);
		$data = array('pdf' => new pdf('P','mm','A4',$dataPDF));
	    $this->load->view('cetak/request_pembayaran_khusus',$data);
	}

	public function request_keuangan()
	{
		$dataPDF = array(
				'judul' => 'BIMBEL INFINITY',
				'alamat' => 'Jalan Pisok I Blok EA 15 No.1. Bintaro Sektor 5 Jurangmangu',
				'region' => 'Pondok Aren, Kota Tangerang Selatan, Banten - 15222',
				'telp' => '021-7358675',
				'email' => 'admin@bimbelinfinity.co.id',
			);
		$data = array('pdf' => new pdf('P','mm','A4',$dataPDF));
	    $this->load->view('cetak/request_uang_ke_keuangan',$data);
	}

	public function surat_penugasan_pengajar()
	{
		$dataPDF = array(
				'judul' => 'BIMBEL INFINITY',
				'alamat' => 'Jalan Pisok I Blok EA 15 No.1. Bintaro Sektor 5 Jurangmangu',
				'region' => 'Pondok Aren, Kota Tangerang Selatan, Banten - 15222',
				'telp' => '021-7358675',
				'email' => 'admin@bimbelinfinity.co.id',
			);
		$data = array('pdf' => new pdf('P','mm','A4',$dataPDF));
	    $this->load->view('cetak/surat_penugasan_pengajar',$data);
	}

	public function pembuatan_virtual_account()
	{
		$dataPDF = array(
				'judul' => 'BIMBEL INFINITY',
				'alamat' => 'Jalan Pisok I Blok EA 15 No.1. Bintaro Sektor 5 Jurangmangu',
				'region' => 'Pondok Aren, Kota Tangerang Selatan, Banten - 15222',
				'telp' => '021-7358675',
				'email' => 'admin@bimbelinfinity.co.id',
			);
		$data = array('pdf' => new pdf('P','mm','A4',$dataPDF));
	    $this->load->view('cetak/permintaan_pembuatan_virtual_account',$data);
	}

	public function pemberian_virtual_account()
	{
		$dataPDF = array(
				'judul' => 'BIMBEL INFINITY',
				'alamat' => 'Jalan Pisok I Blok EA 15 No.1. Bintaro Sektor 5 Jurangmangu',
				'region' => 'Pondok Aren, Kota Tangerang Selatan, Banten - 15222',
				'telp' => '021-7358675',
				'email' => 'admin@bimbelinfinity.co.id',
			);
		$data = array('pdf' => new pdf('P','mm','A4',$dataPDF));
	    $this->load->view('cetak/pemberian_virtual_account',$data);
	}

	public function pengingat_pembayaran_siswa()
	{
		$dataPDF = array(
				'judul' => 'BIMBEL INFINITY',
				'alamat' => 'Jalan Pisok I Blok EA 15 No.1. Bintaro Sektor 5 Jurangmangu',
				'region' => 'Pondok Aren, Kota Tangerang Selatan, Banten - 15222',
				'telp' => '021-7358675',
				'email' => 'admin@bimbelinfinity.co.id',
			);
		$data = array('pdf' => new pdf('P','mm','A4',$dataPDF));
	    $this->load->view('cetak/pengingat_pembayaran_siswa',$data);
	}

	public function surat_pemberian_izin()
	{
		$jenis = $this->input->get("jenis",true);
		$dataPDF = array(
				'judul' => 'BIMBEL INFINITY',
				'alamat' => 'Jalan Pisok I Blok EA 15 No.1. Bintaro Sektor 5 Jurangmangu',
				'region' => 'Pondok Aren, Kota Tangerang Selatan, Banten - 15222',
				'telp' => '021-7358675',
				'email' => 'admin@bimbelinfinity.co.id',
			);
		$data = array('pdf' => new pdf('P','mm','A4',$dataPDF));
		switch($jenis){
			case 'tidak_masuk':
	    		$this->load->view('cetak/surat_pemberian_izin_tidak_masuk',$data);
			break;

			case 'terlambat':
	    		$this->load->view('cetak/surat_pemberian_izin_terlambat',$data);
			break;

			case 'pulang_awal':
	    		$this->load->view('cetak/surat_pemberian_izin_pulang_mendahului',$data);
			break;

			default:
			break;
		}
	}

}