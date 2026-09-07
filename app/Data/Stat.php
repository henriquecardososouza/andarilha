<?php

namespace App\Data;

final readonly class Stat
{
    public function __construct(
        public string $key,
        public string $value,
    ) {}

    public function label(): string
    {
        return __("pages.about.stats.{$this->key}");
    }
}
