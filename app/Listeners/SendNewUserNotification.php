<?php

namespace App\Listeners;

use App\Notifications\NewUserNotification;
use App\Models\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendNewUserNotification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(object $event): void
    {
        $admins = User::whereHas('roles', function($query){
            $query->where('id', 1);
        })->get();
        Notification::send($admins, new NewUserNotification($event->user));
    }
}
