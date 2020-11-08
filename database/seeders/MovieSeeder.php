<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Term;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    public function run()
    {
        /** @var Term $term */
        foreach (Term::cursor() as $term) {
            Movie::factory()
                ->count(rand(0, 10))
                ->create([
                    'term_id' => $term->id,
                ]);
        }
    }
}
