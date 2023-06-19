<?php

namespace App\Http\Controllers;

use App\Jobs\SendPdfWablasJob;
use App\Jobs\SendSmsJob;
use App\Jobs\SendVideoWablasJob;
use App\Jobs\SendWablasJob;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Log;
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

    public function processWablas(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:10240', // 10MB Max
        ]);

        $file = $request->file->getRealPath();
        $fastExcel = new FastExcel;
        $rows = $fastExcel->import($file);

        $delayCounter = 0;
        foreach ($rows as $row) {
            if (isset($row['NO_HSET'])) {
                SendWablasJob::dispatch($row['NO_HSET'])->delay(now()->addSeconds($delayCounter));
                // SendPdfWablasJob::dispatch($row['NO_HSET'])->delay(now()->addSeconds($delayCounter));
                // SendVideoWablasJob::dispatch($row['NO_HSET'])->delay(now()->addSeconds($delayCounter));
            }
        }
    }
}
