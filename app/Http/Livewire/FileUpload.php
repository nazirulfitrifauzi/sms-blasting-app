<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Jobs\SendSmsJob;

class FileUpload extends Component
{
    use WithFileUploads;

    public $file;
    public $uploadStatus;
    public $batchId;
    protected $batch;

    public function uploadFile()
    {
        $this->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240', // 10MB Max
        ]);

        $collection = (new FastExcel)->import($this->file->getRealPath());

        $this->uploadStatus = 'Processing';

        $msg = 'RM0.00 Kempen CSC HEHEHEHE.';

        $jobs = [];
        foreach ($collection as $item) {
            $jobs[] = new SendSmsJob($item['phone_number'], $msg);
        }

        $batch = Bus::batch($jobs)
            ->onConnection('database')
            ->onQueue('default')
            ->dispatch();

        $this->batchId = $batch->id;
        $this->uploadStatus = 'Processed';
    }

    public function render()
    {
        $batch = null;
        if ($this->batchId) {
            $batch = Bus::findBatch($this->batchId);
        }

        return view('livewire.file-upload', [
            'batch' => $batch,
        ]);
    }
}
