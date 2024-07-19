<?php

namespace App\Services;

use App\Models\WebsiteConf;
use Carbon\Carbon;

class TokopayService{
    private $apiUrl;
    private $apiKey;
    private $secretKey;

    public function __construct()
    {
        $this->apiKey = WebsiteConf::where('conf_key', 'tokopay_api')->first()->conf_value;
        $this->secretKey = WebsiteConf::where('conf_key','tokopay_secret')->first()->conf_value;
        $this->apiUrl = "https://api.tokopay.id";
    }

    public function generateSignature($refId){
        $formula = $this->apiKey.":".$this->secretKey.":".$refId;
        $signatureTrx = md5($formula);
        return $signatureTrx;
    }

    public function getSignature(){
        $formula = $this->apiKey.":".$this->secretKey;
        return md5($formula);
    }

    public function createOrder($nominal, $method, $invoice){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->apiUrl."/v1/order?merchant=$this->apiKey&secret=$this->secretKey&ref_id=$invoice&nominal=$nominal&metode=$method",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function createAdvanceOrder($send){
        $curl = curl_init();       

        if(auth()->check()){
            $user = auth()->user();
            $customer = [
                'username' => $user->username,
                'phone' => $user->no_telp,
                'email' => $user->email
            ];
        }

        $data = [
            'merchant_id' => $this->apiKey,
            'kode_channel' => $send['kode_channel'],
            'reff_id' => $send['invoice'],
            'amount' => intval($send['amount']),
            'customer_name' => $customer['username'],
            'customer_email' => $customer['email'],
            'customer_phone' => $customer['phone'],
            'redirect_url' => url(),
            'expired_ts' => Carbon::now()->addHours(24)->timestamp,
            'signature' => $this->generateSignature($send['invoice']),
            'items' => [
                'product_code' => $send['id'],
                'name' => $send['product_name'],
                'price' => intval($send['amount']),
                'product_url' => NULL,
                'image_url' => NULL
            ]
        ];

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->apiUrl.'/v1/order',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded',
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function getProfile()
    {
        $data = [
            'merchant_id' => $this->apiKey,
            'signature' => $this->getSignature()
        ];
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->apiUrl.'/v1/merchant',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>json_encode($data),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return json_decode($response);
    }
}