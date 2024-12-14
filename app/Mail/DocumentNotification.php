<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DocumentNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $document;

    /**
     * Create a new message instance.
     *
     * @param $document
     */
    public function __construct($document)
    {
        $this->document = $document;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.document_notification')
                    ->with([
                        'documentTitle' => $this->document->title,
                        'documentSender' => $this->document->sender,
                    ]);
    }
}
