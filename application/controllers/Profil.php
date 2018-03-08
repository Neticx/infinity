<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profil extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Profil_model','profil',true);
	}

	private function cekInputUser()
	{
		$form = array(
					array(
						'field' => 'nama',
						'label' => 'Nama',
						'rules' => 'required',
						),
					array(
						'field' => 'no_telp',
						'label' => 'No Telepon',
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

	private function cekInputPassword()
	{
		$form = array(
					array(
						'field' => 'oldpassword',
						'label' => 'Old Password',
						'rules' => 'required',
						),
					array(
						'field' => 'password',
						'label' => 'Password',
						'rules' => 'required',
						),
					array(
						'field' => 'confpassword',
						'label' => 'Confirm Password',
						'rules' => 'required|matches[password]',
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

	public function index()
	{
		if($this->profil->cekIdUser($this->session->userdata('id_user'))){
			$data = array(
					'title' => 'Profil ' . $this->session->userdata('nama_user'),
					'dataUser' => $this->profil->getDataUser(),
				);
			$this->_render('profil/profil',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function action_edit()
	{
		if($this->profil->cekIdUser($this->session->userdata('id_user'))){
			$dataUser = $this->profil->getDataUser();

			if($this->cekInputUser()){
				if(!empty($this->input->post('oldpassword',true))){
					$oldPassword = md5(md5($this->input->post('oldpassword',true)));
					if($oldPassword == $dataUser['password'] && $this->cekInputPassword()){
						$data = array(
								'id_user' => $this->session->userdata('id_user'),
								'nama' => $this->input->post('nama',true),
								'no_telp' => $this->input->post('no_telp',true),
								'password' => md5(md5($this->input->post('password',true))),
								'alamat' => $this->input->post('alamat',true),
							);

						if($this->profil->updateUser($data)){
							$this->session->set_flashdata('alert_type', 'success');
							$this->session->set_flashdata('alert_data', '<strong>SUCCESS. </strong> Berhasil mengubah data dan password.');
							redirect(base_url('profil'),'refresh');
						}
						else{
							$this->session->set_flashdata('alert_type', 'danger');
							$this->session->set_flashdata('alert_data', '<strong>ERROR. </strong> Terjadi kesalahan dalam melakukan input. '. validation_errors('<span>','</span>'));
							redirect(base_url('profil'),'refresh');
						}
					}
					else{
						$this->session->set_flashdata('alert_type', 'danger');
						$this->session->set_flashdata('alert_data', '<strong>ERROR. </strong> Terjadi kesalahan dalam melakukan input. '. validation_errors('<span>','</span>'));
						redirect(base_url('profil'),'refresh');
					}
				}
				else{
					$data = array(
							'id_user' => $this->session->userdata('id_user'),
							'nama' => $this->input->post('nama',true),
							'no_telp' => $this->input->post('no_telp',true),
							'alamat' => $this->input->post('alamat',true),
						);

					if($this->profil->updateUser($data)){
						$this->session->set_flashdata('alert_type', 'success');
						$this->session->set_flashdata('alert_data', '<strong>SUCCESS. </strong> Berhasil mengubah data.');
						redirect(base_url('profil'),'refresh');
					}
					else{
						$this->session->set_flashdata('alert_type', 'danger');
						$this->session->set_flashdata('alert_data', '<strong>ERROR. </strong> Terjadi kesalahan dalam melakukan input. '. validation_errors('<span>','</span>'));
						redirect(base_url('profil'),'refresh');
					}
				}
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', '<strong>ERROR. </strong> Data yang anda masukan tidak lengkap. '. validation_errors('<span>','</span>'));
				redirect(base_url('profil'),'refresh');
			}
		}
		else{
			$this->error_404();
		}
	}

}