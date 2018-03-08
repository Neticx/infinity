<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rollover_kas extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Rollover_model','rollover',true);
		$this->load->helper('formatting_helper');
	}

	public function index()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->rollover->cekIdCabang($id)){
			$cabang = $this->rollover->getDataCabang();
			$data = array(
					'title' => 'Form Rollover Kas Kecil ' . $cabang['nama'],
					'cabangID' => $id,
				);
			$this->_render('rollover/rollover_kas',$data);
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'rollover_kas/?cabangID=',
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function action_add()
	{
		$id = $this->input->get("cabangID",true);
		if($this->rollover->cekIdCabang($id)){
			$data = array(
					'id_rollover' => '',
					'id_cabang' => $id,
					'id_user' => $this->session->userdata('id_user'),
					'nominal' => $this->input->post('nominal',true),
					'tanggal' => date('Y-m-d H:i:s'),
				);
			if($this->rollover->insertRollover($data)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Berhasil Menambahkan Rollover Kas Kecil');
				redirect(base_url('rollover_kas/?cabangID=' . $id));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Gagal Menambahkan Rollover Kas Kecil');
				redirect(base_url('rollover_kas/?cabangID=' . $id));
			}
		}
		else{
			$this->error_404();
		}
	}

	public function delete()
	{
		$id = $this->input->get("cabangID",true);
		if($this->rollover->cekIdCabang($id)){
			$id2 = $this->input->get("rolloverID",true);
			if($this->rollover->deleteRollover($id2)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Berhasil Menghapus Rollover Kas Kecil');
				redirect(base_url('rollover_kas/?cabangID=' . $id));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Gagal Menghapus Rollover Kas Kecil');
				redirect(base_url('rollover_kas/?cabangID=' . $id));
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
			$array = array(
				'limit' => (int) $this->input->get('limit', TRUE),
				'offset' => (int) $this->input->get('offset', TRUE),
				'search' => $this->input->get('search', TRUE)
				);
			$jumlah = $this->rollover->getListTotal($id, $array['search']);
			$i = ($array['offset'] == 0 || $array['offset'] == null)?1:$array['offset']+1;
			header('Content-type: application/json');
			$dataJSON = array();
			$dataJSON['total'] = $jumlah;
			$dataJSON['rows'] = array();
			foreach($this->rollover->getList($id, $array) as $result){
				$data = array(
						'no' => $i,
						'tanggal' => $result->tgl,
						'nominal' => formatRP($result->nominal),
						'aksi' => "<a href=\"".base_url('cetak/rollover_kas/?cabangID='.$result->id_cabang.'&rolloverID='.$result->id_rollover)."\" target=\"_blank\" class=\"btn btn-xs btn-success\">Cetak</a> <a onclick=\"doHapus($result->id_rollover,'$result->tgl')\" class=\"btn btn-xs btn-danger\">Hapus</a>"
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