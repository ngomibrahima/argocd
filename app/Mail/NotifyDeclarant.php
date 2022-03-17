<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyDeclarant extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($declaration, $reponse, $admin)
    {
        $this->subject("Déclaration de Cadeau ou d'Invitation");
        $this->declaration = $declaration;
        $this->reponse = $reponse;
        $this->admin = $admin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('cadeau.declarant-notification', ['declaration' => $this->declaration, 'reponse' => $this->reponse, 'admin' => $this->admin]);
    }
}
