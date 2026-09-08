<?php

namespace Tests\Feature;

use App\Enums\QuotationTypesEnum;
use App\Models\Destiny;
use App\Models\Quotation;
use App\Models\User;
use App\Notifications\QuotationAnswered;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class QuotationAnswerTest extends TestCase
{
    use RefreshDatabase;

    public function test_answering_with_a_price_quotes_the_trip_and_emails_the_traveller(): void
    {
        Notification::fake();

        $quotation = $this->pendingQuotation();

        $this->actingAs(User::factory()->create())
            ->patch(route('admin.quotations.answer', $quotation), [
                'answer' => 'priced',
                'price' => '4890.00',
            ])->assertRedirect();

        $quotation->refresh();

        $this->assertSame(QuotationTypesEnum::QUOTE_FINISHED, $quotation->status);
        $this->assertSame('4890.00', $quotation->price);
        $this->assertNotNull($quotation->answered_at);

        Notification::assertSentOnDemand(
            QuotationAnswered::class,
            fn (QuotationAnswered $notification, array $channels, AnonymousNotifiable $notifiable) => $notifiable->routes['mail'] === $quotation->user_email,
        );
    }

    public function test_answering_as_unavailable_leaves_no_price(): void
    {
        Notification::fake();

        $quotation = $this->pendingQuotation();

        $this->actingAs(User::factory()->create())
            ->patch(route('admin.quotations.answer', $quotation), ['answer' => 'unavailable'])
            ->assertRedirect();

        $quotation->refresh();

        $this->assertSame(QuotationTypesEnum::NOT_AVAILABLE, $quotation->status);
        $this->assertNull($quotation->price);
        $this->assertNotNull($quotation->answered_at);

        Notification::assertSentOnDemand(QuotationAnswered::class);
    }

    public function test_a_price_is_required_to_quote_a_trip(): void
    {
        Notification::fake();

        $quotation = $this->pendingQuotation();

        $this->actingAs(User::factory()->create())
            ->patchJson(route('admin.quotations.answer', $quotation), ['answer' => 'priced'])
            ->assertStatus(422)
            ->assertJsonValidationErrors('price');

        $this->assertSame(QuotationTypesEnum::PENDING, $quotation->fresh()->status);

        Notification::assertNothingSent();
    }

    private function pendingQuotation(): Quotation
    {
        return Quotation::factory()
            ->for(Destiny::factory()->create(), 'destiny')
            ->create(['status' => QuotationTypesEnum::PENDING]);
    }
}
