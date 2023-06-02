<?php

namespace App\Jobs;

use App\Classes\Notification\Sms;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendSmsJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $phone_number;
    protected $msg;

    public function __construct($phone_number, $msg)
    {
        $this->phone_number = $phone_number;
        $this->msg = $msg;
    }

    public function handle()
    {
        usleep(100000);
        // Log::info('Handling SendSmsJob for phone number: ' . $this->phone_number);

        try {
            // $sms = new Sms();
            // $sms->bulk($this->phone_number, $this->msg);

            Log::info('Successfully sent SMS to : ' . $this->phone_number);
        } catch (\Exception $e) {
            Log::error('Failed to send SMS: ' . $e->getMessage());
        }
    }

}
