<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Siswa_model extends CI_Model {

	private $dataSiswa;
	private $dataCabang;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Log_model','logData',true);
	}

	public function cekIdSiswa($id)
	{
		$query = $this->db->select('siswa.*')
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

	public function getPembayaranKhusus($nis, $cabang)
	{
		return $this->db->select('id_req_pembayaran, disetujui, cicilan1, cicilan2, cicilan3, cicilan4')
							->where('nis',$nis)
							->where('id_cabang',$cabang)
							->limit(1)
							->get('req_pembayaran_khusus')
							->row_array();
	}

	public function getProgram()
	{
		$query = $this->db->select('*')
							->get('program');
		return $query->result_array();
	}

	public function getThisProgram($id)
	{
		$query = $this->db->select('*')
							->where('id_program',$id)
							->get('program');
		return $query->row_array();
	}

	public function getLastID($year)
	{
		return $this->db->select('no_pendaftaran')
								->where('tahun',$year)
								->order_by('no_pendaftaran','DESC')
								->limit(1)
								->get('siswa');
	}

	public function getListTotal($id, $search)
	{
		if($search != null){
			$query = $this->db->select('COUNT(nis) as jumlah')
							->where('id_cabang',$id)
							->group_start()
							->like('nis', $search)
							->or_like('nama', $search)
							->group_end()
							->get('siswa')->row_array();
		}
		else{
			$query = $this->db->select('COUNT(nis) as jumlah')
							->where('id_cabang',$id)
							->get('siswa')->row_array();
		}
		return $query['jumlah'];
	}

	public function getList($id, $array = array())
	{
		if($array['search'] != null){
			$query = $this->db->select('nis, nama, id_cabang, virtual_account')
							->where('id_cabang',$id)
							->group_start()
							->like('nis', $array['search'])
							->or_like('nama', $array['search'])
							->group_end()
							->limit($array['limit'], $array['offset'])
							->order_by('nis','DESC')
							->get('siswa');
		}
		else{
			$query = $this->db->select('nis, nama, id_cabang, virtual_account')
							->where('id_cabang',$id)
							->limit($array['limit'], $array['offset'])
							->order_by('nis','DESC')
							->get('siswa');
		}
		return $query->result();
	}

	public function getProvinsi()
	{
		return $this->db->select('id_provinsi, name')
							->order_by('id_provinsi','ASC')
							->get('provinsi')
							->result_array();
	}

	public function getKabupaten($id)
	{
		return $this->db->select('id_kabupaten, name')
							->where('id_provinsi',$id)
							->order_by('id_kabupaten','ASC')
							->get('kabupaten')
							->result_array();
	}

	public function getKecamatan($id)
	{
		return $this->db->select('id_kecamatan, name')
							->where('id_kabupaten',$id)
							->order_by('id_kecamatan','ASC')
							->get('kecamatan')
							->result_array();
	}

	public function getProvKabKec($id)
	{
		return $this->db->select('kecamatan.id_kecamatan, kabupaten.id_kabupaten, provinsi.id_provinsi')
							->join('kabupaten','kecamatan.id_kabupaten = kabupaten.id_kabupaten','left')
							->join('provinsi','kabupaten.id_provinsi = provinsi.id_provinsi','left')
							->where('id_kecamatan',$id)
							->limit(1)
							->get('kecamatan')
							->row_array();
	}

	public function insertSiswa($data, $diskon = 0)
	{
		$program = $this->getThisProgram($data['id_program']);
		$this->db->insert('siswa', $data);

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','insert',$this->db->last_query());
			$data2 = array(
					'id_pembayaran' => '',
					'nis_siswa' => $data['nis'],
					'biaya_program' => $program['harga'],
					'biaya_pendaftaran' => $program['pendaftaran'],
					'diskon' => $diskon,
					'total' => $program['pendaftaran'] + ($program['harga'] - (($diskon/100) * $program['harga']))
				);
			$this->db->insert('siswa_pembayaran',$data2);
			$this->logData->insertLogData('success','insert',$this->db->last_query());
			return true;
		}
		else{
			$this->logData->insertLogData('error','insert',$this->db->last_query());
			return false;
		}
	}

	public function importSiswa($data)
	{
		$this->db->insert_batch('siswa', $data);
		if($this->db->affected_rows() > 1){
			$this->logData->insertLogData('success','insert',$this->db->last_query());
			return true;
		}
		else{
			$this->logData->insertLogData('error','insert',$this->db->last_query());
			return false;
		}
	}

	public function updateSiswa($nis, $data = array())
	{
		$program = $this->getThisProgram($data['id_program']);
		$siswa_pembayaran = $this->db->select('id_pembayaran')->where('nis_siswa',$nis)->limit(1)->get('siswa_pembayaran')->row_array();
		$query = $this->db->select('*')->where('nis',$nis)->limit(1)->get('siswa')->row_array();
		$this->db->where('nis',$nis)->update('siswa', $data);

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','update',$this->db->last_query());
			$data2 = array(
					'biaya_program' => $program['harga'],
					'biaya_pendaftaran' => $program['pendaftaran'],
				);
			$this->db->where('id_pembayaran',$siswa_pembayaran['id_pembayaran'])->update('siswa_pembayaran', $data2);
			$this->logData->tmpLogData('siswa', json_encode($query));
			return true;
		}
		else{
			$this->logData->insertLogData('error','update',$this->db->last_query());
			return false;
		}
	}

	public function deleteSiswa($id)
	{
		$query = $this->db->select('*')->where('nis',$id)->limit(1)->get('siswa')->row_array();
		$this->db->where('nis',$id)->delete('siswa');

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','delete',$this->db->last_query());
			$this->logData->tmpLogData('siswa', json_encode($query));
			return true;
		}
		else{
			$this->logData->insertLogData('error','delete',$this->db->last_query());
			return false;
		}
	}

}