<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cabang_model extends CI_Model {

	private $dataCabang = array();

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Log_model','logData',true);
	}

	public function getLastID()
	{
		return $this->db->select('id_cabang')
							->limit(1)
							->order_by('id_cabang','DESC')
							->get('cabang');
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

	public function getKepalaCabang($id)
	{
		$query = $this->db->select('id_user, cabang.id_cabang, user.nama, user.email, user.no_telp')
							->join('user','cabang.id_user_kc = user.id_user','inner')
							->where('cabang.id_cabang',$id)
							->limit(1)
							->get('cabang');
		if($query->num_rows() == 1){
			return $query->row_array();
		}
		else{
			return array();
		}
	}

	public function getPegawaiCabang($id)
	{
		$query = $this->db->select('id_user, user.nama, email, no_telp, access.nama as access')
							->join('access','user.id_access = access.id_access','left')
							->where('id_cabang',$id)
							->order_by('nama','ASC')
							->get('user');
		if($query->num_rows() == 1){
			return $query->result_array();
		}
		else{
			return array();
		}
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

	public function getListTotal($search)
	{
		if($search != null){
			$query = $this->db->select('COUNT(id_cabang) as jumlah')
							->like('nama', $search)
							->or_like('alamat', $search)
							->or_like('no_telp', $search)
							->get('cabang')->row_array();
		}
		else{
			$query = $this->db->select('COUNT(id_cabang) as jumlah')
							->get('cabang')->row_array();
		}
		return $query['jumlah'];
	}

	public function getList($array = array())
	{
		if($array['search'] != null){
			$query = $this->db->select('id_cabang, nama, alamat, no_telp')
							->like('nama', $array['search'])
							->or_like('alamat', $array['search'])
							->or_like('no_telp', $array['search'])
							->limit($array['limit'], $array['offset'])
							->order_by('nama','ASC')
							->get('cabang');
		}
		else{
			$query = $this->db->select('id_cabang, nama, alamat, no_telp')
							->limit($array['limit'], $array['offset'])
							->order_by('nama','ASC')
							->get('cabang');
		}
		return $query->result();
	}

	public function insertCabang($data = array())
	{
		$this->db->insert('cabang', $data);

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','insert',$this->db->last_query());
			return true;
		}
		else{
			$this->logData->insertLogData('error','insert',$this->db->last_query());
			return false;
		}
	}

	public function inputKepalaCabang($idUser, $idCabang)
	{
		$query = $this->db->select('*')->where('id_cabang',$idCabang)->limit(1)->get('cabang')->row_array();
		$data = array(
				'id_user_kc' => $idUser,
			);
		$this->db->where('id_cabang',$idCabang)->update('cabang', $data);
		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','update',$this->db->last_query());
			$this->logData->tmpLogData('cabang', json_encode($query));
			$data2 = array(
					'id_cabang' => $idCabang,
				);
			$this->db->where('id_user',$idUser)->update('user', $data2);
			return true;
		}
		else{
			$this->logData->insertLogData('error','update',$this->db->last_query());
			return false;
		}
	}

	public function updateCabang($data = array())
	{
		$query = $this->db->select('*')->where('id_cabang',$data['id_cabang'])->limit(1)->get('cabang')->row_array();
		$this->db->where('id_cabang',$data['id_cabang'])->update('cabang', $data);

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','update',$this->db->last_query());
			$this->logData->tmpLogData('cabang', json_encode($query));
			return true;
		}
		else{
			$this->logData->insertLogData('error','update',$this->db->last_query());
			return false;
		}
	}

	public function deleteCabang($id)
	{
		$query = $this->db->select('*')->where('id_cabang',$id)->limit(1)->get('cabang')->row_array();
		$this->db->where('id_cabang',$id)->delete('cabang');

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','delete',$this->db->last_query());
			$this->logData->tmpLogData('cabang', json_encode($query));
			return true;
		}
		else{
			$this->logData->insertLogData('error','delete',$this->db->last_query());
			return false;
		}
	}

	public function deleteKepalaCabang($idUser, $idCabang)
	{
		$query = $this->db->select('*')->where('id_cabang',$idCabang)->limit(1)->get('cabang')->row_array();
		$data = array(
				'id_user_kc' => NULL,
			);
		$this->db->where('id_cabang',$idCabang)->update('cabang', $data);

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','update',$this->db->last_query());
			$this->logData->tmpLogData('cabang', json_encode($query));
			return true;
		}
		else{
			$this->logData->insertLogData('error','update',$this->db->last_query());
			return false;
		}
	}

}