<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	private function get_menu($id)
	{
		return $this->db->select('*')
						->where('id_menu',$id)
						->limit(1)
						->get('menu')
						->row_array();
	}

	public function auth($email, $password, $tipe)
	{
		switch($tipe){
			case 'pegawai':
				$query = $this->db->select('id_user, user.nama, foto, access.id_access, access.role, user.id_cabang')
									->join('access','user.id_access = access.id_access','left')
									->where('password',md5(md5($password)))
									->where('email',$email)
									->get('user');
			break;

			case 'pengajar':
				$query = $this->db->select('id_pengajar as id_user, pengajar.nama, foto, CONCAT(18) as id_access, access.role, pengajar.id_cabang')
									->join('access','18 = access.id_access','left')
									->where('password',md5(md5($password)))
									->where('email',$email)
									->get('pengajar');
			break;

			/*case 'siswa':
				$query = $this->db->select('')
			break;*/

			default:
				return false;
				exit(0);
			break;
		}

		if($query->num_rows() == 1){
			$row = $query->row_array();
			$listRole = explode(',',$row['role']);
			$menu = array();
			foreach($listRole as $rol){
				$tmp_menu = $this->get_menu($rol);
				if(empty($tmp_menu['id_main_menu'])){
					$id_menu = $tmp_menu['id_menu'];
					$menu[$id_menu] = array(
							'main' => array(
									'nama' => $tmp_menu['nama'],
									'icon' => $tmp_menu['icon'],
									'url' => $tmp_menu['url'],
								)
						);
				}
				else{
					$id_menu = $tmp_menu['id_main_menu'];
					if(array_key_exists('sub', $menu[$id_menu])){
						$menu[$id_menu]['sub'][] = array(
									'nama' => $tmp_menu['nama'],
									'icon' => $tmp_menu['icon'],
									'url' => $tmp_menu['url'],
								);
					}
					else{
						$menu[$id_menu]['sub'] = array();
						$menu[$id_menu]['sub'][] = array(
										'nama' => $tmp_menu['nama'],
										'icon' => $tmp_menu['icon'],
										'url' => $tmp_menu['url'],
									);
					}
				}
			}

			$arraySESSION = array(
					'id_user' => $row['id_user'],
					'sess_user' => true,
					'access_user' => $row['id_access'],
					'nama_user' => $row['nama'],
					'role_user' => $menu,
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