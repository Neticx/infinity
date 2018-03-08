<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Surat extends MY_Controller {

	private $romawi = array(
					'01' => 'I',
					'02' => 'II',
					'03' => 'III',
					'04' => 'IV',
					'05' => 'V',
					'06' => 'VI',
					'07' => 'VII',
					'08' => 'VIII',
					'09' => 'IX',
					'10' => 'X',
					'11' => 'XI',
					'12' => 'XII',
				);

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Surat_model','surat',true);
	}

	private function generateNomor($id)
	{
		$hasil = array();
		$result = $this->surat->getLastNomor($id, date('m'), date('Y'));
		if(!empty($result['nomor'])){
			$hasil['nomor'] = $result['nomor'] + 1;
		}
		else{
			$hasil['nomor'] = 1;
		}

		if($hasil['nomor'] < 10){
			$hasil['nomor_surat'] = "000".$hasil['nomor']."/PENUGASAN/".$this->romawi[date('m')]."/".date('Y');
		}
		elseif($hasil['nomor'] >= 10 && $hasil['nomor'] < 100){
			$hasil['nomor_surat'] = "00".$hasil['nomor']."/PENUGASAN/".$this->romawi[date('m')]."/".date('Y');
		}
		elseif($hasil['nomor'] >= 100 && $hasil['nomor'] < 1000){
			$hasil['nomor_surat'] = "0".$hasil['nomor']."/PENUGASAN/".$this->romawi[date('m')]."/".date('Y');
		}
		else{
			$hasil['nomor_surat'] = $hasil['nomor']."/PENUGASAN/".$this->romawi[date('m')]."/".date('Y');
		}

		return $hasil;
	}

	private function generateNomorKeuangan($id)
	{
		$hasil = array();
		$result = $this->surat->getLastNomorKeuangan($id, date('m'), date('Y'));
		if(!empty($result['nomor'])){
			$hasil['nomor'] = $result['nomor'] + 1;
		}
		else{
			$hasil['nomor'] = 1;
		}

		if($hasil['nomor'] < 10){
			$hasil['nomor_surat'] = "000".$hasil['nomor']."/PENG-KEUANGAN/".$this->romawi[date('m')]."/".date('Y');
		}
		elseif($hasil['nomor'] >= 10 && $hasil['nomor'] < 100){
			$hasil['nomor_surat'] = "00".$hasil['nomor']."/PENG-KEUANGAN/".$this->romawi[date('m')]."/".date('Y');
		}
		elseif($hasil['nomor'] >= 100 && $hasil['nomor'] < 1000){
			$hasil['nomor_surat'] = "0".$hasil['nomor']."/PENG-KEUANGAN/".$this->romawi[date('m')]."/".date('Y');
		}
		else{
			$hasil['nomor_surat'] = $hasil['nomor']."/PENG-KEUANGAN/".$this->romawi[date('m')]."/".date('Y');
		}

		return $hasil;
	}

	private function generateNomorSP($jenis)
	{
		$hasil = array();
		$result = $this->surat->getLastNomorSP($jenis, date('m'), date('Y'));
		if(!empty($result['nomor'])){
			$hasil['nomor'] = $result['nomor'] + 1;
		}
		else{
			$hasil['nomor'] = 1;
		}

		if($hasil['nomor'] < 10){
			$hasil['nomor_surat'] = "000".$hasil['nomor']."/SP".$jenis."/".$this->romawi[date('m')]."/".date('Y');
		}
		elseif($hasil['nomor'] >= 10 && $hasil['nomor'] < 100){
			$hasil['nomor_surat'] = "00".$hasil['nomor']."/SP".$jenis."/".$this->romawi[date('m')]."/".date('Y');
		}
		elseif($hasil['nomor'] >= 100 && $hasil['nomor'] < 1000){
			$hasil['nomor_surat'] = "0".$hasil['nomor']."/SP".$jenis."/".$this->romawi[date('m')]."/".date('Y');
		}
		else{
			$hasil['nomor_surat'] = $hasil['nomor']."/SP".$jenis."/".$this->romawi[date('m')]."/".date('Y');
		}

		return $hasil;
	}

	private function generateNomorST()
	{
		$hasil = array();
		$result = $this->surat->getLastNomorST(date('m'), date('Y'));
		if(!empty($result['nomor'])){
			$hasil['nomor'] = $result['nomor'] + 1;
		}
		else{
			$hasil['nomor'] = 1;
		}

		if($hasil['nomor'] < 10){
			$hasil['nomor_surat'] = "000".$hasil['nomor']."/TEGURAN/".$this->romawi[date('m')]."/".date('Y');
		}
		elseif($hasil['nomor'] >= 10 && $hasil['nomor'] < 100){
			$hasil['nomor_surat'] = "00".$hasil['nomor']."/TEGURAN/".$this->romawi[date('m')]."/".date('Y');
		}
		elseif($hasil['nomor'] >= 100 && $hasil['nomor'] < 1000){
			$hasil['nomor_surat'] = "0".$hasil['nomor']."/TEGURAN/".$this->romawi[date('m')]."/".date('Y');
		}
		else{
			$hasil['nomor_surat'] = $hasil['nomor']."/TEGURAN/".$this->romawi[date('m')]."/".date('Y');
		}

		return $hasil;
	}

	public function penugasan_pengajar()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->surat->cekIdCabang($id)){
			$cabang = $this->surat->getDataCabang();
			$data = array(
				'title' => 'Form Penugasan Pengajar',
				'cabangID' => $id,
				'pengajar' => $this->surat->getPengajar($id)
			);
			$this->_render('surat/penugasan_pengajar',$data);
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'surat/penugasan_pengajar/?cabangID=',
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function add_penugasan_pengajar()
	{
		$id = $this->input->post('id_cabang',true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}
		$nomor = $this->generateNomor($id);

		$data = array(
				'id_penugasan_pengajar' => '',
				'id_cabang' => $id,
				'id_cabang_tujuan' => $this->input->post('id_cabang_tujuan',true),
				'id_pengajar' => $this->input->post('pengajar',true),
				'id_kelas' => $this->input->post('kelas',true),
				'materi' => $this->input->post('materi',true),
				'waktu_mulai' => $this->input->post('mulai',true),
				'waktu_selesai' => $this->input->post('selesai',true),
				'nomor' => $nomor['nomor'],
				'nomor_surat' => $nomor['nomor_surat'],
				'tanggal' => date('Y-m-d H:i:s'),
				'id_user_penugas' => $this->session->userdata('id_user'),
			);
		if($this->surat->insertPenugasanPengajar($data)){
			$lastID = $this->surat->getLastID();
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_data', 'Berhasil menambahkan data Penugasan Pengajar');
			redirect(base_url('cetak/surat_penugasan_pengajar/?suratID='.$lastID));
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', 'Gagal menambahkan data Penugasan Pengajar');
			redirect(base_url('surat/penugasan_pengajar/?cabangID='.$id));
		}
	}

	public function get_kelas()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->surat->cekIdCabang($id)){
			$kelas = $this->surat->getKelas($id);
			echo '<option value="">--- Pilih Kelas ---</option>';
			foreach($kelas as $row){
				echo '<option value="'.$row['id_kelas'].'">'.$row['nama_kelas'].'</option>';
			}
		}
		else{
			$this->error_404();
		}
	}

	public function ke_keuangan()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->surat->cekIdCabang($id)){
			$data = array(
					'title' => 'Request Uang Ke Keuangan',
					'cabangID' => $id,
				);
			$this->_render('surat/ke_keuangan',$data);
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'surat/ke_keuangan/?cabangID=',
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function action_add_ke_keuangan()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->surat->cekIdCabang($id)){
			$nomor = $this->generateNomorKeuangan($id);
			$data = array(
					'id_permintaan_uang_keuangan' => '',
					'id_cabang' => $id,
					'id_user' => $this->session->userdata('id_user'),
					'kegiatan' => $this->input->post('kegiatan',true),
					'nominal' => $this->input->post('nominal',true),
					'nomor' => $nomor['nomor'],
					'nomor_surat' => $nomor['nomor_surat'],
					'tanggal' => date('Y-m-d H:i:s'),
				);
			if($this->surat->insertReqKeuangan($data)){
				$lastID = $this->surat->getLastID();
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Berhasil menambahkan data Pengajuan Ke Keuangan');
				redirect(base_url('cetak/request_keuangan/?cabangID='.$id.'&suratID='.$lastID));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Gagal menambahkan data Pengajuan Ke Keuangan');
				redirect(base_url('surat/ke_keuangan/?cabangID='.$id));
			}
		}
		else{
			$this->error_404();
		}
	}

	public function pemberian_surat_peringatan()
	{
		$data = array(
				'title' => 'Form Surat Peringatan',
			);
		$this->_render('surat/surat_peringatan',$data);
	}

	public function action_add_sp()
	{
		$jenis = $this->input->post('jenis',true);
		$nomor = $this->generateNomorSP($jenis);

		$data = array(
				'id_surat_peringatan' => '',
				'jenis' => $jenis,
				'nomor' => $nomor['nomor'],
				'nama' => $this->input->post('nama',true),
				'jabatan' => $this->input->post('jabatan',true),
				'alasan' => json_encode($this->input->post('alasan',true)),
				'nomor_surat' => $nomor['nomor_surat'],
				'tanggal' => date('Y-m-d H:i:s'),
				'id_user' => $this->session->userdata('id_user')
			);
		if($this->surat->insertSP($data)){
			$lastID = $this->surat->getLastID();
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_data', 'Berhasil menambahkan Surat Peringatan');
			redirect(base_url('cetak/surat_peringatan/?suratID='.$lastID));
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', 'Gagal menambahkan Surat Peringatan');
			redirect(base_url('surat/pemberian_surat_peringatan'));
		}
	}

	public function pemberian_surat_teguran()
	{
		$data = array(
				'title' => 'Form Surat Teguran',
			);
		$this->_render('surat/surat_teguran',$data);
	}

	public function action_add_st()
	{
		$nomor = $this->generateNomorST();

		$data = array(
				'id_surat_teguran' => '',
				'nomor' => $nomor['nomor'],
				'nama' => $this->input->post('nama',true),
				'jabatan' => $this->input->post('jabatan',true),
				'alasan' => json_encode($this->input->post('alasan',true)),
				'nomor_surat' => $nomor['nomor_surat'],
				'tanggal' => date('Y-m-d H:i:s'),
				'id_user' => $this->session->userdata('id_user')
			);
		if($this->surat->insertST($data)){
			$lastID = $this->surat->getLastID();
			$this->session->set_flashdata('alert_type', 'success');
			$this->session->set_flashdata('alert_data', 'Berhasil menambahkan Surat Teguran');
			redirect(base_url('cetak/surat_teguran/?suratID='.$lastID));
		}
		else{
			$this->session->set_flashdata('alert_type', 'danger');
			$this->session->set_flashdata('alert_data', 'Gagal menambahkan Surat Teguran');
			redirect(base_url('surat/pemberian_surat_teguran'));
		}
	}

	public function pengusulan_gaji()
	{
		
	}

	public function permohonan_cuti()
	{
		
	}

	public function permohonan_lembur()
	{
		
	}

	public function pemberian_perintah_lembur()
	{
		
	}

	public function pemberian_surat_tugas()
	{
		
	}

}