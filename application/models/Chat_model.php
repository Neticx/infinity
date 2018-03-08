<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Chat_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function getListUser()
	{
		return $this->db->select('id_user, user.nama, divisi, access.nama as otoritas')
							->join('access','user.id_access = access.id_access','left')
							->where('id_user !=',$this->session->userdata('id_user'))
							->order_by('user.nama','ASC')
							->get('user')
							->result_array();
	}

	public function getNamaUser($id)
	{
		$query = $this->db->select('nama')
							->where('id_user',$id)
							->get('user')
							->row_array();
		return $query['nama'];
	}

	public function searchUser($keyword)
	{
		return $this->db->select('id_user, user.nama, divisi, access.nama as otoritas')
							->join('access','user.id_access = access.id_access','left')
							->where('id_user !=',$this->session->userdata('id_user'))
							->like('user.nama',$keyword)
							->order_by('user.nama','ASC')
							->get('user')
							->result_array();
	}

	public function getChat($user, $stranger)
	{
		return $this->db->select('id_chat, id_user, id_user_tujuan, DATE_FORMAT(time, "%c/%e/%Y, %h:%i:%s %p") as waktu, text, status')
							->where('id_user',$user)
							->where('id_user_tujuan',$stranger)
							->or_where('id_user',$stranger)
							->where('id_user_tujuan',$user)
							->order_by('id_chat','ASC')
							->get('chat')
							->result_array();
	}

	public function getMessage($user, $stranger)
	{
		return $this->db->select('id_chat, id_user, id_user_tujuan, DATE_FORMAT(time, "%c/%e/%Y, %h:%i:%s %p") as waktu, text, status')
							->where('id_user',$stranger)
							->where('id_user_tujuan',$user)
							->where('status','0')
							->order_by('id_chat','ASC')
							->get('chat')
							->result_array();
	}

	public function sendMessage($data = array())
	{
		$this->db->insert('chat',$data);
	}

	public function updateStatusBatch($data = array())
	{
		$this->db->update_batch('chat', $data, 'id_chat');
	}
}