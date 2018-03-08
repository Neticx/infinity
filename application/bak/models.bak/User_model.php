<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {

	private $dataUser = array();

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Log_model','logData',true);
	}

	public function cekIdUser($id)
	{
		$query = $this->db->select('user.*, access.nama as access')
							->join('access','access.id_access = user.id_access','left')
							->where('id_user',$id)
							->limit(1)
							->get('user');
		if($query->num_rows() == 1){
			$this->dataUser = $query->row_array();
			return true;
		}
		else{
			return false;
		}
	}

	public function getDataUser()
	{
		return $this->dataUser;
	}

	public function getListOtorisasi($id)
	{
		return $this->db->select('DATE_FORMAT(mulai_tanggal, "%d %b %Y") as mulai, DATE_FORMAT(selesai_tanggal, "%d %b %Y") as sampai, access.nama')
						->join('access','otorisasi.id_access = access.id_access','left')
						->where('id_user',$id)
						->order_by('tanggal_input','DESC')
						->get('otorisasi')
						->result_array();
	}

	public function getListCabang()
	{
		return $this->db->select('id_cabang, nama')
							->order_by('id_cabang','ASC')
							->get('cabang')
							->result_array();
	}

	public function getListRoles()
	{
		return $this->db->select('*')
							->order_by('id_access','ASC')
							->get('access')
							->result_array();
	}

	public function getListTotal($search)
	{
		if($search != null){
			$query = $this->db->select('COUNT(id_user) as jumlah')
							->like('nama', $search)
							->or_like('email', $search)
							->or_like('no_telp', $search)
							->get('user')->row_array();
		}
		else{
			$query = $this->db->select('COUNT(id_user) as jumlah')
							->get('user')->row_array();
		}
		return $query['jumlah'];
	}

	public function getList($array = array())
	{
		if($array['search'] != null){
			$query = $this->db->select('id_user, user.nama, email, no_telp, access.nama as access')
							->join('access','access.id_access = user.id_access','left')
							->like('nama', $array['search'])
							->or_like('email', $array['search'])
							->or_like('no_telp', $array['search'])
							->limit($array['limit'], $array['offset'])
							->order_by('nama','ASC')
							->get('user');
		}
		else{
			$query = $this->db->select('id_user, user.nama, email, no_telp, access.nama as access')
							->join('access','access.id_access = user.id_access','left')
							->limit($array['limit'], $array['offset'])
							->order_by('nama','ASC')
							->get('user');
		}
		return $query->result();
	}

	public function insertUser($data = array(), $data2 = array())
	{
		$this->db->insert('user', $data);

		if($this->db->affected_rows() == 1){
			$data2['id_user'] = $this->db->insert_id();
			$this->logData->insertLogData('success','insert',$this->db->last_query());
			$this->db->insert('otorisasi',$data2);
			$this->logData->insertLogData('success','insert',$this->db->last_query());
			return true;
		}
		else{
			$this->logData->insertLogData('error','insert',$this->db->last_query());
			return false;
		}
	}

	public function inputOtorisasi($data = array())
	{
		$this->db->insert('otorisasi', $data);

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','insert',$this->db->last_query());
			return true;
		}
		else{
			$this->logData->insertLogData('error','insert',$this->db->last_query());
			return false;
		}
	}

	public function updateUser($data = array())
	{
		$query = $this->db->select('*')->where('id_user',$data['id_user'])->limit(1)->get('user')->row_array();
		$this->db->where('id_user',$data['id_user'])->update('user', $data);

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','update',$this->db->last_query());
			$this->logData->tmpLogData('user', json_encode($query));
			return true;
		}
		else{
			$this->logData->insertLogData('error','update',$this->db->last_query());
			return false;
		}
	}

	public function updatePasswordUser($data = array())
	{
		$query = $this->db->select('*')->where('id_user',$data['id_user'])->limit(1)->get('user')->row_array();
		$this->db->where('id_user',$data['id_user'])->update('user', $data);

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','update',$this->db->last_query());
			$this->logData->tmpLogData('user', json_encode($query));
			return true;
		}
		else{
			$this->logData->insertLogData('error','update',$this->db->last_query());
			return false;
		}
	}

	public function deleteUser($id)
	{
		$query = $this->db->select('*')->where('id_user',$data['id_user'])->limit(1)->get('user')->row_array();
		$this->db->where('id_user',$data['id_user'])->delete('user');

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','delete',$this->db->last_query());
			$this->logData->tmpLogData('user', json_encode($query));
			return true;
		}
		else{
			$this->logData->insertLogData('error','delete',$this->db->last_query());
			return false;
		}
	}

}