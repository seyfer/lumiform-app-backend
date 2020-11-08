<?php

namespace Database\Factories;

use App\Models\Term;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TermFactory extends Factory
{
    protected $model = Term::class;

    public function definition()
    {
        return [
            'term' => $this->faker->unique()->word,
            'last_used_at' => $this->faker->dateTimeBetween('-2 hours','now'),
        ];
    }
}
