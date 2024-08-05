<?php

namespace App\Jobs;

use App\Mail\CustomWorkerMail;
use App\Models\WorkersMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    // public $subject;
    // public $recipient;
    // public $body;
    // public $sender;
    public function __construct(public WorkersMail $workersMail)
    {
        // $this->subject=$subject;
        // $this->recipient=$recipient;
        // $this->body=$body;
        // $this->sender=$sender;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Mail::to($this->recipient)->send(new CustomWorkerMail(
        //     $this->subject,$this->body,$this->recipient,$this->sender
        // ));


        Mail::to($this->workersMail->recipient)->send(new CustomWorkerMail($this->workersMail));

    }
}
