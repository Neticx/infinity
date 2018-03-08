<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cetak_model extends CI_Model {

	private $dataCabang;
	private $dataSiswa;

	public function __construct()
	{
		parent::__construct();
	}

	public function cekIdSiswa($id)
	{
		$query = $this->db->select('siswa.*, kecsis.name as kecsis, kabsis.name as kabsis, provsis.name as provsis, kecwali.name as kecwali, kabwali.name as kabwali, provwali.name as provwali, nama_program, harga, pendaftaran')
							->join('kecamatan as kecsis','siswa.id_kec_siswa = kecsis.id_kecamatan','left')
							->join('kabupaten as kabsis','kecsis.id_kabupaten = kabsis.id_kabupaten','left')
							->join('provinsi as provsis','kabsis.id_provinsi = provsis.id_provinsi','left')
							->join('kecamatan as kecwali','siswa.id_kec_siswa = kecwali.id_kecamatan','left')
							->join('kabupaten as kabwali','kecwali.id_kabupaten = kabwali.id_kabupaten','left')
							->join('provinsi as provwali','kabwali.id_provinsi = provwali.id_provinsi','left')
							->join('program','siswa.id_program = program.id_program','left')
							->where('nis',$id)
							->limit(1)
							->get('siswa');
		if($query->num_rows() == 1){
			$this->dataSiswa = $query->row_array();
			return true;
		}
		else{
			return false;
		}
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

	public function getDataSiswa()
	{
		return $this->dataSiswa;
	}

	public function getDataCabang()
	{
		return $this->dataCabang;
	}

}