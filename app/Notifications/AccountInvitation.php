<?php

namespace App\Notifications;

class AccountInvitation extends BrandedMail
{
    public function __construct(private readonly string $token)
    {
    }

    /**
     * @return array<string, mixed>
     */
    protected function content(object $notifiable): array
    {
        $days = $this->expiresInDays();

        return [
            'subject' => __('admin.invite.mail.subject'),
            'preheader' => __('admin.invite.mail.preheader'),
            'eyebrow' => __('admin.invite.mail.eyebrow'),
            'heading' => __('admin.invite.mail.heading', ['name' => $notifiable->name]),
            'paragraphs' => [
                __('admin.invite.mail.intro'),
                __('admin.invite.mail.instruction'),
            ],
            'action' => [
                'label' => __('admin.invite.mail.action'),
                'url' => $this->url($notifiable),
            ],
            'note' => trans_choice('admin.invite.mail.expires', $days, ['days' => $days]),
            'footnote' => __('admin.invite.mail.footnote'),
        ];
    }

    private function url(object $notifiable): string
    {
        return route('admin.invitation.create', [
            'token' => $this->token,
            'email' => $notifiable->getEmailForPasswordReset(),
        ]);
    }

    private function expiresInDays(): int
    {
        return (int) ceil(config('auth.passwords.invitations.expire') / 1440);
    }
}
