<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getIdPayment($nis) {
        $query = $this->db->select('id_pembayaran')
            ->where('nis_siswa', $nis)
            ->limit(1)
            ->get('siswa_pembayaran');
        $row = $query->row();
        return $row->id_pembayaran;
    }

    public function insertCicilan($data) {
        $this->db->insert('cicilan', $data);

        if($this->db->affected_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }
}