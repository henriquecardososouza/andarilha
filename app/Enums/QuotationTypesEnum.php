<?php

namespace App\Enums;

enum QuotationTypesEnum: int
{
    case PENDING = 0;
    case NOT_AVAILABLE = 1;
    case QUOTE_FINISHED = 2;

    public function label(): string
    {
        return __('admin.quotations.status.'.$this->name);
    }

    /**
     * Tailwind classes for the badge that renders this status.
     */
    public function badge(): string
    {
        return match ($this) {
            self::PENDING => 'border-amber-400/30 bg-amber-400/10 text-amber-200',
            self::NOT_AVAILABLE => 'border-red-400/30 bg-red-400/10 text-red-200',
            self::QUOTE_FINISHED => 'border-ember-400/40 bg-ember-500/15 text-ember-300'
        };
    }

    public function isAnswerable(): bool
    {
        return in_array($this, [self::PENDING], true);
    }

    /**
     * The statuses the panel actually produces: a new request plus the two answers it can receive.
     *
     * @return array<int, self>
     */
    public static function options(): array
    {
        return [self::PENDING, self::QUOTE_FINISHED, self::NOT_AVAILABLE];
    }
}
