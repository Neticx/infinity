<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengajar_model extends CI_Model {

	private $dataPengajar;
	private $dataCabang;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Log_model','logData',true);
	}

	public function cekIdPengajar($id)
	{
		$query = $this->db->select('pengajar.*, kabupaten.id_kabupaten, provinsi.id_provinsi')
							->join('kecamatan','pengajar.id_kecamatan = kecamatan.id_kecamatan','left')
							->join('kabupaten','kecamatan.id_kabupaten = kabupaten.id_kabupaten','left')
							->join('provinsi','kabupaten.id_provinsi = provinsi.id_provinsi','left')
							->where('id_pengajar',$id)
							->limit(1)
							->get('pengajar');
		if($query->num_rows() == 1){
			$this->dataPengajar = $query->row_array();
			return true;
		}
		else{
			return false;
		}
	}

	public function cekIdCabang($id)
	{
		$query = $this->db->select('id_cabang, nama, alamat, kode_pos, email, lat, lng, no_telp, no_fax, kecamatan.id_kecamatan, kabupaten.id_kabupaten, provinsi.id_provinsi, kecamatan.name as kecamatan, kabupaten.name as kabupaten, provinsi.name as provinsi')
							->join('kecamatan','kecamatan.id_kecamatan = cabang.id_kecamatan','left')
							->join('kabupaten','kabupaten.id_kabupaten = kecamatan.id_kabupaten','left')
							->join('provinsi','provinsi.id_provinsi = kabupaten.id_provinsi','left')
							->where('id_cabang', $id)
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

	public function getDataPengajar()
	{
		return $this->dataPengajar;
	}

	public function getProvinsi()
	{
		return $this->db->select('id_provinsi, name')
							->order_by('id_provinsi','ASC')
							->get('provinsi')
							->result_array();
	}

	public function getKabupaten($id)
	{
		return $this->db->select('id_kabupaten, name')
							->where('id_provinsi',$id)
							->order_by('id_kabupaten','ASC')
							->get('kabupaten')
							->result_array();
	}

	public function getKecamatan($id)
	{
		return $this->db->select('id_kecamatan, name')
							->where('id_kabupaten',$id)
							->order_by('id_kecamatan','ASC')
							->get('kecamatan')
							->result_array();
	}

	public function getListTotal($id, $search)
	{
		if($search != null){
			$query = $this->db->select('COUNT(id_pengajar) as jumlah')
							->where('id_cabang',$id)
							->group_start()
							->like('nama', $search)
							->or_like('kode_pengajar', $search)
							->or_like('no_hp', $search)
							->or_like('email', $search)
							->group_end()
							->get('pengajar')->row_array();
		}
		else{
			$query = $this->db->select('COUNT(id_pengajar) as jumlah')
							->where('id_cabang',$id)
							->get('pengajar')->row_array();
		}
		return $query['jumlah'];
	}

	public function getList($id, $array = array())
	{
		if($array['search'] != null){
			$query = $this->db->select('id_pengajar, id_cabang, kode_pengajar, nama, email, no_hp')
							->where('id_cabang',$id)
							->group_start()
							->like('nama', $search)
							->or_like('kode_pengajar', $search)
							->or_like('no_hp', $search)
							->or_like('email', $search)
							->group_end()
							->limit($array['limit'], $array['offset'])
							->order_by('nama','ASC')
							->get('pengajar');
		}
		else{
			$query = $this->db->select('id_pengajar, id_cabang, kode_pengajar, nama, email, no_hp')
							->where('id_cabang',$id)
							->limit($array['limit'], $array['offset'])
							->order_by('nama','ASC')
							->get('pengajar');
		}
		return $query->result();
	}

	public function insertPengajar($data = array())
	{
		$this->db->insert('pengajar', $data);

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','insert',$this->db->last_query());
			return true;
		}
		else{
			$this->logData->insertLogData('error','insert',$this->db->last_query());
			return false;
		}
	}

	public function updatePasswordPengajar($data = array())
	{
		$query = $this->db->select('*')->where('id_pengajar',$data['id_pengajar'])->limit(1)->get('pengajar')->row_array();
		$this->db->where('id_pengajar',$data['id_pengajar'])->update('pengajar', $data);

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','update',$this->db->last_query());
			$this->logData->tmpLogData('pengajar', json_encode($query));
			return true;
		}
		else{
			$this->logData->insertLogData('error','update',$this->db->last_query());
			return false;
		}
	}

	public function updatePengajar($data = array())
	{
		$query = $this->db->select('*')->where('id_pengajar',$data['id_pengajar'])->limit(1)->get('pengajar')->row_array();
		$this->db->where('id_pengajar',$data['id_pengajar'])->update('pengajar', $data);

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','update',$this->db->last_query());
			$this->logData->tmpLogData('pengajar', json_encode($query));
			return true;
		}
		else{
			$this->logData->insertLogData('error','update',$this->db->last_query());
			return false;
		}
	}

	public function deletePengajar($id)
	{
		$query = $this->db->select('*')->where('id_pengajar',$id)->limit(1)->get('pengajar')->row_array();
		$this->db->where('id_pengajar',$id)->delete('pengajar');

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','delete',$this->db->last_query());
			$this->logData->tmpLogData('pengajar', json_encode($query));
			return true;
		}
		else{
			$this->logData->insertLogData('error','delete',$this->db->last_query());
			return false;
		}
	}

}