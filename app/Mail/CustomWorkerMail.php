<?php

namespace App\Mail;

use App\Models\WorkersMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomWorkerMail extends Mailable
{
    use Queueable, SerializesModels;

    // public $subject;
    // public $body;
    // public $recipient;
    // public $sender;
    /**
     * Create a new message instance.
     */
    public function __construct(public WorkersMail $workersMail)
    {
    //    $this->subject=$subject;
    //    $this->body=$body;
    //    $this->recipient=$recipient;
    //    $this->sender=$sender;
    }
    public function build()
    {
        // return $this->to($this->recipient)
        //             ->subject($this->subject)
        //             ->from($this->sender)
        //             ->view('mail.custom')
        //             ->with(['body' => $this->body]);
        return $this->to($this->workersMail->recipient)
        ->subject($this->workersMail->subject)
        ->from($this->workersMail->sender)
        ->view('mail.mailsent')
        ->with(['body' => $this->workersMail->body,'subject'=>$this->workersMail->body
    ]);
    }
    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */

     public function content():Content{
        return new Content(
            view: 'mail.mailsent',
        );
     }
    public function attachments(): array
    {
        return [];
    }
}
