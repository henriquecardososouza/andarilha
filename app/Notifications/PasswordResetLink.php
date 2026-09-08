<?php

namespace App\Notifications;

class PasswordResetLink extends BrandedMail
{
    public function __construct(private readonly string $token)
    {
    }

    /**
     * @return array<string, mixed>
     */
    protected function content(object $notifiable): array
    {
        $minutes = config('auth.passwords.users.expire');

        return [
            'subject' => __('admin.reset.mail.subject'),
            'preheader' => __('admin.reset.mail.preheader'),
            'eyebrow' => __('admin.reset.mail.eyebrow'),
            'heading' => __('admin.reset.mail.heading', ['name' => $notifiable->name]),
            'paragraphs' => [
                __('admin.reset.mail.intro'),
                __('admin.reset.mail.instruction'),
            ],
            'action' => [
                'label' => __('admin.reset.mail.action'),
                'url' => $this->url($notifiable),
            ],
            'note' => trans_choice('admin.reset.mail.expires', $minutes, ['minutes' => $minutes]),
            'footnote' => __('admin.reset.mail.footnote'),
        ];
    }

    private function url(object $notifiable): string
    {
        return route('admin.password.reset', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ]);
    }
}
