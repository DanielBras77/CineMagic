<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PurchaseReceipt extends Mailable
{
    use Queueable, SerializesModels;

    protected $file_path;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($file_path)
    {
        $this->file_path = $file_path;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Purchase Receipt')->view('emails.purchase_receipt')
                    ->attach($this->file_path, [
                        'as' => 'receipt.pdf',
                        'mime' => 'application/pdf',
                    ]);
    }
}
