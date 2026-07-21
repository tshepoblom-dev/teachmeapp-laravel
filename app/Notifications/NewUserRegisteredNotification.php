<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewUserRegisteredNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        private readonly User $newUser,
    ) {}

    /**
     * Always-on for admins — bypasses NotificationPreferenceService like
     * AdminBroadcastNotification does, since missing a new sign-up risks
     * breaking the platform's 2-3 day response commitment.
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'          => 'new_user_registered',
            'new_user_id'   => $this->newUser->id,
            'new_user_name' => $this->newUser->name,
            'new_user_role' => $this->newUser->role->value,
            'message'       => "{$this->newUser->name} just signed up as a {$this->newUser->role->value}.",
        ];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $data = $this->toArray($notifiable);

        return (new MailMessage)
            ->subject('New ' . ucfirst($data['new_user_role']) . ' sign-up — ' . $data['new_user_name'])
            ->view('emails.new-user-registered', [
                'newUser' => $this->newUser,
            ]);
    }
}
