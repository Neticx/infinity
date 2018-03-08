<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tamu_model extends CI_Model {

	private $dataCabang = array();
	private $dataTamu = array();

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

	public function cekIdTamu($id)
	{
		$query = $this->db->select('*')
							->where('id_tamu',$id)
							->limit(1)
							->get('tamu');
		if($query->num_rows() == 1){
			$this->dataTamu = $query->row_array();
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

	public function getDataTamu()
	{
		return $this->dataTamu;
	}

	public function getListTotal($id, $search)
	{
		if($search != null){
			$query = $this->db->select('COUNT(id_tamu) as jumlah')
							->where('id_cabang',$id)
							->like('nama_siswa', $search)
							->or_like('asal_sekolah', $search)
							->or_like('jurusan', $search)
							->get('tamu')->row_array();
		}
		else{
			$query = $this->db->select('COUNT(id_tamu) as jumlah')
							->where('id_cabang',$id)
							->get('tamu')->row_array();
		}
		return $query['jumlah'];
	}

	public function getList($id, $array = array())
	{
		if($array['search'] != null){
			$query = $this->db->select('id_tamu, nama_siswa, jk, email, no_hp, asal_sekolah, DATE_FORMAT(tanggal, "%a, %e %b %Y") as tgl')
							->where('id_cabang',$id)
							->like('nama_siswa', $search)
							->or_like('asal_sekolah', $search)
							->or_like('jurusan', $search)
							->order_by('tanggal','DESC')
							->get('tamu');
		}
		else{
			$query = $this->db->select('id_tamu, nama_siswa, jk, email, no_hp, asal_sekolah, DATE_FORMAT(tanggal, "%a, %e %b %Y") as tgl')
							->where('id_cabang',$id)
							->limit($array['limit'], $array['offset'])
							->order_by('tanggal','DESC')
							->get('tamu');
		}
		return $query->result();
	}

	public function insertTamu($data = array())
	{
		$this->db->insert('tamu', $data);

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','insert',$this->db->last_query());
			return true;
		}
		else{
			$this->logData->insertLogData('error','insert',$this->db->last_query());
			return false;
		}
	}

	public function updateTamu($data = array())
	{
		$query = $this->db->select('*')->where('id_tamu',$data['id_tamu'])->limit(1)->get('tamu')->row_array();
		$this->db->where('id_tamu',$data['id_tamu'])->update('tamu', $data);

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','update',$this->db->last_query());
			$this->logData->tmpLogData('tamu', json_encode($query));
			return true;
		}
		else{
			$this->logData->insertLogData('error','update',$this->db->last_query());
			return false;
		}
	}

	public function deleteTamu($cabang, $tamu)
	{
		$query = $this->db->select('*')->where('id_tamu',$tamu)->where('id_cabang',$cabang)->limit(1)->get('tamu')->row_array();
		$this->db->where('id_tamu',$tamu)->where('id_cabang',$cabang)->delete('tamu');

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','delete',$this->db->last_query());
			$this->logData->tmpLogData('tamu', json_encode($query));
			return true;
		}
		else{
			$this->logData->insertLogData('error','delete',$this->db->last_query());
			return false;
		}
	}

}