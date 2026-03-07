<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentReceivedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $document;
    public $pdfContent;

    public function __construct($document, $pdfContent)
    {
        $this->document = $document;
        $this->pdfContent = $pdfContent;
    }

    public function build()
    {
        return $this->view('emails.payment_received')
                    ->subject('Payment Received - Thank You! (#' . $this->document->doc_number . ')')
                    ->attachData($this->pdfContent, $this->document->doc_number . '.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
