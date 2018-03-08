<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notification_model extends CI_Model {

	private $dataNotifikasi = array();

	public function __construct()
	{
		parent::__construct();
	}

	public function cekIdNotif($id)
	{
		$query = $this->db->select('*')
							->where('id_notifikasi',$id)
							->limit(1)
							->get('notifikasi');
		if($query->num_rows() == 1){
			$this->dataNotifikasi = $query->row_array();
			return true;
		}
		else{
			return false;
		}
	}

	public function getDataNotif()
	{
		return $this->dataNotifikasi;
	}

	public function notifUnread($user, $access)
	{
		return $this->db->select('id_notifikasi, judul, pesan, status')
								->where('status','0')
								->group_start()
								->where('id_user',$user)
								->or_where('id_access',$access)
								->group_end()
								->get('notifikasi')
								->result_array();
	}

	public function getListTotal($user, $access, $search)
	{
		if($search != null){
			$query = $this->db->select('COUNT(id_notifikasi) as jumlah')
							->group_start()
							->where('id_user',$user)
							->or_where('id_access',$access)
							->like('judul', $search)
							->group_end()
							->get('notifikasi')->row_array();
		}
		else{
			$query = $this->db->select('COUNT(id_notifikasi) as jumlah')
							->group_start()
							->where('id_user',$user)
							->or_where('id_access',$access)
							->group_end()
							->get('notifikasi')->row_array();
		}
		return $query['jumlah'];
	}

	public function getList($user, $access, $array = array())
	{
		if($array['search'] != null){
			$query = $this->db->select('id_notifikasi, judul, pesan, status')
							->group_start()
							->where('id_user',$user)
							->or_where('id_access',$access)
							->group_end()
							->like('judul', $array['search'])
							->order_by('tanggal','DESC')
							->get('notifikasi');
		}
		else{
			$query = $this->db->select('id_notifikasi, judul, pesan, status')
							->group_start()
							->where('id_user',$user)
							->or_where('id_access',$access)
							->group_end()
							->limit($array['limit'], $array['offset'])
							->order_by('tanggal','DESC')
							->get('notifikasi');
		}
		return $query->result();
	}

	public function updateStatus($id)
	{
		$data = array(
				'status' => '1'
			);
		$this->db->where('id_notifikasi',$id)->update('notifikasi', $data);
	}

}