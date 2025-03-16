<?php

namespace App\Notifications;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NouvelleCommande extends Notification
{
    use Queueable;

    protected $commande;

    public function __construct(Commande $commande)
    {
        $this->commande = $commande;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $url = route('gestionnaire.commandes.show', $this->commande->id);

        return (new MailMessage)
            ->subject('Nouvelle commande #' . $this->commande->id)
            ->greeting('Bonjour!')
            ->line('Une nouvelle commande vient d\'être passée.')
            ->line('Commande #' . $this->commande->id . ' - Total: ' . number_format($this->commande->total, 2) . ' €')
            ->action('Voir la commande', $url)
            ->line('Merci d\'y répondre rapidement!');
    }

    public function toArray($notifiable)
    {
        return [
            'commande_id' => $this->commande->id,
            'message' => 'Nouvelle commande #' . $this->commande->id,
            'total' => $this->commande->total
        ];
    }
}
