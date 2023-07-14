<?php


namespace App\Traits;


use Ghasedak\GhasedakApi;

trait SendSmsTrait
{
    public function sendSms($number,$message){
        $api = new GhasedakApi(env('GHASEDAKAPI_KEY'));
        $api->Verify(
            "$number",
            "1",
            env('GHASEDAKAPI_PATTERN'),
            implode(',',$message)
        );
    }
}
