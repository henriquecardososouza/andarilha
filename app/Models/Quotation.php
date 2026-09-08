<?php

namespace App\Models;

use App\Enums\QuotationTypesEnum;
use Database\Factories\QuotationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'destiny_uuid',
    'user_name',
    'user_email',
    'trip_date',
    'description',
    'status',
    'price',
    'answered_at'
])]
#[Table(key: 'uuid')]
class Quotation extends Model
{
    /** @use HasFactory<QuotationFactory> */
    use HasUuids, HasFactory;

    protected function casts(): array
    {
        return [
            'destiny_uuid' => 'string',
            'user_name' => 'string',
            'user_email' => 'string',
            'trip_date' => 'date',
            'description' => 'string',
            'status' => QuotationTypesEnum::class,
            'price' => 'decimal:2',
            'answered_at' => 'datetime'
        ];
    }

    public function formattedTripDate(): string
    {
        return $this->trip_date?->format('d/m/Y') ?? '';
    }

    public function formattedPrice(): ?string
    {
        return $this->price === null
            ? null
            : __('admin.quotations.currency', ['value' => number_format((float) $this->price, 2, ',', '.')]);
    }

    /**
     * The destiny of this trip
     * @return BelongsTo
     */
    public function destiny(): BelongsTo
    {
        return $this->belongsTo(Destiny::class, 'destiny_uuid', 'uuid');
    }
}
