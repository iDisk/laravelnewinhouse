<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotificationMail extends Mailable
{

    use Queueable,
        SerializesModels;

    public $template = '';
    public $subject  = '';
    public $data     = array();

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($template, $subject, $data)
    {
        $this->template = $template;
        $this->subject  = $subject;
        $this->data     = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $view         = \View::make($this->template, ['data' => $this->data]);
        $page_content = $view->render();

        return $this->markdown('notifications.base')
                        ->subject($this->subject)
                        ->with(['page_content' => $page_content]);
    }

}
