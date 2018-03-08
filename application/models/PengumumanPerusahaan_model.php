<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class PengumumanPerusahaan_model extends CI_Model {

	private $lastID;
	private $dataPengumuman;

	public function __construct()
	{
		parent::__construct();
		
	}

	public function getLastID()
	{
		return $this->lastID;
	}

	public function cekIdPengumuman($id)
	{
		$query = $this->db->select('*')
								->where('id_pengumuman',$id)
								->limit(1)
								->get('pengumuman_perusahaan');
		if($query->num_rows() == 1){
			$this->dataPengumuman = $query->row_array();
			return true;
		}
		else{
			return false;
		}
	}

	public function getDataPengumuman()
	{
		return $this->dataPengumuman;
	}

	public function getListUserTujuan($id)
	{
		return $this->db->select('user.id_user, user.nama')
							->join('user','tujuan_pengumuman_perusahaan.id_user = user.id_user','left')
							->where('id_pengumuman',$id)
							->get('tujuan_pengumuman_perusahaan')
							->result_array();
	}

	public function getListTotal($search)
	{
		if($search != null){
			$query = $this->db->select('COUNT(id_pengumuman) as jumlah')
							->like('judul', $search)
							->get('pengumuman_perusahaan')->row_array();
		}
		else{
			$query = $this->db->select('COUNT(id_pengumuman) as jumlah')
							->get('pengumuman_perusahaan')->row_array();
		}
		return $query['jumlah'];
	}

	public function getList($array = array())
	{
		if($array['search'] != null){
			$query = $this->db->select('id_pengumuman, judul, DATE_FORMAT(tanggal, "%a, %e %b %Y") as tgl')
							->like('judul', $array['search'])
							->limit($array['limit'], $array['offset'])
							->order_by('tanggal','DESC')
							->get('pengumuman_perusahaan');
		}
		else{
			$query = $this->db->select('id_pengumuman, judul, DATE_FORMAT(tanggal, "%a, %e %b %Y") as tgl')
							->limit($array['limit'], $array['offset'])
							->order_by('tanggal','DESC')
							->get('pengumuman_perusahaan');
		}
		return $query->result();
	}

	public function insertPengumuman($data = array(), $tujuan = array())
	{
		$this->db->insert('pengumuman_perusahaan', $data);

		if($this->db->affected_rows() == 1){
			$this->lastID = $this->db->insert_id();

			if(!empty($tujuan)){
				$dataTujuan = array();
				foreach($tujuan as $tuj){
					$dataTujuan[] = array(
							'id_pengumuman' => $this->lastID,
							'id_user' => $tuj,
						);
				}
				$this->db->insert_batch('tujuan_pengumuman_perusahaan', $dataTujuan);
			}
			return true;
		}
		else{
			return false;
		}
	}

	public function updatePengumuman($data = array(), $tujuan = array())
	{
		$this->db->where('id_pengumuman',$data['id_pengumuman'])->update('pengumuman_perusahaan', $data);

		if($this->db->affected_rows() == 1){
			if(!empty($tujuan)){
				$dataTujuan = array();
				foreach($tujuan as $tuj){
					$dataTujuan[] = array(
							'id_pengumuman' => $data['id_pengumuman'],
							'id_user' => $tuj,
						);
				}

				$this->db->where('id_pengumuman',$data['id_pengumuman'])->delete('tujuan_pengumuman_perusahaan');

				if($this->db->affected_rows() > 0){
					$this->db->insert_batch('tujuan_pengumuman_perusahaan', $dataTujuan);
				}
			}
			return true;
		}
		else{
			if(!empty($tujuan)){
				$dataTujuan = array();
				foreach($tujuan as $tuj){
					$dataTujuan[] = array(
							'id_pengumuman' => $data['id_pengumuman'],
							'id_user' => $tuj,
						);
				}

				$this->db->where('id_pengumuman',$data['id_pengumuman'])->delete('tujuan_pengumuman_perusahaan');
				$this->db->insert_batch('tujuan_pengumuman_perusahaan', $dataTujuan);
				return true;
			}
			else{
				return false;
			}
		}
	}

	public function deletePengumuman($id)
	{
		$this->db->where('id_pengumuman',$id)->delete('pengumuman_perusahaan');

		if($this->db->affected_rows() == 1){
			return true;
		}
		else{
			return false;
		}
	}

}