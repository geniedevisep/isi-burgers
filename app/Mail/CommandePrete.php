<?php

namespace App\Mail;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CommandePrete extends Mailable
{
    use Queueable, SerializesModels;

    public $commande;
    public $pdf;

    public function __construct(Commande $commande, $pdf)
    {
        $this->commande = $commande;
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->subject('Votre commande ISI BURGER est prête !')
                    ->view('emails.commande-prete')
                    ->attachData($this->pdf->output(), 'facture.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
} 