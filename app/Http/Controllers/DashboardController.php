<?php

namespace App\Http\Controllers;

use App\Jobs\SendSmsJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Rap2hpoutre\FastExcel\FastExcel;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $batches = null;
        if ($request->has('batches')) {
            $batchIds = unserialize($request->batches);
            $batches = collect($batchIds)->map(function ($batchId) {
                return Bus::findBatch($batchId);
            });
        }

        return view('welcome', compact('batches'));
    }

    public function process(Request $request)
    {
        ini_set('max_execution_time', 300);

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240', // 10MB Max
        ]);

        $msg = 'RM0.00 Kempen CSC HEHEHEHE.';
        $file = $request->file->getRealPath();
        $chunkSize = 2000;

        $batches = [];
        $batchList = $this->processDataInChunks($file, $chunkSize, $msg);

        foreach($batchList as $batch) {
            $batches[] = $batch->id;
        }

        return redirect('/dashboard?batches=' . serialize($batches));
    }

    private function processDataInChunks($file, $chunkSize, $msg)
    {
        $jobs = [];
        $chunk_data = [];
        $count = 0;

        (new FastExcel())->import($file, function ($data) use (&$count, &$chunk_data, $chunkSize, &$jobs, $msg) {
            $chunk_data[] = $data;

            if (++$count % $chunkSize === 0) {
                foreach ($chunk_data as $item) {
                    $jobs[] = new SendSmsJob($item['phone_number'], $msg);
                }
                $chunk_data = []; // Reset chunk data after processing
            }
        });

        // Process remaining chunk data if it exists
        if (!empty($chunk_data)) {
            foreach ($chunk_data as $item) {
                $jobs[] = new SendSmsJob($item['phone_number'], $msg);
            }
        }

        $jobChunks = array_chunk($jobs, 200);  // Adjust this value as needed

        $batches = [];
        foreach ($jobChunks as $chunk) {
            $batches[] = Bus::batch($chunk)
                ->onConnection('database')
                ->onQueue('default')
                ->dispatch();
        }

        return $batches;
    }
}
