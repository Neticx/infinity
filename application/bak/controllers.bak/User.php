<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->helper('randompass');
		$this->load->model('User_model','user',true);
	}

	private function cekInputUser()
	{
		$form = array(
					array(
						'field' => 'nama',
						'label' => 'Nama Pegawai',
						'rules' => 'required',
						),
					array(
						'field' => 'no_pegawai',
						'label' => 'Nomor Pegawai',
						'rules' => 'required',
						),
					array(
						'field' => 'divisi',
						'label' => 'Divisi',
						'rules' => 'required',
						),
					array(
						'field' => 'mulai',
						'label' => 'Mulai Tanggal',
						'rules' => 'required',
						),
					array(
						'field' => 'sampai',
						'label' => 'S.D Tanggal',
						'rules' => 'required',
						),
					array(
						'field' => 'email',
						'label' => 'E-mail',
						'rules' => 'required|valid_email|is_unique[user.email]',
						),
					array(
						'field' => 'no_telp',
						'label' => 'No Telepon',
						'rules' => 'required',
						),
					array(
						'field' => 'status',
						'label' => 'Status',
						'rules' => 'required',
						),
					array(
						'field' => 'access',
						'label' => 'Otoritas',
						'rules' => 'required',
						),
					array(
						'field' => 'cabang',
						'label' => 'Cabang',
						'rules' => 'required',
						),
					array(
						'field' => 'alamat',
						'label' => 'Alamat',
						'rules' => 'required',
						),
				);


		$this->form_validation->set_rules($form);
		if($this->form_validation->run()){
			return true;
		}
		else{
			return false;
		}
	}

	private function cekInputUser2()
	{
		$form = array(
					array(
						'field' => 'nama',
						'label' => 'Nama Pegawai',
						'rules' => 'required',
						),
					array(
						'field' => 'no_pegawai',
						'label' => 'Nomor Pegawai',
						'rules' => 'required',
						),
					array(
						'field' => 'divisi',
						'label' => 'Divisi',
						'rules' => 'required',
						),
					array(
						'field' => 'no_telp',
						'label' => 'No Telepon',
						'rules' => 'required',
						),
					array(
						'field' => 'status',
						'label' => 'Status',
						'rules' => 'required',
						),
					array(
						'field' => 'cabang',
						'label' => 'Cabang',
						'rules' => 'required',
						),
					array(
						'field' => 'alamat',
						'label' => 'Alamat',
						'rules' => 'required',
						),
				);


		$this->form_validation->set_rules($form);
		if($this->form_validation->run()){
			return true;
		}
		else{
			return false;
		}
	}

	private function send_pass($email, $pass, $nama)
	{
		$this->load->library('email');
		$config['protocol'] = 'smtp';
	    $config['smtp_host'] = 'ssl://smtp.gmail.com';
	    $config['smtp_port'] = '465';
	    $config['smtp_user'] = 'raliableprototype@gmail.com';
	    $config['smtp_pass'] = 'raliableggwp123?';
	    $config['mailtype'] = 'html';
	    $config['charset'] = 'iso-8859-1';
	    $config['wordwrap'] = TRUE;
	    $config['newline'] = "\r\n";

		$this->email->initialize($config);

		$body = '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Bimbel Password</title><meta name="viewport" content="width=device-width, initial-scale=1.0" /></head><body style="background-color: #f9f9f9; margin: 10px; font: 13px/20px normal Helvetica, Arial, sans-serif; color: #4F5155;"><div style="margin: 5px; border: 1px solid #C0C0C0; box-shadow: 0 0 8px #C0C0C0; background-color: #fff;"><h1 style="color: #444; background-color: transparent; border-bottom: 1px solid #C0C0C0; font-size: 19px; font-weight: normal; margin: 0 0 14px 0; padding: 14px 15px 10px 15px;">Selamat Datang!</h1><p style="margin: 12px 15px 12px 15px;">Hi '.$nama.', selamat datang dalam sistem Bimbel. Berikut ini Kami Sampaikan Informasi tentang Login anda :</p><p style="margin: 12px 15px 5px 15px;">Email : '.$email.'</p><p style="margin: 0px 15px 12px 15px;">Password : '.$pass.'</p><p style="margin: 12px 15px 12px 15px;">Demikian kami sampaikan kepada anda, terimakasih <br /><i style="color: red;">*) Demi alasan keamanaan kami sarankan anda mengganti password anda setelah ini.</i></p></div></body></html>';
		$this->email->from('raliableprototype@gmail.com', 'Administrator Bimbel No-Reply');
		$this->email->to($email);
		$this->email->subject('Selamat Datang di Sistem Bimbel');
		$this->email->message($body);
		if($this->email->send()){
			return true;
		}
		else{
			return false;
		}
	}

	public function index()
	{
		$data = array(
				'title' => 'Daftar Pegawai',
			);
		$this->_render('user/user',$data);
	}

	public function profil()
	{
		$id = (int) $this->input->get('UserID',true);

		if($this->user->cekIdUser($id)){
			$row = $this->user->getDataUser();
			$data = array(
					'title' => 'Profil ' . $row['nama'],
					'dataUser' => $row,
					'cabang' => $this->user->getListCabang(),
					'roles' => $this->user->getListRoles(),
					'historyOtorisasi' => $this->user->getListOtorisasi($id),
					'status' => array('tetap' => 'Pegawai Tetap','panggilan' => 'Pegawai Panggilan','pengganti' => 'Pegawai Pengganti','sementara' => 'Pegawai Sementara'),
				);
			$this->_render('user/profil',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function add()
	{
		$data = array(
				'title' => 'Tambah Pegawai',
				'roles' => $this->user->getListRoles(),
				'cabang' => $this->user->getListCabang(),
			);
		$this->_render('user/add_user',$data);
	}

	public function edit()
	{
		$id = (int) $this->input->get('UserID',true);

		if($this->user->cekIdUser($id)){}
		else{}
	}

	public function delete()
	{
		$id = (int) $this->input->get('UserID',true);

		if($this->user->cekIdUser($id)){}
		else{}
	}

	public function reset_pass()
	{
		if($this->input->is_ajax_request()){
			$id = (int) $this->input->get('UserID',true);

			if($this->user->cekIdUser($id)){
				$pass = random_pass(6);
				$row = $this->user->getDataUser();

				$data = array(
						'id_user' => $id,
						'password' => md5(md5($pass)),
					);
				if($this->user->updatePasswordUser($data) && $this->send_pass($row['email'], $pass, $row['nama'])){
					echo json_encode(array('success' => true));
				}
				else{
					echo json_encode(array('success' => false));
				}
			}
			else{
				echo json_encode(array('success' => false));
			}
		}
		else{
			$this->error_404();
		}
	}

	public function action_add()
	{
		$pass = random_pass(6);
		if($this->cekInputUser()){
			$data = array(
					'id_user' => '',
					'no_pegawai' => $this->input->post('no_pegawai',true),
					'nama' => $this->input->post('nama',true),
					'divisi' => $this->input->post('divisi',true),
					'email' => $this->input->post('email',true),
					'no_telp' => $this->input->post('no_telp',true),
					'id_access' => $this->input->post('access',true),
					'id_cabang' => NULL,
					'password' => md5(md5($pass)),
					'foto' => '',
					'alamat' => $this->input->post('alamat',true),
					'status' => $this->input->post('status',true),
				);

			$data2 = array(
					'id_otorisasi' => '',
					'id_user' => '',
					'id_access' => $this->input->post('access',true),
					'tanggal_input' => date('Y-m-d H:i:s'),
					'mulai_tanggal' => date('Y-m-d', strtotime($this->input->post('mulai',true))),
					'selesai_tanggal' => date('Y-m-d', strtotime($this->input->post('sampai',true))),
				);

			if($this->user->insertUser($data, $data2) || $this->send_pass($data['email'], $pass, $data['nama'])){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', '<strong>SUCCESS. </strong> Berhasil menambahkan user.');
				redirect(base_url('user/add'),'refresh');
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', '<strong>ERROR. </strong> Gagal menambahkan user.');
				redirect(base_url('user/add'),'refresh');	
			}
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', '<strong>ERROR. </strong> Terjadi kesalahan dalam menginputkan data. ' . validation_errors('<span>','</span>'));
			redirect(base_url('user/add'),'refresh');
		}
	}

	public function action_edit()
	{
		$id = $this->input->post('id_user',true);
		if($this->cekInputUser2()){
			$data = array(
					'id_user' => $id,
					'no_pegawai' => $this->input->post('no_pegawai',true),
					'nama' => $this->input->post('nama',true),
					'divisi' => $this->input->post('divisi',true),
					'email' => $this->input->post('email',true),
					'no_telp' => $this->input->post('no_telp',true),
					'alamat' => $this->input->post('alamat',true),
					'status' => $this->input->post('status',true),
				);

			if($this->user->updateUser($data)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', '<strong>SUCCESS. </strong> Berhasil mengubah user.');
				redirect(base_url('user/profil/?UserID='.$data['id_user']),'refresh');
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', '<strong>ERROR. </strong> Gagal mengubah user.');
				redirect(base_url('user/profil/?UserID='.$data['id_user']),'refresh');	
			}
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', '<strong>ERROR. </strong> Terjadi kesalahan dalam menginputkan data. ' . validation_errors('<span>','</span>'));
			redirect(base_url('user/profil/?UserID='.$id),'refresh');
		}
	}

	public function action_edit_otorisasi()
	{
		$data = array(
				'id_otorisasi' => '',
				'id_user' => $this->input->post('id_user'),
				'id_access' => $this->input->post('access'),
				'tanggal_input' => date('Y-m-d H:i:s'),
				'mulai_tanggal' => date('Y-m-d', strtotime($this->input->post('mulai',true))),
				'selesai_tanggal' => date('Y-m-d', strtotime($this->input->post('sampai',true))),
			);
		if($this->user->inputOtorisasi($data)){
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_data', '<strong>SUCCESS. </strong> Berhasil mengubah otorisasi user.');
			redirect(base_url('user/profil/?UserID='.$data['id_user']),'refresh');
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', '<strong>ERROR. </strong> Gagal mengubah otorisasi user.');
			redirect(base_url('user/profil/?UserID='.$data['id_user']),'refresh');	
		}
	}

	public function list_data()
	{
		if($this->input->is_ajax_request()){
			$array = array(
				'limit' => (int) $this->input->get('limit', TRUE),
				'offset' => (int) $this->input->get('offset', TRUE),
				'search' => $this->input->get('search', TRUE)
				);
			$jumlah = $this->user->getListTotal($array['search']);
			$i = ($array['offset'] == 0 || $array['offset'] == null)?1:$array['offset']+1;
			header('Content-type: application/json');
			$dataJSON = array();
			$dataJSON['total'] = $jumlah;
			$dataJSON['rows'] = array();
			foreach($this->user->getList($array) as $result){
				$data = array(
						'no' => $i,
						'nama' => $result->nama,
						'email' => $result->email,
						'telp' => $result->no_telp,
						'role' => $result->access,
						'aksi' => "<a href=\"".base_url('user/profil/?UserID='.$result->id_user)."\" class=\"btn btn-xs btn-success\">Lihat Detail</a> <a onclick=\"doHapus('$result->id_user','$result->nama')\" class=\"btn btn-xs btn-danger\">Hapus</a>"
					);
				array_push($dataJSON['rows'], $data);
				$i++;
			}
			echo json_encode($dataJSON);
		}
		else{
			$this->error_404();
		}
	}

}