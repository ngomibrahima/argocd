<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyResHie extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($cadeau)
    {
        $this->subject("Déclaration de Cadeau ou d'Invitation");

        $this->cadeau = $cadeau;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('cadeau.res-hierarchique', ['cadeau' => $this->cadeau]);
    }
}
