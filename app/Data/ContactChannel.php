<?php

namespace App\Data;

final readonly class ContactChannel
{
    /**
     * @param  list<string>  $lines
     */
    public function __construct(
        public string $key,
        public string $icon,
        public array $lines,
        public ?string $href = null,
    ) {}

    public function heading(): string
    {
        return __("pages.contact.channels.{$this->key}");
    }

    public function component(): string
    {
        return 'icons.'.$this->icon;
    }

    public function summary(): string
    {
        return implode(', ', $this->lines);
    }
}
