<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ChatApp_model extends CI_Model {

	public function getListUser($id)
	{
		return $this->db->select('chat_app.id_user_app, nama, SUBSTR(text,1,20) as pesan, DATE_FORMAT(time, "%a-%e-%b-%Y, %h:%i:%s %p") as waktu, tipe')
							->join('user_app','chat_app.id_user_app = user_app.id_user_app','left')
							->where('id_user',$id)
							->order_by('id_chat','DESC')
							->group_by('id_user_app')
							->get('chat_app')
							->result_array();
	}

	public function getNamaUser($id)
	{
		$query = $this->db->select('nama')
							->where('id_user_app',$id)
							->get('user_app')
							->row_array();
		return $query['nama'];
	}

	public function getChats($id, $id2)
	{
		return $this->db->select('id_chat, DATE_FORMAT(time, "%c/%e/%Y, %h:%i:%s %p") as waktu, text, jenis, status')
							->where('id_user',$id)
							->where('id_user_app',$id2)
							->order_by('id_chat','ASC')
							->get('chat_app')
							->result_array();
	}

	public function getChat($id, $id2)
	{
		return $this->db->select('id_chat, DATE_FORMAT(time, "%c/%e/%Y, %h:%i:%s %p") as waktu, text, status')
							->where('id_user',$id)
							->where('id_user_app',$id2)
							->where('status','0')
							->where('jenis','1')
							->order_by('id_chat','ASC')
							->get('chat_app')
							->result_array();
	}

	public function sendMessage($data = array())
	{
		$this->db->insert('chat_app',$data);

		if($this->db->affected_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}

	public function updateStatusBatch($data = array())
	{
		$this->db->update_batch('chat_app', $data, 'id_chat');
	}

}