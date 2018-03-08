<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PengumumanApps_model extends CI_Model {

	private $dataPengumuman;
	private $lastID;

	public function __construct()
	{
		parent::__construct();
		
	}

	public function cekIdPengumuman($id)
	{
		$query = $this->db->select('*')
								->where('id_pengumuman',$id)
								->limit(1)
								->get('pengumuman');
		if($query->num_rows() == 1){
			$this->dataPengumuman = $query->row_array();
			return true;
		}
		else{
			return false;
		}
	}

	public function getDataPengumuman()
	{
		return $this->dataPengumuman;
	}

	public function getListTotal($search)
	{
		if($search != null){
			$query = $this->db->select('COUNT(id_pengumuman) as jumlah')
							->like('judul', $search)
							->get('pengumuman')->row_array();
		}
		else{
			$query = $this->db->select('COUNT(id_pengumuman) as jumlah')
							->get('pengumuman')->row_array();
		}
		return $query['jumlah'];
	}

	public function getList($array = array())
	{
		if($array['search'] != null){
			$query = $this->db->select('id_pengumuman, judul, DATE_FORMAT(tanggal, "%a, %e %b %Y") as tgl')
							->like('judul', $array['search'])
							->limit($array['limit'], $array['offset'])
							->order_by('tanggal','DESC')
							->get('pengumuman');
		}
		else{
			$query = $this->db->select('id_pengumuman, judul, DATE_FORMAT(tanggal, "%a, %e %b %Y") as tgl')
							->limit($array['limit'], $array['offset'])
							->order_by('tanggal','DESC')
							->get('pengumuman');
		}
		return $query->result();
	}

	public function getLastID()
	{
		return $this->lastID;
	}

	public function insertPengumuman($data = array())
	{
		$this->db->insert('pengumuman', $data);

		if($this->db->affected_rows() == 1){
			$this->lastID = $this->db->insert_id();
			return true;
		}
		else{
			return false;
		}
	}

	public function updatePengumuman($data = array())
	{
		$this->db->where('id_pengumuman',$data['id_pengumuman'])->update('pengumuman', $data);

		if($this->db->affected_rows() == 1){
			return true;
		}
		else{
			return false;
		}
	}

	public function deletePengumuman($id)
	{
		$this->db->where('id_pengumuman',$id)->delete('pengumuman');

		if($this->db->affected_rows() == 1){
			return true;
		}
		else{
			return false;
		}
	}

}