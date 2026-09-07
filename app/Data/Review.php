<?php

namespace App\Data;

use Illuminate\Support\Str;

final readonly class Review
{
    public const MAX_RATING = 5;

    public function __construct(
        private string $destination,
        public string $key,
        public string $author,
        public int $rating,
        public ?string $photo = null,
    ) {}

    public function text(): string
    {
        return __("landing.cities.{$this->destination}.reviews.{$this->key}");
    }

    public function photoUrl(): ?string
    {
        return $this->photo === null
            ? null
            : asset('assets/reviewers/'.rawurlencode($this->photo));
    }

    /**
     * Fallback avatar for reviewers without a portrait.
     */
    public function initials(): string
    {
        return Str::of($this->author)
            ->explode(' ')
            ->filter()
            ->take(2)
            ->map(fn (string $part) => Str::upper(Str::substr($part, 0, 1)))
            ->implode('');
    }

    /**
     * Star slots, each flagged as earned or not, ready to loop over.
     *
     * @return array<int, bool>
     */
    public function stars(): array
    {
        return array_map(
            fn (int $slot) => $slot <= $this->rating,
            range(1, self::MAX_RATING),
        );
    }
}
