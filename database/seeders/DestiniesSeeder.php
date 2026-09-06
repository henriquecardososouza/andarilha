<?php

namespace Database\Seeders;

use App\Models\Destiny;
use Illuminate\Database\Seeder;

class DestiniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Destiny::factory(50)->create();
    }
}
