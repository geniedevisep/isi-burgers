<?php

namespace App\Mail;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommandeConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public $commande;

    public function __construct(Commande $commande)
    {
        $this->commande = $commande;
    }

    public function build()
    {
        return $this->subject('Confirmation de votre commande ISI BURGER #' . $this->commande->id)
                    ->view('emails.commande-confirmation');
    }
} 