<?php

namespace App\Jobs;

use App\Classes\Notification\Whatsapp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendVideoWablasJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $phone;

    public function __construct($phone)
    {
        $this->phone = $phone;
    }


    public function handle()
    {
        $whatsapp = new Whatsapp();
        $whatsapp->sendVideo($this->phone, "https://cscabs.net.my/media/datomusvid.mp4");
    }
}
