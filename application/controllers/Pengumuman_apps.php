<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengumuman_apps extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('PengumumanApps_model','pengumuman',true);
	}

	private function sendNotif($judul, $tanggal, $id)
	{
		$notif = array(
			"to" => "/topics/pengumuman",
			"notification" => array(
				"title" => $judul,
				"body" => $tanggal
			),
			"data" => array(
				"id" => $id
			)
	    );
	    $headers = array(
		    	'Content-Type:application/json',
		    	'Authorization: key=AAAAntGpfn8:APA91bG-fUoAuOuDbbfwo74c7eI-bu_6knxI9_U7lbK9lmogyjmeaAs9xzKcqN3pWtjm-ocpfpYPu09G8S43K4HgbUAd0Nk2NQIlOvjBKoFK_0S0BGKDNrpVh8ngUzvf-pCbKDOUhbgX'
		    );
	    $ch=curl_init();
	    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send' );
	    curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notif));
		$result = curl_exec($ch);
		curl_close($ch);
	}

	public function index()
	{
		$data = array(
				'title' => 'Pengumuman Apps',
			);
		$this->_render('pengumuman_apps/pengumuman_apps',$data);
	}

	public function add_pengumuman()
	{
		$data = array(
				'title' => 'Add Pengumuman Apps',
			);
		$this->_render('pengumuman_apps/add_pengumuman_apps',$data);
	}

	public function edit_pengumuman()
	{
		$id = $this->input->get('PengumumanID',true);
		if($this->pengumuman->cekIdPengumuman($id)){
			$pengumuman = $this->pengumuman->getDataPengumuman();
			$data = array(
					'title' => 'Edit Pengumuman Apps',
					'row' => $pengumuman
				);
			$this->_render('pengumuman_apps/edit_pengumuman_apps',$data);
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
				'foto' => NULL,
				'tanggal' => date('Y-m-d'),
				'create_date' => date('Y-m-d H:i:s'),
			);
		if(! empty($_FILES) && $_FILES['gambar']['name'] != null){
			$data['foto'] = "pengumuman-" . md5(time() . rand(0,100)) . "." . strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));

			$config['upload_path'] = './assets/img/pengumuman';
			$config['allowed_types'] = 'jpg|png|jpeg';
			$config['max_size']     = '1536';
			$this->load->library('upload', $config);

			$config['file_name'] = $data['foto'];
			$this->upload->initialize($config);

			if($this->upload->do_upload('gambar')){
				$config['image_library'] = 'gd2';
				$config['source_image'] = './assets/img/pengumuman/'.$data['foto'];
				$config['maintain_ratio'] = TRUE;
				$config['quality'] = 70;
				$this->load->library('image_lib', $config);
				$this->image_lib->resize();
			}
			else{
				$data['foto'] = NULL;
			}
		}

		if($this->pengumuman->insertPengumuman($data)){
			$this->sendNotif($data['judul'], date('d/m/Y'), $this->pengumuman->getLastID());
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_data', 'Pengumuman berhasil ditambahkan');
			redirect(base_url('pengumuman_apps'));
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', 'Pengumuman gagal ditambahkan');
			redirect(base_url('pengumuman_apps/add_pengumuman/'));
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
			if(!empty($_FILES) && $_FILES['gambar']['name'] != null){
				$nama_file = "pengumuman-" . md5(time() . rand(0,100)) . "." . strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));

				$config['upload_path'] = './assets/img/pengumuman';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['max_size']     = '1536';
				$this->load->library('upload', $config);

				$config['file_name'] = $nama_file;
				$this->upload->initialize($config);

				if($this->upload->do_upload('gambar')){
					$config['image_library'] = 'gd2';
					$config['source_image'] = './assets/img/pengumuman/'.$nama_file;
					$config['maintain_ratio'] = TRUE;
					$config['quality'] = 70;
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();
				}

				if(!empty($row['foto'])){
					unlink(FCPATH . "/assets/img/pengumuman/".$row['foto']);
				}

				$data['foto'] = $nama_file;
			}

			if($this->pengumuman->updatePengumuman($data)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Pengumuman berhasil diubah');
				redirect(base_url('pengumuman_apps/edit_pengumuman/?PengumumanID=' . $id));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Pengumuman gagal diubah');
				redirect(base_url('pengumuman_apps/edit_pengumuman/?PengumumanID=' . $id));
			}
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', 'Data Pengumuman tidak tepat');
			redirect(base_url('pengumuman_apps'));
		}
	}

	public function delete()
	{
		$id = $this->input->get('PengumumanID',true);
		if($this->pengumuman->cekIdPengumuman($id)){
			if($this->pengumuman->deletePengumuman($id)){
				$row = $this->pengumuman->getDataPengumuman();

				if(!empty($row['foto'])){
					unlink(FCPATH . "/assets/img/pengumuman/".$row['foto']);
				}
				
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Berhasil menghapus data pengumuman');
				redirect(base_url('pengumuman_apps'));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Gagal menghapus data pengumuman');
				redirect(base_url('pengumuman_apps'));
			}
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', 'Data Pengumuman tidak tepat');
			redirect(base_url('pengumuman_apps'));
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
						'aksi' => "<a href=\"".base_url('pengumuman_apps/edit_pengumuman/?PengumumanID='.$result->id_pengumuman)."\" class=\"btn btn-xs btn-primary\">Edit</a> <a onclick=\"doHapus('$result->id_pengumuman','$result->judul')\" class=\"btn btn-xs btn-danger\">Hapus</a>"
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