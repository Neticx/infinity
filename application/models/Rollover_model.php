<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rollover_model extends CI_Model {

	private $dataCabang = array();

	public function __construct()
	{
		parent::__construct();
		
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

	public function getDataCabang()
	{
		return $this->dataCabang;
	}

	public function getListTotal($id, $search)
	{
		if($search != null){
			$query = $this->db->select('COUNT(id_rollover) as jumlah')
							->where('id_cabang',$id)
							->like('nominal', $search)
							->get('rollover')->row_array();
		}
		else{
			$query = $this->db->select('COUNT(id_rollover) as jumlah')
							->where('id_cabang',$id)
							->get('rollover')->row_array();
		}
		return $query['jumlah'];
	}

	public function getList($id, $array = array())
	{
		if($array['search'] != null){
			$query = $this->db->select('id_rollover, id_cabang, nominal, DATE_FORMAT(tanggal, "%a, %e %b %Y") as tgl')
							->where('id_cabang',$id)
							->like('nominal', $array['search'])
							->order_by('tanggal','DESC')
							->get('rollover');
		}
		else{
			$query = $this->db->select('id_rollover, id_cabang, nominal, DATE_FORMAT(tanggal, "%a, %e %b %Y") as tgl')
							->where('id_cabang',$id)
							->limit($array['limit'], $array['offset'])
							->order_by('tanggal','DESC')
							->get('rollover');
		}
		return $query->result();
	}

	public function insertRollover($data)
	{
		$this->db->insert('rollover', $data);

		if($this->db->affected_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}

	public function deleteRollover($id)
	{
		$this->db->where('id_rollover',$id)->delete('rollover');

		if($this->db->affected_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}

}