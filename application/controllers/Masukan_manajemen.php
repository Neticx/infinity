<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Masukan_manajemen extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function add()
	{
		$data = array(
				'title' => 'Berikan Masukan Manajemen',
			);
		$this->_render('masukan_manajemen/add_masukan',$data);
	}

	public function daftar_masukan()
	{
		$data = array(
				'title' => 'Daftar Masukan Manajemen',
			);
		$this->_render('masukan_manajemen/daftar_masukan',$data);
	}

	public function list_data()
	{}

}