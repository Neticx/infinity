<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cetak_model extends CI_Model {

	private $dataCabang;
	private $dataSiswa;
	private $dataPenugasanPengajar;
	private $dataReqKeuangan;
	private $dataSurat;

	public function __construct()
	{
		parent::__construct();
	}

	public function cekIdSiswa($id)
	{
		$query = $this->db->select('siswa.*, kecsis.name as kecsis, kabsis.name as kabsis, provsis.name as provsis, kecwali.name as kecwali, kabwali.name as kabwali, provwali.name as provwali, nama_program, harga, pendaftaran')
							->join('kecamatan as kecsis','siswa.id_kec_siswa = kecsis.id_kecamatan','left')
							->join('kabupaten as kabsis','kecsis.id_kabupaten = kabsis.id_kabupaten','left')
							->join('provinsi as provsis','kabsis.id_provinsi = provsis.id_provinsi','left')
							->join('kecamatan as kecwali','siswa.id_kec_siswa = kecwali.id_kecamatan','left')
							->join('kabupaten as kabwali','kecwali.id_kabupaten = kabwali.id_kabupaten','left')
							->join('provinsi as provwali','kabwali.id_provinsi = provwali.id_provinsi','left')
							->join('program','siswa.id_program = program.id_program','left')
							->where('nis',$id)
							->limit(1)
							->get('siswa');
		if($query->num_rows() == 1){
			$this->dataSiswa = $query->row_array();
			return true;
		}
		else{
			return false;
		}
	}

	public function cekIdCabang($id)
	{
		$query = $this->db->select('cabang.*, kecamatan.name as nama_kec, kabupaten.name as nama_kab, provinsi.name as nama_prov')
							->join('kecamatan','cabang.id_kecamatan = kecamatan.id_kecamatan','left')
							->join('kabupaten','kecamatan.id_kabupaten = kabupaten.id_kabupaten','left')
							->join('provinsi','kabupaten.id_provinsi = provinsi.id_provinsi','left')
							->where('id_Cabang',$id)
							->limit(1)
							->get('cabang');
		if($query->num_rows() == 1){
			$this->dataCabang = $query->row_array();
			return true;
		}
		else{
			return false;
		}
	}

	public function getDataSiswa()
	{
		return $this->dataSiswa;
	}

	public function getDataCabang()
	{
		return $this->dataCabang;
	}

	public function cekIdPenugasanPengajar($id)
	{
		$query = $this->db->select('id_cabang_tujuan, waktu_mulai, waktu_selesai, penugasan_pengajar.tanggal, nomor_surat, materi, pengajar.bidang, pengajar.nama as nama_pengajar, kelas.nama_kelas, cabang.*, kecamatan.name as nama_kec, kabupaten.name as nama_kab, provinsi.name as nama_prov, user.nama as nama_user')
							->join('cabang','penugasan_pengajar.id_cabang = cabang.id_cabang','left')
							->join('kecamatan','cabang.id_kecamatan = kecamatan.id_kecamatan','left')
							->join('kabupaten','kecamatan.id_kabupaten = kabupaten.id_kabupaten','left')
							->join('provinsi','kabupaten.id_provinsi = provinsi.id_provinsi','left')
							->join('pengajar','penugasan_pengajar.id_pengajar = pengajar.id_pengajar','left')
							->join('kelas','penugasan_pengajar.id_kelas = kelas.id_kelas','left')
							->join('user','penugasan_pengajar.id_user_penugas = user.id_user','left')
							->where('id_penugasan_pengajar',$id)
							->limit(1)
							->get('penugasan_pengajar');

		if($query->num_rows() == 1){
			$this->dataPenugasanPengajar = $query->row_array();
			return true;
		}
		else{
			return false;
		}
	}

	public function cekIdReqKeuangan($id)
	{
		$query = $this->db->select('permintaan_uang_keuangan.*, user.nama, access.nama as jabatan')
								->join('user','permintaan_uang_keuangan.id_user = user.id_user')
								->join('access','user.id_access = access.id_access')
								->where('id_permintaan_uang_keuangan',$id)
								->get('permintaan_uang_keuangan');
		if($query->num_rows() == 1){
			$this->dataReqKeuangan = $query->row_array();
			return true;
		}
		else{
			return false;
		}

	}

	public function getDataPenugasanPengajar()
	{
		return $this->dataPenugasanPengajar;
	}

	public function getDataReqKeuangan()
	{
		return $this->dataReqKeuangan;
	}

	public function getSiswaPembayaran($id)
	{
		return $this->db->select('*')
							->where('nis_siswa',$id)
							->limit(1)
							->get('siswa_pembayaran')
							->row_array();
	}

	public function getSiswaPembayaranCicilan($id)
	{
		$row = $this->db->select('SUM(nominal) as jml_bayar')
							->where('id_pembayaran',$id)
							->get('cicilan')
							->row_array();
		return $row['jml_bayar'];
	}

	public function getKepalaCabang($cabang)
	{
		$query = $this->db->select('nama')
							->where('id_cabang',$cabang)
							->where('id_access','15')
							->limit(1)
							->get('user');

		if($query->num_rows() == 1){
			$row = $query->row_array();
			return $row['nama'];
		}
		else{
			return NULL;
		}
	}

	public function cekIdSP($id)
	{
		$query =  $this->db->select('surat_peringatan.*, DATE_FORMAT(surat_peringatan.tanggal, "%e %b %Y") as tgl')
								->where('id_surat_peringatan',$id)
								->limit(1)
								->get('surat_peringatan');
		if($query->num_rows() == 1){
			$this->dataSurat = $query->row_array();
			return true;
		}
		else{
			return false;
		}
	}

	public function cekIdST($id)
	{
		$query =  $this->db->select('surat_teguran.*, DATE_FORMAT(surat_teguran.tanggal, "%e %b %Y") as tgl')
								->where('id_surat_teguran',$id)
								->limit(1)
								->get('surat_teguran');
		if($query->num_rows() == 1){
			$this->dataSurat = $query->row_array();
			return true;
		}
		else{
			return false;
		}
	}

	public function cekIdRefund($id)
	{
		$query = $this->db->select('refund.*, siswa.nama as nama_siswa, program.nama_program, user.nama as konsultan')
								->join('siswa','refund.nis = siswa.nis','left')
								->join('program','siswa.id_program = program.id_program','left')
								->join('user','refund.id_user = user.id_user','left')
								->where('id_refund',$id)
								->limit(1)
								->get('refund');
		if($query->num_rows() == 1){
			$this->dataSurat = $query->row_array();
			return true;
		}
		else{
			return false;
		}
	}

	public function getDataSurat()
	{
		return $this->dataSurat;
	}

}