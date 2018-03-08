<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nilai extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Nilai_model','nilai',true);
	}

	public function index()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->nilai->cekIdCabang($id)){
			$cabang = $this->nilai->getDataCabang();
			$bidang = $this->input->get('bidang',true);
		    $kelas = $this->input->get('kelasID',true);
		    $jenis = base64_decode($this->input->get('jenis',true));

			if(($bidang == 'tpa' || $bidang == 'tbi') && $this->nilai->cekIdKelas($kelas)){
			    $data = array(
			    		'title' => 'Daftar Nilai Siswa ' . $cabang['nama'],
			    		'cabangID' => $id,
						'bidang' => $bidang,
						'kelasID' => $kelas,
						'jenis' => $jenis,
			    		'listNilai' => $this->nilai->getDaftarNilai($id, $bidang, $kelas, $jenis),
			    	);
			    $this->_render('nilai/lihat_nilai',$data);
			}
			else{
				$data = array(
						'title' => 'Menu Nilai ' . $cabang['nama'],
						'cabangID' => $id,
						'kelas' => $this->nilai->getKelas($id),
					);
				$this->_render('nilai/menu_nilai',$data);
			}
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'nilai/?cabangID=',
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function input_nilai()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->nilai->cekIdCabang($id)){
			$bidang = $this->input->get('bidang',true);
			$kelas = $this->input->get('kelasID',true);

			$data = array(
						'title' => 'Input Nilai Siswa',
						'cabangID' => $id,
						'bidang' => $bidang,
						'kelasID' => $kelas,
						'daftarSiswa' => $this->nilai->getDaftarSiswa($kelas),
					);
			$this->_render('nilai/nilai',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function action_add()
	{
		$id = $this->input->post('id_cabang',true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->nilai->cekIdCabang($id)){
			$data = array();
			$nis = $this->input->post('nis',true);
			$nilai = $this->input->post('nilai',true);
			$bidang = $this->input->post('bidang',true);
			$kelas = $this->input->post('kelas',true);
			$jenis = $this->input->post('jenis',true);
			$jumlah = count($nis);
			for($i = 0; $i < $jumlah; $i++){
				array_push($data, array(
						'id_nilai' => '',
						'id_cabang' => $id,
						'bidang' => $bidang,
						'id_kelas' => $kelas,
						'jenis' => $jenis,
						'nis' => $nis[$i],
						'nilai' => $nilai[$i],
						'tanggal' => date('Y-m-d H:i:s'),
					));

			}
			if($this->nilai->insertNilai($data)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Berhasil menambahkan data nilai');
				redirect(base_url('nilai/?cabangID='.$id.'&bidang='.$bidang.'&kelasID='.$kelas.'&jenis='.base64_encode($jenis)));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Gagal menambahkan data nilai');
				redirect(base_url('nilai/?cabangID='.$id.'&bidang='.$bidang.'&kelasID='.$kelas.'&jenis='.base64_encode($jenis)));
			}
		}
		else{
			$this->error_404();
		}
	}

	public function action_update()
	{
		$id = $this->input->post('id_cabang',true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->nilai->cekIdCabang($id)){
			$bidang = $this->input->post('bidang',true);
			$kelas = $this->input->post('kelas',true);
			$jenis = $this->input->post('jenis',true);

			$id_nilai = $this->input->post('id_nilai',true);
			$nilai = $this->input->post('nilai',true);
			$jumlah = count($id_nilai);
			$data = array();

			for($i = 0; $i < $jumlah; $i++){
				array_push($data, array(
						'id_nilai' => $id_nilai[$i],
						'jenis' => $jenis,
						'nilai' => $nilai[$i],
					));
			}

			if($this->nilai->updateNilai($data)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Berhasil mengubah data nilai');
				redirect(base_url('nilai/?cabangID='.$id.'&bidang='.$bidang.'&kelasID='.$kelas.'&jenis='.base64_encode($jenis)));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Gagal mengubah data nilai');
				redirect(base_url('nilai/?cabangID='.$id.'&bidang='.$bidang.'&kelasID='.$kelas.'&jenis='.base64_encode($jenis)));
			}
		}
		else{
			$this->error_404();
		}
	}

	public function action_delete()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->nilai->cekIdCabang($id)){
			$bidang = $this->input->get('bidang',true);
		    $kelas = $this->input->get('kelasID',true);
		    $jenis = base64_decode($this->input->get('jenis',true));

			if(($bidang == 'tpa' || $bidang == 'tbi') && $this->nilai->cekIdKelas($kelas)){
				if($this->nilai->deleteNilai($id, $bidang, $kelas, $jenis)){
					$this->session->set_flashdata('alert_type', 'success');
					$this->session->set_flashdata('alert_data', 'Berhasil menghapus data nilai');
					redirect(base_url('nilai/?cabangID='.$id));
				}
				else{
					$this->session->set_flashdata('alert_type', 'danger');
					$this->session->set_flashdata('alert_data', 'Gagal menghapus data nilai');
					redirect(base_url('nilai/?cabangID='.$id.'&bidang='.$bidang.'&kelasID='.$kelas.'&jenis='.base64_encode($jenis)));
				}
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Gagal menghapus data nilai');
				redirect(base_url('nilai/?cabangID='.$id.'&bidang='.$bidang.'&kelasID='.$kelas.'&jenis='.base64_encode($jenis)));
			}
		}
		else{
			$this->error_404();
		}
	}

	public function jenis_ujian()
	{
		if($this->input->is_ajax_request()){
			$id = $this->input->get("cabangID",true);
			if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
				$id = $this->session->userdata("cabang_user");
			}

			$bidang = $this->input->get('bidang',true);
			$kelas = $this->input->get('kelasID',true);
			$jenis = $this->nilai->getJenisUjian($id, $kelas, $bidang);
			if(!empty($jenis)){
				echo '<option value="">--- Pilih Jenis Ujian ---</option>';
				foreach($jenis as $row){
				echo '<option value="'.base64_encode($row['jenis']).'">'.$row['jenis'].'</option>';
				}
			}
			else{
				echo '<option value="">--- Pilih Jenis Ujian ---</option>';
			}
		}
		else{
			$this->error_404();
		}
	}

}