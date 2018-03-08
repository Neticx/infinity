<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Materi extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Materi_model','materi',true);
	}

	public function index()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->materi->cekIdCabang($id)){
			$cabang = $this->materi->getDataCabang();
			$bidang = $this->input->get("bidang",true);
			$program = $this->input->get("programID",true);

			if(($bidang == 'tpa' || $bidang == 'tbi') && $this->materi->cekIdProgram($program)){
				$programData = $this->materi->getDataProgram();
				$data = array(
						'title' => 'Daftar Materi Pengajar',
						'cabangID' => $id,
						'program' => $programData,
						'bidang' => $bidang,
						'programID' => $program
					);
				$this->_render('materi/materi',$data);
			}
			else{
				$data = array(
						'title' => 'Daftar Materi Pengajar ' . $cabang['nama'],
						'cabangID' => $id,
						'program' => $this->materi->getProgram(),
						'halaman' => 'materi/?cabangID='.$id.'&bidang=',
					);
				$this->_render('materi/materi_search',$data);
			}
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'materi/?cabangID=',
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function action_add()
	{
		$id = $this->input->post('id_cabang',true);
		$program = $this->input->post('id_program',true);
		$bidang = $this->input->post('bidang',true);

		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->materi->cekIdCabang($id) && ($bidang == 'tpa' || $bidang == 'tbi') && $this->materi->cekIdProgram($program)){
			$data = array(
					'id_materi_pengajar' => '',
					'id_cabang' => $id,
					'id_program' => $program,
					'bidang' => $bidang,
					'judul' => $this->input->post('judul',true),
					'silabus' => $this->input->post('isi',true),
				);
			if($this->materi->insertMateri($data)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Berhasil menambahkan data');
				redirect(base_url('materi/?cabangID='.$id.'&bidang='.$bidang.'&programID='.$program));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Gagal menambahkan data');
				redirect(base_url('materi/?cabangID='.$id.'&bidang='.$bidang.'&programID='.$program));
			}
		}
		else{
			$this->error_404();
		}
	}

	public function get_data()
	{
		if($this->input->is_ajax_request()){
			header('Content-type: application/json');
		    $id = $this->input->get('materiID',true);

		    if($this->materi->cekIdMateri($id)){
		    	$dataMateri = $this->materi->getDataMateri();
		    	echo json_encode(array('id_materi' => $dataMateri['id_materi_pengajar'],'judul' => $dataMateri['judul'], 'isi' => $dataMateri['silabus']));
		    }
		}
		else{
			$this->error_404();
		}
	}

	public function action_edit()
	{
		$id = $this->input->post('id_materi',true);
		if($this->materi->cekIdMateri($id)){
		    $dataMateri = $this->materi->getDataMateri();
			$data = array(
					'id_materi_pengajar' => $id,
					'judul' => $this->input->post('judul',true),
					'silabus' => $this->input->post('isi',true),
				);
		    if($this->materi->updateMateri($data)){
		    	$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Berhasil mengubah data materi');
				redirect(base_url('materi/?cabangID='.$dataMateri['id_cabang'].'&bidang='.$dataMateri['bidang'].'&programID='.$dataMateri['id_program']));
		    }
		    else{
		    	$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Gagal mengubah data materi');
				redirect(base_url('materi/?cabangID='.$dataMateri['id_cabang'].'&bidang='.$dataMateri['bidang'].'&programID='.$dataMateri['id_program']));
		    }
		}
		else{
			$this->error_404();
		}
	}

	public function delete()
	{
		$id = $this->input->get('materiID',true);
		if($this->materi->cekIdMateri($id)){
		    $dataMateri = $this->materi->getDataMateri();
		    if($this->materi->deleteMateri($id)){
		    	$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Berhasil menghapus data materi');
				redirect(base_url('materi/?cabangID='.$dataMateri['id_cabang'].'&bidang='.$dataMateri['bidang'].'&programID='.$dataMateri['id_program']));
		    }
		    else{
		    	$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Gagal menghapus data materi');
				redirect(base_url('materi/?cabangID='.$dataMateri['id_cabang'].'&bidang='.$dataMateri['bidang'].'&programID='.$dataMateri['id_program']));
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

			$bidang = $this->input->get("bidang",true);
			$program = $this->input->get("programID",true);

			$array = array(
				'limit' => (int) $this->input->get('limit', TRUE),
				'offset' => (int) $this->input->get('offset', TRUE),
				'search' => $this->input->get('search', TRUE)
				);
			$jumlah = $this->materi->getListTotal($array['search']);
			$i = ($array['offset'] == 0 || $array['offset'] == null)?1:$array['offset']+1;
			header('Content-type: application/json');
			$dataJSON = array();
			$dataJSON['total'] = $jumlah;
			$dataJSON['rows'] = array();
			foreach($this->materi->getList($array) as $result){
				$data = array(
						'no' => $i,
						'judul' => $result->judul,
						'aksi' => "<a onclick=\"lihatMateri('$result->id_materi_pengajar')\" class=\"btn btn-xs btn-success\">Lihat</a> <a onclick=\"editMateri('$result->id_materi_pengajar')\" class=\"btn btn-xs btn-primary\">Edit</a> <a onclick=\"doHapus('$result->id_materi_pengajar','$result->judul')\" class=\"btn btn-xs btn-danger\">Hapus</a>"
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