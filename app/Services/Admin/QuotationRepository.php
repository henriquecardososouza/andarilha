<?php

namespace App\Services\Admin;

use App\Data\Admin\QuotationFilters;
use App\Models\Quotation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

final class QuotationRepository
{
    private const PER_PAGE = 15;

    public function paginate(QuotationFilters $filters): LengthAwarePaginator
    {
        return Quotation::query()
            ->with('destiny:uuid,name,country')
            ->when($filters->search, fn (Builder $query, string $term) => $query->where(
                fn (Builder $group) => $group
                    ->where('user_name', 'like', $this->like($term))
                    ->orWhere('user_email', 'like', $this->like($term))
                    ->orWhereHas('destiny', fn (Builder $destiny) => $destiny
                        ->where('name', 'like', $this->like($term))
                        ->orWhere('country', 'like', $this->like($term))),
            ))
            ->when($filters->status, fn (Builder $query) => $query->where('status', $filters->status))
            ->when($filters->destiny, fn (Builder $query, string $uuid) => $query->where('destiny_uuid', $uuid))
            ->when($filters->tripFrom, fn (Builder $query, string $date) => $query->whereDate('trip_date', '>=', $date))
            ->when($filters->tripUntil, fn (Builder $query, string $date) => $query->whereDate('trip_date', '<=', $date))
            ->latest('created_at')
            ->paginate(self::PER_PAGE)
            ->withQueryString();
    }

    private function like(string $term): string
    {
        return '%'.addcslashes($term, '%_\\').'%';
    }
}
