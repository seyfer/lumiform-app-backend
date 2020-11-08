<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Term;
use App\Models\User;
use App\Services\movie\MovieScoreService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

class GameFactory extends Factory
{
    protected $model = Game::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'term_id' => Term::factory(),
            'final_score' => rand(0, 5),
        ];
    }
}
