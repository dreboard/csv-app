<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CSVFileProcessed extends Mailable
{
    use Queueable, SerializesModels;

    private string $batch;

    /**
     * Create a new message instance.
     *
     * @param string $batch
     */
    public function __construct(string $batch)
    {
        $this->batch = $batch;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('admin@example.com', 'Batch Complete')
            ->view('emails.batch', ['batch' => $this->batch]);
    }
}
