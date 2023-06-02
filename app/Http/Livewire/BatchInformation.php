<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;

class BatchInformation extends Component
{
    public $batchId;

    public function mount($batchId)
    {
        $this->batchId = $batchId;
    }

    public function render()
    {
        $batch = Bus::findBatch($this->batchId);

        return view('livewire.batch-information', compact('batch'));
    }

    public function pollBatchInformation()
    {
        $this->emit('$refresh');
    }
}
