<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Chat_model','chat',true);
	}

	public function index()
	{
		$data = array(
				'title' => 'Chat',
				'users' => $this->chat->getListUser(),
			);
		$this->_render('chat/chat',$data);
	}

	public function get_message()
	{
		if($this->input->is_ajax_request()){
			$stranger = $this->input->get('stranger',true);
			$user = $this->session->userdata('id_user');
			$chats = $this->chat->getMessage($user, $stranger);
			$namaStranger = $this->chat->getNamaUser($stranger);
			$hasil = '';

			$update = array();

			foreach($chats as $chat){
				array_push($update, array(
						'id_chat' => $chat['id_chat'],
						'status' => '1',
					));
				$hasil .= '<li class="pull-left" style="margin-top: 5px; margin-left: 5px; width: 60%; background-color: #DFF0D8;">';
				$hasil .= '<span>';
				$hasil .= '<span class="profile_thumb">';
				$hasil .= '<i class="fa fa-user green"></i>';
				$hasil .= '</span>';
				$hasil .= '<span> '.$namaStranger.'</span>';
				$hasil .= '</span>';
				$hasil .= '<span class="pull-right">';
				$hasil .= '<span><i class="fa fa-clock-o"></i></span>';
				$hasil .= '<span class="time"> '.$chat['waktu'].'</span>';
				$hasil .= '</span><br />';
				$hasil .= '<span class="message">'.$chat['text'].'</span>';
				$hasil .= '</li>';
			}

			if(!empty($update)){
				$this->chat->updateStatusBatch($update);			
			}
			echo $hasil;
		}
		else{
			$this->error_404();
		}
	}

	public function get_chat()
	{
		if($this->input->is_ajax_request()){
			$stranger = $this->input->get('stranger',true);
			$user = $this->session->userdata('id_user');
			$chats = $this->chat->getChat($user, $stranger);
			$namaStranger = $this->chat->getNamaUser($stranger);
			$hasil = '';

			$update = array();

			foreach($chats as $chat){
				if($chat['id_user_tujuan'] == $user && $chat['status'] == '0'){
					array_push($update, array(
							'id_chat' => $chat['id_chat'],
							'status' => '1',
						));
				}

				if($chat['id_user'] == $user){
					$hasil .= '<li class="pull-right" style="margin-top: 5px; margin-right: 5px; width: 60%; background-color: #D9EDF7;">';
					$hasil .= '<span class="pull-left">';
					$hasil .= '<span><i class="fa fa-clock-o"></i></span>';
					$hasil .= '<span class="time"> '.$chat['waktu'].'</span>';
					$hasil .= '</span>';
					$hasil .= '<span class="pull-right">';
					$hasil .= '<span class="profile_thumb">';
					$hasil .= '<i class="fa fa-user blue"></i>';
					$hasil .= '</span>';
					$hasil .= '<span> You</span>';
					$hasil .= '</span><br />';
					$hasil .= '<span class="message">'.$chat['text'].'</span>';
					$hasil .= '</li>';
				}
				else{
					$hasil .= '<li class="pull-left" style="margin-top: 5px; margin-left: 5px; width: 60%; background-color: #DFF0D8;">';
					$hasil .= '<span>';
					$hasil .= '<span class="profile_thumb">';
					$hasil .= '<i class="fa fa-user green"></i>';
					$hasil .= '</span>';
					$hasil .= '<span> '.$namaStranger.'</span>';
					$hasil .= '</span>';
					$hasil .= '<span class="pull-right">';
					$hasil .= '<span><i class="fa fa-clock-o"></i></span>';
					$hasil .= '<span class="time"> '.$chat['waktu'].'</span>';
					$hasil .= '</span><br />';
					$hasil .= '<span class="message">'.$chat['text'].'</span>';
					$hasil .= '</li>';
				}
			}

			if(!empty($update)){
				$this->chat->updateStatusBatch($update);			
			}
			echo $hasil;
		}
		else{
			$this->error_404();
		}
	}

	public function send_message()
	{
		if($this->input->is_ajax_request()){
			$stranger = $this->input->get('stranger',true);
			$user = $this->session->userdata('id_user');
			$pesan = $this->input->post('pesan',true);

			if(!empty($pesan)){
				$data = array(
						'id_chat' => '',
						'time' => date('Y-m-d H:i:s'),
						'id_user' => $user,
						'id_user_tujuan' => $stranger,
						'text' => $pesan,
						'status' => '0',
					);
				$this->chat->sendMessage($data);
			}

		}
		else{
			$this->error_404();
		}
	}

	public function search_user()
	{
		$keyword = $this->input->get('keyword',true);
		if($this->input->is_ajax_request()){
			$users = $this->chat->searchUser($keyword);
			if(!empty($users)){
				$hasil = "";
				foreach($users as $user){
					$hasil .= '<li class="media event" style="cursor: pointer;" onclick="doChat('.$user['id_user'].')">';
					$hasil .= '<a class="pull-left border-green profile_thumb">';
					$hasil .= '<i class="fa fa-user green"></i>';
					$hasil .= '</a>';
					$hasil .= '<div class="media-body">';
					$hasil .= '<a class="title" href="#">'.$user['nama'].'</a>';
					$hasil .= '<p>'.$user['otoritas'].'<br />';
					$hasil .= '<small>'.$user['divisi'].'</small></p>';
					$hasil .= '</div>';
					$hasil .= '</li>';
				}
				echo $hasil;
			}
			else{
				echo '<li class="media event"><h3 style="text-align: center;">No Data Found</h3></li>';
			}
		}
		else{
			$this->error_404();
		}
	}

}