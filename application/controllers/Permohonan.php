<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Permohonan extends MY_Controller {
	// Page Cetak
	public function izin($typeIzin)
	{	
        if ($typeIzin == "permohonan_izin") {
            $data = array(
                'title' => 'Permohonan Izin ',
            );

            $this->_render("permohonan/izin/permohonan_izin",$data);
        }elseif ($typeIzin == "izin_tidak_masuk_kerja"){
            $data = array(
                'title' => 'Permohonan Izin ',
            );

            $this->_render("permohonan/izin/izin_tidak_masuk_kerja",$data);
        }elseif ($typeIzin == "izin_terlambat"){
            $data = array(
                'title' => 'Permohonan Izin ',
            );

            $this->_render("permohonan/izin/izin_terlambat",$data);
        }elseif ($typeIzin == "izin_pulang_awal"){
            $data = array(
                'title' => 'Permohonan Izin ',
            );

            $this->_render("permohonan/izin/izin_pulang_awal",$data);
        }
		
	}
}