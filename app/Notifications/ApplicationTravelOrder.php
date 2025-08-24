<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class ApplicationTravelOrder extends Notification implements ShouldQueue
{
    use Queueable;

    public $appliedName;
    public $recipientName;
    public $travelInfo;
    public $url;

    /**
     * Create a new notification instance.
     */
    public function __construct($appliedName, $recipientName, $travelInfo, $url)
    {
        $this->appliedName = $appliedName;
        $this->recipientName = $recipientName;
        $this->travelInfo = $travelInfo;
        $this->url = $url;
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
                    ->greeting('Hello ' . $this->recipientName . ',')
                    ->line('This is to inform you that ' . $this->appliedName . ' has submitted a request for a travel order that requires your approval.')
                    ->line('Name: '. $this->travelInfo->user->name)
                    ->line('Purpose: '. $this->travelInfo->purpose)
                    ->line('Destination: '. $this->travelInfo->destination)
                    ->line('Departure Date: '. $this->travelInfo->travel_departure_date)
                    ->line('Arrival Date: '.$this->travelInfo->travel_arrival_date)
                    ->action('Go to the TCAMP Application', $this->url)
                    ->line('Thank you!');
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
