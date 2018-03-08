<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('Bni');
        $this->load->model('Payment_model','payment',true);
    }

    public function callback() {
        header('Content-Type: application/json');
        $reqMethod = $this->input->server('REQUEST_METHOD');
        if ($reqMethod !== 'POST') return $this->resSend('001', 'Bad request');

        $streamClean = $this->security->xss_clean($this->input->raw_input_stream);
        $req = json_decode($streamClean);

        $data = $this->bni->decryptData($req->data);
        if (!$data) return $this->resSend('999', 'Waktu tidak sesuai NTP atau Secret Key salah');

        $paymentId = $this->payment->getIdPayment($data['trx_id']);
        $dataCicilan = array(
            'id_cicilan' => '',
            'id_pembayaran' => $paymentId,
            'nominal' => $data['payment_amount']
        );
        if ($this->payment->insertCicilan($dataCicilan)) return $this->resSend('000');
    }

    private function resSend($status, $message = false) {
        $response = array(
            'status' => $status,
        );
        if ($message) $response['message'] = $message;

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output( json_encode($response) );
    }
}