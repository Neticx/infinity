<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengumuman_perusahaan extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('PengumumanPerusahaan_model','pengumuman',true);
	}

	public function index()
	{
		$data = array(
				'title' => 'Pengumuman Perusahaan',
			);
		$this->_render('pengumuman_perusahaan/pengumuman_perusahaan',$data);
	}

	public function add_pengumuman_perusahaan()
	{
		$data = array(
				'title' => 'Add Pengumuman Perusahaan',
			);
		$this->_render('pengumuman_perusahaan/add_pengumuman_perusahaan',$data);
	}

	public function edit_pengumuman()
	{
		$id = $this->input->get('PengumumanID',true);
		if($this->pengumuman->cekIdPengumuman($id)){
			$pengumuman = $this->pengumuman->getDataPengumuman();
			$data = array(
					'title' => 'Edit Pengumuman Perusahaan',
					'row' => $pengumuman,
					'userTujuan' => $this->pengumuman->getListUserTujuan($id)
				);
			$this->_render('pengumuman_perusahaan/edit_pengumuman_perusahaan',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function action_add()
	{
		$data = array(
				'id_pengumuman' => '',
				'judul' => $this->input->post('judul',TRUE),
				'isi' => $this->input->post('isi',TRUE),
				'file_lampiran' => NULL,
				'tanggal' => date('Y-m-d'),
			);
		$tujuan = $this->input->post('tujuan',true);

		if(! empty($_FILES) && $_FILES['lampiran']['name'] != null){
			$data['file_lampiran'] = "lampiran-" . md5(time() . rand(0,100)) . "." . strtolower(pathinfo($_FILES['lampiran']['name'], PATHINFO_EXTENSION));

			$config['upload_path'] = './assets/data/lampiran';
			$config['allowed_types'] = 'jpg|png|jpeg|pdf|doc|docx|ppt|pptx|xls|xlsx';
			$config['max_size']     = '4096';
			$this->load->library('upload', $config);

			$config['file_name'] = $data['file_lampiran'];
			$this->upload->initialize($config);

			if(!$this->upload->do_upload('lampiran')){
				$data['file_lampiran'] = NULL;
			}
		}

		if($this->pengumuman->insertPengumuman($data, $tujuan)){
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_data', 'Pengumuman berhasil ditambahkan');
			redirect(base_url('pengumuman_perusahaan'));
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', 'Pengumuman gagal ditambahkan');
			redirect(base_url('pengumuman_perusahaan/add_pengumuman/'));
		}
	}

	public function action_edit()
	{
		$id = $this->input->get('PengumumanID',true);
		if($this->pengumuman->cekIdPengumuman($id)){
			$row = $this->pengumuman->getDataPengumuman();

			$data = array(
					'id_pengumuman' => $id,
					'judul' => $this->input->post('judul',TRUE),
					'isi' => $this->input->post('isi',TRUE),
				);
			$tujuan = $this->input->post('tujuan',true);

			if(!empty($_FILES) && $_FILES['lampiran']['name'] != null){
				$nama_file = "lampiran-" . md5(time() . rand(0,100)) . "." . strtolower(pathinfo($_FILES['lampiran']['name'], PATHINFO_EXTENSION));

				$config['upload_path'] = './assets/data/lampiran';
				$config['allowed_types'] = 'jpg|png|jpeg|pdf|doc|docx|ppt|pptx|xls|xlsx';
				$config['max_size']     = '4096';
				$this->load->library('upload', $config);

				$config['file_name'] = $nama_file;
				$this->upload->initialize($config);

				if($this->upload->do_upload('lampiran')){
					$data['file_lampiran'] = $nama_file;
					if(!empty($row['file_lampiran'])){
						unlink(FCPATH . "/assets/data/lampiran/".$row['file_lampiran']);
					}
				}
			}

			if($this->pengumuman->updatePengumuman($data, $tujuan)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Pengumuman berhasil diubah');
				redirect(base_url('pengumuman_perusahaan/edit_pengumuman/?PengumumanID=' . $id));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Pengumuman gagal diubah');
				redirect(base_url('pengumuman_perusahaan/edit_pengumuman/?PengumumanID=' . $id));
			}
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', 'Data Pengumuman tidak tepat');
			redirect(base_url('pengumuman_perusahaan'));
		}
	}

	public function delete()
	{
		$id = $this->input->get('PengumumanID',true);
		if($this->pengumuman->cekIdPengumuman($id)){
			if($this->pengumuman->deletePengumuman($id)){
				$row = $this->pengumuman->getDataPengumuman();

				if(!empty($row['file_lampiran'])){
					unlink(FCPATH . "/assets/data/lampiran/".$row['file_lampiran']);
				}
				
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Berhasil menghapus data pengumuman');
				redirect(base_url('pengumuman_perusahaan'));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Gagal menghapus data pengumuman');
				redirect(base_url('pengumuman_perusahaan'));
			}
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', 'Data Pengumuman tidak tepat');
			redirect(base_url('pengumuman_perusahaan'));
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
			$jumlah = $this->pengumuman->getListTotal($array['search']);
			$i = ($array['offset'] == 0 || $array['offset'] == null)?1:$array['offset']+1;
			header('Content-type: application/json');
			$dataJSON = array();
			$dataJSON['total'] = $jumlah;
			$dataJSON['rows'] = array();
			foreach($this->pengumuman->getList($array) as $result){
				$data = array(
						'no' => $i,
						'judul' => $result->judul,
						'tanggal' => $result->tgl,
						'aksi' => "<a href=\"".base_url('pengumuman_perusahaan/edit_pengumuman/?PengumumanID='.$result->id_pengumuman)."\" class=\"btn btn-xs btn-primary\">Edit</a> <a onclick=\"doHapus('$result->id_pengumuman','$result->judul')\" class=\"btn btn-xs btn-danger\">Hapus</a>"
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