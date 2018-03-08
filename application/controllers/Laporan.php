<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Laporan_model','laporan',true);
	}

	/*
	DAFTAR LAPORAN KONSULTAN
	*/

	public function daftar_laporan_konsultan()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->laporan->cekIdCabang($id)){
			$data = array(
					'title' => 'Daftar Laporan Konsultan',
					'cabangID' => $id
				);
			$this->_render('laporan/daftar_laporan_konsultan',$data);
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'laporan/daftar_laporan_konsultan/?cabangID='
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function add_laporan_konsultan()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->laporan->cekIdCabang($id)){
			$cabang = $this->laporan->getDataCabang();
			$data = array(
					'title' => 'Add Laporan Konsultan',
					'cabangID' => $id,
					'namaCabang' => $cabang['nama'],
				);
			$this->_render('laporan/add_laporan_konsultan',$data);
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'laporan/add_laporan_konsultan/?cabangID='
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function edit_laporan_konsultan()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}
		$id2 = $this->input->get("id",true);

		if($this->laporan->cekIdCabang($id)){
			$cabang = $this->laporan->getDataCabang();
			$data = array(
					'title' => 'Edit Laporan Konsultan',
					'cabangID' => $id,
					'namaCabang' => $cabang['nama'],
					'laporan' => $this->laporan->getLaporanKonsultan($id2)
				);
			$this->_render('laporan/edit_laporan_konsultan',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function delete_laporan_konsultan()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}
		$id2 = $this->input->get('id',true);

		if($this->laporan->cekIdCabang($id)){
			if($this->laporan->deleteLaporanKonsultan($id2)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Laporan Konsultan berhasil dihapus');
				redirect(base_url('laporan/daftar_laporan_konsultan/?cabangID='.$id));
			}
			else{
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Laporan Konsultan gagal dihapus');
				redirect(base_url('laporan/daftar_laporan_konsultan/?cabangID='.$id));
			}
		}
		else{
			$this->error_404();
		}
	}

	public function action_add_laporan_konsultan()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->laporan->cekIdCabang($id)){
			$data = array(
					'id_laporan_konsultan' => '',
					'id_cabang' => $id,
					'id_user_konsultan' => $this->session->userdata('id_user'),
					'tanggal' => $this->input->post('tanggal',true),
					'jml_tamu' => $this->input->post('jml_tamu',true),
					'jml_daftar' => $this->input->post('jml_daftar',true),
					'jml_bayar' => $this->input->post('jml_bayar',true),
					'catatan' => $this->input->post('catatan',true),
				);
			if($this->laporan->insertLaporanKonsultan($data)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Laporan Konsultan berhasil ditambahkan');
				redirect(base_url('laporan/daftar_laporan_konsultan/?cabangID='.$id));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Laporan Konsultan gagal ditambahkan');
				redirect(base_url('laporan/add_laporan_konsultan/?cabangID='.$id));
			}
		}
		else{
			$this->error_404();
		}
	}

	public function action_edit_laporan_konsultan()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->laporan->cekIdCabang($id)){
			$data = array(
					'id_laporan_konsultan' => $this->input->post('id_laporan_konsultan',true),
					'tanggal' => $this->input->post('tanggal',true),
					'jml_tamu' => $this->input->post('jml_tamu',true),
					'jml_daftar' => $this->input->post('jml_daftar',true),
					'jml_bayar' => $this->input->post('jml_bayar',true),
					'catatan' => $this->input->post('catatan',true),
				);
			if($this->laporan->updateLaporanKonsultan($data)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Laporan Konsultan berhasil diubah');
				redirect(base_url('laporan/edit_laporan_konsultan/?cabangID='.$id.'&id='.$data['id_laporan_konsultan']));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Laporan Konsultan gagal diubah');
				redirect(base_url('laporan/edit_laporan_konsultan/?cabangID='.$id.'&id='.$data['id_laporan_konsultan']));
			}
		}
		else{
			$this->error_404();
		}
	}

	public function list_data_laporan_konsultan()
	{
		if($this->input->is_ajax_request()){
			$id = $this->input->get("cabangID",true);
			if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
				$id = $this->session->userdata("cabang_user");
			}

			if($this->laporan->cekIdCabang($id)){
				$array = array(
					'limit' => (int) $this->input->get('limit', TRUE),
					'offset' => (int) $this->input->get('offset', TRUE),
					'search' => $this->input->get('search', TRUE)
					);
				$jumlah = $this->laporan->getListTotalLaporanKonsultan($array['search']);
				$i = ($array['offset'] == 0 || $array['offset'] == null)?1:$array['offset']+1;
				header('Content-type: application/json');
				$dataJSON = array();
				$dataJSON['total'] = $jumlah;
				$dataJSON['rows'] = array();
				foreach($this->laporan->getListLaporanKonsultan($array) as $result){
					$data = array(
							'no' => $i,
							'tanggal' => $result->tgl,
							'aksi' => "<a href=\"".base_url('laporan/edit_laporan_konsultan/?cabangID='.$id.'&id='.$result->id_laporan_konsultan)."\" class=\"btn btn-xs btn-primary\">Edit</a> <a onclick=\"doHapus('$result->id_laporan_konsultan','$result->tgl')\" class=\"btn btn-xs btn-danger\">Hapus</a>"
						);
					array_push($dataJSON['rows'], $data);
					$i++;
				}
				echo json_encode($dataJSON);
			}
		}
		else{
			$this->error_404();
		}
	}

	/*
	DAFTAR LAPORAN Koordinator Pengajar
	*/

	public function daftar_laporan_koordinator()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->laporan->cekIdCabang($id)){
			$data = array(
					'title' => 'Daftar Laporan Koordinator',
					'cabangID' => $id
				);
			$this->_render('laporan/daftar_laporan_koordinator',$data);
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'laporan/daftar_laporan_koordinator/?cabangID='
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function add_laporan_koordinator()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->laporan->cekIdCabang($id)){
			$cabang = $this->laporan->getDataCabang();
			$data = array(
					'title' => 'Add Laporan Koordinator',
					'cabangID' => $id,
					'namaCabang' => $cabang['nama'],
					'pengajar' => $this->laporan->getPengajar($id)
				);
			$this->_render('laporan/add_laporan_koordinator',$data);
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'laporan/add_laporan_koordinator/?cabangID='
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function edit_laporan_koordinator()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->laporan->cekIdCabang($id)){
			$cabang = $this->laporan->getDataCabang();
			$data = array(
					'title' => 'Edit Laporan Koordinator',
					'cabangID' => $id,
					'namaCabang' => $cabang['nama'],
					'pengajar' => $this->laporan->getPengajar($id),
					'laporan' => $this->laporan->getLaporanKoordinator($id),
				);
			$this->_render('laporan/edit_laporan_koordinator',$data);
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'laporan/add_laporan_koordinator/?cabangID='
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function delete_laporan_koordinator()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}
		$id2 = $this->input->get('id',true);

		if($this->laporan->cekIdCabang($id)){
			if($this->laporan->deleteLaporanKoordinator($id2)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Laporan Koordinator berhasil dihapus');
				redirect(base_url('laporan/daftar_laporan_koordinator/?cabangID='.$id));
			}
			else{
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Laporan Koordinator gagal dihapus');
				redirect(base_url('laporan/daftar_laporan_koordinator/?cabangID='.$id));
			}
		}
		else{
			$this->error_404();
		}
	}

	public function action_add_laporan_koordinator()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->laporan->cekIdCabang($id)){
			$data = array(
					'id_laporan_koordinator' => '',
					'id_cabang' => $id,
					'id_pengajar' => $this->input->post('pengajar',true),
					'tanggal' => $this->input->post('tanggal',true),
					'jml_kelas' => $this->input->post('jml_kelas',true),
					'jml_sesi' => $this->input->post('jml_sesi',true),
					'sesi_tpa' => $this->input->post('sesi_tpa',true),
					'sesi_tbi' => $this->input->post('sesi_tbi',true),
					'siswa_total' => $this->input->post('total',true),
					'siswa_masuk' => $this->input->post('masuk',true),
					'catatan' => $this->input->post('catatan',true),
				);
			if($this->laporan->insertLaporanKoordinator($data)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Laporan Koordinator berhasil ditambahkan');
				redirect(base_url('laporan/daftar_laporan_koordinator/?cabangID='.$id));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Laporan Koordinator gagal ditambahkan');
				redirect(base_url('laporan/add_laporan_koordinator/?cabangID='.$id));
			}
		}
		else{
			$this->error_404();
		}
	}

	public function action_edit_laporan_koordinator()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->laporan->cekIdCabang($id)){
			$data = array(
					'id_laporan_koordinator' => $this->input->post('id_laporan_koordinator',true),
					'id_pengajar' => $this->input->post('pengajar',true),
					'tanggal' => $this->input->post('tanggal',true),
					'jml_kelas' => $this->input->post('jml_kelas',true),
					'jml_sesi' => $this->input->post('jml_sesi',true),
					'sesi_tpa' => $this->input->post('sesi_tpa',true),
					'sesi_tbi' => $this->input->post('sesi_tbi',true),
					'siswa_total' => $this->input->post('total',true),
					'siswa_masuk' => $this->input->post('masuk',true),
					'catatan' => $this->input->post('catatan',true),
				);
			if($this->laporan->updateLaporanKoordinator($data)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Laporan Koordinator berhasil diubah');
				redirect(base_url('laporan/edit_laporan_koordinator/?cabangID='.$id.'&id='.$data['id_laporan_koordinator']));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Laporan Koordinator gagal diubah');
				redirect(base_url('laporan/edit_laporan_koordinator/?cabangID='.$id.'&id='.$data['id_laporan_koordinator']));
			}
		}
		else{
			$this->error_404();
		}
	}

	public function list_data_laporan_koordinator()
	{
		if($this->input->is_ajax_request()){
			$id = $this->input->get("cabangID",true);
			if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
				$id = $this->session->userdata("cabang_user");
			}

			if($this->laporan->cekIdCabang($id)){
				$array = array(
					'limit' => (int) $this->input->get('limit', TRUE),
					'offset' => (int) $this->input->get('offset', TRUE),
					'search' => $this->input->get('search', TRUE)
					);
				$jumlah = $this->laporan->getListTotalLaporanKoordinator($array['search']);
				$i = ($array['offset'] == 0 || $array['offset'] == null)?1:$array['offset']+1;
				header('Content-type: application/json');
				$dataJSON = array();
				$dataJSON['total'] = $jumlah;
				$dataJSON['rows'] = array();
				foreach($this->laporan->getListLaporanKoordinator($array) as $result){
					$data = array(
							'no' => $i,
							'nama_pengajar' => $result->pengajar,
							'tanggal' => $result->tgl,
							'aksi' => "<a href=\"".base_url('laporan/edit_laporan_koordinator/?cabangID='.$id.'&id='.$result->id_laporan_koordinator)."\" class=\"btn btn-xs btn-primary\">Edit</a> <a onclick=\"doHapus('$result->id_laporan_koordinator','$result->pengajar - $result->tgl')\" class=\"btn btn-xs btn-danger\">Hapus</a>"
						);
					array_push($dataJSON['rows'], $data);
					$i++;
				}
				echo json_encode($dataJSON);
			}
		}
		else{
			$this->error_404();
		}
	}

}