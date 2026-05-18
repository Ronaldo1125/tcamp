<?php

namespace App\Notifications;

use App\Models\TravelOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TravelStepNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $request;
    public $type; // 'next_approver', 'final_approved', or 'rejected'

    public function __construct(TravelOrder $request, $type)
    {
        $this->request = $request;
        $this->type = $type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = url('/travel_orders/' . $this->request->id);

        return match ($this->type) {
            'new_submission' => (new MailMessage)
                ->subject('New Travel Request: ' . $this->request->destination)
                ->line($this->request->user->name . ' has submitted a new travel request that requires your initial approval.')
                ->line('Destination: ' . $this->request->destination)
                ->action('View Request Details', $url)
                ->line('Please review this at your earliest convenience.'),

            'next_approver' => (new MailMessage)
                ->subject('Action Required: New Travel Request for Approval')
                ->line('A travel request to ' . $this->request->destination . ' is awaiting your review.')
                ->action('Review Request', $url)
                ->line('Thank you for keeping the workflow moving!'),

            'final_approved' => (new MailMessage)
                ->subject('Congratulations! Your Travel is Approved')
                ->line('Your travel request to ' . $this->request->destination . ' has been fully approved by the Budget Officer.')
                ->action('View & Download Voucher', $url),

            'rejected' => (new MailMessage)
                ->error()
                ->subject('Attention: Travel Request Disapproved')
                ->line('Your travel request to ' . $this->request->destination . ' was sent back for revisions.')
                ->line('Reason: ' . $this->request->remarks)
                ->action('Edit & Resubmit', $url),
        };
                   
    }

    public function toDatabase($notifiable)
{
    return [
        'travel_order_id' => (int) $this->request->id, // Ensure it's an integer
        'message' => 'New travel request to ' . $this->request->destination,
    ];
}

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'travel_order_id' => int($this->request->id),
            'message' => 'Travel to ' . $this->request->destination . ' updated.',
        ];
    }
}
