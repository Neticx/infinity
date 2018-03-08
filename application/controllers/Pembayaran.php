<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pembayaran extends MY_Controller {

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
		$this->load->model('Pembayaran_model','pembayaran',true);
		$this->load->helper('formatting_helper');
	}

	private function generateNomorRefund($id)
	{
		$hasil = array();
		$result = $this->pembayaran->getLastNomorRefund($id, date('m'), date('Y'));
		if(!empty($result['nomor'])){
			$hasil['nomor'] = $result['nomor'] + 1;
		}
		else{
			$hasil['nomor'] = 1;
		}

		if($hasil['nomor'] < 10){
			$hasil['nomor_surat'] = "000".$hasil['nomor']."/REFUND/".$this->romawi[date('m')]."/".date('Y');
		}
		elseif($hasil['nomor'] >= 10 && $hasil['nomor'] < 100){
			$hasil['nomor_surat'] = "00".$hasil['nomor']."/REFUND/".$this->romawi[date('m')]."/".date('Y');
		}
		elseif($hasil['nomor'] >= 100 && $hasil['nomor'] < 1000){
			$hasil['nomor_surat'] = "0".$hasil['nomor']."/REFUND/".$this->romawi[date('m')]."/".date('Y');
		}
		else{
			$hasil['nomor_surat'] = $hasil['nomor']."/REFUND/".$this->romawi[date('m')]."/".date('Y');
		}

		return $hasil;
	}

	public function refund_transfer()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->pembayaran->cekIdCabang($id)){
			$data = array(
					'title' => 'Refund Transfer Siswa',
					'cabangID' => $id,
				);
			$this->_render('pembayaran/refund_transfer',$data);
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'pembayaran/refund_transfer/?cabangID=',
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function action_refund_transfer()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->pembayaran->cekIdCabang($id)){
			$nomor = $this->generateNomorRefund($id);
			$data = array(
					'id_refund' => '',
					'nis' => $this->input->post('nis',true),
					'id_cabang' => $id,
					'biaya_pendaftaran' => $this->input->post('biaya_pendaftaran',true),
					'harga_program' => $this->input->post('harga_program',true),
					'diskon' => $this->input->post('diskon',true),
					'harus_bayar' => $this->input->post('total_harga',true),
					'total_bayar' => $this->input->post('total_pembayaran',true),
					'sisa_bayar' => $this->input->post('sisa_pembayaran',true),
					'alasan_refund' => $this->input->post('alasan',true),
					'tanggal' => date('Y-m-d H:i:s'),
					'id_user' => $this->session->userdata('id_user'),
					'jenis' => $this->input->post('jenis_refund',true),
					'nomor' => $nomor['nomor'],
					'nomor_surat' => $nomor['nomor_surat']
				);
			if($this->pembayaran->insertRefund($data)){
				$this->session->set_flashdata('alert_type', 'success');
				$this->session->set_flashdata('alert_data', 'Berhasil menambahkan data refund');
				redirect(base_url('cetak/refund_transfer/?cabangID='.$id.'&refundID='.$this->pembayaran->getLastID()));
			}
			else{
				$this->session->set_flashdata('alert_type', 'danger');
				$this->session->set_flashdata('alert_data', 'Gagal menambahkan data refund');
				redirect(base_url('pembayaran/refund_transfer/?cabangID='.$this->pembayaran->getLastID()));
			}
		}
		else{
			$this->error_404();
		}
	}

	public function bayar()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->pembayaran->cekIdCabang($id)){
			$cabang = $this->pembayaran->getDataCabang();
				$data = array(
					'title' => 'Pembayaran Tagihan Siswa',
					'cabangID' => $id,
					'cabang' => $cabang,
				);
			$this->_render('pembayaran/cek_tagihan',$data);
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'pembayaran/bayar/?cabangID=',
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function send_pembayaran()
	{
		if($this->input->is_ajax_request()){
			header('Content-Type: application/json');
			$nis = $this->input->post('NIS',true);
			$nominal = $this->input->post('nominal',true);

			$tagihan = $this->pembayaran->getSiswaPembayaran($nis);

			if(!empty($tagihan)){
				$data = array(
						'id_cicilan' => '',
						'id_pembayaran' => $tagihan['id_pembayaran'],
						'nominal' => $nominal,
						'tanggal' => date('Y-m-d H:i:s')
					);

				if($this->pembayaran->insertCicilanSiswa($data)){
					echo json_encode(array('success' => true));
				}
				else{
					echo json_encode(array('success' => false));
				}
			}
			else{
				echo json_encode(array('success' => false));
			}
		}
		else{
			$this->error_404();
		}
	}

	public function do_cek_tagihan()
	{
		if($this->input->is_ajax_request()){
			$nis = $this->input->get('nis',true);
			$tagihan = $this->pembayaran->getSiswaPembayaran($nis);
			$cicilan = $this->pembayaran->getSiswaPembayaranCicilan($tagihan['id_pembayaran']);

			echo '<table class="table table-stripped">';
			echo '<tbody>';
			echo '<tr>';
			echo '<td>Harga Program</td>';
			echo '<td>:</td>';
			echo '<td>'.formatRP($tagihan['biaya_program']).'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Biaya Pendaftaran</td>';
			echo '<td>:</td>';
			echo '<td>'.formatRP($tagihan['biaya_pendaftaran']).'</td>';
			echo '</tr>';
			echo '<td>Diskon</td>';
			echo '<td>:</td>';
			echo '<td>'.formatRP(($tagihan['diskon']/100) * $tagihan['biaya_program']).'</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td>Total</td>';
			echo '<td>:</td>';
			echo '<td>'.formatRP($tagihan['total']).'</td>';
			echo '</tr>';
			echo '</tbody>';
			echo '</table>';
			echo '<hr />';
			echo '<p>Sudah Dibayarkan</p>';
			echo '<table class="table table-stripped">';
			echo '<thead>';
			echo '<tr>';
			echo '<th>No</th>';
			echo '<th>Tanggal</th>';
			echo '<th>Nominal Pembayaran</th>';
			echo '</tr>';
			echo '</thead>';
			echo '<tbody>';
			$i = 1;
			$total_bayar = 0;
			if(!empty($cicilan)){
				foreach($cicilan as $cic){
					echo '<tr>';
					echo '<td>'.$i.'</td>';
					echo '<td>'.$cic['tgl'].'</td>';
					echo '<td>'.formatRP($cic['nominal']).'</td>';
					echo '</tr>';
					$total_bayar += $cic['nominal'];
					$i++;
				}
			}
			else{
				echo '<tr>';
				echo '<td colspan="3">Belum Melakukan Pembayaran</td>';
				echo '</tr>';
			}
			echo '</tbody>';
			echo '</table>';
			echo '<table class="table table-stripped">';
			echo '<tr style="background-color: #000; color: #fff;">';
			echo '<td>Total Pembayaran</td>';
			echo '<td><strong>'.formatRP($total_bayar).'</strong></td>';
			echo '</tr>';
			echo '<tr style="background-color: #000; color: #fff;">';
			echo '<td>Total Kekurangan</td>';
			echo '<td><strong style="color: red;">'.formatRP($tagihan['total'] - $total_bayar).'</strong></td>';
			echo '</tr>';
			echo '</table>';
			echo '</div>';
		}
		else{
			$this->error_404();
		}
	}

}