<?php

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
        Schema::create('destinies', function (Blueprint $table) {
            $table->uuid()->primary();

            $table->boolean('active')->default(true);
            $table->string('name', 100);
            $table->string('country', 60);
            $table->string('postal_code', 50)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinies');
    }
};
