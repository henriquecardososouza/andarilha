<?php

namespace App\Notifications;

use Illuminate\Support\Facades\URL;

class EmailVerification extends BrandedMail
{
    /**
     * @return array<string, mixed>
     */
    protected function content(object $notifiable): array
    {
        $minutes = config('auth.verification.expire', 60);

        return [
            'subject' => __('admin.verify.mail.subject'),
            'preheader' => __('admin.verify.mail.preheader'),
            'eyebrow' => __('admin.verify.mail.eyebrow'),
            'heading' => __('admin.verify.mail.heading', ['name' => $notifiable->name]),
            'paragraphs' => [
                __('admin.verify.mail.intro'),
                __('admin.verify.mail.instruction'),
            ],
            'action' => [
                'label' => __('admin.verify.mail.action'),
                'url' => $this->url($notifiable),
            ],
            'note' => trans_choice('admin.verify.mail.expires', $minutes, ['minutes' => $minutes]),
            'footnote' => __('admin.verify.mail.footnote'),
        ];
    }

    private function url(object $notifiable): string
    {
        return URL::temporarySignedRoute(
            'admin.verification.verify',
            now()->addMinutes(config('auth.verification.expire', 60)),
            [
                'id' => $notifiable->getKey(),
                'hash' => sha1($notifiable->getEmailForVerification()),
            ],
        );
    }
}
