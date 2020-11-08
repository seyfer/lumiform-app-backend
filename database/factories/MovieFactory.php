<?php

namespace Database\Factories;

use App\Models\Movie;
use App\Models\Term;
use App\Services\movie\MovieScoreService;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;

class MovieFactory extends Factory
{
    private $movieScoreService;

    protected $model = Movie::class;

    public function __construct($count = null, ?Collection $states = null, ?Collection $has = null, ?Collection $for = null, ?Collection $afterMaking = null, ?Collection $afterCreating = null, $connection = null)
    {
        parent::__construct($count, $states, $has, $for, $afterMaking, $afterCreating, $connection);

        $this->movieScoreService = app()->make(MovieScoreService::class);
    }


    public function definition()
    {
        return [
            'term_id' => Term::factory(),
            'score' => $this->movieScoreService->generateRandomScore(),
            'title' => $this->faker->word,
            'poster' => $this->faker->imageUrl(640, 480, 'movie'),
        ];
    }
}
