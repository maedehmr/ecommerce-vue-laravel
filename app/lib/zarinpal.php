<?php
namespace App\lib;
use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use nusoap_client;
class zarinpal
{
    public $MerchantID;
    public function __construct()
    {
        $merchantID = Setting::where('key' , 'merchantID')->pluck('value')->first();
        $this->MerchantID=$merchantID;
    }
    public function pay($Amount,$Email,$Mobile,$call)
    {
        $Description = 'خرید ';  // Required
        $CallbackURL = url($call); // Required

        $client = new nusoap_client('https://sandbox.zarinpal.com/pg/services/WebGate/wsdl', 'wsdl');
        $client->soap_defencoding = 'UTF-8';
        $result = $client->call('PaymentRequest', [
            [
                'MerchantID'     => $this->MerchantID,
                'Amount'         => $Amount,
                'Description'    => $Description,
                'Email'          => $Email,
                'Mobile'         => $Mobile,
                'CallbackURL'    => $CallbackURL,
            ],
        ]);

        //Redirect to URL You can do it also by creating a form
        if ($result['Status'] == 100) {
            return $result['Authority'];
        } else {
            return false;
        }



    }
}
