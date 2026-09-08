<?php

namespace Tests\Feature;

use App\Enums\QuotationTypesEnum;
use App\Models\Destiny;
use App\Models\Quotation;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class QuotationFiltersTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_list_narrows_by_status(): void
    {
        [$lisbon] = $this->seedQuotations();

        $rows = $this->listing(['status' => QuotationTypesEnum::QUOTE_FINISHED->value]);

        $this->assertSame(1, $rows->total());
        $this->assertSame('Bruna Quotada', $rows->first()->user_name);
        $this->assertSame($lisbon->uuid, $rows->first()->destiny_uuid);
    }

    public function test_the_list_narrows_by_destination(): void
    {
        [, $porto] = $this->seedQuotations();

        $rows = $this->listing(['destiny' => $porto->uuid]);

        $this->assertSame(1, $rows->total());
        $this->assertSame('Caio Distante', $rows->first()->user_name);
    }

    public function test_the_list_narrows_by_trip_date_range(): void
    {
        $this->seedQuotations();

        $rows = $this->listing([
            'trip_from' => '2026-06-01',
            'trip_until' => '2026-06-30',
        ]);

        $this->assertSame(1, $rows->total());
        $this->assertSame('Bruna Quotada', $rows->first()->user_name);
    }

    public function test_the_search_box_looks_at_people_and_destinations(): void
    {
        $this->seedQuotations();

        $this->assertSame(1, $this->listing(['search' => 'Caio'])->total());
        $this->assertSame(1, $this->listing(['search' => 'ana@example.com'])->total());
        $this->assertSame(1, $this->listing(['search' => 'Porto'])->total());
        $this->assertSame(0, $this->listing(['search' => 'ninguem'])->total());
    }

    public function test_filters_combine(): void
    {
        [$lisbon] = $this->seedQuotations();

        $this->assertSame(1, $this->listing([
            'destiny' => $lisbon->uuid,
            'status' => QuotationTypesEnum::PENDING->value,
        ])->total());

        $this->assertSame(0, $this->listing([
            'destiny' => $lisbon->uuid,
            'status' => QuotationTypesEnum::NOT_AVAILABLE->value,
        ])->total());
    }

    /**
     * @return array{0: Destiny, 1: Destiny}
     */
    private function seedQuotations(): array
    {
        $lisbon = Destiny::factory()->create(['name' => 'Lisboa', 'country' => 'Portugal']);
        $porto = Destiny::factory()->create(['name' => 'Porto', 'country' => 'Portugal']);

        Quotation::factory()->for($lisbon, 'destiny')->create([
            'user_name' => 'Ana Pendente',
            'user_email' => 'ana@example.com',
            'trip_date' => '2026-03-10',
            'status' => QuotationTypesEnum::PENDING,
        ]);

        Quotation::factory()->for($lisbon, 'destiny')->create([
            'user_name' => 'Bruna Quotada',
            'user_email' => 'bruna@example.com',
            'trip_date' => '2026-06-15',
            'status' => QuotationTypesEnum::QUOTE_FINISHED,
            'price' => '3200.00',
        ]);

        Quotation::factory()->for($porto, 'destiny')->create([
            'user_name' => 'Caio Distante',
            'user_email' => 'caio@example.com',
            'trip_date' => '2026-09-20',
            'status' => QuotationTypesEnum::NOT_AVAILABLE,
        ]);

        return [$lisbon, $porto];
    }

    /**
     * @param  array<string, string>  $filters
     */
    private function listing(array $filters): LengthAwarePaginator
    {
        $response = $this->actingAs(User::factory()->create())
            ->get(route('admin.quotations.index', $filters));

        $response->assertOk();

        return $this->quotationsOf($response);
    }

    private function quotationsOf(TestResponse $response): LengthAwarePaginator
    {
        return $response->original->getData()['quotations'];
    }
}
