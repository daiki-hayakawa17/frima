<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TradeCompleteNotice extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $item;
    public $purchaser;

    public function __construct($item, $purchaser)
    {
        $this->item = $item;
        $this->purchaser = $purchaser;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject("{$this->item->name}の取引が完了されました")
                    ->view('emails.trade_mail');
    }
}
