<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News_model extends CI_Model {

	private $dataCabang = array();
	private $dataNews = array();

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Log_model','logData',true);
	}

	public function cekIdCabang($id)
	{
		$query = $this->db->select('*')
							->where('id_cabang',$id)
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

	public function cekIdNews($id)
	{
		$query = $this->db->select('*')
								->where('id_berita',$id)
								->limit(1)
								->get('berita');
		if($query->num_rows() == 1){
			$this->dataNews = $query->row_array();
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

	public function getDataNews()
	{
		return $this->dataNews;
	}

	public function getListTotal($search)
	{
		if($search != null){
			$query = $this->db->select('COUNT(id_berita) as jumlah')
							->like('judul', $search)
							->get('berita')->row_array();
		}
		else{
			$query = $this->db->select('COUNT(id_berita) as jumlah')
							->get('berita')->row_array();
		}
		return $query['jumlah'];
	}

	public function getList($array = array())
	{
		if($array['search'] != null){
			$query = $this->db->select('id_berita, judul, DATE_FORMAT(tanggal, "%a, %e %b %Y") as tgl')
							->like('judul', $array['search'])
							->order_by('tanggal','DESC')
							->get('berita');
		}
		else{
			$query = $this->db->select('id_berita, judul, DATE_FORMAT(tanggal, "%a, %e %b %Y") as tgl')
							->limit($array['limit'], $array['offset'])
							->order_by('judul','DESC')
							->get('berita');
		}
		return $query->result();
	}

	public function insertNews($data = array())
	{
		$this->db->insert('berita', $data);

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','insert',$this->db->last_query());
			return true;
		}
		else{
			$this->logData->insertLogData('error','insert',$this->db->last_query());
			return false;
		}
	}

	public function updateNews($data = array())
	{
		$this->db->where('id_berita',$data['id_berita'])->update('berita', $data);

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','update',$this->db->last_query());
			return true;
		}
		else{
			$this->logData->insertLogData('error','update',$this->db->last_query());
			return false;
		}
	}

	public function deleteNews($id)
	{
		$query = $this->db->select('*')->where('id_berita',$id)->limit(1)->get('berita')->row_array();
		$this->db->where('id_berita',$id)->delete('berita');

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','delete',$this->db->last_query());
			$this->logData->tmpLogData('berita', json_encode($query));
			return true;
		}
		else{
			$this->logData->insertLogData('error','delete',$this->db->last_query());
			return false;
		}
	}

}