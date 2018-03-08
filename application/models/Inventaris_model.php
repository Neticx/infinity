<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventaris_model extends CI_Model {

	private $dataCabang = array();
	private $dataInventaris = array();

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

	public function cekIdInventaris($id)
	{
		$query = $this->db->select('*')
								->where('id_inventaris',$id)
								->limit(1)
								->get('inventaris');
		if($query->num_rows() == 1){
			$this->dataInventaris = $query->row_array();
			return true;
		}
		else{
			return false;
		}
	}

	public function getDataInventaris()
	{
		return $this->dataInventaris;
	}

	public function getInventaris($id)
	{
		return $this->db->select('*')
							->where('id_cabang',$id)
							->get('inventaris')
							->result_array();
	}

	public function insertInventaris($data = array())
	{
		$this->db->insert('inventaris', $data);

		if($this->db->affected_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}

	public function updateInventaris($data = array())
	{
		$this->db->where('id_inventaris',$data['id_inventaris'])->update('inventaris', $data);

		if($this->db->affected_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}

	public function deleteInventaris($id)
	{
		$this->db->where('id_inventaris',$id)->delete('inventaris');

		if($this->db->affected_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}

}