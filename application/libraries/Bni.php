<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Bni {
    private $CI;
    private $bniUrl;
    private $clientId;
    private $secretKey;
    private $expiredVA;

    const TIME_DIFF_LIMIT = 480;
    const BILLING_TYPE = array(
        'fixed' => 'c',
        'partial' => 'i'
    );
    
    public function __construct() {
        $this->CI =& get_instance();
        $this->bniUrl = $this->CI->config->item('bni_url_dev');
        $this->clientId = $this->CI->config->item('client_id');
        $this->secretKey = $this->CI->config->item('secret_key');
        $this->expiredVA = $this->CI->config->item('expired_va');
    }

    public function generateVA($nis, $total) {
        $row = $this->getByNis($nis);
        if (! isset($row)) return array( 'status' => false, 'message' => 'NIS tidak ditemukan' );
        $dataBody = array(
            'type' => 'createbilling',
            'client_id' => $this->clientId,
            'trx_id' => $row->nis,
            'trx_amount' => $total,
            'billing_type' => self::BILLING_TYPE['partial'],
            'customer_name' => $row->nama,
            'customer_email' => $row->email,
            'customer_phone' => $row->no_hp,
            'datetime_expired' => date('c', time() + 24 * 3600 * $this->expiredVA)
        );
        $hashString = self::encrypt($dataBody, $this->clientId, $this->secretKey);
        $data = array(
            'client_id' => $this->clientId,
            'data' => $hashString
        );
        $res = $this->request($this->bniUrl, json_encode($data));
        $resJson = json_decode($res, true);
        if ($resJson['status'] === '105') return array( 'status' => false, 'message' => 'VA sudah ada & tidak bisa generate' );
        if ($resJson['status'] !== '000') return array( 'status' => false, 'message' => 'Terjadi kesalahan' );

        $dataRes = self::decrypt($resJson['data'], $this->clientId, $this->secretKey);

        return array( 'status' => true, 'va' => $dataRes['virtual_account'] );
    }

    public function getVA($nis) {
        $dataBody = array(
            'type' => 'inquirybilling',
            'client_id' => $this->clientId,
            'trx_id' => $nis
        );
        $hashString = self::encrypt($dataBody, $this->clientId, $this->secretKey);
        $data = array(
            'client_id' => $this->clientId,
            'data' => $hashString
        );
        $res = $this->request($this->bniUrl, json_encode($data));
        $resJson = json_decode($res, true);
        if ($resJson['status'] === '101') return array( 'status' => false, 'message' => 'NIS tidak ditemukan' );
        if ($resJson['status'] !== '000' ) return array( 'status' => false, 'message' => 'Terjadi kesalahan' );

        $dataRes = self::decrypt($resJson['data'], $this->clientId, $this->secretKey);

        return array( 'status' => true, 'va' => $dataRes['virtual_account'] );
    }

    public function encryptData($data) {
        $hashString = self::encrypt($data, $this->clientId, $this->secretKey);
        return $hashString;
    }

    public function decryptData($data) {
        $dataRes = self::decrypt($data, $this->clientId, $this->secretKey);
        return $dataRes;
    }

    private function getByNis($nis) {
        $query = $this->CI->db->select('nis, virtual_account, nama, email, no_hp')
            ->where('nis', $nis)
            ->limit(1)
            ->get('siswa');
        $row = $query->row();
        return $row;
    }

    private function request($url, $post = '') {
        $usecookie = __DIR__ . "/cookie.txt";
        $header[] = 'Content-Type: application/json';
        $header[] = "Accept-Encoding: gzip, deflate";
        $header[] = "Cache-Control: max-age=0";
        $header[] = "Connection: keep-alive";
        $header[] = "Accept-Language: en-US,en;q=0.8,id;q=0.6";
    
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        // curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);
    
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36");
    
        if ($post)
        {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }
    
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
        $rs = curl_exec($ch);
    
        if(empty($rs)){
            var_dump($rs, curl_error($ch));
            curl_close($ch);
            return false;
        }
        curl_close($ch);
        return $rs;
    }

    private static function encrypt(array $json_data, $cid, $secret) {
        return self::doubleEncrypt(strrev(time()) . '.' . json_encode($json_data), $cid, $secret);
    }

    private static function decrypt($hased_string, $cid, $secret) {
        $parsed_string = self::doubleDecrypt($hased_string, $cid, $secret);
        list($timestamp, $data) = array_pad(explode('.', $parsed_string, 2), 2, null);
        if (self::tsDiff(strrev($timestamp)) === true) {
            return json_decode($data, true);
        }
        return null;
    }

    private static function tsDiff($ts) {
        return abs($ts - time()) <= self::TIME_DIFF_LIMIT;
    }

    private static function doubleEncrypt($string, $cid, $secret) {
        $result = '';
        $result = self::enc($string, $cid);
        $result = self::enc($result, $secret);
        return strtr(rtrim(base64_encode($result), '='), '+/', '-_');
    }

    private static function enc($string, $key) {
        $result = '';
        $strls = strlen($string);
        $strlk = strlen($key);
        for($i = 0; $i < $strls; $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % $strlk) - 1, 1);
            $char = chr((ord($char) + ord($keychar)) % 128);
            $result .= $char;
        }
        return $result;
    }

    private static function doubleDecrypt($string, $cid, $secret) {
        $result = base64_decode(strtr(str_pad($string, ceil(strlen($string) / 4) * 4, '=', STR_PAD_RIGHT), '-_', '+/'));
        $result = self::dec($result, $cid);
        $result = self::dec($result, $secret);
        return $result;
    }

    private static function dec($string, $key) {
        $result = '';
        $strls = strlen($string);
        $strlk = strlen($key);
        for($i = 0; $i < $strls; $i++) {
            $char = substr($string, $i, 1);
            $keychar = substr($key, ($i % $strlk) - 1, 1);
            $char = chr(((ord($char) - ord($keychar)) + 256) % 128);
            $result .= $char;
        }
        return $result;
    }
}