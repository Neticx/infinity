<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Surat_model extends CI_Model {

	private $dataCabang = array();
	private $lastID;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Log_model','logData',true);
	}

	public function cekIdCabang($id)
	{
		$query = $this->db->select('id_cabang, nama, alamat, kode_pos, email, lat, lng, no_telp, no_fax, kecamatan.id_kecamatan, kabupaten.id_kabupaten, provinsi.id_provinsi, kecamatan.name as kecamatan, kabupaten.name as kabupaten, provinsi.name as provinsi')
							->join('kecamatan','kecamatan.id_kecamatan = cabang.id_kecamatan','left')
							->join('kabupaten','kabupaten.id_kabupaten = kecamatan.id_kabupaten','left')
							->join('provinsi','provinsi.id_provinsi = kabupaten.id_provinsi','left')
							->where('id_cabang', $id)
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

	public function getDataCabang()
	{
		return $this->dataCabang;
	}

	public function getLastID()
	{
		return $this->lastID;
	}

	public function getPengajar($id)
	{
		return $this->db->select('id_pengajar, nama, bidang')
							->where('id_cabang',$id)
							->order_by('nama','ASC')
							->get('pengajar')
							->result_array();
	}

	public function getKelas($id)
	{
		return $this->db->select('id_kelas, nama_kelas')
							->where('id_cabang',$id)
							->order_by('nama_kelas','ASC')
							->get('kelas')
							->result_array();
	}

	public function getLastNomor($id, $bulan, $tahun)
	{
		return $this->db->select('nomor')
								->where('id_cabang',$id)
								->where('MONTH(tanggal)',$bulan)
								->where('YEAR(tanggal)',$tahun)
								->order_by('id_penugasan_pengajar','DESC')
								->limit(1)
								->get('penugasan_pengajar')
								->row_array();
	}

	public function getLastNomorKeuangan($id, $bulan, $tahun)
	{
		return $this->db->select('nomor')
								->where('id_cabang',$id)
								->where('MONTH(tanggal)',$bulan)
								->where('YEAR(tanggal)',$tahun)
								->order_by('id_permintaan_uang_keuangan','DESC')
								->limit(1)
								->get('permintaan_uang_keuangan')
								->row_array();
	}

	public function getLastNomorSP($jenis, $bulan, $tahun)
	{
		return $this->db->select('nomor')
								->where('jenis',$jenis)
								->where('MONTH(tanggal)',$bulan)
								->where('YEAR(tanggal)',$tahun)
								->order_by('id_surat_peringatan','DESC')
								->limit(1)
								->get('surat_peringatan')
								->row_array();
	}

	public function getLastNomorST($bulan, $tahun)
	{
		return $this->db->select('nomor')
								->where('MONTH(tanggal)',$bulan)
								->where('YEAR(tanggal)',$tahun)
								->order_by('id_surat_teguran','DESC')
								->limit(1)
								->get('surat_teguran')
								->row_array();
	}

	public function insertPenugasanPengajar($data = array())
	{
		$this->db->insert('penugasan_pengajar', $data);

		if($this->db->affected_rows() == 1){
			$this->lastID = $this->db->insert_id();
			$this->logData->insertLogData('success','insert',$this->db->last_query());
			return true;
		}
		else{
			$this->logData->insertLogData('error','insert',$this->db->last_query());
			return false;
		}
	}

	public function insertReqKeuangan($data = array())
	{
		$this->db->insert('permintaan_uang_keuangan', $data);

		if($this->db->affected_rows() == 1){
			$this->lastID = $this->db->insert_id();
			$this->logData->insertLogData('success','insert',$this->db->last_query());
			return true;
		}
		else{
			$this->logData->insertLogData('error','insert',$this->db->last_query());
			return false;
		}
	}

	public function insertSP($data = array())
	{
		$this->db->insert('surat_peringatan', $data);

		if($this->db->affected_rows() == 1){
			$this->lastID = $this->db->insert_id();
			$this->logData->insertLogData('success','insert',$this->db->last_query());
			return true;
		}
		else{
			$this->logData->insertLogData('error','insert',$this->db->last_query());
			return false;
		}
	}

	public function insertST($data = array())
	{
		$this->db->insert('surat_teguran', $data);

		if($this->db->affected_rows() == 1){
			$this->lastID = $this->db->insert_id();
			$this->logData->insertLogData('success','insert',$this->db->last_query());
			return true;
		}
		else{
			$this->logData->insertLogData('error','insert',$this->db->last_query());
			return false;
		}
	}

}