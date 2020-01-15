<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BienvenidoMail extends Mailable
{
    use Queueable, SerializesModels;


    public $name;
    public $usuario;
    public $contrasena;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name,$usuario,$contrasena)
    {
        //
        $this->name = $name;
        $this->usuario = $usuario;
        $this->contrasena = $contrasena;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(__('sistema.controller_user.user_mail_new'))
                    ->view('emails.nuevo');
    }
}
