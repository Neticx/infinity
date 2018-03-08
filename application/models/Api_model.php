<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_model extends CI_Model {

	private $dataUserApp;
	private $dataPengajar;
	private $tokenData;

	public function __construct()
	{
		parent::__construct();
	}

	private function setSession($tokens, $data = array())
	{
		$arraySESSION = array(
				'tokens' => $tokens,
				'dataToken' => $data,
			);
		$this->session->set_userdata($arraySESSION);
	}

	public function cekEmailSiswa($email)
	{
		$query = $this->db->select('email')
							->where('email',$email)
							->limit(1)
							->get('siswa');
		if($query->num_rows() == 1){
			return true;
		}
		else{
			return false;
		}
	}

	public function cekEmailWali($email)
	{
		$query = $this->db->select('email_wali')
							->where('email_wali',$email)
							->limit(1)
							->get('siswa');
		if($query->num_rows() == 1){
			return true;
		}
		else{
			return false;
		}
	}

	public function cekEmailUserApp($email)
	{
		$query = $this->db->select('*')
							->where('email',$email)
							->limit(1)
							->get('user_app');
		if($query->num_rows() == 1){
			$this->dataUserApp = $query->row_array();
			return true;
		}
		else{
			return false;
		}
	}

	public function cekEmailPengajar($email)
	{
		$query = $this->db->select('*')
							->where('email',$email)
							->limit(1)
							->get('pengajar');
		if($query->num_rows() == 1){
			$this->dataPengajar = $query->row_array();
			return true;
		}
		else{
			return false;
		}
	}

	public function getDataUserApp()
	{
		return $this->dataUserApp;
	}

	public function getDataPengajar()
	{
		return $this->dataPengajar;
	}

	public function loginApps($tokens, $email, $password)
	{
		$query = $this->db->select('id_user_app')
								->where('email',$email)
								->where('password',$password)
								->limit(1)
								->get('user_app');
		if($query->num_rows() == 1){
			$row = $query->row_array();
			$data = array(
					'tokens' => $tokens,
				);
			$this->db->where('id_user_app',$row['id_user_app'])->update('user_app', $data);
			return true;
		}
		else{
			return false;
		}

	}

	public function loginAppsPengajar($tokens, $email, $password)
	{
		$query = $this->db->select('id_pengajar')
								->where('email',$email)
								->where('password',$password)
								->limit(1)
								->get('pengajar');
		if($query->num_rows() == 1){
			$row = $query->row_array();
			$data = array(
					'tokens' => $tokens,
				);
			$this->db->where('id_pengajar',$row['id_pengajar'])->update('pengajar', $data);
			return true;
		}
		else{
			return false;
		}

	}

	public function registerApps($data)
	{
		$this->db->insert('user_app', $data);

		if($this->db->affected_rows() == 1){
			return true;
		}
		else{
			return false;
		}
	}

	public function updatePass($email, $pass)
	{
		$data = array(
				'password' => md5(md5($pass)),
			);
		$this->db->where('email',$email)->update('user_app',$data);

		if($this->db->affected_rows() == 1){
			return true;
		}
		else{
			return false;
		}
	}

	public function updatePassPengajar($email, $pass)
	{
		$data = array(
				'password' => md5(md5($pass)),
			);
		$this->db->where('email',$email)->update('pengajar',$data);

		if($this->db->affected_rows() == 1){
			return true;
		}
		else{
			return false;
		}
	}

	public function updateNama($email, $nama)
	{
		$data = array(
				'nama' => $nama,
			);
		$this->db->where('email',$email)->update('user_app',$data);

		if($this->db->affected_rows() == 1){
			return true;
		}
		else{
			return false;
		}
	}

	public function updateNamaPengajar($email, $nama)
	{
		$data = array(
				'nama' => $nama,
			);
		$this->db->where('email',$email)->update('pengajar',$data);

		if($this->db->affected_rows() == 1){
			return true;
		}
		else{
			return false;
		}
	}

	public function getPembayaranKhusus($email)
	{
		return $this->db->select('req_pembayaran_khusus.*')
							->join('req_pembayaran_khusus','siswa.nis = req_pembayaran_khusus.nis','left')
							->group_start()
							->where('siswa.email',$email)
							->or_where('siswa.email_wali',$email)
							->group_end()
							->where('req_pembayaran_khusus.disetujui','1')
							->limit(1)
							->get('siswa')
							->row_array();
	}

	public function getPembayaran($email)
	{
		return $this->db->select('siswa_pembayaran.*')
							->join('siswa_pembayaran','siswa.nis = siswa_pembayaran.nis_siswa','left')
							->where('siswa.email',$email)
							->or_where('siswa.email_wali',$email)
							->limit(1)
							->get('siswa')
							->row_array();
	}

	public function getPembayaranCicilan($id)
	{
		return $this->db->select('cicilan.*, DATE_FORMAT(tanggal, "%a, %e %b %Y") as tgl')
							->where('id_pembayaran',$id)
							->order_by('tanggal','ASC')
							->get('cicilan')
							->result_array();
	}

	public function cekTokens($tokens)
	{
		if($this->session->userdata('tokens') == $tokens){
			$this->tokenData = $this->session->userdata('dataToken');
			return true;
		}
		else{
			$query = $this->db->select('id_user_app, nama, email, tipe, foto')
									->where('tokens',$tokens)
									->limit(1)
									->get('user_app');
			if($query->num_rows() == 1){
				$data = array();
				foreach($query->result_array() as $row){
					$data['id'] = $row['id_user_app'];
					$data['nama'] = $row['nama'];
					$data['email'] = $row['email'];
					$data['tipe'] = $row['tipe'];
					$data['foto'] = $row['foto'];
					$data['foto_url'] = base_url('assets/img/profil/'.$row['foto']);
				}

				$this->tokenData = $data;
				$this->setSession($tokens, $data);
				return true;
			}
			else{
				$query = $this->db->select("nama, email, foto")
										->where('tokens',$tokens)
										->limit(1)
										->get('pengajar');
				if($query->num_rows() == 1){
					$data = array();
					foreach($query->result_array() as $row){
						$data['nama'] = $row['nama'];
						$data['email'] = $row['email'];
						$data['tipe'] = 'pengajar';
						$data['foto'] = $row['foto'];
						$data['foto_url'] = base_url('assets/img/profil/'.$row['foto']);
					}

					$this->tokenData = $data;
					$this->setSession($tokens, $data);
					return true;
				}
				else{
					return false;
				}
			}
		}
	}

	public function cekPassword($email, $password)
	{
		$query = $this->db->select('id_user_app')
								->where('email',$email)
								->where('password',md5(md5($password)))
								->get('user_app');
		if($query->num_rows() == 1){
			return true;
		}
		else{
			return false;
		}
	}

	public function cekPasswordPengajar($email, $password)
	{
		$query = $this->db->select('id_pengajar')
								->where('email',$email)
								->where('password',md5(md5($password)))
								->get('pengajar');
		if($query->num_rows() == 1){
			return true;
		}
		else{
			return false;
		}
	}

	public function getDataToken()
	{
		return $this->tokenData;
	}

	public function updateFoto($email, $foto)
	{
		$data = array(
				'foto' => $foto,
			);
		$this->db->where('email',$email)->update('user_app',$data);

		if($this->db->affected_rows() == 1){
			$data = array();
			$row = $this->session->userdata('dataToken');
			
			$data['id'] = $row['id'];
			$data['nama'] = $row['nama'];
			$data['email'] = $row['email'];
			$data['tipe'] = $row['tipe'];
			$data['foto'] = $foto;
			$data['foto_url'] = base_url('assets/img/profil/'.$foto);
			$this->session->unset_userdata('dataToken');
			$this->session->set_userdata('dataToken', $data);
			return true;
		}
		else{
			return false;
		}
	}

	public function updateFotoPengajar($email, $foto)
	{
		$data = array(
				'foto' => $foto,
			);
		$this->db->where('email',$email)->update('pengajar',$data);

		if($this->db->affected_rows() == 1){
			$data = array();
			$row = $this->session->userdata('dataToken');
			
			$data['nama'] = $row['nama'];
			$data['email'] = $row['email'];
			$data['tipe'] = $row['tipe'];
			$data['foto'] = $foto;
			$data['foto_url'] = base_url('assets/img/profil/'.$foto);
			$this->session->unset_userdata('dataToken');
			$this->session->set_userdata('dataToken', $data);
			return true;
		}
		else{
			return false;
		}
	}

	public function getListContact($email)
	{
		$row = $this->db->select('id_cabang')
							->where('email',$email)
							->or_where('email_wali',$email)
							->limit(1)
							->get('siswa')
							->row_array();

		return $this->db->select('id_user, user.nama, user.divisi, access.nama as jabatan')
							->join('access','user.id_access = access.id_access','left')
							->where('id_cabang',$row['id_cabang'])
							->where_in('user.id_access',array('15','16','17','18'))
							->get('user')
							->result_array();
	}

	public function getChats($id, $id2)
	{
		return $this->db->select('id_chat, DATE_FORMAT(time, "%c/%e/%Y, %h:%i:%s %p") as waktu, text, jenis, status')
							->where('id_user_app',$id)
							->where('id_user',$id2)
							->order_by('id_chat','ASC')
							->get('chat_app')
							->result_array();
	}

	public function getChat($id, $id2)
	{
		return $this->db->select('id_chat, DATE_FORMAT(time, "%c/%e/%Y, %h:%i:%s %p") as waktu, text, jenis, status')
							->where('id_user_app',$id)
							->where('id_user',$id2)
							->where('status','0')
							->order_by('id_chat','ASC')
							->get('chat_app')
							->result_array();
	}

	public function sendMessage($data = array())
	{
		$this->db->insert('chat_app',$data);

		if($this->db->affected_rows() > 0){
			return true;
		}
		else{
			return false;
		}
	}

	public function updateStatusChat($data = array())
	{
		$this->db->update_batch('chat_app', $data, 'id_chat');
	}

	public function getListPengumuman()
	{
		return $this->db->select('id_pengumuman as id, judul, DATE_FORMAT(tanggal, "%a, %e %b %Y") as tgl')
							->order_by('create_date','DESC')
							->get('pengumuman')
							->result_array();
	}

	public function getDetailPengumuman($id)
	{
		return $this->db->select('judul, isi, foto, DATE_FORMAT(tanggal, "%a, %e %b %Y") as tgl')
							->where('id_pengumuman',$id)
							->get('pengumuman')
							->row_array();
	}

	private function cekScanAbsen($id, $id_user, $tipe)
	{
		switch ($tipe) {
			case 'siswa':
				$query = $this->db->select('id_daftar_absen_siswa')
								->where('id_absen_siswa',$id)
								->where('nis',$id_user)
								->limit(1)
								->get('daftar_absen_siswa');
				if($query->num_rows() == 1){
					return true;
				}
				else{
					return false;
				}
			break;

			case 'pengajar':
				$query = $this->db->select('id_daftar_absen_pengajar')
								->where('id_absen_pengajar',$id)
								->where('id_pengajar',$id_user)
								->limit(1)
								->get('daftar_absen_pengajar');
				if($query->num_rows() == 1){
					return true;
				}
				else{
					return false;
				}
			break;
		}
	}

	public function doAbsen($email, $code)
	{
		$siswa = $this->db->select('nis')
								->where('email', $email)
								->limit(1)
								->get('siswa');
		if($siswa->num_rows() == 1){
			$row = $siswa->row_array();
			$query = $this->db->select('id_absen_siswa, jenis')
									->where('qr',$code)
									->limit(1)
									->get('absen_siswa');
			if($query->num_rows() == 1){
				$absen = $query->row_array();

				if($this->cekScanAbsen($absen['id_absen_siswa'],$row['nis'],'siswa')){
					return true;
				}
				else{
					$data = array(
							'id_daftar_absen_siswa' => '',
							'id_absen_siswa' => $absen['id_absen_siswa'],
							'nis' => $row['nis'],
							'ket' => 'M',
							'jenis' => $absen['jenis'],
							'time' => date('Y-m-d H:i:s')
						);

					$this->db->insert('daftar_absen_siswa',$data);
					if($this->db->affected_rows() > 0){
						return true;
					}
					else{
						return false;
					}
					
				}

			}
			else{
				return false;
			}
		}
		else{
			$pengajar = $this->db->select('id_pengajar')
									->where('email', $email)
									->limit(1)
									->get('pengajar');
			if($pengajar->num_rows() == 1){
				$row = $pengajar->row_array();
				$query = $this->db->select('id_absen_pengajar, jenis')
										->where('qr',$code)
										->limit(1)
										->get('absen_pengajar');
				if($query->num_rows() == 1){
					$absen = $query->row_array();

					if($this->cekScanAbsen($absen['id_absen_pengajar'],$row['id_pengajar'],'pengajar')){
						return true;
					}
					else{
						$data = array(
								'id_daftar_absen_pegawai' => '',
								'id_absen_pengajar' => $absen['id_absen_pengajar'],
								'id_pengajar' => $row['id_pengajar'],
								'ket' => 'M',
								'jenis' => $absen['jenis'],
								'time' => date('Y-m-d H:i:s')
							);

						$this->db->insert('daftar_absen_pengajar',$data);
						if($this->db->affected_rows() > 0){
							return true;
						}
						else{
							return false;
						}
					}
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
		}
	}

}