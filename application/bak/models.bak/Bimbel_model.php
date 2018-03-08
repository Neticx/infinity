<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bimbel_model extends CI_Model {

	private $dataProgram = array();

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Log_model','logData',true);
	}

	public function cekIdProgram($id)
	{
		$query = $this->db->select('*')
							->where('id_program',$id)
							->limit(1)
							->get('program');
		if($query->num_rows() == 1){
			$this->dataProgram = $query->row_array();
			return true;
		}
		else{
			return false;
		}
	}

	public function getDataProgram()
	{
		return $this->dataProgram;
	}

	public function getProgram()
	{
		$query = $this->db->select('*')
							->get('program');
		return $query->result_array();
	}

	public function insertProgram($data = array())
	{
		$this->db->insert('program', $data);

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','insert',$this->db->last_query());
			return true;
		}
		else{
			$this->logData->insertLogData('error','insert',$this->db->last_query());
			return false;
		}
	}

	public function updateProgram($data = array())
	{
		$query = $this->db->select('*')->where('id_program',$data['id_program'])->limit(1)->get('program')->row_array();
		$this->db->where('id_program',$data['id_program'])->update('program', $data);

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','update',$this->db->last_query());
			$this->logData->tmpLogData('program', json_encode($query));
			return true;
		}
		else{
			$this->logData->insertLogData('error','update',$this->db->last_query());
			return false;
		}
	}

	public function deleteProgram($id)
	{
		$query = $this->db->select('*')->where('id_program',$id)->limit(1)->get('program')->row_array();
		$this->db->where('id_program',$id)->delete('program');

		if($this->db->affected_rows() == 1){
			$this->logData->insertLogData('success','delete',$this->db->last_query());
			$this->logData->tmpLogData('program', json_encode($query));
			return true;
		}
		else{
			$this->logData->insertLogData('error','delete',$this->db->last_query());
			return false;
		}
	}

}