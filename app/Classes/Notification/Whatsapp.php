<?php

namespace App\Classes\Notification;

use Illuminate\Support\Facades\Log;

class Whatsapp
{
    private $url;
    private $token;

    public function __construct()
    {
        $this->url = config('app.wablas_api_url');
        $this->token = config('app.wablas_api_token');
    }

    public function send($contact, $message)
    {
        $curl = curl_init();

        $payload = [
            "data" => [
                [
                    'phone' => trim($contact),
                    'message' => $message,
                ],
            ]
        ];

        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                "Authorization: $this->token",
                "Content-Type: application/json"
            )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($curl, CURLOPT_URL, 'https://solo.wablas.com/api/v2/send-message');
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);

        // return json_decode($result)->status;
        Log::info($result);
        return $result;
    }

    public function sendPdf($contact, $document)
    {
        $curl = curl_init();

        $payload = [
            "data" => [
                [
                    'phone' => $contact,
                    'document' => $document,
                ],
            ]
        ];

        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                "Authorization: $this->token",
                "Content-Type: application/json"
            )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($curl, CURLOPT_URL, 'https://solo.wablas.com/api/v2/send-document');
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);

        // return json_decode($result)->status;
        return $result;
    }

    public function sendVideo($contact, $video)
    {
        $curl = curl_init();

        $payload = [
            "data" => [
                [
                    'phone' => $contact,
                    'video' => $video,
                    'caption' => '',
                ],
            ]
        ];

        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            array(
                "Authorization: $this->token",
                "Content-Type: application/json"
            )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($curl, CURLOPT_URL, 'https://solo.wablas.com/api/v2/send-video');
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);

        // return json_decode($result)->status;
        return $result;
    }
}
