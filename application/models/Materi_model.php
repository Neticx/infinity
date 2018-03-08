<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Materi_model extends CI_Model {

	private $dataCabang = array();
	private $dataProgram = array();
	private $dataMateri = array();

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

	public function cekIdProgram($id)
	{
		$query = $this->db->select('id_program, nama_program, sesi_kelas, sesi_to')
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

	public function cekIdMateri($id)
	{
		$query = $this->db->select('*')
							->where('id_materi_pengajar',$id)
							->limit(1)
							->get('materi_pengajar');
		if($query->num_rows() == 1){
			$this->dataMateri = $query->row_array();
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

	public function getDataProgram()
	{
		return $this->dataProgram;
	}

	public function getDataMateri()
	{
		return $this->dataMateri;
	}

	public function getProgram()
	{
		return $this->db->select('id_program, nama_program, sesi_kelas, sesi_to')
							->get('program')
							->result_array();
	}

	public function getListTotal($search)
	{
		if($search != null){
			$query = $this->db->select('COUNT(id_materi_pengajar) as jumlah')
							->like('judul', $search)
							->get('materi_pengajar')->row_array();
		}
		else{
			$query = $this->db->select('COUNT(id_materi_pengajar) as jumlah')
							->get('materi_pengajar')->row_array();
		}
		return $query['jumlah'];
	}

	public function getList($array = array())
	{
		if($array['search'] != null){
			$query = $this->db->select('id_materi_pengajar, judul')
							->like('judul', $array['search'])
							->order_by('judul','ASC')
							->get('materi_pengajar');
		}
		else{
			$query = $this->db->select('id_materi_pengajar, judul')
							->limit($array['limit'], $array['offset'])
							->order_by('judul','ASC')
							->get('materi_pengajar');
		}
		return $query->result();
	}

	public function insertMateri($data = array())
	{
		$this->db->insert('materi_pengajar', $data);

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','insert',$this->db->last_query());
			return true;
		}
		else{
			$this->logData->insertLogData('error','insert',$this->db->last_query());
			return false;
		}
	}

	public function updateMateri($data = array())
	{
		$query = $this->db->select('*')->where('id_materi_pengajar',$data['id_materi_pengajar'])->limit(1)->get('materi_pengajar')->row_array();
		$this->db->where('id_materi_pengajar',$data['id_materi_pengajar'])->update('materi_pengajar', $data);

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','update',$this->db->last_query());
			$this->logData->tmpLogData('materi_pengajar', json_encode($query));
			return true;
		}
		else{
			$this->logData->insertLogData('error','update',$this->db->last_query());
			return false;
		}
	}

	public function deleteMateri($id)
	{
		$query = $this->db->select('*')->where('id_materi_pengajar',$id)->limit(1)->get('materi_pengajar')->row_array();
		$this->db->where('id_materi_pengajar',$id)->delete('materi_pengajar');

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','delete',$this->db->last_query());
			$this->logData->tmpLogData('materi_pengajar', json_encode($query));
			return true;
		}
		else{
			$this->logData->insertLogData('error','delete',$this->db->last_query());
			return false;
		}
	}

}