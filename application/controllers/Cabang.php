<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cabang extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('Cabang_model','cabang',true);
	}

	public function index()
	{
		$data = array(
				'title' => 'Daftar Cabang'
			);
		$this->_render('cabang/cabang',$data);
	}

	public function add()
	{
		$data = array(
				'title' => 'Tambah Data Cabang',
				'provinsi' => $this->cabang->getProvinsi(),
			);
		$this->_render('cabang/add_cabang',$data);
	}

	public function edit()
	{
		$id = $this->input->get('CabID',true);

		if($this->cabang->cekIdCabang($id)){
			$row = $this->cabang->getDataCabang();
			$data = array(
					'title' => 'Edit Cabang ' . $row['nama'],
					'dataCabang' => $row,
					'provinsi' => $this->cabang->getProvinsi(),
					'kabupaten' => $this->cabang->getKabupaten($row['id_provinsi']),
					'kecamatan' => $this->cabang->getKecamatan($row['id_kabupaten']),
				);
			$this->_render('cabang/edit_cabang',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function delete()
	{
		$id = $this->input->get('CabID',true);

		if($this->cabang->cekIdCabang($id)){
			if($this->cabang->deleteCabang($id)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', '<strong>SUCCESS. </strong> Data cabang berhasil di hapus');
				redirect(base_url('cabang'),'refresh');
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', '<strong>ERROR. </strong> Data cabang gagal di hapus');
				redirect(base_url('cabang'),'refresh');
			}
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', '<strong>ERROR. </strong> Data cabang gagal di hapus');
			redirect(base_url('cabang'),'refresh');
		}
	}

	public function delete_kc()
	{
		$idUser = $this->input->get('userID',true);
		$idCabang = $this->input->get('cabangID',true);

		if($this->cabang->deleteKepalaCabang($idUser, $idCabang)){
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_data', '<strong>SUCCESS. </strong> Data cabang berhasil di hapus');
			redirect(base_url('cabang/detail/?CabID='.$idCabang),'refresh');
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', '<strong>ERROR. </strong> Data cabang gagal di hapus');
			redirect(base_url('cabang/detail/?CabID='.$idCabang),'refresh');
		}
	}

	public function getKab()
	{
		if($this->input->is_ajax_request()){
			$id = (int) $this->input->get('id',true);
			$kabupaten = $this->cabang->getKabupaten($id);
			echo '<option value="0">--- Pilih Kabupaten ---</option>';
			foreach($kabupaten as $kab){
				echo '<option value="'.$kab['id_kabupaten'].'">'.$kab['name'].'</option>';
			}
		}
		else{
			redirect(base_url(),'refresh');
		}
	}

	public function getKec()
	{
		if($this->input->is_ajax_request()){
			$id = (int) $this->input->get('id',true);
			$kecamatan = $this->cabang->getKecamatan($id);
			echo '<option value="0">--- Pilih Kecamatan ---</option>';
			foreach($kecamatan as $kec){
				echo '<option value="'.$kec['id_kecamatan'].'">'.$kec['name'].'</option>';
			}
		}
		else{
			redirect(base_url(),'refresh');
		}
	}

	private function cekInputCabang()
	{
		$form = array(
					array(
						'field' => 'nama',
						'label' => 'Nama Cabang',
						'rules' => 'required',
						),
					array(
						'field' => 'lat',
						'label' => 'Latitude',
						'rules' => 'required',
						),
					array(
						'field' => 'lng',
						'label' => 'Longtitude',
						'rules' => 'required',
						),
					array(
						'field' => 'no_telp',
						'label' => 'No Telepon',
						'rules' => 'required',
						),
					array(
						'field' => 'fax',
						'label' => 'No Fax',
						'rules' => 'required',
						),
					array(
						'field' => 'email',
						'label' => 'E-mail',
						'rules' => 'required|valid_email',
						),
					array(
						'field' => 'prov',
						'label' => 'Provinsi',
						'rules' => 'required',
						),
					array(
						'field' => 'kab',
						'label' => 'Kabupaten',
						'rules' => 'required',
						),
					array(
						'field' => 'kec',
						'label' => 'Kecamatan',
						'rules' => 'required',
						),
					array(
						'field' => 'alamat',
						'label' => 'Alamat',
						'rules' => 'required',
						),
					array(
						'field' => 'pos',
						'label' => 'Kode POS',
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

	private function generateIdCabang()
	{
		$resultID = '';
		$result = $this->cabang->getLastID();
		if($result->num_rows() == 1){
			$row = $result->row_array();
			$sub = substr($row['id_cabang'], 3);
			$resultID = 'CAB'.str_pad($sub + 1, 5, 0, STR_PAD_LEFT);
		}
		else{
			$resultID = 'CAB00001';
		}

		return $resultID;
	}

	public function action_add()
	{
		if($this->cekInputCabang()){
			$data = array(
					'id_cabang' => $this->generateIdCabang(),
					'id_kecamatan' => $this->input->post('kec',true),
					'nama' => $this->input->post('nama',true),
					'alamat' => $this->input->post('alamat',true),
					'kode_pos' => $this->input->post('pos',true),
					'email' => $this->input->post('email',true),
					'lat' => $this->input->post('lat',true),
					'lng' => $this->input->post('lng',true),
					'no_telp' => $this->input->post('no_telp',true),
					'no_fax' => $this->input->post('fax',true),
					'id_user_kc' => NULL,
				);
			if($this->cabang->insertCabang($data)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', '<strong>SUCCESS. </strong> Data cabang berhasil ditambahkan!');
				redirect(base_url('cabang'),'refresh');
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', '<strong>ERROR. </strong> Data cabang gagal ditambahkan silahkan cek kembali data yang anda masukan!');
				redirect(base_url('cabang/add'),'refresh');
			}
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', '<strong>ERROR. </strong> Terjadi kesalahan dalam menginputkan data. ' . validation_errors('<span>','</span>'));
			redirect(base_url('cabang/add'),'refresh');
		}
	}

	public function action_add_kc()
	{
		$idUser = $this->input->post('id_user_kc',true);
		$idCabang = $this->input->post('id_cabang',true);

		if($this->cabang->inputKepalaCabang($idUser, $idCabang)){
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_data', '<strong>SUCCESS. </strong> Berhasil menginputkan data. ');
			redirect(base_url('cabang/detail/?CabID='.$idCabang),'refresh');
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', '<strong>ERROR. </strong> Terjadi kesalahan dalam menginputkan data. ');
			redirect(base_url('cabang/detail/?CabID='.$idCabang),'refresh');
		}
	}

	public function action_edit()
	{
		if($this->cekInputCabang()){
			$data = array(
					'id_cabang' => $this->input->post('id_cabang',true),
					'id_kecamatan' => $this->input->post('kec',true),
					'nama' => $this->input->post('nama',true),
					'alamat' => $this->input->post('alamat',true),
					'kode_pos' => $this->input->post('pos',true),
					'email' => $this->input->post('email',true),
					'lat' => $this->input->post('lat',true),
					'lng' => $this->input->post('lng',true),
					'no_telp' => $this->input->post('no_telp',true),
					'no_fax' => $this->input->post('fax',true),
				);
			if($this->cabang->updateCabang($data)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', '<strong>SUCCESS. </strong> Data cabang berhasil diubah!');
				redirect(base_url('cabang/edit/?CabID='.$data['id_cabang']),'refresh');
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', '<strong>ERROR. </strong> Data cabang gagal diubah silahkan cek kembali data yang anda masukan!');
				redirect(base_url('cabang/edit/?CabID='.$data['id_cabang']),'refresh');
			}
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', '<strong>ERROR. </strong> Terjadi kesalahan dalam menginputkan data. ' . validation_errors('<span>','</span>'));
			redirect(base_url('cabang/edit/?CabID='.$data['id_cabang']),'refresh');
		}
	}

	public function detail()
	{
		$id = $this->input->get('CabID',true);

		if($this->cabang->cekIdCabang($id)){
			$row = $this->cabang->getDataCabang();
			$data = array(
					'title' => 'Detail Cabang ' . $row['nama'],
					'useMaps' => true,
					'dataCabang' => $row,
					'kepCab' => $this->cabang->getKepalaCabang($id),
					'pegawai' => $this->cabang->getPegawaiCabang($id),
				);
			$this->_render('cabang/detail_cabang',$data);
		}
		else{
			$this->error_404();
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
			$jumlah = $this->cabang->getListTotal($array['search']);
			$i = ($array['offset'] == 0 || $array['offset'] == null)?1:$array['offset']+1;
			header('Content-type: application/json');
			$dataJSON = array();
			$dataJSON['total'] = $jumlah;
			$dataJSON['rows'] = array();
			foreach($this->cabang->getList($array) as $result){
				$data = array(
						'no' => $i,
						'nama' => $result->nama,
						'alamat' => substr($result->alamat, 0, 50) . ' ...',
						'telp' => $result->no_telp,
						'aksi' => "<a href=\"".base_url('cabang/detail/?CabID='.$result->id_cabang)."\" class=\"btn btn-xs btn-success\">Lihat Detail</a> <a href=\"".base_url('cabang/edit/?CabID='.$result->id_cabang)."\" class=\"btn btn-xs btn-primary\">Edit</a> <a onclick=\"doHapus('$result->id_cabang','$result->nama')\" class=\"btn btn-xs btn-danger\">Hapus</a>"
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