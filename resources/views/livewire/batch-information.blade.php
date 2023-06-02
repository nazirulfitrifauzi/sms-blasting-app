<div>
    <p>Pending Jobs: {{ $batch->pendingJobs }}</p>
    <p>Failed Jobs: {{ $batch->failedJobs }}</p>
    <p>Processed Jobs: {{ $batch->processedJobs }}</p>
</div>

@wirePoll('pollBatchInformation', ['batchId' => $batch->id])