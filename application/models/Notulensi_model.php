<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notulensi_model extends CI_Model {
	private $dataCabang;
	private $dataNote;

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

	public function cekIdNote($id)
	{
		$query = $this->db->select('*')
							->where('id_notula',$id)
							->limit(1)
							->get('notula_rapat');
		if($query->num_rows() == 1){
			$this->dataNote = $query->row_array();
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

	public function getDataNote()
	{
		return $this->dataNote;
	}

	public function getListTotal($id, $search)
	{
		if($search != null){
			$query = $this->db->select('COUNT(id_notula) as jumlah')
							->where('id_cabang',$id)
							->group_start()
							->like('agenda', $search)
							->or_like('tempat', $search)
							->group_end()
							->get('notula_rapat')->row_array();
		}
		else{
			$query = $this->db->select('COUNT(id_notula) as jumlah')
							->get('notula_rapat')->row_array();
		}
		return $query['jumlah'];
	}

	public function getList($id, $array = array())
	{
		if($array['search'] != null){
			$query = $this->db->select('id_notula as id, id_cabang, agenda, DATE_FORMAT(tanggal, "%d %b %Y") as tgl, tempat')
							->where('id_cabang',$id)
							->group_start()
							->like('agenda', $search)
							->or_like('tempat', $search)
							->group_end()
							->limit($array['limit'], $array['offset'])
							->order_by('tanggal_input','DESC')
							->get('notula_rapat');
		}
		else{
			$query = $this->db->select('id_notula as id, id_cabang, agenda, DATE_FORMAT(tanggal, "%d %b %Y") as tgl, tempat')
							->where('id_cabang',$id)
							->limit($array['limit'], $array['offset'])
							->order_by('tanggal_input','DESC')
							->get('notula_rapat');
		}
		return $query->result();
	}

	public function insertNotulensi($data = array())
	{
		$this->db->insert('notula_rapat', $data);

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','insert',$this->db->last_query());
			return true;
		}
		else{
			$this->logData->insertLogData('error','insert',$this->db->last_query());
			return false;
		}
	}

	public function updateNotulensi($data = array())
	{
		$this->db->where('id_notula',$data['id_notula'])->update('notula_rapat', $data);

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','update',$this->db->last_query());
			return true;
		}
		else{
			$this->logData->insertLogData('error','update',$this->db->last_query());
			return false;
		}
	}

	public function deleteNotulensi($id)
	{
		$query = $this->db->select('*')->where('id_notula',$id)->limit(1)->get('notula_rapat')->row_array();
		$this->db->where('id_notula',$id)->delete('notula_rapat');

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','delete',$this->db->last_query());
			$this->logData->tmpLogData('notula_rapat', json_encode($query));
			return true;
		}
		else{
			$this->logData->insertLogData('error','delete',$this->db->last_query());
			return false;
		}
	}

}