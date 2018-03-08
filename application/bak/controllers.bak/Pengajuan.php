<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengajuan extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Pengajuan_model','pengajuan',true);
	}

	/*
	PEMBAYARAN KHUSUS
	*/

	private function generateNomor($tipe)
	{
		switch($tipe){
			case 'pembayaran':
				$lastNomor = $this->pengajuan->getLastNomorPembayaranKhusus();
			break;

			case 'va':
				$lastNomor = $this->pengajuan->getLastNomorVirtualAccount();
			break;
		}

		if(empty($lastNomor)){
			return '0001';
		}
		else{
			return str_pad($lastNomor + 1, 4, 0, STR_PAD_LEFT);
		}
	}

	public function pembayaran_khusus()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->pengajuan->cekIdCabang($id)){
			$nis = $this->input->get('NIS',true);
			$cabang = $this->pengajuan->getDataCabang();
			if(empty($nis)){
				$data = array(
					'title' => 'Request Pembayaran Khusus',
					'cabangID' => $id,
					'cabang' => $cabang,
				);
				$this->_render("pengajuan/pembayaran_khusus",$data);
			}
			else{
				if($this->pengajuan->cekIdSiswa($nis)){
					$data = array(
						'title' => 'Request Pembayaran Khusus',
						'cabangID' => $id,
						'cabang' => $cabang,
						'nis' => $nis,
						'siswa' => $this->pengajuan->getDataSiswa(),
					);
					$this->_render("pengajuan/pembayaran_khusus2",$data);
				}
				else{
					$this->error_404();
				}
			}
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'pengajuan/pembayaran_khusus/?cabangID='
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function daftar_pembayaran_khusus()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->pengajuan->cekIdCabang($id)){
			$cabang = $this->pengajuan->getDataCabang();
			$data = array(
				'title' => 'Request Pembayaran Khusus',
				'cabang' => $cabang,
			);
			$this->_render("pengajuan/daftar_pembayaran_khusus",$data);
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'pengajuan/daftar_pembayaran_khusus/?cabangID='
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function add_pembayaran_khusus()
	{
		$id = $this->input->get("cabangID",true);
		$extra = (!empty($this->input->get("fromDetail",true)))?true:false;
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->pengajuan->cekIdCabang($id)){
			$data = array(
					'id_req_pembayaran' => '',
					'nomor' => $this->generateNomor('pembauaran'),
					'tanggal_input' => date('Y-m-d H:i:s'),
					'id_user_konsultan' => $this->session->userdata('id_user'),
					'id_cabang' => $id,
					'nis' => $this->input->post('nis',true),
					'cicilan1' => $this->input->post('cicilan1',true),
					'cicilan2' => $this->input->post('cicilan2',true),
					'cicilan3' => $this->input->post('cicilan3',true),
					'cicilan4' => $this->input->post('cicilan4',true),
					'id_user_man' => NULL,
					'disetujui' => '0',
				);
			if($this->pengajuan->cekPembayaranKhusus($data['nis'],$id)){
				if($this->pengajuan->insertPembayaranKhusus($data)){
					$this->session->set_flashdata('alert_type', 'success');
					$this->session->set_flashdata('alert_data', 'Berhasil mengajukan Permohonan Pembayaran Khusus');
					if($extra){
						redirect(base_url('siswa/detail/?cabangID='.$data['id_cabang'].'&NIS='.$data['nis']));
					}
					else{
						redirect(base_url('pengajuan/pembayaran_khusus/?cabangID='.$id));
					}
				}
				else{
					$this->session->set_flashdata('alert_type', 'danger');
					$this->session->set_flashdata('alert_data', 'Terjadi kesalahan dalam menginputkan data');
					if($extra){
						redirect(base_url('siswa/detail/?cabangID='.$data['id_cabang'].'&NIS='.$data['nis']));
					}
					else{
						redirect(base_url('pengajuan/pembayaran_khusus/?cabangID='.$id));
					}
				}
			}
			else{
				$this->session->set_flashdata('alert_type', 'warning');
				$this->session->set_flashdata('alert_data', 'Sudah melakukan pengajuan pembayaran khusus sebelumnya');
				if($extra){
					redirect(base_url('siswa/detail/?cabangID='.$data['id_cabang'].'&NIS='.$data['nis']));
				}
				else{
					redirect(base_url('pengajuan/pembayaran_khusus/?cabangID='.$id));
				}
			}
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', 'Terjadi kesalahan dalam membaca data Cabang');
			if($extra){
				redirect(base_url('siswa/detail/?cabangID='.$data['id_cabang'].'&NIS='.$data['nis']));
			}
			else{
				redirect(base_url('pengajuan/pembayaran_khusus'));
			}
		}
	}

	public function edit_pembayaran_khusus()
	{
		$id = $this->input->get("cabangID",true);
		$id2 = $this->input->get("reqID",true);
		$extra = (!empty($this->input->get("fromDetail",true)))?true:false;
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->pengajuan->cekIdCabang($id) && $this->pengajuan->cekIdPembayaranKhusus($id2)){
			$cabang = $this->pengajuan->getDataCabang();
			$pembayaran = $this->pengajuan->getDataPembayaranKhusus();
			$data = array(
						'title' => 'Edit Request Pembayaran Khusus',
						'cabangID' => $id,
						'cabang' => $cabang,
						'pembayaran' => $pembayaran,
						'extra' => $extra,
					);
			$this->_render("pengajuan/edit_pembayaran_khusus",$data);
		}
		else{
			$this->error_404();
		}
	}

	public function action_edit_pembayaran_khusus()
	{
		$id = $this->input->get("cabangID",true);
		$extra = (!empty($this->input->get("fromDetail",true)))?true:false;
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}
		if($this->pengajuan->cekIdCabang($id)){
			$data = array(
					'id_req_pembayaran' => $this->input->post('id_pembayaran',true),
					'nis' => $this->input->post('nis',true),
					'cicilan1' => $this->input->post('cicilan1',true),
					'cicilan2' => $this->input->post('cicilan2',true),
					'cicilan3' => $this->input->post('cicilan3',true),
					'cicilan4' => $this->input->post('cicilan4',true),
				);
			if($this->pengajuan->updatePembayaranKhusus($data)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Berhasil mengubah Permohonan Pembayaran Khusus');
				if($extra){
					redirect(base_url('siswa/detail/?cabangID='.$id.'&NIS='.$data['nis']));
				}
				else{
					redirect(base_url('pengajuan/edit_pembayaran_khusus/?cabangID='.$id.'&reqID='.$data['id_req_pembayaran']));
				}
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Gagal mengubah Permohonan Pembayaran Khusus');
				if($extra){
					redirect(base_url('pengajuan/edit_pembayaran_khusus/?cabangID='.$id.'&reqID='.$data['id_req_pembayaran'].'&fromDetail=yes'));
				}
				else{
					redirect(base_url('pengajuan/edit_pembayaran_khusus/?cabangID='.$id.'&reqID='.$data['id_req_pembayaran']));
				}
			}
		}
		else{
			$this->error_404();
		}
	}

	public function delete_pembayaran_khusus()
	{
		$id = $this->input->get("cabangID",true);
		$id2 = $this->input->get("reqID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->pengajuan->cekIdCabang($id)){
			if($this->pengajuan->deletePembayaranKhusus($id2)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Berhasil menghapus data pengajuan pembayaran khusus');
				redirect(base_url('pengajuan/daftar_pembayaran_khusus/?cabangID='.$id));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Gagal menghapus data pengajuan pembayaran khusus');
				redirect(base_url('pengajuan/daftar_pembayaran_khusus/?cabangID='.$id));
			}
		}
		else{
			$this->error_404();
		}
	}

	public function list_data_pembayaran_khusus()
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
			$jumlah = $this->pengajuan->getListPembayaranTotal($id, $array['search']);
			$i = ($array['offset'] == 0 || $array['offset'] == null)?1:$array['offset']+1;
			header('Content-type: application/json');
			$dataJSON = array();
			$dataJSON['total'] = $jumlah;
			$dataJSON['rows'] = array();
			foreach($this->pengajuan->getListPembayaran($id, $array) as $result){
				$data = array(
						'no' => $i,
						'nama' => $result->nama,
						'nis' => $result->nis,
						'tgl' => $result->tanggal,
						'status' => ($result->disetujui == '0')?'<span class="label label-danger">Belum Disetujui</span>':'<span class="label label-success">Disetujui</span>',
						'aksi' => "<a href=\"".base_url('cetak/request_pembayaran_khusus/?reqID='.$result->id)."\" target=\"_blank\" class=\"btn btn-xs btn-success\">Cetak</a> <a href=\"".base_url('pengajuan/edit_pembayaran_khusus/?cabangID='.$result->id_cabang.'&reqID='.$result->id)."\" class=\"btn btn-xs btn-primary\">Edit</a> <a onclick=\"doHapus($result->id,'$result->nama')\" class=\"btn btn-xs btn-danger\">Hapus</a>"
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

	/*
	VIRTUAL ACCOUNT
	*/
	public function daftar_virtual_account()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}
		if($this->pengajuan->cekIdCabang($id)){
			$cabang = $this->pengajuan->getDataCabang();
			$data = array(
				'title' => 'Request Virtual Account',
				'cabang' => $cabang,
			);
			$this->_render("pengajuan/daftar_virtual_account",$data);
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'pengajuan/daftar_virtual_account/?cabangID='
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function virtual_account()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}
		if($this->pengajuan->cekIdCabang($id)){
			$cabang = $this->pengajuan->getDataCabang();
			$data = array(
				'title' => 'Request Virtual Account',
				'cabang' => $cabang,
			);
			$this->_render("pengajuan/add_virtual_account",$data);
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'pengajuan/virtual_account/?cabangID='
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function add_va()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->pengajuan->cekIdCabang($id)){
			$data = array(
					'id_req_va' => '',
					'id_user_konsultan' => $this->session->userdata('id_user'),
					'id_cabang' => $id,
					'nomor' => $this->generateNomor('va'),
					'tahun' => date('Y'),
					'id_user_man' => NULL,
					'disetujui' => 0,
				);
			$data2 = array(
					'nis' => $this->input->post('nis',true),
					'va' => $this->input->post('va',true),
				);

			if($this->pengajuan->insertVirtualAccount($data, $data2)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Berhasil menghapus data pengajuan pembayaran khusus');
				redirect(base_url('pengajuan/virtual_account/?cabangID='.$id));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Gagal menghapus data pengajuan pembayaran khusus');
				redirect(base_url('pengajuan/virtual_account/?cabangID='.$id));
			}

		}
		else{}
	}

	public function edit_va()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->input->cekIdCabang()){}
		else{}
	}

	public function action_edit_va()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->input->cekIdCabang()){}
		else{}
	}

	public function list_data_va()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->input->cekIdCabang()){}
		else{}
	}

}