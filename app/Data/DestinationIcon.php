<?php

namespace App\Data;

final readonly class DestinationIcon
{
    public function __construct(
        private string $destination,
        public string $name,
    ) {}

    /**
     * Blade component that draws this icon.
     */
    public function component(): string
    {
        return 'icons.'.$this->name;
    }

    /**
     * Short phrase shown in the tooltip.
     */
    public function label(): string
    {
        return __("landing.cities.{$this->destination}.icons.{$this->name}");
    }
}
