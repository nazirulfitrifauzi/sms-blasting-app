<?php

namespace App\Classes\Notification;

use Illuminate\Support\Facades\Log;

class Sms
{
    private $url;
    private $api_key;
    private $api_secret;

    public function __construct()
    {
        $this->url = config('app.esms_api_url');
        $this->api_key = config('app.esms_api_key');
        $this->api_secret = config('app.esms_api_secret');
    }

    public function bulk($phone_no, $msg_txt)
    {
        $contact = "6" . $phone_no;
        Log::info('Preparing to send SMS to ' . $contact);
        return $this->send($contact, $msg_txt);
    }

    private function send($contact, $message)
    {
        $data = [
            'user' => $this->api_key,
            'pass' => $this->api_secret,
            'to' => $contact,
            'msg' => $message,
            'type' => 0,
        ];

        Log::info('Sending SMS with data: ' . json_encode($data));

        try {
            $options = [
                'http' => [
                    'header'  => "Content-type: application/x-www-form-urlencoded; charset=utf-8",
                    'method'  => 'POST',
                    'content' => http_build_query($data),
                ],
            ];

            $context  = stream_context_create($options);
            $result = file_get_contents($this->url, false, $context);

            if ($result === FALSE) {
                Log::error('Failed to send SMS');
                return;
            }

            Log::info('SMS sent. Response: ' . $result);
            return $result;
        } catch (\Exception $e) {
            Log::error('Error sending SMS: ' . $e->getMessage());
        }
    }

}
