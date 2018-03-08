<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat_app extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('ChatApp_model','chat',true);
	}

	public function index()
	{
		$data = array(
				'title' => 'Chat Apps',
				'users' => $this->chat->getListUser($this->session->userdata('id_user')),
			);
		$this->_render('chat_app/chat',$data);
	}

	public function get_chats()
	{
		if($this->input->is_ajax_request()){
			$user = $this->session->userdata('id_user');
			$stranger = $this->input->get('user',true);
			$chats = $this->chat->getChats($user, $stranger);
			$namaStranger = $this->chat->getNamaUser($stranger);
			$hasil = '';

			$update = array();

			foreach($chats as $chat){
				if($chat['jenis'] == '1' && $chat['status'] == '0'){
					array_push($update, array(
							'id_chat' => $chat['id_chat'],
							'status' => '1',
						));
				}

				if($chat['jenis'] == '2'){
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

	public function get_chat()
	{
		if($this->input->is_ajax_request()){
			$user = $this->session->userdata('id_user');
			$stranger = $this->input->get('user',true);
			$chats = $this->chat->getChat($user, $stranger);
			$namaStranger = $this->chat->getNamaUser($stranger);
			$hasil = '';

			$update = array();

			foreach($chats as $chat){
				if($chat['status'] == '0'){
					array_push($update, array(
							'id_chat' => $chat['id_chat'],
							'status' => '1',
						));
				}

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

	public function send_message()
	{
		if($this->input->is_ajax_request()){
			$user = $this->session->userdata('id_user');
			$stranger = $this->input->get('user',true);
			$pesan = $this->input->post('pesan',true);

			if(!empty($pesan)){
				$data = array(
						'id_chat' => '',
						'time' => date('Y-m-d H:i:s'),
						'id_user' => $user,
						'id_user_app' => $stranger,
						'text' => $pesan,
						'jenis' => '2',
						'status' => '0',
					);
				$this->chat->sendMessage($data);
			}
		}
		else{
			$this->error_404();
		}
	}

}