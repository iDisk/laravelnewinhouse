<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class GeneralMail extends Mailable
{
    use Queueable, SerializesModels;

    public $template = '';
    public $subject = '';
    public $mail_data = array();    

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($template, $subject, $mail_data)
    {
        $this->template = $template;
        $this->subject = $subject;
        $this->mail_data = $mail_data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view($this->template)
                ->subject($this->subject)
                ->with([
                    'mail_data' => $this->mail_data,
                ]);
    }
}
