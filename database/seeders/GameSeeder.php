<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Term;
use App\Models\User;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    public function run()
    {
        /** @var Term $term */
        foreach (Term::cursor() as $term) {
            /** @var User $user */
            foreach (User::cursor() as $user) {
                Game::factory()
                    ->count(rand(0, 10))
                    ->create([
                        'term_id' => $term->id,
                        'user_id' => $user->id,
                    ]);
            }
        }
    }
}
