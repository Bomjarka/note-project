<?php

namespace App\Services;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Collection;

class NotificationService
{
    /**
     * @param Collection $notifiables
     * @param Notification $notification
     * @return void
     */
    public function sentNotification(Collection $notifiables, Notification $notification): void
    {
        foreach ($notifiables as $notifiable) {
            $notifiable->notify($notification);
        }
    }
}
