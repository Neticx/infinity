<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jadwal_model extends CI_Model {

	private $dataCabang;
	private $dataKelas;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Log_model','logData',true);
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

	public function cekIdKelas($id)
	{
		$query = $this->db->select('*')
							->where('id_kelas',$id)
							->limit(1)
							->get('kelas');
		if($query->num_rows() == 1){
			$this->dataKelas = $query->row_array();
			return true;
		}
		else{
			return false;
		}
	}

	public function cekIdJadwal($id)
	{
		$query = $this->db->select('id_jadwal')
								->where('id_jadwal',$id)
								->limit(1)
								->get('jadwal');
		if($query->num_rows() == 1){
			return true;
		}
		else{
			return false;
		}
	}

	public function getKelas($id)
	{
		$query = $this->db->select('*')
							->where('id_cabang',$id)
							->get('kelas');
		return $query->result_array();
	}

	public function getDataCabang()
	{
		return $this->dataCabang;
	}

	public function getDataKelas()
	{
		return $this->dataKelas;
	}

	public function getListPengajar($bidang)
	{
		return $this->db->select('id_pengajar, nama')
							->where('bidang',$bidang)
							->get('pengajar')
							->result_array();
	}

	public function getListRuang($id)
	{
		return $this->db->select('id_ruang, nama_ruang')
							->where('id_cabang',$id)
							->get('ruang')
							->result_array();
	}

	public function getSesi($id)
	{
		return $this->db->select('*')
							->where('id_cabang',$id)
							->get('sesi_jadwal')
							->result_array();
	}

	public function jadwalHari($id)
	{
		return $this->db->select('jadwal.id_jadwal, pengajar.nama, pengajar.bidang, sesi_jadwal.sesi, sesi_jadwal.mulai, sesi_jadwal.selesai, ruang.nama_ruang')
						->join('pengajar','jadwal.id_pengajar = pengajar.id_pengajar','left')
						->join('sesi_jadwal','jadwal.id_sesi_jadwal = sesi_jadwal.id_sesi_jadwal','left')
						->join('ruang','jadwal.id_ruang = ruang.id_ruang','left')
						->where('jadwal.hari',$id)
						->order_by('sesi_jadwal.sesi','ASC')
						->get('jadwal')
						->result_array();
	}

	public function insertJadwal($data = array())
	{
		$this->db->insert('jadwal', $data);

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','insert',$this->db->last_query());
			return true;
		}
		else{
			$this->logData->insertLogData('error','insert',$this->db->last_query());
			return false;
		}
	}

	public function deleteJadwal($cabang, $jadwal)
	{
		$query = $this->db->select('*')->where('id_jadwal',$jadwal)->where('id_cabang',$cabang)->limit(1)->get('jadwal')->row_array();
		$this->db->where('id_jadwal',$jadwal)->where('id_cabang',$cabang)->delete('jadwal');

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','delete',$this->db->last_query());
			$this->logData->tmpLogData('jadwal', json_encode($query));
			return true;
		}
		else{
			$this->logData->insertLogData('error','delete',$this->db->last_query());
			return false;
		}
	}

}