<?php

namespace App\Notifications;

use App\Models\Note;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewNoteCreatedNotification extends Notification
{
    use Queueable;

    protected Note $note;

    /**
     * Create a new notification instance.
     */
    public function __construct(Note $note)
    {
        $this->note = $note;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Т.к. заглушка, то мы пишем ток в DB
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('User - ' . $notifiable->name . ' created new Note')
            ->action('Note . ' . $this->note->topic, url('/api/v1/admin/note/' . $this->note->id));
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'notification' => self::class,
            'data' => [
                'notifiable' => $notifiable,
                'message' => 'User - ' . $notifiable->name . ' created new Note',
                'messageLink' => $this->note->topic, url('admin/note/' . $this->note->id),
            ],
        ];
    }
}
