<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class News extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('News_model','news',true);
	}

	public function index()
	{
		$data = array(
				'title' => 'List Berita',
			);
		$this->_render('news/news',$data);
	}

	public function add()
	{
		$data = array(
				'title' => 'Add Berita',
			);
		$this->_render('news/add_news',$data);
	}

	public function edit()
	{
		$id = $this->input->get('NewsID',true);
		if($this->news->cekIdNews($id)){
			$news = $this->news->getDataNews();
			$data = array(
					'title' => 'Edit Berita ' . $news['judul'],
					'news' => $news,
				);
			$this->_render('news/edit_news',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function action_add()
	{
		/*if($this->session->userdata('cabang_user') != null){
			$id = $this->session->userdata('cabang_user');
		}
		else{
			$id = $this->input->get('idCabang',true);
		}


		if($this->news->cekIdCabang($id)){*/
			$data = array(
					'id_berita' => '',
					'judul' => $this->input->post('judul',TRUE),
					'text' => $this->input->post('isi',TRUE),
					'foto' => NULL,
					'tanggal' => date('Y-m-d H:i:s'),
					'id_cabang' => NULL,
				);
			if(! empty($_FILES) && $_FILES['gambar']['name'] != null){
				$data['foto'] = "news-" . md5(time() . rand(0,100)) . "." . strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));

				$config['upload_path'] = './assets/img/news';
				$config['allowed_types'] = 'jpg|png|jpeg|svg';
				$config['max_size']     = '1536';
				$this->load->library('upload', $config);

				$config['file_name'] = $data['foto'];
				$this->upload->initialize($config);

				if($this->upload->do_upload('gambar')){
					$config['image_library'] = 'gd2';
					$config['source_image'] = './assets/img/news/'.$data['foto'];
					$config['maintain_ratio'] = TRUE;
					$config['quality'] = 70;
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();
				}
				else{
					$data['foto'] = NULL;
				}
			}

			if($this->news->insertNews($data)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Berita berhasil ditambahkan');
				redirect(base_url('news/index/' . $id));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Berita gagal ditambahkan');
				redirect(base_url('news/add/' . $id));
			}
		/*}
		else{
			$this->error_404();
		}*/
	}

	public function action_edit()
	{
		$id = $this->input->get('NewsID',true);
		if($this->news->cekIdNews($id)){
			$row = $this->news->getDataNews();

			$data = array(
					'id_berita' => $id,
					'judul' => $this->input->post('judul',TRUE),
					'text' => $this->input->post('isi',TRUE),
				);
			if(!empty($_FILES) && $_FILES['gambar']['name'] != null){
				$nama_file = "news-" . md5(time() . rand(0,100)) . "." . strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));

				$config['upload_path'] = './assets/img/news';
				$config['allowed_types'] = 'jpg|png|jpeg|svg';
				$config['max_size']     = '1536';
				$this->load->library('upload', $config);

				$config['file_name'] = $nama_file;
				$this->upload->initialize($config);

				if($this->upload->do_upload('gambar')){
					$config['image_library'] = 'gd2';
					$config['source_image'] = './assets/img/news/'.$nama_file;
					$config['maintain_ratio'] = TRUE;
					$config['quality'] = 70;
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();
				}

				if(!empty($row['foto'])){
					unlink(FCPATH . "/assets/img/news/".$row['foto']);
				}

				$data['foto'] = $nama_file;
			}

			if($this->news->updateNews($data)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Berita berhasil diubah');
				redirect(base_url('news/edit/?NewsID=' . $id));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Berita gagal diubah');
				redirect(base_url('news/edit/?NewsID=' . $id));
			}
		}
		else{
			$this->error_404();
		}
	}

	public function delete()
	{
		$id = $this->input->get('NewsID',true);

		if($this->news->cekIdNews($id)){
			$row = $this->news->getDataNews();

			if($this->news->deleteNews($id)){
				if(!empty($row['foto'])){
					unlink(FCPATH . "/assets/img/news/".$row['foto']);
				}

				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Berita berhasil dihapus');
				redirect(base_url('news'));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Berita berhasil dihapus');
				redirect(base_url('news'));
			}
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
			$jumlah = $this->news->getListTotal($array['search']);
			$i = ($array['offset'] == 0 || $array['offset'] == null)?1:$array['offset']+1;
			header('Content-type: application/json');
			$dataJSON = array();
			$dataJSON['total'] = $jumlah;
			$dataJSON['rows'] = array();
			foreach($this->news->getList($array) as $result){
				$data = array(
						'no' => $i,
						'judul' => $result->judul,
						'tanggal' => $result->tgl,
						'aksi' => "<a href=\"".base_url('news/edit/?NewsID='.$result->id_berita)."\" class=\"btn btn-xs btn-primary\">Edit</a> <a onclick=\"doHapus('$result->id_berita','$result->judul')\" class=\"btn btn-xs btn-danger\">Hapus</a>"
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