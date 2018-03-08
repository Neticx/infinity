<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pengajuan_model extends CI_Model {

	private $dataCabang;
	private $dataSiswa;
	private $dataPembayaran;
	private $dataVA;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Log_model','logData',true);
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

	public function cekIdSiswa($id)
	{
		$query = $this->db->select('siswa.nama, siswa.nis, siswa.alamat, program.nama_program, kecamatan.name as nama_kec, kabupaten.name as nama_kab, provinsi.name as nama_prov')
							->join('program','siswa.id_program = program.id_program','left')
							->join('kecamatan','siswa.id_kec_siswa = kecamatan.id_kecamatan','left')
							->join('kabupaten','kecamatan.id_kabupaten = kabupaten.id_kabupaten','left')
							->join('provinsi','kabupaten.id_provinsi = provinsi.id_provinsi','left')
							->where('siswa.nis',$id)
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

	public function cekIdPembayaranKhusus($id)
	{
		$query = $this->db->select('id_req_pembayaran, req_pembayaran_khusus.id_cabang, cicilan1, cicilan2, cicilan3, cicilan4, siswa.nama, siswa.nis, siswa.alamat, program.nama_program, kecamatan.name as nama_kec, kabupaten.name as nama_kab, provinsi.name as nama_prov')
							->join('siswa','req_pembayaran_khusus.nis = siswa.nis','left')
							->join('program','siswa.id_program = program.id_program','left')
							->join('kecamatan','siswa.id_kec_siswa = kecamatan.id_kecamatan','left')
							->join('kabupaten','kecamatan.id_kabupaten = kabupaten.id_kabupaten','left')
							->join('provinsi','kabupaten.id_provinsi = provinsi.id_provinsi','left')
							->where('id_req_pembayaran',$id)
							->limit(1)
							->get('req_pembayaran_khusus');
		if($query->num_rows() == 1){
			$this->dataPembayaran = $query->row_array();
			return true;
		}
		else{
			return false;
		}
	}

	public function cekIdVA($id)
	{
		$query = $this->db->select('*')
							->where('id_req_va',$id)
							->limit(1)
							->get('req_virtual_account');
		if($query->num_rows() == 1){
			$this->dataVA = $query->row_array();
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

	public function getDataSiswa()
	{
		return $this->dataSiswa;
	}

	public function getDataPembayaranKhusus()
	{
		return $this->dataPembayaran;
	}

	public function getDataVA()
	{
		return $this->dataVA;
	}

	public function cekPembayaranKhusus($nis,$cabang){
		$query = $this->db->select('id_req_pembayaran')
							->where('nis',$nis)
							->where('id_cabang',$cabang)
							->limit(1)
							->get('req_pembayaran_khusus');
		if($query->num_rows() == 0){
			return true;
		}
		else{
			return false;
		}
	}

	public function getSubVA($id)
	{
		return $this->db->select('sub_req_virtual_account.*, siswa.nama, program.nama_program')
						->join('siswa','sub_req_virtual_account.nis = siswa.nis','left')
						->join('program','siswa.id_program = program.id_program','left')
						->where('id_req_va',$id)
						->get('sub_req_virtual_account')
						->result_array();
	}

	public function getLastNomorPembayaranKhusus()
	{
		$query = $this->db->select('nomor')
							->order_by('id_req_pembayaran','DESC')
							->limit(1)
							->get('req_pembayaran_khusus')
							->row_array();
		return $query['nomor'];
	}

	public function getLastNomorVirtualAccount()
	{
		$query = $this->db->select('nomor')
							->order_by('id_req_va','DESC')
							->limit(1)
							->get('req_virtual_account')
							->row_array();
		return $query['nomor'];
	}

	public function getListPembayaranTotal($id, $search)
	{
		if($search != null){
			$query = $this->db->select('COUNT(id_req_pembayaran) as jumlah')
							->join('siswa','req_pembayaran_khusus.nis = siswa.nis','left')
							->where('req_pembayaran_khusus.id_cabang',$id)
							->group_start()
							->like('req_pembayaran_khusus.nis', $search)
							->or_like('siswa.nama', $search)
							->group_end()
							->get('req_pembayaran_khusus')->row_array();
		}
		else{
			$query = $this->db->select('COUNT(id_req_pembayaran) as jumlah')
							->join('siswa','req_pembayaran_khusus.nis = siswa.nis','left')
							->where('req_pembayaran_khusus.id_cabang',$id)
							->get('req_pembayaran_khusus')->row_array();
		}
		return $query['jumlah'];
	}

	public function getListPembayaran($id, $array = array())
	{
		if($array['search'] != null){
			$query = $this->db->select('id_req_pembayaran as id, req_pembayaran_khusus.id_cabang, DATE_FORMAT(req_pembayaran_khusus.tanggal_input, "%d %b %Y") as tanggal, siswa.nama, siswa.nis, disetujui')
							->join('siswa','req_pembayaran_khusus.nis = siswa.nis','left')
							->where('req_pembayaran_khusus.id_cabang',$id)
							->group_start()
							->like('req_pembayaran_khusus.nis', $array['search'])
							->or_like('siswa.nama', $array['search'])
							->group_end()
							->limit($array['limit'], $array['offset'])
							->order_by('req_pembayaran_khusus.tanggal_input','DESC')
							->get('req_pembayaran_khusus');
		}
		else{
			$query = $this->db->select('id_req_pembayaran as id, req_pembayaran_khusus.id_cabang, DATE_FORMAT(req_pembayaran_khusus.tanggal_input, "%d %b %Y") as tanggal, siswa.nama, siswa.nis, disetujui')
							->join('siswa','req_pembayaran_khusus.nis = siswa.nis','left')
							->where('req_pembayaran_khusus.id_cabang',$id)
							->limit($array['limit'], $array['offset'])
							->order_by('req_pembayaran_khusus.tanggal_input','DESC')
							->get('req_pembayaran_khusus');
		}
		return $query->result();
	}

	public function getListVATotal($id, $search)
	{
		if($search != null){
			$query = $this->db->select('COUNT(id_req_va) as jumlah')
							->where('id_cabang',$id)
							->like('nomor', $search)
							->get('req_virtual_account')->row_array();
		}
		else{
			$query = $this->db->select('COUNT(id_req_va) as jumlah')
							->get('req_virtual_account')->row_array();
		}
		return $query['jumlah'];
	}

	public function getListVA($id, $array = array())
	{
		if($array['search'] != null){
			$query = $this->db->select('id_req_va as id, id_cabang, DATE_FORMAT(tanggal_input, "%d %b %Y") as tanggal, nomor, tahun, disetujui')
							->where('id_cabang',$id)
							->like('nomor', $array['search'])
							->limit($array['limit'], $array['offset'])
							->order_by('tanggal_input','DESC')
							->get('req_virtual_account');
		}
		else{
			$query = $this->db->select('id_req_va as id, id_cabang, DATE_FORMAT(tanggal_input, "%d %b %Y") as tanggal, nomor, tahun, disetujui')
							->where('id_cabang',$id)
							->limit($array['limit'], $array['offset'])
							->order_by('tanggal_input','DESC')
							->get('req_virtual_account');
		}
		return $query->result();
	}

	public function insertPembayaranKhusus($data = array())
	{
		$this->db->insert('req_pembayaran_khusus', $data);

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','insert',$this->db->last_query());
			return true;
		}
		else{
			$this->logData->insertLogData('error','insert',$this->db->last_query());
			return false;
		}
	}

	public function insertVirtualAccount($data = array(), $data2 = array())
	{
		$this->db->insert('req_virtual_account', $data);
		$last_id = $this->db->insert_id();
		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','insert',$this->db->last_query());
			$jumlah = count($data2['nis']);

			$dt = array();
			for($i = 0; $i < $jumlah; $i++){
				$dt[] = array(
						'id_sub_req_va' => '',
						'id_req_va' => $last_id,
						'nis' => $data2['nis'][$i],
						'virtual_account' => $data2['va'][$i],
					);
			}

			$this->db->insert_batch('sub_req_virtual_account', $dt);
			$this->logData->insertLogData('success','insert',$this->db->last_query());
			return true;
		}
		else{
			$this->logData->insertLogData('error','insert',$this->db->last_query());
			return false;
		}
	}

	public function updatePembayaranKhusus($data = array())
	{
		$query = $this->db->select('*')->where('id_req_pembayaran',$data['id_req_pembayaran'])->limit(1)->get('req_pembayaran_khusus')->row_array();
		$this->db->where('id_req_pembayaran',$data['id_req_pembayaran'])->update('req_pembayaran_khusus', $data);

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','update',$this->db->last_query());
			$this->logData->tmpLogData('req_pembayaran_khusus', json_encode($query));
			return true;
		}
		else{
			$this->logData->insertLogData('error','update',$this->db->last_query());
			return false;
		}
	}

	public function updateSubVA($data = array())
	{
		$this->db->update_batch('sub_req_virtual_account', $data, 'id_sub_req_va');

		if($this->db->affected_rows() >= 0){
			$this->logData->insertLogData('success','update',$this->db->last_query());
			return true;
		}
		else{
			$this->logData->insertLogData('error','update',$this->db->last_query());
			return false;
		}
	}

	public function deletePembayaranKhusus($id)
	{
		$query = $this->db->select('*')->where('id_req_pembayaran',$id)->limit(1)->get('req_pembayaran_khusus')->row_array();
		$this->db->where('id_req_pembayaran',$id)->delete('req_pembayaran_khusus');

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','delete',$this->db->last_query());
			$this->logData->tmpLogData('req_pembayaran_khusus', json_encode($query));
			return true;
		}
		else{
			$this->logData->insertLogData('error','delete',$this->db->last_query());
			return false;
		}
	}

	public function deleteVA($id)
	{
		$query = $this->db->select('*')->where('id_req_va',$id)->limit(1)->get('req_virtual_account')->row_array();
		$this->db->where('id_req_va',$id)->delete('req_virtual_account');

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','delete',$this->db->last_query());
			$this->logData->tmpLogData('req_virtual_account', json_encode($query));
			return true;
		}
		else{
			$this->logData->insertLogData('error','delete',$this->db->last_query());
			return false;
		}
	}

}