<?php

namespace App\Models;

use Database\Factories\DestinyFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'active',
    'name',
    'country',
    'postal_code'
])]
#[Table(key: 'uuid')]
class Destiny extends Model
{
    /** @use HasFactory<DestinyFactory> */
    use HasUuids, HasFactory;

    protected function casts(): array
    {
        return [
            'active' => 'boolean',
            'name' => 'string',
            'country' => 'string',
            'postal_code' => 'string'
        ];
    }

    public function quotations(): HasMany
    {
        return $this->hasMany(Quotation::class, 'destiny_uuid', 'uuid');
    }
}
