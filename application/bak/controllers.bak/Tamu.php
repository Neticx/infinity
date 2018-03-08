<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tamu extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data = array(
				'title' => 'Tamu Bimbel Infinity',
			);
		$this->_render('tamu/daftar_tamu');
	}

	public function add()
	{
		$data = array(
				'title' => 'Form Buku Tamu',
			);
		$this->_render('tamu/form_tamu',$data);
	}

}