<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	public function get_menu($id)
	{
		return $this->db->select('*')
						->where('id_menu',$id)
						->limit(1)
						->get('menu')
						->row_array();
	}

	public function get_sub_menu($id)
	{}

}