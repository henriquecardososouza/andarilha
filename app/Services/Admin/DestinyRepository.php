<?php

namespace App\Services\Admin;

use App\Models\Destiny;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

final class DestinyRepository
{
    private const PER_PAGE = 15;

    public function paginate(?string $search): LengthAwarePaginator
    {
        return Destiny::query()
            ->withCount('quotations')
            ->when($search, fn (Builder $query, string $term) => $query->where(
                fn (Builder $group) => $group
                    ->where('name', 'like', $this->like($term))
                    ->orWhere('country', 'like', $this->like($term))
                    ->orWhere('postal_code', 'like', $this->like($term)),
            ))
            ->orderBy('name')
            ->paginate(self::PER_PAGE)
            ->withQueryString()
            ->through(fn (Destiny $destiny) => $destiny->setAttribute('edit_payload', $this->editPayload($destiny)));
    }

    private function editPayload(Destiny $destiny): array
    {
        return [
            'modal' => 'destiny-form',
            'action' => route('admin.destinies.update', $destiny),
            'method' => 'PATCH',
            'fields' => [
                'name' => $destiny->name,
                'country' => $destiny->country,
                'postal_code' => $destiny->postal_code,
                'active' => $destiny->active,
            ],
        ];
    }

    private function like(string $term): string
    {
        return '%'.addcslashes($term, '%_'.chr(92)).'%';
    }
}
