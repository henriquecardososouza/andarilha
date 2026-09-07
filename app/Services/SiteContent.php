<?php

namespace App\Services;

use App\Data\ContactChannel;
use App\Data\Stat;
use App\Data\TeamMember;
use App\Models\Destiny;
use Illuminate\Support\Collection;

final class SiteContent
{
    /**
     * Headline numbers.
     * @return Collection<int, Stat>
     */
    public function stats(): Collection
    {
        return collect([
            new Stat('years', '12'),
            new Stat('travellers', '4.800'),
            new Stat('destinations', $this->activeDestinies()),
            new Stat('guides', '18'),
        ]);
    }

    private function activeDestinies(): string
    {
        return number_format(Destiny::where('active', true)->count(), 0, ',', '.');
    }

    /**
     * @return Collection<int, TeamMember>
     */
    public function team(): Collection
    {
        return collect([
            new TeamMember('founder', 'Beatriz Andrade'),
            new TeamMember('routes', 'Caio Bernardes'),
            new TeamMember('support', 'Marina Yoshida'),
        ]);
    }

    /**
     * @return Collection<int, ContactChannel>
     */
    public function channels(): Collection
    {
        return collect([
            new ContactChannel('email', 'mail', ['comercial@andarilha.com'], 'mailto:comercial@andarilha.com'),
            new ContactChannel('phone', 'phone', ['+55 38 90000-0000'], 'tel:+5538900000000'),
            new ContactChannel('office', 'pin', ['Rua das Rotas, 128', 'Montes Claros, MG']),
        ]);
    }

    /**
     * Keys for the questions and answers on the contact page.
     * @return Collection<int, string>
     */
    public function faq(): Collection
    {
        return collect(['quote', 'payment', 'group', 'changes']);
    }
}
