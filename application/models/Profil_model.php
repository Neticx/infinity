<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profil_model extends CI_Model {

	private $dataUser = array();

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Log_model','logData',true);		
	}

	public function cekIdUser($id)
	{
		$query = $this->db->select('user.*')
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

}