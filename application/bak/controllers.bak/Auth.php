<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Auth extends CI_Controller {

	/*
	SESSION
	---------
	id_user
	sess_user
	nama_user
	role_user
	*/

	private $authAlert = '';

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('user_agent');
		$this->load->model('Auth_model','auth',true);
	}

	private function authValidation()
	{
		$form = array(
					array(
						'field' => 'email',
						'label' => 'E-mail',
						'rules' => 'required|valid_email',
						),
					array(
						'field' => 'password',
						'label' => 'Password',
						'rules' => 'required',
						),
				);


		$this->form_validation->set_rules($form);
		if($this->form_validation->run()){
			return true;
		}
		else{
			$this->authAlert = validation_errors('<span>','</span>');
			return false;
		}
	}

	public function login()
	{
		if($this->session->userdata('sess_user') == true && $this->session->userdata('nama_user') !== null && $this->session->userdata('role_user') !== null && $this->session->userdata('id_user') !== null){
			redirect('dashboard');
			exit(0);
		}

		if($this->authValidation()){
			$email = $this->input->post('email',true);
			$password = $this->input->post('password',true);

			if($this->auth->auth($email, $password)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', '<strong>Success</strong> Login Success!!!');
				redirect('dashboard','refresh');
			}
			else{
				$this->authAlert = 'E-mail or Password doesn\'t exists!!';
			}
		}

		$data = array(
				'alert' => $this->authAlert,
			);

		$this->load->view('auth/login', $data);

	}

	public function logout()
	{
		if($this->session->userdata('sess_user') == true && $this->session->userdata('nama_user') !== null && $this->session->userdata('role_user') !== null && $this->session->userdata('id_user') !== null){
			$array = array('id_user','sess_user','nama_user','role_user','foto_user');
			$this->session->unset_userdata($array);
			$this->session->sess_destroy();
			redirect(base_url('auth/login'),'refresh');
			exit(0);
		}
		else{
			redirect(base_url('auth/login'),'refresh');
			exit(0);
		}
	}

}