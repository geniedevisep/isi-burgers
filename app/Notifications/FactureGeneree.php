<?php

namespace App\Notifications;

use App\Models\Paiement;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class FactureGeneree extends Notification
{
    use Queueable;

    protected $paiement;
    protected $pdf;

    public function __construct(Paiement $paiement, $pdf)
    {
        $this->paiement = $paiement;
        $this->pdf = $pdf;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Facture de votre commande #' . $this->paiement->commande_id)
            ->greeting('Bonjour ' . $notifiable->name . '!')
            ->line('Merci pour votre paiement.')
            ->line('Vous trouverez votre facture en pièce jointe.')
            ->attachData($this->pdf->output(), 'facture-' . $this->paiement->id . '.pdf')
            ->action('Voir mes commandes', route('client.commandes.index'))
            ->line('Merci de votre confiance!');
    }

    public function toArray($notifiable)
    {
        return [
            'paiement_id' => $this->paiement->id,
            'commande_id' => $this->paiement->commande_id,
            'message' => 'Facture générée pour la commande #' . $this->paiement->commande_id
        ];
    }
}
