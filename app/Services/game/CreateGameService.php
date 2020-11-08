<?php

namespace App\Services\game;

use App\Models\Game;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Collection;

class CreateGameService
{
    private $gameLogicService;

    public function __construct(GameLogicService $gameLogicService)
    {
        $this->gameLogicService = $gameLogicService;
    }

    public function create(array $data)
    {
        $movies = $this->fetchMovies($data['movies']);
        $normalizedMovies = $this->toGameMovies($movies, $data);

        $gameResults = $this->gameLogicService->createGame($normalizedMovies->toArray());

        // If we would like we could record the results (or guesses) as well
        $game = Game::create([
            'user_id' => $data['user'],
            'term_id' => $data['term'],
            'final_score' => $gameResults['finalScore'],
        ]);

        return $game;
    }

    private function fetchMovies(array $movies)
    {
        $movieIds = array_map(function ($value) {
            return $value['id'];
        }, $movies);

        return Movie::select('id', 'score', 'title')->whereIn('id', $movieIds)->get();
    }

    private function toGameMovies(Collection $movies, array $request)
    {
        return $movies->map(function($movie, $index) use ($request) {
            /** @var Movie $movie */
            return [
                'id' => $movie->id,
                'title' => $movie->title,
                'guessing' => (float) $request['movies'][$index]['guessing'],
                'score' => $movie->score,
            ];
        });
    }
}
