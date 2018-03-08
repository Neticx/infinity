<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tamu extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Tamu_model','tamu',true);
	}

	public function index()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->tamu->cekIdCabang($id)){
			$data = array(
					'title' => 'Tamu Bimbel Infinity',
					'cabangID' => $id,
				);
			$this->_render('tamu/daftar_tamu',$data);
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'tamu/?cabangID=',
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	private function send_followup($judul, $body)
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

		$content = '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Bimbel Password</title><meta name="viewport" content="width=device-width, initial-scale=1.0" /></head><body style="background-color: #f9f9f9; margin: 10px; font: 13px/20px normal Helvetica, Arial, sans-serif; color: #4F5155;"><div style="margin: 5px; border: 1px solid #C0C0C0; box-shadow: 0 0 8px #C0C0C0; background-color: #fff;"><h1 style="color: #444; background-color: transparent; border-bottom: 1px solid #C0C0C0; font-size: 19px; font-weight: normal; margin: 0 0 14px 0; padding: 14px 15px 10px 15px;">'.$judul.'</h1>'.$body.'</div></body></html>';
		$this->email->from('raliableprototype@gmail.com', 'FollowUp Bimbel Infinity No-Reply');
		$this->email->to($email);
		$this->email->subject('FollowUp Bimbel Infinity');
		$this->email->message($content);
		$this->email->send();
	}

	public function add()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->tamu->cekIdCabang($id)){
			$data = array(
					'title' => 'Form Buku Tamu',
					'cabangID' => $id,
				);
			$this->_render('tamu/form_tamu',$data);
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'tamu/add/?cabangID=',
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function edit()
	{
		$id = $this->input->get("cabangID",true);
		$id2 = $this->input->get("tamuID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->tamu->cekIdCabang($id)){
			if($this->tamu->cekIdTamu($id2)){
				$data = array(
						'title' => 'Form Edit Buku Tamu',
						'cabangID' => $id,
						'tamu' => $this->tamu->getDataTamu(),
					);
				$this->_render('tamu/form_tamu_edit',$data);
			}
			else{
				$this->error_404();
			}
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'tamu/add/?cabangID=',
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function followup()
	{
		$data = array(
				'title' => 'Followup Tamu Bimbel Infinity',
			);
		$this->_render('tamu/form_followup',$data);
	}

	public function action_add()
	{
		$id = $this->input->post('id_cabang',true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		$data = array(
					'id_tamu' => '',
					'id_cabang' => $id,
					'nama_siswa' => $this->input->post('nama',true),
					'jk' => $this->input->post('jk',true),
					'email' => $this->input->post('email',true),
					'no_hp' => $this->input->post('no_hp',true),
					'asal_sekolah' => $this->input->post('asal_sekolah',true),
					'jurusan' => $this->input->post('jurusan',true),
					'alamat' => $this->input->post('alamat',true),
					'nama_wali' => $this->input->post('nama_wali',true),
					'no_hp_wali' => $this->input->post('no_hp_wali',true),
					'tahu_infinity' => $this->input->post('tahu_infinity',true),
					'tanggal' => date('Y-m-d H:i:s'),
				);
		if($this->tamu->insertTamu($data)){
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_data', '<strong>SUCCESS. </strong> Berhasil menambahkan data tamu.');
			redirect(base_url('tamu/add/?cabangID='.$id),'refresh');
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', '<strong>ERROR. </strong> Gagal menambahkan data tamu.');
			redirect(base_url('tamu/add/?cabangID='.$id),'refresh');
		}
	}

	public function action_edit()
	{
		$id = $this->input->post('id_cabang',true);
		$id2 = $this->input->post('id_tamu',true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		$data = array(
				'id_tamu' => $id2,
				'id_cabang' => $id,
				'nama_siswa' => $this->input->post('nama',true),
				'jk' => $this->input->post('jk',true),
				'email' => $this->input->post('email',true),
				'no_hp' => $this->input->post('no_hp',true),
				'asal_sekolah' => $this->input->post('asal_sekolah',true),
				'jurusan' => $this->input->post('jurusan',true),
				'alamat' => $this->input->post('alamat',true),
				'nama_wali' => $this->input->post('nama_wali',true),
				'no_hp_wali' => $this->input->post('no_hp_wali',true),
				'tahu_infinity' => $this->input->post('tahu_infinity',true),
			);
		if($this->tamu->updateTamu($data)){
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_data', '<strong>SUCCESS. </strong> Berhasil mengubah data tamu.');
			redirect(base_url('tamu/edit/?cabangID='.$id.'&tamuID='.$id2),'refresh');
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', '<strong>ERROR. </strong> Gagal mengubah data tamu.');
			redirect(base_url('tamu/edit/?cabangID='.$id.'&tamuID='.$id2),'refresh');
		}
	}

	public function delete()
	{
		$id = $this->input->get("cabangID",true);
		$id2 = $this->input->get("tamuID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->tamu->cekIdCabang($id)){
			if($this->tamu->cekIdTamu($id2)){
				if($this->tamu->deleteTamu($id, $id2)){
					$this->session->set_flashdata('alert_type', 'success');
					$this->session->set_flashdata('alert_data', '<strong>SUCCESS. </strong> Berhasil menghapus data tamu.');
					redirect(base_url('tamu/?cabangID='.$id),'refresh');
				}
				else{
					$this->session->set_flashdata('alert_type', 'danger');
					$this->session->set_flashdata('alert_data', '<strong>ERROR. </strong> Gagal menghapus data tamu.');
					redirect(base_url('tamu/?cabangID='.$id),'refresh');
				}
			}
			else{
				$this->error_404();
			}
		}
		else{
			$this->error_404();
		}
	}

	public function list_data()
	{
		if($this->input->is_ajax_request()){
			$id = $this->input->get("cabangID",true);
			if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
				$id = $this->session->userdata("cabang_user");
			}

			$array = array(
				'limit' => (int) $this->input->get('limit', TRUE),
				'offset' => (int) $this->input->get('offset', TRUE),
				'search' => $this->input->get('search', TRUE)
				);
			$jumlah = $this->tamu->getListTotal($id, $array['search']);
			$i = ($array['offset'] == 0 || $array['offset'] == null)?1:$array['offset']+1;
			header('Content-type: application/json');
			$dataJSON = array();
			$dataJSON['total'] = $jumlah;
			$dataJSON['rows'] = array();
			foreach($this->tamu->getList($id, $array) as $result){
				$data = array(
						'no' => $i,
						'nama' => $result->nama_siswa,
						'jk' => ($result->jk == 'm')?'Laki-laki':'Perempuan',
						'asal' => $result->asal_sekolah,
						'email' => $result->email,
						'no_hp' => $result->no_hp,
						'tanggal' => $result->tgl,
						'tanggal' => $result->tgl,
						'aksi' => "<a href=\"".base_url('tamu/edit/?cabangID='.$id.'&tamuID='.$result->id_tamu)."\" class=\"btn btn-xs btn-primary\">Edit</a> <a onclick=\"doHapus('$result->id_tamu','$result->nama_siswa')\" class=\"btn btn-xs btn-danger\">Hapus</a>"
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