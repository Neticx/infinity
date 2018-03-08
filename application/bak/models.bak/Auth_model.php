<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function auth($email, $password)
	{
		$query = $this->db->select('id_user, user.nama, foto, access.role, user.id_cabang')
							->join('access','user.id_access = access.id_access','left')
							->where('password',md5(md5($password)))
							->where('email',$email)
							->get('user');

		if($query->num_rows() == 1){
			$row = $query->row_array();
			$role = explode(',',$row['role']);

			$arraySESSION = array(
					'id_user' => $row['id_user'],
					'sess_user' => true,
					'nama_user' => $row['nama'],
					'role_user' => $role,
					'foto_user' => $row['foto'],
					'cabang_user' => $row['id_cabang'],
				);
			$this->session->set_userdata($arraySESSION);

			$log_login = array(
				'ip' => $this->input->server('REMOTE_ADDR'),
				'agent' => $this->agent->agent_string(),
				'id_user' => $row['id_user'],
				'device' => $this->agent->platform(),
				'time' => date('Y-m-d H:i:s')
				);
			$this->db->insert('log_login',$log_login);
			return true;
		}
		else{
			return false;
		}
	}

}