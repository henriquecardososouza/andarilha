<?php

use App\Enums\QuotationTypesEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->uuid()->primary();

            $table->foreignUuid('destiny_uuid')->constrained('destinies', 'uuid');

            $table->string('user_name', 100);
            $table->string('user_email', 150);

            $table->tinyInteger('status')->default(QuotationTypesEnum::PENDING)->index();
            $table->date('trip_date')->index();
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
