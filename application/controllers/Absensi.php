<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Absensi extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Absensi_model', 'absensi', true);
	}

	public function daftar_absensi_pengajar()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->absensi->cekIdCabang($id)){
			$jenis = $this->input->get('jenis',true);
			if($jenis == null){
				$data = array(
						'title' => 'Daftar Absensi Range',
						'halaman' => 'absensi/daftar_absensi_pengajar/?cabangID='.$id
					);
				$this->_render('absensi/range',$data);
			}
			else{
				switch($jenis){
					case 'range':
						$data = array(
								'title' => 'Daftar Absensi Pengajar'
							);
					break;

					case 'bulan':
						$data = array(
								'title' => 'Daftar Absensi Pengajar'
							);
					break;

					default:
						$this->error_404();
					break;
				}
			}
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'absensi/daftar_absensi_pengajar/?cabangID=',
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function daftar_absensi_siswa()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->absensi->cekIdCabang($id)){
			$jenis = $this->input->get('jenis',true);
			if($jenis == null){
				$data = array(
						'title' => 'Daftar Absensi Range',
						'halaman' => 'absensi/daftar_absensi_siswa/?cabangID='.$id
					);
				$this->_render('absensi/range',$data);
			}
			else{
				switch($jenis){
					case 'range':
						$data = array(
								'title' => 'Daftar Absensi Siswa'
							);
					break;

					case 'bulan':
						$data = array(
								'title' => 'Daftar Absensi Siswa'
							);
					break;

					default:
						$this->error_404();
					break;
				}
			}
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'absensi/daftar_absensi_siswa/?cabangID=',
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function daftar_absensi_karyawan()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->absensi->cekIdCabang($id)){
			$jenis = $this->input->get('jenis',true);
			if($jenis == null){
				$data = array(
						'title' => 'Daftar Absensi Range',
						'halaman' => 'absensi/daftar_absensi_karyawan/?cabangID='.$id
					);
				$this->_render('absensi/range',$data);
			}
			else{
				switch($jenis){
					case 'range':
						$data = array(
								'title' => 'Daftar Absensi Karyawan'
							);
					break;

					case 'bulan':
						$data = array(
								'title' => 'Daftar Absensi Karyawan'
							);
					break;

					default:
						$this->error_404();
					break;
				}
			}
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'absensi/daftar_absensi_karyawan/?cabangID=',
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function absensi_pengajar()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->absensi->cekIdCabang($id)){
			$data = array(
					'title' => 'Absensi Pengajar',
					'cabangID' => $id,
				);
			$this->_render('absensi/absensi_pengajar',$data);
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'absensi/absensi_pengajar/?cabangID=',
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function absensi_siswa()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->absensi->cekIdCabang($id)){
			$data = array(
					'title' => 'Absensi Siswa',
					'cabangID' => $id,
				);
			$this->_render('absensi/absensi_siswa',$data);
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'absensi/absensi_siswa/?cabangID=',
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	public function absensi_karyawan()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->absensi->cekIdCabang($id)){
			$data = array(
					'title' => 'Absensi Karyawan',
					'cabangID' => $id,
				);
			$this->_render('absensi/absensi_karyawan',$data);
		}
		elseif($id == null){
			$data = array(
					'title' => 'Cari Data Cabang',
					'halaman' => 'absensi/absensi_karyawan/?cabangID=',
				);
			$this->_render('search/search',$data);
		}
		else{
			$this->error_404();
		}
	}

	private function generateQR()
	{
		return md5(time().rand(0,100).uniqid());
	}

	private function renderAbsenQR($nama_file, $tipe)
	{
		$hasil = '';
		$url_qr = base_url('assets/img/absensi/'.$nama_file);
		$hasil .= '<center>';
		$hasil .= '<h2>Scan Here</h2>';
		$hasil .= '<img src="'.$url_qr.'" alt="">';
		$hasil .= '<h2>Absensi '.$tipe.'</h2>';
		$hasil .= '</center>';
		$hasil .= '<hr />';
		return $hasil;
	}

	public function gen_absensi_masuk()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->absensi->cekIdCabang($id)){
			header('Content-Type: application/json');
			$tipe = $this->input->get('tipe',true);
			$qr = $this->generateQR();
			$this->load->library('ciqrcode');

			switch($tipe){
				case 'pengajar':
					if($this->absensi->cekAbsensiPengajar(date('Y-m-d'), 'masuk')){
						$nama_file = 'qr_pengajar_masuk'.$qr.'.png';
						$params['data'] = $qr;
						$params['level'] = 'H';
						$params['size'] = 10;
						$params['savename'] = FCPATH.'assets/img/absensi/'.$nama_file;

						$data = array(
								'id_absen_pengajar' => '',
								'id_cabang' => $id,
								'qr' => $qr,
								'jenis' => 'masuk',
								'time' => date('Y-m-d H:i:s')
							);

						if($this->absensi->insertAbsensiPengajar($data)){
							$this->ciqrcode->generate($params);
							echo json_encode(array(
								'url' => 'list_absensi_pengajar/?id='.$this->absensi->getLastID(),
								'data' => $this->renderAbsenQR($nama_file, 'Pengajar Masuk')
							));
						}
						else{
							echo json_encode(array(
								'url' => null,
								'data' => "<center><h2>Cannot Generate Please Try Again</h2></center>"
							));
						}
					}
					else{
						$absen = $this->absensi->getDataAbsensiPengajar();
						$nama_file = 'qr_pengajar_masuk'.$absen['qr'].'.png';
						echo json_encode(array(
								'url' => 'list_absensi_pengajar/?id='.$absen['id_absen_pengajar'],
								'data' => $this->renderAbsenQR($nama_file, 'Pengajar Masuk')
							));
					}
				break;

				case 'siswa':
					if($this->absensi->cekAbsensiSiswa(date('Y-m-d'), 'masuk')){
						$nama_file = 'qr_siswa_masuk'.$qr.'.png';
						$params['data'] = $qr;
						$params['level'] = 'H';
						$params['size'] = 10;
						$params['savename'] = FCPATH.'assets/img/absensi/'.$nama_file;

						$data = array(
								'id_absen_siswa' => '',
								'id_cabang' => $id,
								'qr' => $qr,
								'jenis' => 'masuk',
								'time' => date('Y-m-d H:i:s')
							);

						if($this->absensi->insertAbsensiSiswa($data)){
							$this->ciqrcode->generate($params);
							echo json_encode(array(
								'url' => 'list_absensi_siswa/?id='.$this->absensi->getLastID(),
								'data' => $this->renderAbsenQR($nama_file, 'Siswa Masuk')
							));
						}
						else{
							echo json_encode(array(
								'url' => null,
								'data' => "<center><h2>Cannot Generate Please Try Again</h2></center>"
							));
						}
					}
					else{
						$absen = $this->absensi->getDataAbsensiSiswa();
						$nama_file = 'qr_siswa_masuk'.$absen['qr'].'.png';
						echo json_encode(array(
								'url' => 'list_absensi_siswa/?id='.$absen['id_absen_siswa'],
								'data' => $this->renderAbsenQR($nama_file, 'Siswa Masuk')
							));
					}
				break;

				case 'karyawan':
					if($this->absensi->cekAbsensiPegawai(date('Y-m-d'), 'masuk')){
						$nama_file = 'qr_pegawai_masuk'.$qr.'.png';
						$params['data'] = $qr;
						$params['level'] = 'H';
						$params['size'] = 10;
						$params['savename'] = FCPATH.'assets/img/absensi/'.$nama_file;

						$data = array(
								'id_absen_pegawai' => '',
								'id_cabang' => $id,
								'qr' => $qr,
								'jenis' => 'masuk',
								'time' => date('Y-m-d H:i:s')
							);

						if($this->absensi->insertAbsensiPegawai($data)){
							$this->ciqrcode->generate($params);
							echo json_encode(array(
								'url' => 'list_absensi_pegawai/?id='.$this->absensi->getLastID(),
								'data' => $this->renderAbsenQR($nama_file, 'Pegawai Masuk')
							));
						}
						else{
							echo json_encode(array(
								'url' => null,
								'data' => "<center><h2>Cannot Generate Please Try Again</h2></center>"
							));
						}
					}
					else{
						$absen = $this->absensi->getDataAbsensiPegawai();
						$nama_file = 'qr_pegawai_masuk'.$absen['qr'].'.png';
						echo json_encode(array(
								'url' => 'list_absensi_pegawai/?id='.$absen['id_absen_pegawai'],
								'data' => $this->renderAbsenQR($nama_file, 'Pegawai Masuk')
							));
					}
				break;
			}
		}
	}

	public function gen_absensi_pulang()
	{
		$id = $this->input->get("cabangID",true);
		if($this->session->userdata("cabang_user") != null && $this->session->userdata("cabang_user") != "PUSAT"){
			$id = $this->session->userdata("cabang_user");
		}

		if($this->absensi->cekIdCabang($id)){
			header('Content-Type: application/json');
			$tipe = $this->input->get('tipe',true);
			$qr = $this->generateQR();
			$this->load->library('ciqrcode');

			switch($tipe){
				case 'pengajar':
					if($this->absensi->cekAbsensiPengajar(date('Y-m-d'), 'pulang')){
						$nama_file = 'qr_pengajar_pulang'.$qr.'.png';
						$params['data'] = $qr;
						$params['level'] = 'H';
						$params['size'] = 10;
						$params['savename'] = FCPATH.'assets/img/absensi/'.$nama_file;

						$data = array(
								'id_absen_pengajar' => '',
								'id_cabang' => $id,
								'qr' => $qr,
								'jenis' => 'pulang',
								'time' => date('Y-m-d H:i:s')
							);

						if($this->absensi->insertAbsensiPengajar($data)){
							$this->ciqrcode->generate($params);
							echo json_encode(array(
								'url' => 'list_absensi_pengajar/?id='.$this->absensi->getLastID(),
								'data' => $this->renderAbsenQR($nama_file, 'Pengajar Pulang')
							));
						}
						else{
							echo json_encode(array(
								'url' => null,
								'data' => "<center><h2>Cannot Generate Please Try Again</h2></center>"
							));
						}
					}
					else{
						$absen = $this->absensi->getDataAbsensiPengajar();
						$nama_file = 'qr_pengajar_pulang'.$absen['qr'].'.png';
						echo json_encode(array(
								'url' => 'list_absensi_pengajar/?id='.$absen['id_absen_pengajar'],
								'data' => $this->renderAbsenQR($nama_file, 'Pengajar Pulang')
							));
					}
				break;

				case 'siswa':
					if($this->absensi->cekAbsensiSiswa(date('Y-m-d'), 'pulang')){
						$nama_file = 'qr_siswa_pulang'.$qr.'.png';
						$params['data'] = $qr;
						$params['level'] = 'H';
						$params['size'] = 10;
						$params['savename'] = FCPATH.'assets/img/absensi/'.$nama_file;

						$data = array(
								'id_absen_siswa' => '',
								'id_cabang' => $id,
								'qr' => $qr,
								'jenis' => 'pulang',
								'time' => date('Y-m-d H:i:s')
							);

						if($this->absensi->insertAbsensiSiswa($data)){
							$this->ciqrcode->generate($params);
							echo json_encode(array(
								'url' => 'list_absensi_siswa/?id='.$this->absensi->getLastID(),
								'data' => $this->renderAbsenQR($nama_file, 'Siswa Pulang')
							));
						}
						else{
							echo json_encode(array(
								'url' => null,
								'data' => "<center><h2>Cannot Generate Please Try Again</h2></center>"
							));
						}
					}
					else{
						$absen = $this->absensi->getDataAbsensiSiswa();
						$nama_file = 'qr_siswa_pulang'.$absen['qr'].'.png';
						echo json_encode(array(
								'url' => 'list_absensi_siswa/?id='.$absen['id_absen_siswa'],
								'data' => $this->renderAbsenQR($nama_file, 'Siswa Pulang')
							));
					}
				break;

				case 'karyawan':
					if($this->absensi->cekAbsensiPegawai(date('Y-m-d'), 'pulang')){
						$nama_file = 'qr_pegawai_pulang'.$qr.'.png';
						$params['data'] = $qr;
						$params['level'] = 'H';
						$params['size'] = 10;
						$params['savename'] = FCPATH.'assets/img/absensi/'.$nama_file;

						$data = array(
								'id_absen_pegawai' => '',
								'id_cabang' => $id,
								'qr' => $qr,
								'jenis' => 'pulang',
								'time' => date('Y-m-d H:i:s')
							);

						if($this->absensi->insertAbsensiPegawai($data)){
							$this->ciqrcode->generate($params);
							echo json_encode(array(
								'url' => 'list_absensi_pegawai/?id='.$this->absensi->getLastID(),
								'data' => $this->renderAbsenQR($nama_file, 'Pegawai Pulang')
							));
						}
						else{
							echo json_encode(array(
								'url' => null,
								'data' => "<center><h2>Cannot Generate Please Try Again</h2></center>"
							));
						}
					}
					else{
						$absen = $this->absensi->getDataAbsensiPegawai();
						$nama_file = 'qr_pegawai_pulang'.$absen['qr'].'.png';
						echo json_encode(array(
								'url' => 'list_absensi_pegawai/?id='.$absen['id_absen_pegawai'],
								'data' => $this->renderAbsenQR($nama_file, 'Pegawai Pulang')
							));
					}
				break;
			}
		}
	}

	public function list_absensi_pengajar()
	{
		$id = $this->input->get('id',true);
		$data = $this->absensi->getListAbsensiPengajar($id, date('Y-m-d'));
		if(!empty($data)){
			$i=1;
			foreach($data as $row){
				echo '<tr>';
				echo '<td class="col-xs-3">'.$i.'</td>';
				echo '<td class="col-xs-6">'.$row['nama'].'</td>';
				echo '<td class="col-xs-3">'.$row['time'].'</td>';
				echo '</tr>';
				$i++;
			}
		}
		else{
			echo '<tr><td class="col-xs-12"><center><h2>Belum Ada Data</h2></center></td></tr>';
		}
	}

	public function list_absensi_siswa()
	{
		$id = $this->input->get('id',true);
		$data = $this->absensi->getListAbsensiSiswa($id, date('Y-m-d'));
		if(!empty($data)){
			$i=1;
			foreach($data as $row){
				echo '<tr>';
				echo '<td class="col-xs-3">'.$i.'</td>';
				echo '<td class="col-xs-6">'.$row['nama'].'</td>';
				echo '<td class="col-xs-3">'.$row['time'].'</td>';
				echo '</tr>';
				$i++;
			}
		}
		else{
			echo '<tr><td class="col-xs-12"><center><h2>Belum Ada Data</h2></center></td></tr>';
		}
	}

	public function list_absensi_pegawai()
	{
		$id = $this->input->get('id',true);
		$data = $this->absensi->getListAbsensiPegawai($id, date('Y-m-d'));
		if(!empty($data)){
			$i=1;
			foreach($data as $row){
				echo '<tr>';
				echo '<td class="col-xs-3">'.$i.'</td>';
				echo '<td class="col-xs-6">'.$row['nama'].'</td>';
				echo '<td class="col-xs-3">'.$row['time'].'</td>';
				echo '</tr>';
				$i++;
			}
		}
		else{
			echo '<tr><td class="col-xs-12"><center><h2>Belum Ada Data</h2></center></td></tr>';
		}
	}

}