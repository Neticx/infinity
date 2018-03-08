<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bimbel_model extends CI_Model {

	private $dataProgram = array();
	private $dataCabang = array();
	private $dataKelas = array();
	private $dataSiswaKelas = array();

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Log_model','logData',true);
	}

	public function cekIdProgram($id)
	{
		$query = $this->db->select('*')
							->where('id_program',$id)
							->limit(1)
							->get('program');
		if($query->num_rows() == 1){
			$this->dataProgram = $query->row_array();
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

	public function cekSiswaKelas($id)
	{
		$query = $this->db->select('siswa_kelas.*, siswa.nama')
							->join('siswa','siswa_kelas.nis = siswa.nis','left')
							->where('id_kelas',$id)
							->get('siswa_kelas');
		if($query->num_rows() > 0){
			$this->dataSiswaKelas = $query->result_array();
			return true;
		}
		else{
			return false;
		}
	}

	public function getDataProgram()
	{
		return $this->dataProgram;
	}

	public function getDataCabang()
	{
		return $this->dataCabang;
	}

	public function getDataKelas()
	{
		return $this->dataKelas;
	}

	public function getDataSiswaKelas()
	{
		return $this->dataSiswaKelas;
	}

	public function getProgram()
	{
		$query = $this->db->select('*')
							->get('program');
		return $query->result_array();
	}

	public function getKelas($id)
	{
		$query = $this->db->select('*')
							->where('id_cabang',$id)
							->get('kelas');
		return $query->result_array();
	}

	public function getRuang($id)
	{
		$query = $this->db->select('*')
							->where('id_cabang',$id)
							->get('ruang');
		return $query->result_array();
	}

	public function getSesi($id)
	{
		return $this->db->select('*')
							->where('id_cabang',$id)
							->get('sesi_jadwal')
							->result_array();
	}

	public function insertProgram($data = array())
	{
		$this->db->insert('program', $data);

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','insert',$this->db->last_query());
			return true;
		}
		else{
			$this->logData->insertLogData('error','insert',$this->db->last_query());
			return false;
		}
	}

	public function insertKelas($data = array())
	{
		$this->db->insert('kelas', $data);

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','insert',$this->db->last_query());
			return true;
		}
		else{
			$this->logData->insertLogData('error','insert',$this->db->last_query());
			return false;
		}
	}

	public function insertRuang($data = array())
	{
		$this->db->insert('ruang', $data);

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','insert',$this->db->last_query());
			return true;
		}
		else{
			$this->logData->insertLogData('error','insert',$this->db->last_query());
			return false;
		}
	}

	public function insertSiswaKelas($data = array())
	{
		$this->db->insert_batch('siswa_kelas', $data);

		if($this->db->affected_rows() > 0){
			$this->logData->insertLogData('success','insert',$this->db->last_query());
			return true;
		}
		else{
			$this->logData->insertLogData('error','insert',$this->db->last_query());
			return false;
		}
	}

	public function insertSesi($data = array())
	{
		$this->db->insert('sesi_jadwal', $data);

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','insert',$this->db->last_query());
			return true;
		}
		else{
			$this->logData->insertLogData('error','insert',$this->db->last_query());
			return false;
		}
	}

	public function updateProgram($data = array())
	{
		$query = $this->db->select('*')->where('id_program',$data['id_program'])->limit(1)->get('program')->row_array();
		$this->db->where('id_program',$data['id_program'])->update('program', $data);

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','update',$this->db->last_query());
			$this->logData->tmpLogData('program', json_encode($query));
			return true;
		}
		else{
			$this->logData->insertLogData('error','update',$this->db->last_query());
			return false;
		}
	}

	public function updateKelas($data = array())
	{
		$query = $this->db->select('*')->where('id_kelas',$data['id_kelas'])->limit(1)->get('kelas')->row_array();
		$this->db->where('id_kelas',$data['id_kelas'])->update('kelas', $data);

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','update',$this->db->last_query());
			$this->logData->tmpLogData('kelas', json_encode($query));
			return true;
		}
		else{
			$this->logData->insertLogData('error','update',$this->db->last_query());
			return false;
		}
	}

	public function updateRuang($data = array())
	{
		$query = $this->db->select('*')->where('id_ruang',$data['id_ruang'])->limit(1)->get('ruang')->row_array();
		$this->db->where('id_ruang',$data['id_ruang'])->update('ruang', $data);

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','update',$this->db->last_query());
			$this->logData->tmpLogData('ruang', json_encode($query));
			return true;
		}
		else{
			$this->logData->insertLogData('error','update',$this->db->last_query());
			return false;
		}
	}

	public function updateSesi($data = array())
	{
		$query = $this->db->select('*')->where('id_sesi_jadwal',$data['id_sesi_jadwal'])->limit(1)->get('sesi_jadwal')->row_array();
		$this->db->where('id_sesi_jadwal',$data['id_sesi_jadwal'])->update('sesi_jadwal', $data);

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','update',$this->db->last_query());
			$this->logData->tmpLogData('sesi_jadwal', json_encode($query));
			return true;
		}
		else{
			$this->logData->insertLogData('error','update',$this->db->last_query());
			return false;
		}
	}

	public function deleteProgram($id)
	{
		$query = $this->db->select('*')->where('id_program',$id)->limit(1)->get('program')->row_array();
		$this->db->where('id_program',$id)->delete('program');

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','delete',$this->db->last_query());
			$this->logData->tmpLogData('program', json_encode($query));
			return true;
		}
		else{
			$this->logData->insertLogData('error','delete',$this->db->last_query());
			return false;
		}
	}

	public function deleteKelas($cabang, $kelas)
	{
		$query = $this->db->select('*')->where('id_kelas',$kelas)->where('id_cabang',$cabang)->limit(1)->get('kelas')->row_array();
		$this->db->where('id_kelas',$kelas)->where('id_cabang',$cabang)->delete('kelas');

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','delete',$this->db->last_query());
			$this->logData->tmpLogData('kelas', json_encode($query));
			return true;
		}
		else{
			$this->logData->insertLogData('error','delete',$this->db->last_query());
			return false;
		}
	}

	public function deleteRuang($cabang, $ruang)
	{
		$query = $this->db->select('*')->where('id_ruang',$ruang)->where('id_cabang',$cabang)->limit(1)->get('ruang')->row_array();
		$this->db->where('id_ruang',$ruang)->where('id_cabang',$cabang)->delete('ruang');

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','delete',$this->db->last_query());
			$this->logData->tmpLogData('ruang', json_encode($query));
			return true;
		}
		else{
			$this->logData->insertLogData('error','delete',$this->db->last_query());
			return false;
		}
	}

	public function deleteAllSiswaKelas($id)
	{
		$this->db->where('id_kelas',$id)->delete('siswa_kelas');
		if($this->db->affected_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}

	public function deleteSesi($cabang, $sesi)
	{
		$query = $this->db->select('*')->where('id_sesi_jadwal',$sesi)->where('id_cabang',$cabang)->limit(1)->get('sesi_jadwal')->row_array();
		$this->db->where('id_sesi_jadwal',$sesi)->where('id_cabang',$cabang)->delete('sesi_jadwal');

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','delete',$this->db->last_query());
			$this->logData->tmpLogData('sesi_jadwal', json_encode($query));
			return true;
		}
		else{
			$this->logData->insertLogData('error','delete',$this->db->last_query());
			return false;
		}
	}

}