<?php

namespace App\Jobs;

use App\Classes\Notification\Whatsapp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;


class SendWablasJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $phone;

    public function __construct($phone)
    {
        $this->phone = $phone;
    }


    public function handle()
    {
        $text = "Assalamualaikum dan salam sejahtera Dato-Dato, Tuan Puan, perwakilan ANGKASA ke Mesyuarat Agung Perwakilan ANGKASA kali ke 37 (MAPA 2023) yang akan diadakan secara fizikal dan maya pada 24 Jun 2023 berpusat di Pusat Siaran Utama Auditorium ANGKASA, Wisma Ungku A.Aziz, Kelana Jaya.

Saya dengan rendah hati menawarkan diri bertanding sebagai calon Lembaga ANGKASA pada Mesyuarat Agung Perwakilan ANGKASA kali ke 37 pada tahun ini. Saya memohon Dato-Dato, Tuan-Puan memberi undi kepada saya sebagai Lembaga ANGKASA. InsyaAllah saya akan menunaikan tanggungjawab dengan sebaik mungkin dan membawa ANGKASA terus cermelang di masa-masa hadapan. Terima  kasih.


Dato' (Dr.) Hj. Mustafha Abd Razak
Koperasi Kakitangan Bank Rakyat Berhad
Wilayah Persekutuan
No. Hp: 0197774981";

        $whatsapp = new Whatsapp();
        $whatsapp->send($this->phone, $text);
    }
}
