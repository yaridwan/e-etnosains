<?php

namespace Database\Seeders;

use App\Models\BahanAjar;
use Illuminate\Database\Seeder;

class BahanAjarSeeder extends Seeder
{
    public function run(): void
    {
        BahanAjar::factory()->count(6)->create();
    }
}
