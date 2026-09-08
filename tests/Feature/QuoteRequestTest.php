<?php

namespace Tests\Feature;

use App\Enums\QuotationTypesEnum;
use App\Models\Destiny;
use App\Models\Quotation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuoteRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_visitor_can_ask_for_a_quote(): void
    {
        $destiny = Destiny::factory()->create(['active' => true]);

        $response = $this->post(route('quotation.store'), [
            'name' => 'Marina Alves',
            'email' => 'marina@example.com',
            'destiny_uuid' => $destiny->uuid,
            'trip_date' => now()->addMonth()->toDateString(),
        ]);

        $response->assertRedirect(route('landing').'#contato');

        $quotation = Quotation::sole();

        $this->assertSame('Marina Alves', $quotation->user_name);
        $this->assertSame('marina@example.com', $quotation->user_email);
        $this->assertSame($destiny->uuid, $quotation->destiny_uuid);
        $this->assertSame(QuotationTypesEnum::PENDING, $quotation->status);
        $this->assertNull($quotation->answered_at);
    }

    /**
     * The same address, destination and date is treated as the request already on file.
     */
    public function test_asking_twice_reports_success_without_duplicating(): void
    {
        $destiny = Destiny::factory()->create(['active' => true]);

        $payload = [
            'name' => 'Marina Alves',
            'email' => 'marina@example.com',
            'destiny_uuid' => $destiny->uuid,
            'trip_date' => now()->addMonth()->toDateString(),
        ];

        $this->post(route('quotation.store'), $payload);
        $this->postJson(route('quotation.store'), $payload)->assertOk();

        $this->assertSame(1, Quotation::query()->count());
    }

    public function test_a_different_date_is_a_new_request(): void
    {
        $destiny = Destiny::factory()->create(['active' => true]);

        $payload = [
            'name' => 'Marina Alves',
            'email' => 'marina@example.com',
            'destiny_uuid' => $destiny->uuid,
            'trip_date' => now()->addMonth()->toDateString(),
        ];

        $this->post(route('quotation.store'), $payload);
        $this->post(route('quotation.store'), [...$payload, 'trip_date' => now()->addMonths(2)->toDateString()]);

        $this->assertSame(2, Quotation::query()->count());
    }

    public function test_the_trip_date_must_be_in_the_future(): void
    {
        $destiny = Destiny::factory()->create(['active' => true]);

        $this->postJson(route('quotation.store'), [
            'name' => 'Marina Alves',
            'email' => 'marina@example.com',
            'destiny_uuid' => $destiny->uuid,
            'trip_date' => now()->subDay()->toDateString(),
        ])->assertStatus(422)->assertJsonValidationErrors('trip_date');

        $this->assertSame(0, Quotation::query()->count());
    }

    public function test_an_inactive_destination_is_rejected(): void
    {
        $destiny = Destiny::factory()->create(['active' => false]);

        $this->postJson(route('quotation.store'), [
            'name' => 'Marina Alves',
            'email' => 'marina@example.com',
            'destiny_uuid' => $destiny->uuid,
            'trip_date' => now()->addMonth()->toDateString(),
        ])->assertStatus(422)->assertJsonValidationErrors('destiny_uuid');

        $this->assertSame(0, Quotation::query()->count());
    }
}
