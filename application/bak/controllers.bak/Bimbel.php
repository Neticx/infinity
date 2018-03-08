<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bimbel extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Bimbel_model','bimbel',true);
	}

	public function program()
	{
		if($this->session->userdata('cabang_user') == null || $this->session->userdata('cabang_user') == 'PUSAT'){
			$data = array(
				'title' => 'Program Bimbel',
				'program' => $this->bimbel->getProgram(),
			);
			$this->_render('bimbel/program',$data);
		}
		else{
			$this->_error404();
		}
	}

	public function action_edit_program()
	{
		$id = $this->input->get('ProgramID',true);
		if($this->bimbel->cekIdProgram($id)){
			$data = array(
					'id_program' => $id,
					'nama_program' => $this->input->post('nama',true),
					'harga' => $this->input->post('harga',true),
					'pendaftaran' => $this->input->post('pendaftaran',true),
					'sesi_kelas' => $this->input->post('sesi_kelas',true),
					'sesi_to' => $this->input->post('sesi_to',true),
				);

			if($this->bimbel->updateProgram($data)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Berhasil mengubah data Program ' . $dataProgram['nama']);
				redirect(base_url('bimbel/program'));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Gagal mengubah Program Bimbel');
				redirect(base_url('bimbel/program'));
			}
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', 'Data Program Bimbel tidak dapat ditemukan');
			redirect(base_url('bimbel/program'));
		}
	}

	public function kelas()
	{
		$data = array(
				'title' => 'Daftar Kelas',
			);
		$this->_render('bimbel/kelas',$data);
	}

	public function ruang()
	{
		$data = array(
				'' => '',
			);
		$this->_render('bimbel',$data);
	}

}