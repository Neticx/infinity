<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Inventaris extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Inventaris_model','inventaris',true);
	}

	public function index()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->inventaris->cekIdCabang($id)){
			$data = array(
					'title' => 'Inventaris',
					'cabangID' => $id,
					'inventaris' => $this->inventaris->getInventaris($id),
				);
			$this->_render('inventaris/inventaris',$data);
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'inventaris/?cabangID=',
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function add_inventaris()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->inventaris->cekIdCabang($id)){
			$data = array(
					'title' => 'Inventaris',
					'cabangID' => $id,
				);
			$this->_render('inventaris/add_inventaris',$data);
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'inventaris/add_inventaris/?cabangID=',
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function edit_inventaris()
	{}

	public function action_add()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->inventaris->cekIdCabang($id)){
			$data = array(
					'id_inventaris' => '',
					'nama' => $this->input->post('nama',true),
					'jenis_barang' => $this->input->post('jenis',true),
					'warna' => $this->input->post('warna',true),
					'jumlah' => $this->input->post('jumlah',true),
					'merk' => $this->input->post('merk',true),
					'gambar' => NULL,
					'keterangan' => $this->input->post('keterangan',true),
					'id_cabang' => $id
				);
			if(! empty($_FILES) && $_FILES['gambar']['name'] != null){
				$data['gambar'] = "inventaris-" . md5(time() . rand(0,100)) . "." . strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));

				$config['upload_path'] = './assets/img/inventaris';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['max_size']     = '1536';
				$this->load->library('upload', $config);

				$config['file_name'] = $data['gambar'];
				$this->upload->initialize($config);

				if($this->upload->do_upload('gambar')){
					$config['image_library'] = 'gd2';
					$config['source_image'] = './assets/img/inventaris/'.$data['gambar'];
					$config['maintain_ratio'] = TRUE;
					$config['quality'] = 70;
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();
				}
				else{
					$data['gambar'] = NULL;
				}
			}

			if($this->inventaris->insertInventaris($data)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Data Inventaris berhasil ditambahkan');
				redirect(base_url('inventaris/?cabangID=' . $id));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Data Inventaris gagal ditambahkan');
				redirect(base_url('inventaris/add_inventaris/?cabangID=' . $id));
			}
		}
		else{
			$this->error_404();
		}
	}

	public function action_edit()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}
		$id2 = $this->input->post('id_inventaris',true);

		if($this->inventaris->cekIdCabang($id) && $this->inventaris->cekIdInventaris($id2)){
			$row = $this->inventaris->getDataInventaris();

			$data = array(
					'id_inventaris' => $id2,
					'nama' => $this->input->post('nama',true),
					'jenis_barang' => $this->input->post('jenis',true),
					'warna' => $this->input->post('warna',true),
					'jumlah' => $this->input->post('jumlah',true),
					'merk' => $this->input->post('merk',true),
					'keterangan' => $this->input->post('keterangan',true),
				);
			if(!empty($_FILES) && $_FILES['gambar']['name'] != null){
				$nama_file = "inventaris-" . md5(time() . rand(0,100)) . "." . strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));

				$config['upload_path'] = './assets/img/inventaris';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['max_size']     = '1536';
				$this->load->library('upload', $config);

				$config['file_name'] = $nama_file;
				$this->upload->initialize($config);

				if($this->upload->do_upload('gambar')){
					$config['image_library'] = 'gd2';
					$config['source_image'] = './assets/img/inventaris/'.$nama_file;
					$config['maintain_ratio'] = TRUE;
					$config['quality'] = 70;
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();
				}

				if(!empty($row['gambar'])){
					unlink(FCPATH . "/assets/img/inventaris/".$row['gambar']);
				}

				$data['gambar'] = $nama_file;
			}

			if($this->inventaris->updateInventaris($data)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Inventaris berhasil diubah');
				redirect(base_url('inventaris/?cabangID=' . $id));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Inventaris gagal diubah');
				redirect(base_url('inventaris/?cabangID=' . $id));
			}
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', 'Data Inventaris tidak tepat');
			redirect(base_url('inventaris'));
		}
	}

	public function delete()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}
		$id2 = $this->input->get('InventarisID',true);

		if($this->inventaris->cekIdCabang($id) && $this->inventaris->cekIdInventaris($id2)){
			$row = $this->inventaris->getDataInventaris();
			if($this->inventaris->deleteInventaris($id2)){
				if(!empty($row['gambar'])){
					unlink(FCPATH . "/assets/img/pengumuman/".$row['gambar']);
				}

				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Inventaris berhasil dihapus');
				redirect(base_url('inventaris/?cabangID=' . $id));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Inventaris gagal dihapus');
				redirect(base_url('inventaris/?cabangID=' . $id));
			}
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', 'Data Inventaris tidak tepat');
			redirect(base_url('inventaris'));
		}
	}

}