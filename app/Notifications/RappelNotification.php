<?php

namespace App\Notifications;

use App\Models\Rappel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RappelNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Rappel $rappel)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Rappel d\'entretien - ' . ucfirst($this->rappel->type))
            ->greeting('Bonjour ' . $notifiable->name . ',')
            ->line('Ceci est un rappel pour l\'entretien programmé de votre véhicule.')
            ->line('**Véhicule:** ' . $this->rappel->vehicule->marque . ' ' . $this->rappel->vehicule->modele)
            ->line('**Immatriculation:** ' . $this->rappel->vehicule->immatriculation)
            ->line('**Type:** ' . ucfirst($this->rappel->type))
            ->line('**Date prévue:** ' . $this->rappel->date_rappel->format('d/m/Y à H:i'))
            ->action('Voir mes véhicules', route('vehicules.index'))
            ->line('Merci de maintenir votre véhicule en bon état.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'rappel_id' => $this->rappel->id,
            'vehicule' => $this->rappel->vehicule->marque . ' ' . $this->rappel->vehicule->modele,
            'type' => $this->rappel->type,
            'date' => $this->rappel->date_rappel,
        ];
    }
}
