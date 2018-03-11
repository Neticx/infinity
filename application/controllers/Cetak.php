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
		$this->load->helper('indonesian_date');
		$this->load->helper('formatting');

		/*ob_clean();
		header('Content-type: application/pdf');
		header('Content-Transfer-Encoding: binary');
		header('Accept-Ranges: bytes');*/
	}

	private function filterKota($kota)
	{
		$cari = array('kota','kabupaten','kab');
		$kota = strtolower($kota);
		$kota = trim(str_replace($cari, '', $kota));
		return ucfirst($kota);
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
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}
		$surat = $this->input->get('suratID',true);

		if($this->cetak->cekIdCabang($id) && $this->cetak->cekIdReqKeuangan($surat)){
			$cabang = $this->cetak->getDataCabang();
			$row = $this->cetak->getDataReqKeuangan();
			$dataPDF = array(
					'judul' => 'BIMBEL INFINITY',
					'alamat' => $cabang['alamat'],
					'region' => $cabang['nama_kec'].', '.$cabang['nama_kab'].', '.$cabang['nama_prov'].' - '.$cabang['kode_pos'],
					'telp' => $cabang['no_telp'],
					'email' => $cabang['email'],
				);
			$data = array(
					'pdf' => new pdf('P','mm','A4',$dataPDF),
					'nama_pegawai' => $row['nama'],
					'jabatan' => $row['jabatan'],
					'kegiatan' => $row['kegiatan'],
					'nominal' => $row['nominal'],
					'no_surat' => $row['nomor_surat']
				);
		    $this->load->view('cetak/request_uang_ke_keuangan',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function surat_penugasan_pengajar()
	{
		$id = $this->input->get('suratID',true);
		if($this->cetak->cekIdPenugasanPengajar($id)){
			$row = $this->cetak->getDataPenugasanPengajar();
			$this->cetak->cekIdCabang($row['id_cabang_tujuan']);
			$cabangTujuan = $this->cetak->getDataCabang();
			$dataPDF = array(
					'judul' => 'BIMBEL INFINITY',
					'alamat' => $row['alamat'],
					'region' => $row['nama_kec'].', '.$row['nama_kab'].', '.$row['nama_prov'].' - '.$row['kode_pos'],
					'telp' => $row['no_telp'],
					'email' => $row['email'],
				);
			$data = array(
					'pdf' => new pdf('P','mm','A4',$dataPDF),
					'nomor_surat' => $row['nomor_surat'],
					'cabang_sekarang' => $row['nama'],
					'cabang_tujuan' => $cabangTujuan['nama'],
					'nama_pengajar' => $row['nama_pengajar'],
					'bidang' => ($row['bidang']=='tpa')?'Tes Potensi Akademik':'Tes Bahasa Inggris',
					'materi' => $row['materi'],
					'kelas' => $row['nama_kelas'],
					'waktu' => $row['waktu_mulai'] . " - " .$row['waktu_selesai'],
					'kota' => $this->filterKota($row['nama_kab']),
					'nama_user' => $row['nama_user'],
				);
		    $this->load->view('cetak/surat_penugasan_pengajar',$data);
		}
		else{
			$this->error_404();
		}
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
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}
		$nis = $this->input->get('nis',true);
		$tanggal = date('d M Y', strtotime($this->input->get('paling_lambat',true)));

		if($this->cetak->cekIdCabang($id) && $this->cetak->cekIdSiswa($nis)){
			$cabang = $this->cetak->getDataCabang();
			$pembayaran = $this->cetak->getSiswaPembayaran($nis);
			$total_bayar = $this->cetak->getSiswaPembayaranCicilan($pembayaran['id_pembayaran']);

			$dataPDF = array(
					'judul' => 'BIMBEL INFINITY',
					'alamat' => $cabang['alamat'],
					'region' => $cabang['nama_kec'].', '.$cabang['nama_kab'].', '.$cabang['nama_prov'].' - '.$cabang['kode_pos'],
					'telp' => $cabang['no_telp'],
					'email' => $cabang['email'],
				);
			$data = array(
					'pdf' => new pdf('P','mm','A4',$dataPDF),
					'nama_cabang' => $cabang['nama'],
					'siswa' => $this->cetak->getDataSiswa(),
					'biaya_pendaftaran' => $pembayaran['biaya_pendaftaran'],
					'biaya_program' => $pembayaran['biaya_program'],
					'total_bayar' => $total_bayar,
					'kekurangan' => ($pembayaran['biaya_pendaftaran']+$pembayaran['biaya_program'])-$total_bayar,
					'tanggal' => $tanggal,
					'nama_kc' => $this->cetak->getKepalaCabang($id),
				);
		    $this->load->view('cetak/pengingat_pembayaran_siswa',$data);
		}
		else{
			$this->error_404();
		}

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
			case 'permohonan_izin':

				$data['data'] = array(
					'pdf' => new pdf('P','mm','A4',$dataPDF),
					'nama' => $this->input->post('nama'),
					'jabatan' => $this->input->post('jabatan'),
					'jenis_permohonan' =>  $this->input->post('jenis_permohonan'),
					'hari' => $this->input->post('hari'),
					'tanggal' =>  $this->input->post('tanggal'),
					'alasan' =>  $this->input->post('alasan'),
				);

				$this->load->view('cetak/surat_pemberian_izin_terlambat',$data);
			break;
			case 'terlambat':
				$data = array(
					'pdf' => new pdf('P','mm','A4',$dataPDF),
					'nama' => $this->input->post('nama'),
					'jabatan' => $this->input->post('jabatan'),
					'jenis_permohonan' =>  $this->input->post('jenis_permohonan'),
					'hari' => $this->input->post('hari'),
					'tanggal' =>  $this->input->post('tanggal'),
					'alasan' =>  $this->input->post('alasan'),
				);
	    		$this->load->view('cetak/surat_pemberian_izin_terlambat',$data);
			break;

			case 'pulang_awal':
				$data = array(
					'pdf' => new pdf('P','mm','A4',$dataPDF),
					'nama' => $this->input->post('nama'),
					'jabatan' => $this->input->post('jabatan'),
					'jenis_permohonan' =>  $this->input->post('jenis_permohonan'),
					'hari' => $this->input->post('hari'),
					'tanggal' =>  $this->input->post('tanggal'),
					'alasan' =>  $this->input->post('alasan'),
				);

	    		$this->load->view('cetak/surat_pemberian_izin_pulang_mendahului',$data);
			break;


			case 'izin_tidak_masuk_kerja':
				$data = array(
					'pdf' => new pdf('P','mm','A4',$dataPDF),
					'nama' => $this->input->post('nama'),
					'jabatan' => $this->input->post('jabatan'),
					'masa_kerja' => $this->input->post('masa_kerja'),
					'hari' => $this->input->post('hari'),
					'awal_tanggal' =>  $this->input->post('awal_tanggal'),
					'akhir_tanggal' =>  $this->input->post('akhir_tanggal'),
					'alasan' =>  $this->input->post('alasan'),
				);

				$this->load->view('cetak/surat_pemberian_izin_tidak_masuk',$data);
			break;

			default:
			break;
		}
	}

	public function surat_teguran()
	{
		$id = $this->input->get('suratID',true);
		$dataPDF = array(
				'judul' => 'BIMBEL INFINITY',
				'alamat' => 'Jalan Pisok I Blok EA 15 No.1. Bintaro Sektor 5 Jurangmangu',
				'region' => 'Pondok Aren, Kota Tangerang Selatan, Banten - 15222',
				'telp' => '021-7358675',
				'email' => 'admin@bimbelinfinity.co.id',
			);

		if($this->cetak->cekIdST($id)){
			$surat = $this->cetak->getDataSurat();
			$data = array(
					'pdf' => new pdf('P','mm','A4',$dataPDF),
					'surat' => $surat
				);
		    $this->load->view('cetak/surat_teguran',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function surat_peringatan()
	{
		$id = $this->input->get('suratID',true);
		$dataPDF = array(
				'judul' => 'BIMBEL INFINITY',
				'alamat' => 'Jalan Pisok I Blok EA 15 No.1. Bintaro Sektor 5 Jurangmangu',
				'region' => 'Pondok Aren, Kota Tangerang Selatan, Banten - 15222',
				'telp' => '021-7358675',
				'email' => 'admin@bimbelinfinity.co.id',
			);

		if($this->cetak->cekIdSP($id)){
			$surat = $this->cetak->getDataSurat();

			switch($surat['jenis']){
				case '1':
					$data = array(
							'jenis' => $surat['jenis'],
							'surat' => $surat,
							'pdf' => new pdf('P','mm','A4',$dataPDF),
							'keterangan' => 'Sehubungan dengan kinerja Saudara sebagai karyawan Bimbel Infinity yang harus mematuhi dan melaksanakan semua kewajiban dan tata tertib serta disiplin dalam bekerja yang seharusnya Saudara laksanakan sepenuhnya. Maka, dengan ini Kami memberikan Surat Peringatan 1 kepada Saudara atas tindakan penyimpangan yang tidak dilaksanakan sebagaimana mestinya seperti yang Kami bawahi berikut ini:'
						);
		    		$this->load->view('cetak/surat_peringatan',$data);
				break;

				case '2':
					$data = array(
							'jenis' => $surat['jenis'],
							'surat' => $surat,
							'pdf' => new pdf('P','mm','A4',$dataPDF),
							'keterangan' => 'Sehubungan dengan kinerja Saudara sebagai karyawan Bimbel Infinity yang harus mematuhi dan melaksanakan semua kewajiban dan tata tertib serta disiplin dalam bekerja yang seharusnya Saudara laksanakan sepenuhnya. Maka, dengan ini Kami memberikan Surat Peringatan 2 kepada Saudara atas tindakan penyimpangan yang tidak dilaksanakan sebagaimana mestinya seperti yang Kami bawahi berikut ini:'
						);
		    		$this->load->view('cetak/surat_peringatan',$data);
				break;

				default:
					$this->error_404();
				break;
			}
		}
		else{
			$this->error_404();
		}
	}

	public function refund_transfer()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}
		$id2 = $this->input->get('refundID',true);
		$nis = $this->input->get('nis',true);
		$tanggal = date('d M Y', strtotime($this->input->get('paling_lambat',true)));

		if($this->cetak->cekIdCabang($id) && $this->cetak->cekIdRefund($id2)){
			$cabang = $this->cetak->getDataCabang();
			$surat = $this->cetak->getDataSurat();
			$dataPDF = array(
						'judul' => 'BIMBEL INFINITY',
						'alamat' => $cabang['alamat'],
						'region' => $cabang['nama_kec'].', '.$cabang['nama_kab'].', '.$cabang['nama_prov'].' - '.$cabang['kode_pos'],
						'telp' => $cabang['no_telp'],
						'email' => $cabang['email'],
					);
			$data = array(
					'pdf' => new pdf('P','mm','A4',$dataPDF),
					'surat' => $surat
				);
		    $this->load->view('cetak/refund_transfer',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function rollover_kas()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}
		$id2 = $this->input->get('rolloverID',true);

		if($this->cetak->cekIdCabang($id) && $this->cetak->cekIdRollover($id2)){
			$cabang = $this->cetak->getDataCabang();
			$dataPDF = array(
					'judul' => 'BIMBEL INFINITY',
					'alamat' => $cabang['alamat'],
					'region' => $cabang['nama_kec'].', '.$cabang['nama_kab'].', '.$cabang['nama_prov'].' - '.$cabang['kode_pos'],
					'telp' => $cabang['no_telp'],
					'email' => $cabang['email'],
				);
			$data = array(
					'pdf' => new pdf('P','mm','A4',$dataPDF),
					'cabang' => $cabang,
					'surat' => $this->cetak->getDataSurat()
				);
		    $this->load->view('cetak/rollover_kas',$data);
		}
		else{
			$this->error_404();
		}
	}


	// Page Cetak

	public function permohonan_izin()
	{	
		$data = array(
			'title' => 'Permohonan Izin',
		);
		$this->_render("cetak/form_izin",$data);
	}
}