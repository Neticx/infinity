<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Search_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function searchKepalaCabang($keyword)
	{
		return $this->db->select('id_user, nama')
						->where('id_access',15)
						->like('nama',$keyword)
						->get('user')
						->result_array();
	}

	public function searchCabang($keyword)
	{
		return $this->db->select('id_cabang, nama')
							->like('nama',$keyword)
							->get('cabang')
							->result_array();
	}

	public function searchPegawai($keyword)
	{
		return $this->db->select('id_user, user.nama, cabang.nama as cabang')
							->join('cabang','user.id_cabang = cabang.id_cabang')
							->like('user.nama',$keyword)
							->get('user')
							->result_array();
	}

	public function searchSiswa($id, $keyword)
	{
		return $this->db->select('siswa.nama, siswa.nis, siswa.alamat, program.nama_program, kecamatan.name as nama_kec, kabupaten.name as nama_kab, provinsi.name as nama_prov')
							->join('program','siswa.id_program = program.id_program','left')
							->join('kecamatan','siswa.id_kec_siswa = kecamatan.id_kecamatan','left')
							->join('kabupaten','kecamatan.id_kabupaten = kabupaten.id_kabupaten','left')
							->join('provinsi','kabupaten.id_provinsi = provinsi.id_provinsi','left')
							->where('siswa.id_cabang',$id)
							->like('siswa.nama',$keyword)
							->or_like('siswa.nis',$keyword)
							->get('siswa')
							->result_array();
	}

	public function searchSiswaRefund($id, $keyword)
	{
		return $this->db->select('siswa.nama, siswa.nis, siswa.alamat, program.nama_program, kecamatan.name as nama_kec, kabupaten.name as nama_kab, provinsi.name as nama_prov, biaya_program, biaya_pendaftaran, diskon, total, (SELECT SUM(nominal) FROM cicilan WHERE cicilan.id_pembayaran = siswa_pembayaran.id_pembayaran) as sudah_bayar')
							->join('program','siswa.id_program = program.id_program','left')
							->join('kecamatan','siswa.id_kec_siswa = kecamatan.id_kecamatan','left')
							->join('kabupaten','kecamatan.id_kabupaten = kabupaten.id_kabupaten','left')
							->join('provinsi','kabupaten.id_provinsi = provinsi.id_provinsi','left')
							->join('siswa_pembayaran','siswa.nis = siswa_pembayaran.nis_siswa','left')
							->where('siswa.id_cabang',$id)
							->like('siswa.nama',$keyword)
							->or_like('siswa.nis',$keyword)
							->get('siswa')
							->result_array();
	}

}