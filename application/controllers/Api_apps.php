<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Api_apps extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Api_model','api',true);
		$this->load->helper('randompass');

		if (isset($_SERVER['HTTP_ORIGIN'])){
            header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
            header('Access-Control-Allow-Credentials: true');
            header('Access-Control-Max-Age: 86400');
        }

        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
                header("Access-Control-Allow-Methods: PUT, GET, POST, OPTIONS");         
            if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
                header("Access-Control-Allow-Headers:{$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
            exit(0);
        }
	}

	private function generateTokens()
	{
		return md5('Infinity'.time().rand(0,100));
	}

	private function send_pass($email, $pass, $nama)
	{
		$this->load->library('email');
		$config['protocol'] = 'smtp';
	    $config['smtp_host'] = 'mail.infinity-onfire.com';
	    $config['smtp_port'] = '587';
	    $config['smtp_user'] = 'no-reply@infinity-onfire.com';
	    $config['smtp_pass'] = 'bismillah123?';
	    $config['mailtype'] = 'html';
	    $config['charset'] = 'iso-8859-1';
	    $config['wordwrap'] = TRUE;
	    $config['newline'] = "\r\n";

		$this->email->initialize($config);

		$body = '<!DOCTYPE html><html><head><meta charset="utf-8"><title>Bimbel Password</title><meta name="viewport" content="width=device-width, initial-scale=1.0" /></head><body style="background-color: #f9f9f9; margin: 10px; font: 13px/20px normal Helvetica, Arial, sans-serif; color: #4F5155;"><div style="margin: 5px; border: 1px solid #C0C0C0; box-shadow: 0 0 8px #C0C0C0; background-color: #fff;"><h1 style="color: #444; background-color: transparent; border-bottom: 1px solid #C0C0C0; font-size: 19px; font-weight: normal; margin: 0 0 14px 0; padding: 14px 15px 10px 15px;">Selamat Datang!</h1><p style="margin: 12px 15px 12px 15px;">Hi '.$nama.', selamat datang dalam sistem Bimbel. Berikut ini Kami Sampaikan Informasi tentang Login anda :</p><p style="margin: 12px 15px 5px 15px;">Email : '.$email.'</p><p style="margin: 0px 15px 12px 15px;">Password : '.$pass.'</p><p style="margin: 12px 15px 12px 15px;">Demikian kami sampaikan kepada anda, terimakasih <br /><i style="color: red;">*) Demi alasan keamanaan kami sarankan anda mengganti password anda setelah ini.</i></p></div></body></html>';
		$this->email->from('no-reply@infinity-onfire.com', 'Administrator Bimbel Infinity No-Reply');
		$this->email->to($email);
		$this->email->subject('Selamat Datang di Sistem Bimbel Infinity');
		$this->email->message($body);
		if($this->email->send()){
			return true;
		}
		else{
			return false;
		}
	}

	public function forgot_pass()
	{
		header('Content-Type: application/json');
		$pass = random_pass(6);
		$email = $this->input->post('email',true);

		if($this->api->cekEmailUserApp($email)){
			$user = $this->api->getDataUserApp();
			if($this->api->updatePass($email, $pass) && $this->send_pass($email, $pass, $user['nama'])){
				echo json_encode(array('status' => true, 'message' => 'Password reset Success'));
			}
			else{
				echo json_encode(array('status' => false, 'message' => 'Password reset fail'));
			}
		}
		elseif($this->api->cekEmailPengajar($email)){
			$pengajar = $this->api->getDataPengajar();
			if($this->api->updatePassPengajar($email, $pass) && $this->send_pass($email, $pass, $user['nama'])){
				echo json_encode(array('status' => true, 'message' => 'Password reset Success'));
			}
			else{
				echo json_encode(array('status' => false, 'message' => 'Password reset fail'));
			}
		}
		else{
			echo json_encode(array('status' => false, 'message' => 'Password reset fail'));
		}
	}

	public function login()
	{
		header('Content-Type: application/json');
		$email = $this->input->post('email',true);
		$password = md5(md5($this->input->post('password',true)));
		$tokens = $this->generateTokens();

		if($this->api->loginApps($tokens, $email, $password)){
			echo json_encode(array('status' => true, 'message' => 'Login success', 'tokens' => $tokens));
		}
		elseif($this->api->loginAppsPengajar($tokens, $email, $password)){
			echo json_encode(array('status' => true, 'message' => 'Login success', 'tokens' => $tokens));
		}
		else{
			echo json_encode(array('status' => false, 'message' => 'Login fail'));
		}
	}

	public function register()
	{
		header('Content-Type: application/json');
		$nama = $this->input->post('nama',true);
		$tipe = $this->input->post('tipe',true);
		$email = $this->input->post('email',true);
		$password = md5(md5($this->input->post('password',true)));

		switch($tipe){
			case 'siswa':
				if($this->api->cekEmailSiswa($email)){
					$data = array(
							'id_user_app' => '',
							'nama' => $nama,
							'email' => $email,
							'password' => $password,
							'tipe' => $tipe,
							'tokens' => NULL,
						);
					if($this->api->registerApps($data)){
						echo json_encode(array('status' => true, 'message' => 'Register Success'));
					}
					else{
						echo json_encode(array('status' => false, 'message' => 'Register Error Email already registered'));
					}
				}
				else{
					echo json_encode(array('status' => false, 'message' => 'Email dosen\'t exist'));
				}
			break;

			case 'wali':
				if($this->api->cekEmailWali($email)){
					$data = array(
							'id_user_app' => '',
							'nama' => $nama,
							'email' => $email,
							'password' => $password,
							'tipe' => $tipe,
							'tokens' => NULL,
						);
					if($this->api->registerApps($data)){
						echo json_encode(array('status' => true, 'message' => 'Register Success'));
					}
					else{
						echo json_encode(array('status' => false, 'message' => 'Register Error Email already registered'));
					}
				}
				else{
					echo json_encode(array('status' => false, 'message' => 'Email dosen\'t exist'));
				}
			break;

			case 'pengajar':
				if($this->api->cekEmailPengajar($email)){
					if($this->api->registerApps($data)){
						echo json_encode(array('status' => true, 'message' => 'Pengajar Tidak perlu melakukan registrasi lagi karena telah didaftarkan dari sistem'));
					}
				}
				else{
					echo json_encode(array('status' => false, 'message' => 'Email dosen\'t exist'));
				}
			break;
		}
	}

	public function main()
	{
		header('Content-Type: application/json');
		$tokens = $this->input->server('HTTP_X_APP_INFINITY',true);
		if($tokens != null && $this->api->cekTokens($tokens)){
			$data = $this->api->getDataToken();
			echo json_encode(array('status' => true, 'message' => 'Success', 'data' => $data));
		}
		else{
			echo json_encode(array('status' => false, 'message' => 'Token invalid!'));
		}
	}

	public function update_pass()
	{
		header('Content-Type: application/json');
		$tokens = $this->input->server('HTTP_X_APP_INFINITY',true);
		if($tokens != null && $this->api->cekTokens($tokens)){
			$data = $this->api->getDataToken();

			$oldpass = $this->input->post('oldpass',true);
			$newpass = $this->input->post('newpass',true);
			$confpass = $this->input->post('confpass',true);
			if($this->api->cekPassword($data['email'], $oldpass)){
				if($newpass == $confpass){
					if($this->api->updatePass($data['email'], $newpass)){
						echo json_encode(array('status' => true, 'message' => 'Success update password!'));
					}
					else{
						echo json_encode(array('status' => false, 'message' => 'Can\'t update password!'));
					}
				}
				else{
					echo json_encode(array('status' => false, 'message' => 'Password not match!'));
				}
			}
			elseif($this->api->cekPasswordPengajar($data['email'], $oldpass)){
				if($newpass == $confpass){
					if($this->api->updatePassPengajar($data['email'], $newpass)){
						echo json_encode(array('status' => true, 'message' => 'Success update password!'));
					}
					else{
						echo json_encode(array('status' => false, 'message' => 'Can\'t update password!'));
					}
				}
				else{
					echo json_encode(array('status' => false, 'message' => 'Password not match!'));
				}
			}
			else{
				echo json_encode(array('status' => false, 'message' => 'Wrong Password!'));
			}
		}
		else{
			echo json_encode(array('status' => false, 'message' => 'Token invalid!'));
		}
	}

	public function update_nama()
	{
		header('Content-Type: application/json');
		$tokens = $this->input->server('HTTP_X_APP_INFINITY',true);
		if($tokens != null && $this->api->cekTokens($tokens)){
			$data = $this->api->getDataToken();

			$nama = $this->input->post('nama',true);
			if(!empty($nama) && $this->api->updateNama($data['email'], $nama)){
				echo json_encode(array('status' => true, 'message' => 'Success Update nama!'));
			}
			elseif(!empty($nama) && $this->api->updateNamaPengajar($data['email'], $nama)){
				echo json_encode(array('status' => true, 'message' => 'Success Update nama!'));
			}
			else{
				echo json_encode(array('status' => false, 'message' => 'Error Update nama!'));
			}
		}
		else{
			echo json_encode(array('status' => false, 'message' => 'Token invalid!'));
		}
	}

	public function update_foto()
	{
		header('Content-Type: application/json');
		$tokens = $this->input->server('HTTP_X_APP_INFINITY',true);
		if($tokens != null && $this->api->cekTokens($tokens)){
			$data = $this->api->getDataToken();
			if(! empty($_FILES) && $_FILES['foto']['name'] != null){
				$foto = "profil-" . md5(time() . rand(0,100)) . "." . strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
				$config['upload_path'] = './assets/img/profil';
				$config['allowed_types'] = 'jpg|png|jpeg';
				$config['max_size']     = '1536';
				$this->load->library('upload', $config);

				$config['file_name'] = $foto;
				$this->upload->initialize($config);

				if($this->upload->do_upload('foto')){
					$config['image_library'] = 'gd2';
					$config['source_image'] = './assets/img/profil/'.$foto;
					$config['maintain_ratio'] = TRUE;
					$config['quality'] = 70;
					$config['width'] = 200;
					$config['height'] = 200;
					$this->load->library('image_lib', $config);
					$this->image_lib->resize();
					if(!empty($data['foto'])){
						if(file_exists("/assets/img/profil/".$data['foto'])){
							unlink(FCPATH . "/assets/img/profil/".$data['foto']);
						}
					}

					if($this->api->updateFoto($data['email'], $foto)){
						echo json_encode(array('status' => true, 'message' => 'Success update profil!'));
					}
					else{
						echo json_encode(array('status' => false, 'message' => 'Error update profil'));
					}
				}
				else{
					echo json_encode(array('status' => false, 'message' => 'Error update profil. '.$this->upload->display_errors('','')));
				}
			}
		}
		else{
			echo json_encode(array('status' => false, 'message' => 'Token invalid!'));
		}
	}

	public function jadwal($tipe = null)
	{
		header('Content-Type: application/json');
		$tokens = $this->input->server('HTTP_X_APP_INFINITY',true);
		if($tokens != null && $this->api->cekTokens($tokens)){
			switch($tipe){
				case 'siswa':
				case 'wali':
					$data = array(
							'senin' => array(
									array(
											'sesi' => '13:00 - 	15:00',
											'mapel' => 'Potensi Akademik',
											'ruang' => 'Ruang A 3',
											'pengajar' => 'Edi Susilo',
										),
									array(
											'sesi' => '15:00 - 	17:00',
											'mapel' => 'Potensi Akademik',
											'ruang' => 'Ruang A 3',
											'pengajar' => 'Edi Susilo',
										),
								),
							'selasa' => array(
									array(
											'sesi' => '15:00 - 	17:00',
											'mapel' => 'Bahasa Inggris',
											'ruang' => 'Ruang B 1',
											'pengajar' => 'Agus Purnomo',
										),
								),
							'rabu' => array(),
							'kamis' => array(
									array(
											'sesi' => '15:00 - 	17:00',
											'mapel' => 'Potensi Akademik',
											'ruang' => 'Ruang A 3',
											'pengajar' => 'Agus Purnomo',
										),
								),
							'jumat' => array(),
							'sabtu' => array(),
							'minggu' => array(),
						);
					echo json_encode(array('status' => true, 'message' => 'Success', 'data' => $data));
				break;

				case 'pengajar':
					$data = array(
							'senin' => array(
									array(
											'sesi' => '10:00 - 	11:00',
											'mapel' => 'Potensi Akademik',
											'ruang' => 'Ruang C 3',
										),
									array(
											'sesi' => '11:00 - 	12:00',
											'mapel' => 'Potensi Akademik',
											'ruang' => 'Ruang C 3',
										),
									array(
											'sesi' => '13:00 - 	14:00',
											'mapel' => 'Potensi Akademik',
											'ruang' => 'Ruang C 3',
										),
									array(
											'sesi' => '15:00 - 	17:00',
											'mapel' => 'Potensi Akademik',
											'ruang' => 'Ruang A 3',
										),
								),
							'selasa' => array(
									array(
											'sesi' => '15:00 - 	17:00',
											'mapel' => 'Bahasa Inggris',
											'ruang' => 'Ruang B 1',
										),
								),
							'rabu' => array(),
							'kamis' => array(
									array(
											'sesi' => '15:00 - 	17:00',
											'mapel' => 'Potensi Akademik',
											'ruang' => 'Ruang A 3',
										),
								),
							'jumat' => array(),
							'sabtu' => array(),
							'minggu' => array(),
						);
					echo json_encode(array('status' => true, 'message' => 'Success', 'data' => $data));
				break;

				default:
					echo json_encode(array('status' => false, 'message' => 'Tipe invalid!'));
				break;
			}
		}
		else{
			echo json_encode(array('status' => false, 'message' => 'Token invalid!'));
		}
	}

	public function nilai()
	{
		header('Content-Type: application/json');
		$tokens = $this->input->server('HTTP_X_APP_INFINITY',true);
		if($tokens != null && $this->api->cekTokens($tokens)){
			$data = array(
					array(	
							'bidang' => 'Tes Potensi Akademik',
							'jenis' => 'Try Out 1',
							'nilai' => 90,
						),
					array(	
							'bidang' => 'Tes Potensi Akademik',
							'jenis' => 'Try Out 2',
							'nilai' => 90,
						),
					array(	
							'bidang' => 'Tes Bahasa Inggris',
							'jenis' => 'Try Out 1',
							'nilai' => 80,
						),
				);
			echo json_encode(array('status' => true, 'message' => 'Success', 'data' => $data));
		}
		else{
			echo json_encode(array('status' => false, 'message' => 'Token invalid!'));
		}
	}

	public function pembayaran()
	{
		header('Content-Type: application/json');
		$tokens = $this->input->server('HTTP_X_APP_INFINITY',true);
		if($tokens != null && $this->api->cekTokens($tokens)){
			$data = $this->api->getDataToken();
			$bayar = $this->api->getPembayaran($data['email']);
			$cicilan = $this->api->getPembayaranCicilan($bayar['id_pembayaran']);

			if(!empty($cicilan)){
				$dataCicilan = array();
				$i = 1;
				foreach($cicilan as $row){
					$dataCicilan[] = array(
							'no' => $i,
							'nominal' => $row['nominal'],
							'tanggal' => $row['tgl'],
						);
					$i++;
				}
			}
			else{
				$dataCicilan = null;
			}

			echo json_encode(array(
					'status' => true, 
					'message' => 'Success', 
					'data' => array(
						'request_pembayaran' => $this->api->getPembayaranKhusus($data['email']),
						'harus_dibayar' => $bayar,
						'cicilan' => $dataCicilan
					)
				));
		}
		else{
			echo json_encode(array('status' => false, 'message' => 'Token invalid!'));
		}

	}

	public function list_pengumuman()
	{
		header('Content-Type: application/json');
		$tokens = $this->input->server('HTTP_X_APP_INFINITY',true);
		if($tokens != null && $this->api->cekTokens($tokens)){
			$data = $this->api->getListPengumuman();
			echo json_encode(array('status' => true, 'message' => 'Success', 'data' => $data));
		}
		else{
			echo json_encode(array('status' => false, 'message' => 'Token invalid!'));
		}
	}

	public function detail_pengumuman()
	{
		header('Content-Type: application/json');
		$tokens = $this->input->server('HTTP_X_APP_INFINITY',true);
		$id = $this->input->get('pengumuman',true);
		if($tokens != null && $this->api->cekTokens($tokens)){
			$row = $this->api->getDetailPengumuman($id);
			if(!empty($row)){
				$data = array(
						'judul' => $row['judul'],
						'isi' => $row['isi'],
						'foto' => ($row['foto']!='')?base_url('assets/img/pengumuman/'.$row['foto']):null,
						'tanggal' => $row['tgl'],
					);
				echo json_encode(array('status' => true, 'message' => 'Success', 'data' => $data));
			}
			else{
				echo json_encode(array('status' => false, 'message' => 'No Data Found!'));
			}
		}
		else{
			echo json_encode(array('status' => false, 'message' => 'Token invalid!'));
		}
	}

	public function list_contact()
	{
		header('Content-Type: application/json');
		$tokens = $this->input->server('HTTP_X_APP_INFINITY',true);
		if($tokens != null && $this->api->cekTokens($tokens)){
			$data = $this->api->getDataToken();
			echo json_encode(array(
					'status' => true, 
					'message' => 'Success', 
					'data' => $this->api->getListContact($data['email'])
				));
		}
		else{
			echo json_encode(array('status' => false, 'message' => 'Token invalid!'));
		}
	}

	public function chats()
	{
		header('Content-Type: application/json');
		$tokens = $this->input->server('HTTP_X_APP_INFINITY',true);
		$id = $this->input->get('user',true);
		if($tokens != null && $this->api->cekTokens($tokens)){
			$data = $this->api->getDataToken();
			$chats = $this->api->getChats($data['id'],$id);

			if(!empty($chats)){
				$hasil = array();
				$update = array();
				foreach($chats as $chat){
					if($chat['status'] == '0'){
						array_push($update, array(
								'id_chat' => $chat['id_chat'],
								'status' => '1',
							));
					}

					$hasil[] = array(
							'jenis' => ($chat['jenis']=='1')?'you':'stranger',
							'waktu' => $chat['waktu'],
							'text' => $chat['text'],
						);
				}

				if(!empty($update)){
					$this->api->updateStatusChat($update);			
				}
			}
			else{
				$hasil = NULL;
			}

			echo json_encode(array(
					'status' => true, 
					'message' => 'Success',
					'data' => $hasil
				));
		}
		else{
			echo json_encode(array('status' => false, 'message' => 'Token invalid!'));
		}
	}

	public function chat()
	{
		header('Content-Type: application/json');
		$tokens = $this->input->server('HTTP_X_APP_INFINITY',true);
		$id = $this->input->get('user',true);
		if($tokens != null && $this->api->cekTokens($tokens)){
			$data = $this->api->getDataToken();
			$chats = $this->api->getChat($data['id'],$id);

			if(!empty($chats)){
				$hasil = array();
				$update = array();
				foreach($chats as $chat){
					if($chat['status'] == '0'){
						array_push($update, array(
								'id_chat' => $chat['id_chat'],
								'status' => '1',
							));
					}

					$hasil[] = array(
							'jenis' => ($chat['jenis']=='1')?'you':'stranger',
							'waktu' => $chat['waktu'],
							'text' => $chat['text'],
						);
				}

				if(!empty($update)){
					$this->api->updateStatusChat($update);			
				}
			}
			else{
				$hasil = NULL;
			}

			echo json_encode(array(
					'status' => true, 
					'message' => 'Success',
					'data' => $hasil
				));
		}
		else{
			echo json_encode(array('status' => false, 'message' => 'Token invalid!'));
		}
	}

	public function send_message()
	{
		header('Content-Type: application/json');
		$tokens = $this->input->server('HTTP_X_APP_INFINITY',true);
		$id = $this->input->post('user',true);
		$pesan = $this->input->post('pesan',true);
		if($tokens != null && $this->api->cekTokens($tokens)){
			$data = $this->api->getDataToken();
			if(!empty($pesan)){
				$data = array(
						'id_chat' => '',
						'time' => date('Y-m-d H:i:s'),
						'id_user' => $id,
						'id_user_app' => $data['id'],
						'text' => $pesan,
						'jenis' => '1',
						'status' => '0',
					);

				if($this->api->sendMessage($data)){
					echo json_encode(array('status' => true, 'message' => 'Success Send Mesaage'));
				}
				else{
					echo json_encode(array('status' => false, 'message' => 'Failed Send Message'));
				}
			}
			else{
				echo json_encode(array('status' => false, 'message' => 'Empty Message!'));
			}
		}
		else{
			echo json_encode(array('status' => false, 'message' => 'Token invalid!'));
		}
	}

	public function scan_absensi()
	{
		header('Content-Type: application/json');
		$tokens = $this->input->server('HTTP_X_APP_INFINITY',true);
		if($tokens != null && $this->api->cekTokens($tokens)){
			$data = $this->api->getDataToken();
			$qrCode = $this->input->post('code',true);
			if($this->api->doAbsen($data['email'],$qrCode)){
				echo json_encode(array('status' => true, 'message' => 'Success to attend'));				
			}
			else{
				echo json_encode(array('status' => false, 'message' => 'Unable to attend!'));
			}
		}
		else{
			echo json_encode(array('status' => false, 'message' => 'Token invalid!'));
		}
	}

}