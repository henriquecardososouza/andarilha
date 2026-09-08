<?php

namespace App\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

abstract class BrandedMail extends Notification
{
    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $content = $this->content($notifiable);

        return (new MailMessage)
            ->subject($content['subject'])
            ->view('mail.message', $content + [
                'preheader' => '',
                'details' => [],
                'action' => null,
                'note' => null,
                'footnote' => __('admin.mail.footnote'),
            ]);
    }

    /**
     * @return array<string, mixed>
     */
    abstract protected function content(object $notifiable): array;
}
