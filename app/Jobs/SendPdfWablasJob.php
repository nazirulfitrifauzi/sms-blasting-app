<?php

namespace App\Jobs;

use App\Classes\Notification\Whatsapp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendPdfWablasJob implements ShouldQueue
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
        $whatsapp->sendPdf($this->phone, "https://cscabs.net.my/media/Dato_Mus.pdf");
    }
}
