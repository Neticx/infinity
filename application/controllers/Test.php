<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('Bni');
        
    }

    public function generate() {
        $httpMethod = $this->input->server('REQUEST_METHOD');
        if ($httpMethod !== 'POST') return $this->resSend(405, 'Method Not Allowed');

        $streamClean = $this->security->xss_clean($this->input->raw_input_stream);
        $req = json_decode($streamClean);

        $nis = $req->nis;
        $data = $this->bni->generateVA($nis, 500000);

        return $this->resSend(200, '', $data);
    }

    public function get() {
        $httpMethod = $this->input->server('REQUEST_METHOD');
        if ($httpMethod !== 'POST') return $this->resSend(405, 'Method Not Allowed');

        $streamClean = $this->security->xss_clean($this->input->raw_input_stream);
        $req = json_decode($streamClean);

        $nis = $req->nis;
        $data = $this->bni->getVA($nis);

        return $this->resSend(200, '', $data);
    }

    private function resSend($status, $message = '', $data = '') {
        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(
                json_encode(array(
                    'status' => $status,
                    'message' => $message,
                    'data' => $data
                ))
            );
    }

}

?>