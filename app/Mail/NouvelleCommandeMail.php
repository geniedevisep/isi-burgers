<?php

namespace App\Mail;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NouvelleCommandeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $commande;

    public function __construct(Commande $commande)
    {
        $this->commande = $commande;
    }

    public function build()
    {
        return $this->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject('Nouvelle commande #' . $this->commande->id . ' - ISI BURGER')
                    ->markdown('emails.nouvelle-commande');
    }
} 