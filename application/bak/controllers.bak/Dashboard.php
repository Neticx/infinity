<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data = array(
				'title' => 'Dashboard',
				);
		$this->_render('dashboard/dashboard',$data);
	}

}