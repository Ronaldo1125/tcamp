<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TravelOrderNotifyUser extends Notification implements ShouldQueue
{
    use Queueable;

    public $url;
    public $travelInfo;
    public $line1;
    /**
     * Create a new notification instance.
     */
    public function __construct($travelInfo, $line1, $url)
    {
        $this->travelInfo = $travelInfo;
        $this->url = $url;
        $this->line1 = $line1;
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
                    ->subject('Request for Travel Order!')
                    ->greeting('Hello ' . $this->travelInfo->user->name . ',')
                    ->line($this->line1)
                    ->line('Purpose: '. $this->travelInfo->purpose)
                    ->line('Destination: '. $this->travelInfo->destination)
                    ->line('Departure Date: '. $this->travelInfo->travel_departure_date)
                    ->line('Arrival Date: '.$this->travelInfo->travel_arrival_date)
                    ->action('Back to TCAMP Application', $this->url)
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
