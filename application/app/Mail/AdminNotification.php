<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($admin, $cadeau)
    {
        $this->subject("Déclaration en attente d'approbation");
        $this->admin = $admin;
        $this->cadeau = $cadeau;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('cadeau.admin-notification', ['admin' => $this->admin, 'cadeau' => $this->cadeau]);
    }
}
