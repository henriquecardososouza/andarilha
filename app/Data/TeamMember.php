<?php

namespace App\Data;

use Illuminate\Support\Str;

final readonly class TeamMember
{
    public function __construct(
        public string $key,
        public string $name,
        public ?string $photo = null,
    ) {}

    public function role(): string
    {
        return __("pages.about.team.members.{$this->key}.role");
    }

    public function bio(): string
    {
        return __("pages.about.team.members.{$this->key}.bio");
    }

    public function photoUrl(): ?string
    {
        return $this->photo === null
            ? null
            : asset('assets/team/'.rawurlencode($this->photo));
    }

    /**
     * Fallback avatar for people without a portrait.
     */
    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->filter()
            ->take(2)
            ->map(fn (string $part) => Str::upper(Str::substr($part, 0, 1)))
            ->implode('');
    }
}
