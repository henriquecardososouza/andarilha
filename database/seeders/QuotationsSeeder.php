<?php

namespace Database\Seeders;

use App\Models\Quotation;
use Illuminate\Database\Seeder;

class QuotationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Quotation::factory(100)->create();
    }
}
