<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pembayaran_model extends CI_Model {

	private $dataCabang = array();
	private $lastID;

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

	public function getLastID()
	{
		return $this->lastID;
	}

	public function getLastNomorRefund($id, $bulan, $tahun)
	{
		return $this->db->select('nomor')
								->where('id_cabang',$id)
								->where('MONTH(tanggal)',$bulan)
								->where('YEAR(tanggal)',$tahun)
								->order_by('id_refund','DESC')
								->limit(1)
								->get('refund')
								->row_array();
	}

	public function getSiswaPembayaran($id)
	{
		return $this->db->select('*')
							->where('nis_siswa',$id)
							->limit(1)
							->get('siswa_pembayaran')
							->row_array();
	}

	public function getSiswaPembayaranCicilan($id)
	{
		return $this->db->select('*, DATE_FORMAT(tanggal, "%a, %e %b %Y") as tgl')
							->where('id_pembayaran',$id)
							->get('cicilan')
							->result_array();
	}

	public function getDataCabang()
	{
		return $this->dataCabang;
	}

	public function insertCicilanSiswa($data = array())
	{
		$this->db->insert('cicilan', $data);

		if($this->db->affected_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}

	public function insertRefund($data = array())
	{
		$this->db->insert('refund', $data);

		if($this->db->affected_rows() > 0){
			$this->lastID = $this->db->insert_id();
			return true;
		}
		else{
			return false;
		}
	}

}