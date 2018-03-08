<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jadwal extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Jadwal_model','jadwal',true);
	}

	public function index()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->jadwal->cekIdCabang($id)){
			$cabang = $this->jadwal->getDataCabang();
			$id_kelas = $this->input->get("kelasID",true);

			if($this->jadwal->cekIdKelas($id_kelas)){
				$kelas = $this->jadwal->getDataKelas();

				$jadwal = array();
				for($i = 1; $i <= 7; $i++){
					$jadwal[$i] = $this->jadwal->jadwalHari($i);
				}

				$data = array(
						'title' => 'Daftar Siswa ' . $cabang['nama'] .' Kelas '.$kelas['nama_kelas'],
						'cabangID' => $id,
						'kelasID' => $id_kelas,
						'ruangan' => $this->jadwal->getListRuang($id),
						'sesi' => $this->jadwal->getSesi($id),
						'jadwal' => $jadwal,
					);

				$this->_render('jadwal/jadwal',$data);
			}
			else{
				$data = array(
						'title' => 'Daftar Siswa Kelas ' . $cabang['nama'],
						'cabangID' => $id,
						'kelas' => $this->jadwal->getKelas($id),
						'halaman' => 'jadwal/?cabangID='.$id.'&kelasID=',
					);
				$this->_render('jadwal/cari_kelas',$data);
			}
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'jadwal/?cabangID=',
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function list_pengajar()
	{
		$bidang = $this->input->get('bidang',true);
		if($this->input->is_ajax_request()){
			$pengajar = $this->jadwal->getListPengajar($bidang);

			if(!empty($pengajar)){
				foreach($pengajar as $row){
					echo '<option value="'.$row['id_pengajar'].'">'.$row['nama'].'</option>';
				}
			}
		}
		else{
			$this->error_404();
		}
	}

	public function action_add()
	{
		$cabang = $this->input->post('id_cabang',true);
		$kelas = $this->input->post('id_kelas',true);

		if($this->jadwal->cekIdCabang($cabang) && $this->jadwal->cekIdKelas($kelas)){
			$data = array(
					'id_jadwal' => '',
					'id_cabang' => $cabang,
					'id_kelas' => $kelas,
					'id_pengajar' => $this->input->post('pengajar',true),
					'id_ruang' => $this->input->post('ruang',true),
					'hari' => $this->input->post('hari',true),
					'id_sesi_jadwal' => $this->input->post('sesi',true),
				);
			if($this->jadwal->insertJadwal($data)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Berhasil menambahkan data jadwal');
				redirect(base_url('jadwal/?cabangID='.$cabang.'&kelasID='.$kelas));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Gagal menambahkan data jadwal');
				redirect(base_url('jadwal/?cabangID='.$cabang.'&kelasID='.$kelas));
			}
		}
		else{
			$this->error_404();
		}
	}

	public function action_delete()
	{
		$cabang = $this->input->get('cabangID',true);
		$kelas = $this->input->get('kelasID',true);
		$jadwal = $this->input->get('jadwalID',true);


		if($this->jadwal->cekIdCabang($cabang) && $this->jadwal->cekIdJadwal($jadwal)){
			if($this->jadwal->deleteJadwal($cabang,$jadwal)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Berhasil menghapus data jadwal');
				redirect(base_url('jadwal/?cabangID='.$cabang.'&kelasID='.$kelas));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Gagal menghapus data jadwal');
				redirect(base_url('jadwal/?cabangID='.$cabang.'&kelasID='.$kelas));
			}
		}
		else{
			$this->error_404();
		}
	}

}