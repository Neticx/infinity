<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log_model extends CI_Model {

	private $idLogData = NULL;

	public function __construct()
	{
		parent::__construct();
	}

	public function insertLogData($status, $type, $str)
	{
		$data = array(
				'id_log_data' => '',
				'status' => $status,
				'log_data' => $str,
				'id_user' => $this->session->userdata('id_user'),
				'tanggal' => date('Y-m-d H:i:s'),
				'ip' => $this->input->server('REMOTE_ADDR'),
				'device' => $this->agent->platform(),
				'agent' => $this->agent->agent_string(),
				'type' => $type,
			);
		$this->db->insert('log_data', $data);
		$this->idLogData = $this->db->insert_id();
	}

	public function tmpLogData($table, $str)
	{
		$data = array(
				'id_tmp_data' => '',
				'nama_table' => $table,
				'tmp' => $str,
				'id_log_data' => $this->idLogData,
				'tanggal' => date('Y-m-d H:i:s'),
			);
		$this->db->insert('tmp_data', $data);
	}

}