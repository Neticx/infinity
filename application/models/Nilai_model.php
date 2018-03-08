<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nilai_model extends CI_Model {

	private $dataCabang = array();

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

	public function getDataCabang()
	{
		return $this->dataCabang;
	}

	public function getKelas($id)
	{
		$query = $this->db->select('*')
							->where('id_cabang',$id)
							->get('kelas');
		return $query->result_array();
	}

	public function getJenisUjian($cabang, $kelas, $bidang)
	{
		return $this->db->select('jenis')
							->where('id_cabang',$cabang)
							->where('id_kelas',$kelas)
							->where('bidang',$bidang)
							->group_by('jenis')
							->get('nilai_siswa')
							->result_array();
	}

	public function getDaftarSiswa($kelas)
	{
		return $this->db->select('siswa.nis, siswa.nama')
							->join('siswa','siswa_kelas.nis = siswa.nis','left')
							->where('siswa_kelas.id_kelas',$kelas)
							->get('siswa_kelas')
							->result_array();
	}

	public function getDaftarNilai($cabang, $bidang, $kelas, $jenis)
	{
		return $this->db->select('id_nilai, nilai, siswa.nis, siswa.nama')
							->join('siswa','nilai_siswa.nis = siswa.nis','left')
							->where('nilai_siswa.id_cabang',$cabang)
							->where('bidang',$bidang)
							->where('id_kelas',$kelas)
							->where('jenis',$jenis)
							->get('nilai_siswa')
							->result_array();
	}

	public function insertNilai($data = array())
	{
		$this->db->insert_batch('nilai_siswa', $data);

		if($this->db->affected_rows() > 0){
			$this->logData->insertLogData('success','insert',$this->db->last_query());
			return true;
		}
		else{
			$this->logData->insertLogData('error','insert',$this->db->last_query());
			return false;
		}
	}

	public function updateNilai($data = array())
	{
		$this->db->update_batch('nilai_siswa', $data, 'id_nilai');

		if($this->db->affected_rows() > 0){
			$this->logData->insertLogData('success','update',$this->db->last_query());
			return true;
		}
		else{
			$this->logData->insertLogData('error','update',$this->db->last_query());
			return false;
		}
	}

	public function deleteNilai($cabang, $bidang, $kelas, $jenis)
	{
		$query = $this->db->select('*')
							->where('id_kelas',$kelas)
							->where('bidang',$bidang)
							->where('jenis',$jenis)
							->where('id_cabang',$cabang)
							->limit(1)
							->get('nilai_siswa')
							->row_array();
		$this->db->where('id_kelas',$kelas)
					->where('bidang',$bidang)
					->where('jenis',$jenis)
					->where('id_cabang',$cabang)
					->delete('nilai_siswa');

		if($this->db->affected_rows() > 0){
			$this->logData->insertLogData('success','delete',$this->db->last_query());
			$this->logData->tmpLogData('nilai_siswa', json_encode($query));
			return true;
		}
		else{
			$this->logData->insertLogData('error','delete',$this->db->last_query());
			return false;
		}
	}

}