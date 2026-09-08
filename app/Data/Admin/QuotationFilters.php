<?php

namespace App\Data\Admin;

use App\Enums\QuotationTypesEnum;
use Illuminate\Http\Request;

final readonly class QuotationFilters
{
    public function __construct(
        public ?string $search = null,
        public ?QuotationTypesEnum $status = null,
        public ?string $destiny = null,
        public ?string $tripFrom = null,
        public ?string $tripUntil = null,
    ) {}

    public static function fromRequest(Request $request): self
    {
        $status = $request->filled('status')
            ? QuotationTypesEnum::tryFrom((int) $request->integer('status'))
            : null;

        return new self(
            search: $request->filled('search') ? trim($request->string('search')->value()) : null,
            status: $status,
            destiny: $request->filled('destiny') ? $request->string('destiny')->value() : null,
            tripFrom: $request->filled('trip_from') ? $request->date('trip_from')?->toDateString() : null,
            tripUntil: $request->filled('trip_until') ? $request->date('trip_until')?->toDateString() : null,
        );
    }

    /**
     * How many filters are on, ignoring the search box which has its own field.
     */
    public function activeCount(): int
    {
        return count(array_filter([
            $this->status,
            $this->destiny,
            $this->tripFrom,
            $this->tripUntil,
        ]));
    }

    public function hasAny(): bool
    {
        return $this->activeCount() > 0;
    }

    /**
     * @return array<string, string>
     */
    public function toQuery(): array
    {
        return array_filter([
            'search' => $this->search,
            'status' => $this->status?->value === null ? null : (string) $this->status->value,
            'destiny' => $this->destiny,
            'trip_from' => $this->tripFrom,
            'trip_until' => $this->tripUntil,
        ], fn ($value) => $value !== null && $value !== '');
    }
}
