<div>
    @if($uploadStatus === 'Processed')
        <h3>Upload Status: {{ $uploadStatus }}</h3>
        <p>Batch ID: {{ $batchId }}</p>
        @if($batch)
            <div class="relative pt-1">
                <div style="width:{{ $batch->progress() * 100 }}%"
                    class="flex flex-col justify-center text-center text-white bg-pink-500 shadow-none whitespace-nowrap">
                </div>
            </div>
            <p>Total Jobs: {{ $batchId }}</p>
            <p>Pending Jobs: {{ $batch->pendingJobs }}</p>
            <p>Failed Jobs: {{ $batch->failedJobs }}</p>
            <p>Processed Jobs: {{ $batch->processedJobs }}</p>
        @endif
    @endif

    <form wire:submit.prevent="uploadFile">
        <input type="file" wire:model="file">
        @error('file') <span class="error">{{ $message }}</span> @enderror
        <button type="submit">Upload and Process File</button>
    </form>
</div>