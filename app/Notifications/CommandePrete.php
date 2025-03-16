<?php

namespace App\Notifications;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CommandePrete extends Notification
{
    use Queueable;

    protected $commande;
    protected $pdf;

    public function __construct(Commande $commande, $pdf)
    {
        $this->commande = $commande;
        $this->pdf = $pdf;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Votre commande #' . $this->commande->id . ' est prête!')
            ->greeting('Bonjour ' . $notifiable->name . '!')
            ->line('Votre commande est prête!')
            ->line('Vous pouvez venir la récupérer à notre restaurant.')
            ->line('Vous trouverez la facture en pièce jointe.')
            ->attachData($this->pdf->output(), 'facture.pdf')
            ->action('Voir ma commande', route('client.commandes.show', $this->commande->id))
            ->line('Merci de votre confiance!');
    }

    public function toArray($notifiable)
    {
        return [
            'commande_id' => $this->commande->id,
            'message' => 'Votre commande #' . $this->commande->id . ' est prête'
        ];
    }
}
