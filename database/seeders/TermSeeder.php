<?php

namespace Database\Seeders;

use App\Models\Term;
use Illuminate\Database\Seeder;

class TermSeeder extends Seeder
{
    public function run()
    {
        Term::factory()
            ->times(rand(1, 20))
            ->create();
    }
}
