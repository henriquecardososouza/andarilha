<?php

namespace App\Data;

use Illuminate\Support\Collection;

final readonly class Destination
{
    /**
     * @param  list<string>  $iconNames
     * @param  list<Review>  $reviews
     */
    public function __construct(
        public string $slug,
        public string $photo,
        public array $iconNames,
        public array $reviews = [],
        public ?string $secondPhoto = null,
        public bool $isBackdrop = false,
    ) {}

    public function name(?string $locale = null): string
    {
        return __("landing.cities.{$this->slug}.name", [], $locale);
    }

    public function country(?string $locale = null): string
    {
        return __("landing.cities.{$this->slug}.country", [], $locale);
    }

    public function description(?string $locale = null): string
    {
        return __("landing.cities.{$this->slug}.description", [], $locale);
    }

    public function image(): string
    {
        return asset('assets/cities/'.rawurlencode($this->photo));
    }

    /**
     * Second showcase photo.
     */
    public function secondImage(): string
    {
        return $this->secondPhoto === null
            ? $this->image()
            : asset('assets/cities/'.rawurlencode($this->secondPhoto));
    }

    public function hasSecondPhoto(): bool
    {
        return $this->secondPhoto !== null;
    }

    /**
     * @return Collection<int, Review>
     */
    public function reviews(): Collection
    {
        return collect($this->reviews);
    }

    /**
     * @return Collection<int, DestinationIcon>
     */
    public function icons(): Collection
    {
        return collect($this->iconNames)
            ->map(fn (string $name) => new DestinationIcon($this->slug, $name));
    }
}
