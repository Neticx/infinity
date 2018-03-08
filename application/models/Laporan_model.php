<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Laporan_model extends CI_Model {

	private $dataCabang = array();

	public function __construct()
	{
		parent::__construct();
	}

	public function cekIdCabang($id)
	{
		$query = $this->db->select('cabang.*, kecamatan.name as nama_kec, kabupaten.name as nama_kab, provinsi.name as nama_prov')
							->join('kecamatan','cabang.id_kecamatan = kecamatan.id_kecamatan','left')
							->join('kabupaten','kecamatan.id_kabupaten = kabupaten.id_kabupaten','left')
							->join('provinsi','kabupaten.id_provinsi = provinsi.id_provinsi','left')
							->where('id_Cabang',$id)
							->limit(1)
							->get('cabang');
		if($query->num_rows() == 1){
			$this->dataCabang = $query->row_array();
			return true;
		}
		else{
			return false;
		}
	}

	public function getDataCabang()
	{
		return $this->dataCabang;
	}

	public function getPengajar($id)
	{
		return $this->db->select('id_pengajar, nama, bidang')
							->where('id_cabang',$id)
							->order_by('nama','ASC')
							->get('pengajar')
							->result_array();
	}

	public function getLaporanKonsultan($id)
	{
		return $this->db->select('*')
							->where('id_laporan_konsultan',true)
							->get('laporan_konsultan')
							->row_array();
	}

	public function insertLaporanKonsultan($data = array())
	{
		$this->db->insert('laporan_konsultan', $data);

		if($this->db->affected_rows() == 1){
			return true;
		}
		else{
			return false;
		}
	}

	public function updateLaporanKonsultan($data = array())
	{
		$this->db->where('id_laporan_konsultan',$data['id_laporan_konsultan'])->update('laporan_konsultan', $data);

		if($this->db->affected_rows() == 1){
			return true;
		}
		else{
			return false;
		}
	}

	public function deleteLaporanKonsultan($id)
	{
		$this->db->where('id_laporan_konsultan',$id)->delete('laporan_konsultan');

		if($this->db->affected_rows() == 1){
			return true;
		}
		else{
			return false;
		}
	}

	public function getListTotalLaporanKonsultan($search)
	{
		if($search != null){
			$query = $this->db->select('COUNT(id_laporan_konsultan) as jumlah')
							->like('tanggal', $search)
							->get('laporan_konsultan')->row_array();
		}
		else{
			$query = $this->db->select('COUNT(id_laporan_konsultan) as jumlah')
							->get('laporan_konsultan')->row_array();
		}
		return $query['jumlah'];
	}

	public function getListLaporanKonsultan($array = array())
	{
		if($array['search'] != null){
			$query = $this->db->select('id_laporan_konsultan, DATE_FORMAT(tanggal, "%a, %e %b %Y") as tgl')
							->like('tanggal', $array['search'])
							->order_by('tanggal','DESC')
							->get('laporan_konsultan');
		}
		else{
			$query = $this->db->select('id_laporan_konsultan, DATE_FORMAT(tanggal, "%a, %e %b %Y") as tgl')
							->limit($array['limit'], $array['offset'])
							->order_by('tanggal','DESC')
							->get('laporan_konsultan');
		}
		return $query->result();
	}

	public function getLaporanKoordinator($id)
	{
		return $this->db->select('*')
							->where('id_laporan_koordinator',true)
							->get('laporan_koordinator')
							->row_array();
	}

	public function insertLaporanKoordinator($data = array())
	{
		$this->db->insert('laporan_koordinator', $data);

		if($this->db->affected_rows() == 1){
			return true;
		}
		else{
			return false;
		}
	}

	public function updateLaporanKoordinator($data = array())
	{
		$this->db->where('id_laporan_koordinator',$data['id_laporan_koordinator'])->update('laporan_koordinator', $data);

		if($this->db->affected_rows() == 1){
			return true;
		}
		else{
			return false;
		}
	}

	public function deleteLaporanKoordinator($id)
	{
		$this->db->where('id_laporan_koordinator',$id)->delete('laporan_koordinator');

		if($this->db->affected_rows() == 1){
			return true;
		}
		else{
			return false;
		}
	}

	public function getListTotalLaporanKoordinator($search)
	{
		if($search != null){
			$query = $this->db->select('COUNT(id_laporan_koordinator) as jumlah')
							->like('tanggal', $search)
							->get('laporan_koordinator')->row_array();
		}
		else{
			$query = $this->db->select('COUNT(id_laporan_koordinator) as jumlah')
							->get('laporan_koordinator')->row_array();
		}
		return $query['jumlah'];
	}

	public function getListLaporanKoordinator($array = array())
	{
		if($array['search'] != null){
			$query = $this->db->select('id_laporan_koordinator, pengajar.nama as pengajar, DATE_FORMAT(tanggal, "%a, %e %b %Y") as tgl')
							->join('pengajar','laporan_koordinator.id_pengajar = pengajar.id_pengajar','left')
							->like('tanggal', $array['search'])
							->or_like('nama', $array['search'])
							->order_by('tanggal','DESC')
							->get('laporan_koordinator');
		}
		else{
			$query = $this->db->select('id_laporan_koordinator, pengajar.nama as pengajar, DATE_FORMAT(tanggal, "%a, %e %b %Y") as tgl')
							->join('pengajar','laporan_koordinator.id_pengajar = pengajar.id_pengajar','left')
							->limit($array['limit'], $array['offset'])
							->order_by('tanggal','DESC')
							->get('laporan_koordinator');
		}
		return $query->result();
	}

}