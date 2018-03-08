<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if($this->session->userdata('sess_user') == false && $this->session->userdata('nama_user') == null && $this->session->userdata('role_user') == null && $this->session->userdata('id_user') == null){
			redirect(base_url('auth/login'));
			exit(0);
		}
	}

	public function _render($view, $data = array())
	{
		$this->load->view('template/header2', $data, FALSE);
		$this->load->view($view, $data, FALSE);
		$this->load->view('template/footer', $data, FALSE);
	}

	public function error_404(){
		$this->output->set_status_header(404);
		$this->load->view('errors/error_404');
	}

}