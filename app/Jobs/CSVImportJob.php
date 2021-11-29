<?php

namespace App\Jobs;

use App\Helpers\ContactArrayHelper;
use App\Helpers\ContactHelper;
use App\Mail\CSVFileProcessed;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class CSVImportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private string $filePath;
    private string $source;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $filePath, string $source)
    {
        $this->filePath = $filePath;
        $this->source = $source;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $array = ContactArrayHelper::csvToArray(Storage::path($this->filePath));
        $batch = time();

        foreach ($array as $a){
            $processed = new ContactHelper($a, $batch, $this->source);
            $processed->filterContact();
            unset($processed);
        }
        /** Can also be broadcast to slack **/
        // Notification::send($users, new SendSlackNotification($batch, $this->filePath));

        Mail::mailer('log')
            ->to('dre.board@example.com')
            ->send(new CSVFileProcessed($batch));

        Log::info(__CLASS__. ' processing job for '.$this->filePath);

    }
}
