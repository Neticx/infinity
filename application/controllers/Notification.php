<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Notification_model','notif',true);
	}

	public function index()
	{
		$data = array(
				'title' => 'Notification List',
			);
		$this->_render('notification/notification',$data);
	}

	public function read()
	{
		$id = $this->input->get('notif',true);
		if($this->notif->cekIdNotif($id)){
			$data = $this->notif->getDataNotif();
			$this->notif->updateStatus($id);
			redirect(base_url($data['url']), 'refresh');
		}
		else{
			$this->error_404();
		}
	}

	public function get_notif()
	{
		if($this->input->is_ajax_request()){
			$user = $this->session->userdata('id_user');
			$access = $this->session->userdata('access_user');
			$notifications = $this->notif->notifUnread($user, $access);
			$total = count($notifications);
			$hasil = '';

			if(!empty($notifications)){
				foreach($notifications as $row){
					$hasil .= '<li>';
					$hasil .= '<a href="'.base_url('notification/read/?notif='.$row['id_notifikasi']).'">';
					$hasil .= '<span>';
					$hasil .= '<span><strong>'.$row['judul'].'</strong></span>';
					$hasil .= '</span>';
					$hasil .= '<span class="message">'.$row['pesan'].'</span>';
					$hasil .= '</a>';
					$hasil .= '</li>';
				}
			}

			$hasil .= '<li>';
			$hasil .= '<div class="text-center">';
			$hasil .= '<a href="'.base_url('notification').'">';
			$hasil .= '<strong>See All Notification</strong>';
			$hasil .= '<i class="fa fa-angle-right"></i>';
			$hasil .= '</a>';
			$hasil .= '</div>';
			$hasil .= '</li>';
			echo json_encode(array('total' => $total, 'data' => $hasil));
		}
		else{
			$this->error404();
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
			$user = $this->session->userdata('id_user');
			$access = $this->session->userdata('access_user');

			$jumlah = $this->notif->getListTotal($user, $access, $array['search']);
			$i = ($array['offset'] == 0 || $array['offset'] == null)?1:$array['offset']+1;
			header('Content-type: application/json');
			$dataJSON = array();
			$dataJSON['total'] = $jumlah;
			$dataJSON['rows'] = array();
			foreach($this->notif->getList($user, $access, $array) as $result){
				$color = ($result->status == '0')?'green':'#000000';
				$data = array(
						'notif' => '<a href="'.base_url('notification/read/?notif='.$result->id_notifikasi).'" style="color: '.$color.'"><strong>'.$result->judul.'</strong><br /><span>'.$result->pesan.'</span></a>',
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