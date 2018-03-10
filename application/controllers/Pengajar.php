<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengajar extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Pengajar_model','pengajar',true);
		$this->load->helper('randompass');
	}

	private function send_pass($email, $pass, $nama)
	{
		$this->load->library('email');
		$config['protocol'] = 'smtp';
	    $config['smtp_host'] = 'mail.infinity-onfire.com';
	    $config['smtp_port'] = '587';
	    $config['smtp_user'] = 'no-reply@infinity-onfire.com';
	    $config['smtp_pass'] = 'bismillah123?';
	    $config['mailtype'] = 'html';
	    $config['charset'] = 'iso-8859-1';
	    $config['wordwrap'] = TRUE;
	    $config['newline'] = "\r\n";

		$this->email->initialize($config);

		$body = '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Bimbel Password</title><meta name="viewport" content="width=device-width, initial-scale=1.0" /></head><body style="background-color: #f9f9f9; margin: 10px; font: 13px/20px normal Helvetica, Arial, sans-serif; color: #4F5155;"><div style="margin: 5px; border: 1px solid #C0C0C0; box-shadow: 0 0 8px #C0C0C0; background-color: #fff;"><h1 style="color: #444; background-color: transparent; border-bottom: 1px solid #C0C0C0; font-size: 19px; font-weight: normal; margin: 0 0 14px 0; padding: 14px 15px 10px 15px;">Selamat Datang!</h1><p style="margin: 12px 15px 12px 15px;">Hi '.$nama.', selamat datang dalam sistem Bimbel. Berikut ini Kami Sampaikan Informasi tentang Login anda :</p><p style="margin: 12px 15px 5px 15px;">Email : '.$email.'</p><p style="margin: 0px 15px 12px 15px;">Password : '.$pass.'</p><p style="margin: 12px 15px 12px 15px;">Demikian kami sampaikan kepada anda, terimakasih <br /><i style="color: red;">*) Demi alasan keamanaan kami sarankan anda mengganti password anda setelah ini.</i></p></div></body></html>';
		$this->email->from('no-reply@infinity-onfire.com', 'Administrator Bimbel Infinity No-Reply');
		$this->email->to($email);
		$this->email->subject('Selamat Datang di Sistem Bimbel Infinity');
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
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->pengajar->cekIdCabang($id)){
			$data = array(
					'title' => 'Data Pengajar',
					'cabangID' => $id,
				);
			$this->_render('pengajar/pengajar',$data);
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'pengajar/?cabangID=',
				);
			$this->_render('search/search',$data);	
		}
		else{
			$this->error_404();
		}
	}

	public function add()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->pengajar->cekIdCabang($id)){
			$cabang = $this->pengajar->getDataCabang();
			$data = array(
					'title' => 'Data Pengajar',
					'cabangID' => $id,
					'cabang' => $cabang,
					'provinsi' => $this->pengajar->getProvinsi()
				);
			$this->_render('pengajar/add_pengajar',$data);
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'pengajar/add/?cabangID=',
				);
			$this->_render('search/search',$data);	
		}
		else{
			$this->error_404();
		}
	}

	public function detail()
	{
		$id = $this->input->get("cabangID",true);
		$id2 = $this->input->get("PengajarID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->pengajar->cekIdCabang($id) && $this->pengajar->cekIdPengajar($id2)){
			$pengajar = $this->pengajar->getDataPengajar();
			$cabang = $this->pengajar->getDataCabang();
			$data = array(
					'title' => 'Data Pengajar',
					'cabangID' => $id,
					'pengajar' => $pengajar,
					'cabang' => $cabang,
					'tgl_lahir' => date('d-m-Y', strtotime($pengajar['tgl_lahir'])),
					'tgl_masuk' => date('d-m-Y', strtotime($pengajar['tanggal_masuk'])),
					'provinsi' => $this->pengajar->getProvinsi(),
					'kabupaten' => $this->pengajar->getKabupaten($pengajar['id_provinsi']),
					'kecamatan' => $this->pengajar->getKecamatan($pengajar['id_kabupaten']),
				);
			$this->_render('pengajar/edit_pengajar',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function delete()
	{
		$id = $this->input->get('cabangID',true);
		$id2 = $this->input->get('PengajarID',true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->pengajar->cekIdCabang($id) || $this->pengajar->cekIdPengajar($id2)){
			if($this->pengajar->deletePengajar($id2)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', '<strong>SUCCESS. </strong> Data cabang berhasil di hapus');
				redirect(base_url('pengajar/?cabangID='.$id),'refresh');
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', '<strong>ERROR. </strong> Data cabang gagal di hapus');
				redirect(base_url('pengajar/?cabangID='.$id),'refresh');
			}
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', '<strong>ERROR. </strong> Data cabang gagal di hapus');
			redirect(base_url('cabang'),'refresh');
		}
	}

	public function action_add()
	{
		$id = $this->input->post('id_cabang',true);
		if($this->pengajar->cekIdCabang($id)){
			$data = array(
					'id_pengajar' => '',
					'id_cabang' => $id,
					'nama' => $this->input->post('nama',true),
					'jk' => $this->input->post('jk',true),
					'tmpt_lahir' => $this->input->post('tmpt_lahir',true),
					'tgl_lahir' => date('Y-m-d', strtotime($this->input->post('tanggal_lahir',true))),
					'email' => $this->input->post('email',true),
					'no_hp' => $this->input->post('no_hp',true),
					'alamat' => $this->input->post('alamat',true),
					'id_kecamatan' => $this->input->post('kec',true),
					'kode_pengajar' => $this->input->post('kode_pengajar',true),
					'no_rek_bni' => $this->input->post('no_rek',true),
					'tanggal_masuk' => date('Y-m-d', strtotime($this->input->post('tanggal_masuk',true))),
					'bidang' => $this->input->post('bidang',true),
					'grade' => $this->input->post('grade',true),
					'status' => $this->input->post('status',true),
					'password' => md5(md5($pass)),
				);
			if($this->pengajar->insertPengajar($data) && $this->send_pass($data['email'], $data['password'], $data['nama'])){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Data Pengajar berhasil ditambahkan');
				redirect(base_url('pengajar/add/?cabangID='.$id));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Data Pengajar gagal ditambahkan');
				redirect(base_url('pengajar/add/?cabangID='.$id));
			}
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', 'Terjadi kesalahan data cabang');
			redirect(base_url('pengajar/add'));
		}
	}

	public function action_edit()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->pengajar->cekIdCabang($id)){
			$data = array(
					'id_pengajar' => $this->input->post('id_pengajar',true),
					'nama' => $this->input->post('nama',true),
					'jk' => $this->input->post('jk',true),
					'tmpt_lahir' => $this->input->post('tmpt_lahir',true),
					'tgl_lahir' => date('Y-m-d', strtotime($this->input->post('tanggal_lahir',true))),
					'email' => $this->input->post('email',true),
					'no_hp' => $this->input->post('no_hp',true),
					'alamat' => $this->input->post('alamat',true),
					'id_kecamatan' => $this->input->post('kec',true),
					'kode_pengajar' => $this->input->post('kode_pengajar',true),
					'no_rek_bni' => $this->input->post('no_rek',true),
					'tanggal_masuk' => date('Y-m-d', strtotime($this->input->post('tanggal_masuk',true))),
					'bidang' => $this->input->post('bidang',true),
					'grade' => $this->input->post('grade',true),
					'status' => $this->input->post('status',true),
				);
			if($this->pengajar->updatePengajar($data)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Data Pengajar berhasil diubah');
				redirect(base_url('pengajar/detail/?cabangID='.$id.'&PengajarID='.$data['id_pengajar']));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Data Pengajar gagal ditambahkan');
				redirect(base_url('pengajar/detail/?cabangID='.$id.'&PengajarID='.$data['id_pengajar']));
			}
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', 'Terjadi kesalahan data cabang');
			redirect(base_url('pengajar'));
		}
	}

	public function reset_pass()
	{
		if($this->input->is_ajax_request()){
			$id = (int) $this->input->get('PengajarID',true);

			if($this->pengajar->cekIdPengajar($id)){
				$pass = random_pass(6);
				$row = $this->pengajar->getDataPengajar();
				$data = array(
						'id_pengajar' => $id,
						'password' => md5(md5($pass)),
					);
				if($this->pengajar->updatePasswordPengajar($data) && $this->send_pass($row['email'], $pass, $row['nama'])){
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

	public function list_data()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->input->is_ajax_request()){
			$array = array(
				'limit' => (int) $this->input->get('limit', TRUE),
				'offset' => (int) $this->input->get('offset', TRUE),
				'search' => $this->input->get('search', TRUE)
				);
			$jumlah = $this->pengajar->getListTotal($id, $array['search']);
			$i = ($array['offset'] == 0 || $array['offset'] == null)?1:$array['offset']+1;
			header('Content-type: application/json');
			$dataJSON = array();
			$dataJSON['total'] = $jumlah;
			$dataJSON['rows'] = array();
			foreach($this->pengajar->getList($id, $array) as $result){
				$data = array(
						'no' => $i,
						'nama' => $result->nama,
						'no_peg' => $result->kode_pengajar,
						'email' => $result->email,
						'telp' => $result->no_hp,
						'aksi' => "<a href=\"".base_url('pengajar/detail/?cabangID='.$result->id_cabang.'&PengajarID='.$result->id_pengajar)."\" class=\"btn btn-xs btn-success\">Lihat Detail</a> <a onclick=\"doHapus('$result->id_cabang','$result->id_pengajar','$result->nama')\" class=\"btn btn-xs btn-danger\">Hapus</a>"
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