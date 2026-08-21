<?php

namespace Database\Seeders;

use App\Models\EModul;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class KontenTagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = Tag::all();

        EModul::dipublikasikan()->get()->each(function (EModul $eModul) use ($tags) {
            $eModul->tags()->syncWithoutDetaching(
                $tags->random(min(3, $tags->count()))->pluck('id')
            );
        });
    }
}
