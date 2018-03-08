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
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->bimbel->cekIdCabang($id)){
			$cabang = $this->bimbel->getDataCabang();
			$data = array(
					'title' => 'Data Kelas Cabang ' . $cabang['nama'],
					'cabangID' => $id,
					'kelas' => $this->bimbel->getKelas($id),
				);
			$this->_render('bimbel/kelas',$data);
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'bimbel/kelas/?cabangID=',
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function action_add_kelas()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->bimbel->cekIdCabang($id)){
			$kelas = $this->input->post('kelas',true);
			$data = array(
					'id_kelas' => '',
					'id_cabang' => $id,
					'nama_kelas' => $kelas,
					'tanggal' => date('Y-m-d H:i:s'),
				);
			if($this->bimbel->insertKelas($data)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Berhasil menambahkan data kelas');
				redirect(base_url('bimbel/kelas/?cabangID='.$id));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Gagal menambahkan data kelas');
				redirect(base_url('bimbel/kelas/?cabangID='.$id));
			}
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', 'Data cabang tidak ada! Pastikan anda telah memilih cabang sebelumnya');
			redirect(base_url('bimbel/kelas'));
		}
	}

	public function action_edit_kelas()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->bimbel->cekIdCabang($id)){
			$id_kelas = $this->input->post('id_kelas',true);
			$kelas = $this->input->post('kelas',true);
			$data = array(
					'id_kelas' => $id_kelas,
					'nama_kelas' => $kelas,
				);
			if($this->bimbel->updateKelas($data)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Berhasil mengubah data kelas');
				redirect(base_url('bimbel/kelas/?cabangID='.$id));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Gagal mengubah data kelas');
				redirect(base_url('bimbel/kelas/?cabangID='.$id));
			}
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', 'Data cabang tidak ada! Pastikan anda telah memilih cabang sebelumnya');
			redirect(base_url('bimbel/kelas'));
		}
	}

	public function action_delete_kelas()
	{
		$id = $this->input->get("cabangID",true);
		$id2 = $this->input->get("kelasID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->bimbel->cekIdCabang($id)){
			if($this->bimbel->deleteKelas($id, $id2)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Berhasil menghapus data kelas');
				redirect(base_url('bimbel/kelas/?cabangID='.$id));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Gagal menghapus data kelas');
				redirect(base_url('bimbel/kelas/?cabangID='.$id));
			}
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', 'Data cabang tidak ada! Pastikan anda telah memilih cabang sebelumnya');
			redirect(base_url('bimbel/kelas'));
		}
	}

	public function ruang()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->bimbel->cekIdCabang($id)){
			$cabang = $this->bimbel->getDataCabang();
			$data = array(
					'title' => 'Data Ruang Cabang ' . $cabang['nama'],
					'cabangID' => $id,
					'ruang' => $this->bimbel->getRuang($id),
				);
			$this->_render('bimbel/ruang',$data);
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'bimbel/ruang/?cabangID=',
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function action_add_ruang()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->bimbel->cekIdCabang($id)){
			$ruang = $this->input->post('ruang',true);
			$data = array(
					'id_ruang' => '',
					'id_cabang' => $id,
					'nama_ruang' => $ruang,
					'tanggal' => date('Y-m-d H:i:s'),
				);
			if($this->bimbel->insertRuang($data)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Berhasil menambahkan data ruang');
				redirect(base_url('bimbel/ruang/?cabangID='.$id));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Gagal menambahkan data ruang');
				redirect(base_url('bimbel/ruang/?cabangID='.$id));
			}
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', 'Data cabang tidak ada! Pastikan anda telah memilih cabang sebelumnya');
			redirect(base_url('bimbel/ruang'));
		}
	}

	public function action_edit_ruang()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->bimbel->cekIdCabang($id)){
			$id_ruang = $this->input->post('id_ruang',true);
			$ruang = $this->input->post('ruang',true);
			$data = array(
					'id_ruang' => $id_ruang,
					'nama_ruang' => $ruang,
				);
			if($this->bimbel->updateRuang($data)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Berhasil mengubah data ruang');
				redirect(base_url('bimbel/ruang/?cabangID='.$id));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Gagal mengubah data ruang');
				redirect(base_url('bimbel/ruang/?cabangID='.$id));
			}
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', 'Data cabang tidak ada! Pastikan anda telah memilih cabang sebelumnya');
			redirect(base_url('bimbel/ruang'));
		}
	}

	public function action_delete_ruang()
	{
		$id = $this->input->get("cabangID",true);
		$id2 = $this->input->get("ruangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->bimbel->cekIdCabang($id)){
			if($this->bimbel->deleteRuang($id, $id2)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Berhasil menghapus data ruang');
				redirect(base_url('bimbel/ruang/?cabangID='.$id));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Gagal menghapus data ruang');
				redirect(base_url('bimbel/ruang/?cabangID='.$id));
			}
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', 'Data cabang tidak ada! Pastikan anda telah memilih cabang sebelumnya');
			redirect(base_url('bimbel/ruang'));
		}
	}

	public function materi_pengajar()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->bimbel->cekIdCabang($id)){
			$cabang = $this->bimbel->getDataCabang();
			$id_kelas = $this->input->get("kelasID",true);

			if($this->bimbel->cekIdKelas($id_kelas)){
				$kelas = $this->bimbel->getDataKelas();
				$data = array(
						'title' => 'Daftar Materi Pengajar ' . $cabang['nama'] .' Kelas '.$kelas['nama_kelas'],
						'cabangID' => $id,
						'materi' => $this->bimbel->getMateri($id_kelas),
					);
				$this->_render('bimbel/materi',$data);
			}
			else{
				$data = array(
						'title' => 'Daftar Materi Pengajar ' . $cabang['nama'],
						'cabangID' => $id,
						'materi' => null,
					);
				$this->_render('bimbel/materi',$data);
			}
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'bimbel/materi_pengajar/?cabangID=',
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function siswa_kelas()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->bimbel->cekIdCabang($id)){
			$cabang = $this->bimbel->getDataCabang();
			$id_kelas = $this->input->get("kelasID",true);

			if($this->bimbel->cekIdKelas($id_kelas)){
				$kelas = $this->bimbel->getDataKelas();
				$data = array(
						'title' => 'Daftar Siswa ' . $cabang['nama'] .' Kelas '.$kelas['nama_kelas'],
						'cabangID' => $id,
						'kelasID' => $id_kelas,
					);

				if($this->bimbel->cekSiswaKelas($id_kelas)){
					$data['siswaKelas'] = $this->bimbel->getDataSiswaKelas();
				}
				else{
					$data['siswaKelas'] = array();
				}

				$this->_render('bimbel/siswa_kelas',$data);
			}
			else{
				$data = array(
						'title' => 'Daftar Siswa Kelas ' . $cabang['nama'],
						'cabangID' => $id,
						'kelas' => $this->bimbel->getKelas($id),
						'halaman' => 'bimbel/siswa_kelas/?cabangID='.$id.'&kelasID=',
					);
				$this->_render('bimbel/cari_kelas',$data);
			}
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'bimbel/siswa_kelas/?cabangID=',
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function action_add_siswa_kelas()
	{
		$id = $this->input->post('id_cabang',true);
		$id2 = $this->input->post('id_kelas',true);
		$nis = $this->input->post('nis',true);
		$data = array();

		if(!empty($nis)){
			foreach($nis as $row){
				array_push($data, array(
						'id_kelas' => $id2,
						'nis' => $row
					));
			}

			if($this->bimbel->cekSiswaKelas($id2)){
				if($this->bimbel->deleteAllSiswaKelas($id2)){
					if($this->bimbel->insertSiswaKelas($data)){
						$this->session->set_flashdata('alert_type', 'success');
						$this->session->set_flashdata('alert_data', 'Berhasil menambahkan data Siswa Kelas');
						redirect(base_url('bimbel/siswa_kelas/?cabangID='.$id.'&kelasID='.$id2));
					}
					else{
						$this->session->set_flashdata('alert_type', 'danger');
						$this->session->set_flashdata('alert_data', 'Gagal menambahkan data Siswa Kelas');
						redirect(base_url('bimbel/siswa_kelas/?cabangID='.$id.'&kelasID='.$id2));
					}
				}
				else{
					$this->session->set_flashdata('alert_type', 'danger');
					$this->session->set_flashdata('alert_data', 'Gagal menambahkan data Siswa Kelas');
					redirect(base_url('bimbel/siswa_kelas/?cabangID='.$id.'&kelasID='.$id2));
				}
			}
			else{
				if($this->bimbel->insertSiswaKelas($data)){
					$this->session->set_flashdata('alert_type', 'success');
					$this->session->set_flashdata('alert_data', 'Berhasil menambahkan data Siswa Kelas');
					redirect(base_url('bimbel/siswa_kelas/?cabangID='.$id.'&kelasID='.$id2));
				}
				else{
					$this->session->set_flashdata('alert_type', 'danger');
					$this->session->set_flashdata('alert_data', 'Gagal menambahkan data Siswa Kelas');
					redirect(base_url('bimbel/siswa_kelas/?cabangID='.$id.'&kelasID='.$id2));
				}
			}
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', 'Gagal melakukan aksi pastikan data Siswa Kelas tidak kosong');
			redirect(base_url('bimbel/siswa_kelas/?cabangID='.$id.'&kelasID='.$id2));
		}

	}

	public function sesi_jadwal()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->bimbel->cekIdCabang($id)){
			$cabang = $this->bimbel->getDataCabang();
			$data = array(
					'title' => 'Data Sesi Jadwal Cabang ' . $cabang['nama'],
					'cabangID' => $id,
					'sesi' => $this->bimbel->getSesi($id),
				);
			$this->_render('bimbel/sesi_jadwal',$data);
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'bimbel/sesi_jadwal/?cabangID=',
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}	
	}

	public function action_add_sesi()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->bimbel->cekIdCabang($id)){
			$data = array(
					'id_sesi_jadwal' => '',
					'id_cabang' => $id,
					'sesi' => $this->input->post('sesi',true),
					'mulai' => $this->input->post('mulai',true),
					'selesai' => $this->input->post('selesai',true),
				);
			if($this->bimbel->insertSesi($data)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Berhasil menambahkan sesi jadwal');
				redirect(base_url('bimbel/sesi_jadwal/?cabangID='.$id));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Gagal menambahkan sesi jadwal');
				redirect(base_url('bimbel/sesi_jadwal/?cabangID='.$id));
			}
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', 'Data cabang tidak ada! Pastikan anda telah memilih cabang sebelumnya');
			redirect(base_url('bimbel/sesi_jadwal'));
		}
	}

	public function action_edit_sesi()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->bimbel->cekIdCabang($id)){
			$data = array(
					'id_sesi_jadwal' => $this->input->post('id_sesi',true),
					'sesi' => $this->input->post('sesi',true),
					'mulai' => $this->input->post('mulai',true),
					'selesai' => $this->input->post('selesai',true),
				);
			if($this->bimbel->updateSesi($data)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Berhasil mengubah sesi jadwal');
				redirect(base_url('bimbel/sesi_jadwal/?cabangID='.$id));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Gagal mengubah sesi jadwal');
				redirect(base_url('bimbel/sesi_jadwal/?cabangID='.$id));
			}
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', 'Data cabang tidak ada! Pastikan anda telah memilih cabang sebelumnya');
			redirect(base_url('bimbel/sesi_jadwal'));
		}
	}

	public function action_delete_sesi()
	{
		$id = $this->input->get("cabangID",true);
		$id2 = $this->input->get("sesiID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->bimbel->cekIdCabang($id)){
			if($this->bimbel->deleteSesi($id, $id2)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Berhasil menghapus sesi jadwal');
				redirect(base_url('bimbel/sesi_jadwal/?cabangID='.$id));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Gagal menghapus sesi jadwal');
				redirect(base_url('bimbel/sesi_jadwal/?cabangID='.$id));
			}
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', 'Data cabang tidak ada! Pastikan anda telah memilih cabang sebelumnya');
			redirect(base_url('bimbel/sesi_jadwal'));
		}
	}

}