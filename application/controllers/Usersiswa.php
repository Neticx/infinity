<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Usersiswa extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data = array(
				'title' => 'Daftar User Siswa dan Orang Tua'
			);
		$this->_render('user_siswa/daftar',$data);
	}

}