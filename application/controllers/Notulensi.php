<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notulensi extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Notulensi_model','notulen',true);
	}

	public function index()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->notulen->cekIdCabang($id)){
			$cabang = $this->notulen->getDataCabang();
			$data = array(
					'title' => 'Notula Rapat ' . $cabang['nama'],
					'cabang' => $cabang,
				);
			$this->_render('notulen/index.php',$data);
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'notulensi/?cabangID='
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

		if($this->notulen->cekIdCabang($id)){
			$cabang = $this->notulen->getDataCabang();
			$data = array(
					'title' => 'Add Data Notulensi',
					'cabang' => $cabang,
				);
			$this->_render('notulen/add_notulensi', $data);
		}
		else{
			$this->error_404();
		}
	}

	public function edit()
	{
		$id = $this->input->get("cabangID",true);
		$id2 = $this->input->get("noteID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->notulen->cekIdCabang($id) && $this->notulen->cekIdNote($id2)){
			$cabang = $this->notulen->getDataCabang();
			$notulen = $this->notulen->getDataNote();
			$data = array(
					'title' => 'Edit Data Notulensi',
					'cabang' => $cabang,
					'notulen' => $notulen,
				);
			$this->_render('notulen/edit_notulensi',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function delete()
	{
		$id = $this->input->get("cabangID",true);
		$id2 = $this->input->get("noteID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->notulen->cekIdCabang($id) && $this->notulen->cekIdNote($id2)){
			if($this->notulen->deleteNotulensi($id2)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', '<strong>SUCCESS. </strong> Data notulensi berhasil di hapus');
				redirect(base_url('notulensi/?cabangID='.$id),'refresh');
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', '<strong>ERROR. </strong> Data notulensi gagal di hapus');
				redirect(base_url('notulensi/?cabangID='.$id),'refresh');
			}
		}
		else{
			$this->error_404();
		}
	}

	public function detail()
	{
		$id = $this->input->get("cabangID",true);
		$id2 = $this->input->get("noteID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->notulen->cekIdCabang($id) && $this->notulen->cekIdNote($id2)){
			$cabang = $this->notulen->getDataCabang();
			$notulen = $this->notulen->getDataNote();

			$data = array(
					'title' => 'Detail Notulensi Rapat',
					'cabang' => $cabang,
					'notulensi' => $notulen,
				);
			$this->_render('notulen/detail',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function action_add()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->notulen->cekIdCabang($id)){
			$data = array(
					'id_notula' => '',
					'id_cabang' => $id,
					'id_user_notulen' => $this->session->userdata('id_user'),
					'tanggal_input' => date('Y-m-d H:i:s'),
					'agenda' => $this->input->post('agenda',true),
					'tanggal' => date('Y-m-d', strtotime($this->input->post('tanggal',true))),
					'tempat' => $this->input->post('tempat',true),
					'isi_rapat' => $this->input->post('isi',false),
				);
			if($this->notulen->insertNotulensi($data)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', '<strong>SUCCESS. </strong> Data notulensi berhasil di tambahkan');
				redirect(base_url('notulensi/?cabangID='.$id),'refresh');
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', '<strong>ERROR. </strong> Data notulensi gagal di tambahkan');
				redirect(base_url('notulensi/add/?cabangID='.$id),'refresh');
			}
		}
		else{
			$this->error_404();
		}
	}

	public function action_edit()
	{
		$id = $this->input->get("cabangID",true);
		$id2 = $this->input->get("noteID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->notulen->cekIdCabang($id) && $this->notulen->cekIdNote($id2)){
			$data = array(
						'id_notula' => $id2,
						'agenda' => $this->input->post('agenda',true),
						'tanggal' => date('Y-m-d', strtotime($this->input->post('tanggal',true))),
						'tempat' => $this->input->post('tempat',true),
						'isi_rapat' => $this->input->post('isi',false),
					);
			if($this->notulen->updateNotulensi($data)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', '<strong>SUCCESS. </strong> Data notulensi berhasil di ubah');
				redirect(base_url('notulensi/edit/?cabangID='.$id.'&noteID='.$data['id_notula']),'refresh');
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', '<strong>ERROR. </strong> Data notulensi gagal di ubah');
				redirect(base_url('notulensi/edit/?cabangID='.$id.'&noteID='.$data['id_notula']),'refresh');
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
			$jumlah = $this->notulen->getListTotal($id, $array['search']);
			$i = ($array['offset'] == 0 || $array['offset'] == null)?1:$array['offset']+1;
			header('Content-type: application/json');
			$dataJSON = array();
			$dataJSON['total'] = $jumlah;
			$dataJSON['rows'] = array();
			foreach($this->notulen->getList($id, $array) as $result){
				$data = array(
						'no' => $i,
						'agenda' => $result->agenda,
						'tanggal' => $result->tgl,
						'tempat' => $result->tempat,
						'aksi' => "<a href=\"".base_url('notulensi/detail/?cabangID='.$result->id_cabang.'&noteID='.$result->id)."\" class=\"btn btn-xs btn-success\">Detail</a> <a href=\"".base_url('notulensi/edit/?cabangID='.$result->id_cabang.'&noteID='.$result->id)."\" class=\"btn btn-xs btn-primary\">Edit</a> <a onclick=\"doHapus($result->id,'$result->agenda')\" class=\"btn btn-xs btn-danger\">Hapus</a>"
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